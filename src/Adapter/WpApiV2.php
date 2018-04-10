<?php
/**
 * Created by PhpStorm.
 * User: tinyporo
 * Date: 08/04/2018
 * Time: 22:35
 */

namespace Dok123\BlogReader\Adapter;

use Dok123\BlogReader\Entities\Item;
use GuzzleHttp\Client;

class WpApiV2 extends ReaderAbstract
{
    const BASE_URL = 'https://www.googleapis.com/blogger/v3/blogs/byurl?url=';

    protected $api_key = 'AIzaSyB4MhXuv8H2crxS_vi4AFlfi0Ndu1F0Zm8';

    public function __construct($url)
    {
        $this->url = $url;
        $this->client = new Client(array('curl' => array( CURLOPT_SSL_VERIFYPEER => false,),));
    }

    public function getInfo(){
        $infoResponse = $this->makeRequest($this->makeGetInfoUrl());

        $this->setInfoData($infoResponse);

        return $infoResponse;
    }

    public function posts(array $fields = null, $page = null, $per_page = 20){
        $post_url = $this->info->getPosts()->selfLink;

        $url =  $post_url.'?key='.$this->api_key."&maxResults=$per_page";

        if($fields) {
            $field_string = 'kind, nextPageToken, items(';

            foreach ($fields as $key => $field){
                if($key == count($fields)-1) $field_string .= $field;
                else $field_string .= $field.',';
            }

            $field_string .= ')';

            $url .= '&fields='.$field_string;
        }

        if($page) {
            $url .= '&pageToken='.$page;
        }

        $postResponse = $this->makeRequest($url);

        $this->page = $postResponse;

        return $postResponse;
    }

    public function next(){
        if(!array_key_exists('nextPageToken', $this->page) || $this->page['nextPageToken'] == null) {
            return false;
        } else {
//            $post_url = $this->info->getPosts()->selfLink;
//
//            $url = $post_url.'?key='.$this->api_key.'&pageToken='.$this->page['nextPageToken'];
//            $this->page = $this->makeRequest($url);
            $this->posts(null, $this->page['nextPageToken']);

            return true;
        }
    }

    public function current_page(){
        return $this->page['nextPageToken'];
    }

    public function setKeyword($keyword){
        $this->keyword = $keyword;

        $post_url = $this->info->getPosts()->selfLink;

        $url = $post_url.'/search?key='.$this->api_key.'&q='.$this->keyword;
        $this->page = $this->makeRequest($url);

        return $this->page;
    }

    public function resetKeyword(){
        $this->keyword = '';
    }

    public function labels($limit = 100){
        $labels = [];

        foreach ($this->page['items'] as $item){
            foreach ($item->labels as $label){
                if (count($labels) == $limit) break;

                $labels[] = $label;
            }
        }

        return $labels;
    }

    protected function makeRequest($url){
        $response = $this->client->request('GET', $url);
        $objectResponse = json_decode($response->getBody());
        $arrayResponse = (array) $objectResponse;

        return $arrayResponse;
    }

    protected function makeGetInfoUrl(){
        return self::BASE_URL.$this->url.'&key='.$this->api_key;
    }

    protected function setInfoData($arrayResponse){
        $item = new Item();

        foreach ($arrayResponse as $key => $value){
            $function_name = 'set'.ucfirst($key);
            $item->$function_name($value);
        }

        $this->info = $item;
    }
}