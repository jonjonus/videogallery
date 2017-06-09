<?php namespace App\Http\Controllers;

use App\Service;
use App\Video;
use App\Youtube;
use App\Http\Requests;
//use App\Http\Requests\Request;
use Illuminate\Http\Request;
use Vinkla\Vimeo\Facades\Vimeo;
//use DB;


class YoutubeController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
	
	public function youtube_index()
    {
        $page_token = (session()->has('youtube_page_token') ? session()->get('youtube_page_token') : null);
		return view('youtube.index', compact('page_token'));
	}

	public function youtube_clear(Request $request){
        $request->session()->forget('youtube_page_token');
        return redirect(action('YoutubeController@youtube_index'));
    }

    public function youtube_update(Request $request)
    {
        try {
            $youtube = new Youtube();
            list($page,$list) = $youtube->retrieveMyUploads( ($request->session()->has('youtube_page_token') ? $request->session()->get('youtube_page_token') : null) );
            $request->session()->put('youtube_page_token',$page);
            //saves videos and adds a column in the list to show new ot not
            $list = $this->youtube_storeVideos($list);
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            header('HTTP/1.1 500 (' . $e->getCode() . ') ' . str_replace(array("\r", "\n"), '', $e->getMessage()));
            header('Content-Type: application/json; charset=UTF-8');
            echo json_encode(array(
                "result" => "error",
                "message" => "A database error occurred trying to update Youtube (" . $e->getCode() . " - " . $e->getMessage() . ")",
                "error" => $e->getMessage(),
                "code" => $e->getCode(),
            ));
            exit;
        }
        catch (\Exception $e)
        {
            header('HTTP/1.1 500 (' . $e->getCode() . ') ' . str_replace(array("\r", "\n"), '', $e->getMessage()));
            header('Content-Type: application/json; charset=UTF-8');
            echo json_encode(array(
                "result" => "error",
                "message" => "An error occurred trying to update Youtube (" . $e->getCode() . " - " . $e->getMessage() . ")",
                "error" => $e->getMessage(),
                "code" => $e->getCode(),
            ));
            exit;
        }

        return response([
            'result' => 'ok',
            'count'  => count($list),
            'page'   => $page,
            "list"   => json_encode($list,JSON_PRETTY_PRINT) ]);
    }

    private function youtube_storeVideos($videos)
	{
	    $youtube_service = Service::find(1);
		foreach ($videos as $key => &$video) {
            //TODO might be faster creating a collection of videos
            //DB::enableQueryLog();
            $oldVideo = Video::withTrashed()
                ->where('service_id', 1)
                ->where('cloud_id',$video['cloud_id'])
                ->first();
            //$query = DB::getQueryLog();

            if (!$oldVideo) {
                $newVideo = Video::create($video);
                $newVideo->service()->associate($youtube_service);
                $newVideo->save();
                $video = ['video' => $video, 'new' => true];
            } else {
                $video = ['video' => $video, 'new' => false];
            }
		}
		return $videos;
	}

	//Vimeo
    public function vimeo_index(){
        $page_token = (session()->has('vimeo_page_token') ? session()->get('vimeo_page_token') : null);
        return view('vimeo.index', compact('page_token'));
    }

    public function vimeo_clear(Request $request){
        $request->session()->forget('vimeo_page_token');
        return redirect(action('YoutubeController@vimeo_index'));
    }

    public function vimeo_update(Request $request)
    {
        try {
            $per_page = 100;
            $page_token = ($request->session()->has('vimeo_page_token') ? $request->session()->get('vimeo_page_token') : null);
            $service = Service::find(2);
            $videos = [];

            if   ($page_token) {
                $response = Vimeo::request($page_token, array(), 'GET');
            } else {
                $options = [
                    'per_page' => $per_page,
                    'fields' => 'uri, duration, pictures.uri, pictures.active, name, description, release_time, link, stats.plays, embed.html',
                    //                'filter'             => 'upload_date',
                    //                'filter_upload_date' => $period, // "day", "month", or "year"
                    'sort' => 'date',
                    'direction' => 'desc'
                ];

                $response = Vimeo::request('/me/videos', $options, 'GET');
            }

            foreach ($response["body"]["data"] as $i => $item) {

                $object = json_decode(json_encode($item), FALSE);

                $video_id = rtrim($object->uri, '/'); //rtrim to support apache-style-canonical URLs
                $video_id = explode('/', $video_id);
                $video_id = end($video_id);

                if (!empty($object->pictures->uri) && $object->pictures->active) {
                    $image_size_url = [
                        "xs" => "https://i.vimeocdn.com/video/" . $video_id . "_100x75.jpg?r=pad",
                        "sm" => "https://i.vimeocdn.com/video/" . $video_id . "_200x150.jpg?r=pad",
                        "md" => "https://i.vimeocdn.com/video/" . $video_id . "_295x166.jpg?r=pad",
                        "lg" => "https://i.vimeocdn.com/video/" . $video_id . "_640x360.jpg?r=pad",
                        "xl" => "https://i.vimeocdn.com/video/" . $video_id . "_960x540.jpg?r=pad",
                        "xx" => "https://i.vimeocdn.com/video/" . $video_id . "_1280x720.jpg?r=pad",
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
                $video["position"]     = (intval($response['body']['page']) - 1) * $per_page + $i;


                // search for the video to check if its new
                if (!Video::withTrashed()
                    ->where('service_id', 2)
                    ->where('cloud_id', $video['cloud_id'])
                    ->first()
                ) {
                    //use array of mapped fields to create object
                    $newVideo = Video::create($video);
                    $newVideo->service()->associate($service);
                    $newVideo->save();
                    $video = ['video' => $video, 'new' => true];
                } else {
                    $video = ['video' => $video, 'new' => false];
                }

                $videos[] = $video;

            }

            $page_token = $response["body"]["paging"]["next"];
            session()->put('vimeo_page_token', $page_token);
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            header('HTTP/1.1 500 (' . $e->getCode() . ') ' . str_replace(array("\r", "\n"), '', $e->getMessage()));
            header('Content-Type: application/json; charset=UTF-8');
            echo json_encode(array(
                "result" => "error",
                "message" => "A database error occurred trying to update Vimeo (" . $e->getCode() . " - " . $e->getMessage() . ")",
                "error" => $e->getMessage(),
                "code" => $e->getCode(),
            ));
            exit;
        }
        catch (\Exception $e)
        {
            header('HTTP/1.1 500 (' . $e->getCode() . ') ' . str_replace(array("\r", "\n"), '', $e->getMessage()));
            header('Content-Type: application/json; charset=UTF-8');
            echo json_encode(array(
                "result" => "error",
                "message" => "An error occurred trying to update Vimeo (" . $e->getCode() . " - " . $e->getMessage() . ")",
                "error" => $e->getMessage(),
                "code" => $e->getCode(),
            ));
            exit;
        }

        return response([
                'result' => 'ok',
                'count'  => count($videos),
                'total'  => $response['body']['total'],
                'page_num' => $response['body']['page'],
                'page'   => $page_token,
                "list"   => json_encode($videos,JSON_PRETTY_PRINT)
            ]);
    }

}
