<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Service;
use App\Video;
use Vinkla\Vimeo\Facades\Vimeo;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class VimeoUpdate extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $service;
    protected $per_page;
    protected $options;
    protected $response;
    protected $count_downloaded;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->service = Service::find(2);
        $this->per_page = 100;
        $this->options = [
            'per_page' => $this->per_page,
            'fields' => 'uri, duration, pictures.uri, pictures.active, name, description, release_time, link, stats.plays, embed.html',
        ];
        $this->count_downloaded = 0;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $time_start = microtime(true);
            $text = 'Job '.$this->job->getJobId().' started';
            echo ($text.PHP_EOL);
            Log::info($text);

            //first page
            $this->response   = Vimeo::request('/me/videos', $this->options, 'GET');
            if (!isset($this->response['body']['total'] || empty($this->response['body']['total']))){
                echo ('BAD RESPONSE: '.var_export($this->response,true));
                Log::error('Bad Response');
                return;
            }
            $count_total      = $this->response['body']['total'];
            $next_page        = $this->response['body']['paging']['next'];

            echo ('Page '.$this->response['body']['page'].PHP_EOL);
            echo ('Next Page '.$next_page.PHP_EOL);

            $this->loop();

            //following pages
            while ($next_page) {
                $this->response = Vimeo::request($next_page, array(), 'GET');
                $next_page = $this->response["body"]["paging"]["next"];
                echo ('Page '.$this->response['body']['page'].PHP_EOL);
                echo ('Next Page '.$next_page.PHP_EOL);
                $this->loop();
            }

            $time_end = microtime(true);
            $execution_time = ($time_end - $time_start)/60;

            $text = 'Vimeo Update: '.$count_total.' (total) '.$this->count_downloaded.' (new) '.$execution_time.' (secs.)';
            echo $text.PHP_EOL;
            Log::info($text);

        } catch (\Exception $exception){
            $text = 'Exception occured while updating Vimeo videos:';
            $text .= ' [file] '.$exception->getFile();
            $text .= ' [line] '.$exception->getLine();
            $text .= ' [message] '.$exception->getMessage();
            Log::error($text);
            throw $exception;
        }
    }

    private function loop()
    {
        foreach ($this->response["body"]["data"] as $i => $item) {
            $object = json_decode(json_encode($item), FALSE);

            //todo loop sizes ordered by with or height
            if (!empty($object->pictures->uri) && $object->pictures->active) {
                $pictures_id = last(explode('/',$object->pictures->uri));
                $image_size_url = [
                    "xs" => "https://i.vimeocdn.com/video/" . $pictures_id . "_100x75.jpg?r=pad",
                    "sm" => "https://i.vimeocdn.com/video/" . $pictures_id . "_200x150.jpg?r=pad",
                    "md" => "https://i.vimeocdn.com/video/" . $pictures_id . "_295x166.jpg?r=pad",
                    "lg" => "https://i.vimeocdn.com/video/" . $pictures_id . "_640x360.jpg?r=pad",
                    "xl" => "https://i.vimeocdn.com/video/" . $pictures_id . "_960x540.jpg?r=pad",
                    "xx" => "https://i.vimeocdn.com/video/" . $pictures_id . "_1280x720.jpg?r=pad",
                ];
            } else {
                $image_size_url = ["xs" => "", "sm" => "", "md" => "", "lg" => "", "xl" => "", "xx" => ""];
            }

            //map fields to an array
            $video["service_id"]   = 2;
            $video["cloud_id"]     = str_replace("/videos/", "", $object->uri);
            $video["embed"]        = (isset($object->embed->html) ? $object->embed->html : '');
            $video["thumbnail_sm"] = (isset($object->pictures) ? $image_size_url["xs"] : '');
            $video["thumbnail"]    = (isset($object->pictures) ? $image_size_url["md"] : '');
            $video["thumbnail_hq"] = (isset($object->pictures) ? $image_size_url["lg"] : '');
            $video["title"]        = $object->name;
            $video["name"]         = $object->name;
            $video["description"]  = ($object->description ? $object->description : '');
            $video["duration"]     = $object->duration;
            $video["produced_at"]  = $object->release_time; //Also has: created_time, modified_time
            $video["url"]          = $object->link;
            $video["count_watch"]  = $object->stats->plays;
            $video["count_reposts"] = 0;
            $video["count_likes"]   = 0;
            $video["ignore"]       = false;
            $video["new"]          = true;
            $video["client_id"]    = null;
            $video["position"]     = (intval($this->response['body']['page']) - 1) * $this->per_page + $i;


            // search for the video to check if its new
            if (!Video::withTrashed()
                ->where('service_id', 2)
                ->where('cloud_id', $video['cloud_id'])
                ->first()
            ) {
                //use array of mapped fields to create object
                $newVideo = Video::create($video);
                $newVideo->service()->associate($this->service);
                $newVideo->save();
                $this->count_downloaded ++;
            }

        }

    }
}
