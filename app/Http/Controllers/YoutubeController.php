<?php namespace App\Http\Controllers;

use App\Jobs\VimeoUpdate;
use App\Service;
use App\Video;
use App\Youtube;
use App\Http\Requests;
//use App\Http\Requests\Request;
use Illuminate\Http\Request;
use Vinkla\Vimeo\Facades\Vimeo;

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
    public function vimeo_index(Request $request){
        $job = \DB::table('jobs')->where('queue', '=', 'vimeo')->first();
        if (!$job) return view('vimeo.index');
        else return redirect(action('YoutubeController@vimeo_in_progress'));
    }

    public function vimeo_create_job(Request $request){
        $job = \DB::table('jobs')->where('queue', '=', 'vimeo')->first();
        if ($request->isMethod('post') && !$job) {
            $job = (new VimeoUpdate())->onQueue('vimeo');
            $this->dispatch($job);
            $job = \DB::table('jobs')->where('queue', '=', 'vimeo')->first();
        }
        if ($job) return redirect(action('YoutubeController@vimeo_in_progress'));
        else return ('Error creating the job');
    }

    public function vimeo_in_progress(){
        $job = \DB::table('jobs')->where('queue', '=', 'vimeo')->first();
        if (!$job) return view('vimeo.index');
        $date = new \DateTime();
        $date->setTimestamp($job->created_at);
        $ago = $this->ago($date);
//        $videoCount = 2;
//        return view('vimeo.progress',compact('job', 'videoCount'));
        return view('vimeo.progress', compact('job', 'ago'));
    }

    private function pluralize( $count, $text )
    {
        return $count . ( ( $count == 1 ) ? ( " $text" ) : ( " ${text}s" ) );
    }

    private function ago( $datetime )
    {
        $interval = date_create('now')->diff( $datetime );
        $suffix = ( $interval->invert ? ' ago' : '' );
        if ( $v = $interval->y >= 1 ) return $this->pluralize( $interval->y, 'year' ) . $suffix;
        if ( $v = $interval->m >= 1 ) return $this->pluralize( $interval->m, 'month' ) . $suffix;
        if ( $v = $interval->d >= 1 ) return $this->pluralize( $interval->d, 'day' ) . $suffix;
        if ( $v = $interval->h >= 1 ) return $this->pluralize( $interval->h, 'hour' ) . $suffix;
        if ( $v = $interval->i >= 1 ) return $this->pluralize( $interval->i, 'minute' ) . $suffix;
        return $this->pluralize( $interval->s, 'second' ) . $suffix;
    }
}
