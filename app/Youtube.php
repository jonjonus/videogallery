<?php namespace App;

//require_once 'vendor/autoload.php';

class Youtube
{
	private $list = [];
	
	function __construct()
	{
		# code...
	}

    public function retrieveMyUploads($pageToken)
    {
        $videos = [];
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . dirname(dirname(__FILE__)) . '/' . 'VideoGallery-1cb59528930f.json');
        $client = new \Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->setScopes('https://www.googleapis.com/auth/youtube');

        $youtube = new \Google_Service_YouTube($client);
        //TODO implement multiple channels
//        $channelsResponse = $youtube->channels->listChannels('contentDetails', array("forUsername" => 'CreativaFlashVideos'));
//        foreach ($channelsResponse['items'] as $channel) {
//            $uploadsListId = $channel['contentDetails']['relatedPlaylists']['uploads'];
//            $options = ['playlistId' => $uploadsListId, 'maxResults' => 50 ];
//            $page = session('youtube_page');
//
//            $playlistItemsResponse = $youtube->playlistItems->listPlaylistItems('snippet',$options);
//            $page = $playlistItemsResponse->getNextPageToken();
//            foreach ($playlistItemsResponse['items'] as $playlistItem) {
//                $video = [ 'title' => $playlistItem['snippet']['title'], 'id' =>  $playlistItem['snippet']['resourceId']['videoId'] ];
//                print_r($videos);
//                $videos[] = $video;
//            }
//        }
        $options = ['playlistId' => "UUvGdkH-6g8lz6RSoq1fO-XA", 'maxResults' => 50];
        if ($pageToken) $options['pageToken'] = $pageToken; //if we are paginating
        $playlistItemsResponse = $youtube->playlistItems->listPlaylistItems('snippet', $options);
        foreach ($playlistItemsResponse['items'] as $playlistItem) {
            $video = [];
            $video['channel_id']    = $playlistItem['snippet']['channelId'];
            $video['channel_title'] = $playlistItem['snippet']['channelTitle'];
            $video['cloud_id']      = $playlistItem['snippet']['resourceId']['videoId'];
            $video['title']         = $playlistItem['snippet']['title'];
            $video['description']   = $playlistItem['snippet']['description'];
            $video['playlist_id']   = $playlistItem['snippet']['playlistId'];
            $video['position']      = $playlistItem['snippet']['position'];
            $video['produced_at']   = $playlistItem['snippet']['publishedAt'];
            $video['service_id']    = '1'; //TODO use constants
            $video['thumbnail']     = ( $playlistItem['snippet']['thumbnails']['standard']['url'] ? $playlistItem['snippet']['thumbnails']['standard']['url']  : "");
            $video['thumbnail_sm']  = ( $playlistItem['snippet']['thumbnails']['default']['url'] ? $playlistItem['snippet']['thumbnails']['default']['url']  : "");
            $video['thumbnail_hq']  = ( $playlistItem['snippet']['thumbnails']['maxres']['url'] ? $playlistItem['snippet']['thumbnails']['maxres']['url']  : "");
            $video["ignore"]        = false;
            $video["new"]           = true;
            $video["client_id"]     = null;
            $videos[] = $video;
        }
        $pageToken = $playlistItemsResponse->nextPageToken;
        return [$pageToken,$videos];
    }
} //class