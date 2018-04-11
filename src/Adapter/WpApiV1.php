<?php
/**
 * Created by PhpStorm.
 * User: tinyporo
 * Date: 08/04/2018
 * Time: 22:35
 */

namespace Dok123\BlogReader\Adapter;

use Dok123\BlogReader\Entities\BlogItem;
use Dok123\BlogReader\Entities\WpItem;
use GuzzleHttp\Client;

class WpApiV1 extends ReaderAbstract
{
    const BASE_URL = 'https://public-api.wordpress.com/rest/v1/sites/';

    protected $api_key = '';
    protected $cur_page = 1;

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
        $post_url = $this->info->getMeta()->links->posts;

        $url =  $post_url."?number=$per_page";

        if($page) {
            $url .= "&page=$page";
        }else $url .= "&page=$this->cur_page";

        if($fields) {
            $field_string = '';

            foreach ($fields as $key => $field){
                if($key == count($fields)-1) $field_string .= $field;
                else $field_string .= $field.',';
            }

            $url .= '&fields='.$field_string;
        }

        $postResponse = $this->makeRequest($url);

        $this->page = $postResponse;

        return $postResponse;
    }

    public function next(){
        $this->cur_page++;
        $this->posts();
        if($this->page['found'] == 0){
            $this->cur_page--;
            return false;
        }

        return true;
    }

    public function current_page(){
        return $this->cur_page;
    }

    public function setKeyword($keyword){
        $this->keyword = $keyword;

        $post_url = $this->info->getMeta()->links->posts;

        $url = $post_url."?search=$this->keyword";
        $this->page = $this->makeRequest($url);

        return $this->page;
    }

    public function resetKeyword(){
        $this->keyword = '';
    }

    public function labels($limit = 100){
        $result = [];

        $tag_url = self::BASE_URL.$this->url."/tags/?number=$limit";

        $tags = $this->makeRequest($tag_url);
        foreach ($tags['tags'] as $tag){
            $result[] = $tag;
        }
        if($tags['found'] < $limit){
            $remain = $limit - $tags['found'];
            $category_url = self::BASE_URL.$this->url."/categories/?number=$remain";
            $categories = $this->makeRequest($category_url);

            foreach ($categories['categories'] as $category){
                $result[] = $category;
            }
        }

        return $result;
    }

    protected function makeRequest($url){
        $response = $this->client->request('GET', $url);
        $objectResponse = json_decode($response->getBody());
        $arrayResponse = (array) $objectResponse;

        return $arrayResponse;
    }

    protected function makeGetInfoUrl(){
        return self::BASE_URL.$this->url;
    }

    protected function setInfoData($arrayResponse){
        $item = new WpItem();

        foreach ($arrayResponse as $key => $value){
            $function_name = 'set'.ucfirst($key);
            $item->$function_name($value);
        }

        $this->info = $item;
    }
}