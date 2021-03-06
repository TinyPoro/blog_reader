<?php
/**
 * Created by PhpStorm.
 * User: tinyporo
 * Date: 08/04/2018
 * Time: 22:35
 */

namespace Dok123\BlogReader\Adapter;

use Dok123\BlogReader\Entities\BlogItem;
use Dok123\BlogReader\Entities\Wp2Item;
use GuzzleHttp\Client;

class WpApiV2 extends ReaderAbstract
{
    const BASE_URL = '';

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
        $post_url = $this->url.'/wp-json/wp/v2/posts';

        $url =  $post_url.'?per_page='.$per_page;

        if($fields) {
            $field_string = '';

            foreach ($fields as $key => $field){
                if($key == count($fields)-1) $field_string .= $field;
                else $field_string .= $field.',';
            }

            $url .= '&context='.$field_string;
        }

        if($page) {
            $url .= '&page='.$page;
        }

        $postResponse = $this->makeRequest($url);

        $this->page = $postResponse;

        return $postResponse;
    }

     public function next(){
        $this->cur_page++;
        $this->posts();
        if(isset($this->page['code'])){
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

        $post_url = $this->url.'/wp-json/wp/v2/posts';

        $url = $post_url."?search=$this->keyword";
        $this->page = $this->makeRequest($url);

        return $this->page;
    }

    public function resetKeyword(){
        $this->keyword = '';
    }

    public function labels($limit = 100){
        $result = [];

        $tag_url = $this->url."/wp-json/wp/v2/tags?per_page=$limit";
        
        $tags = $this->makeRequest($tag_url);
        foreach ($tags as $tag){
            $result[] = $tag;

            if(count($result) == $limit)  break;
        }
        if(count($result) < $limit){
            $remain = $limit - count($tags);
            $category_url = $this->url."/wp-json/wp/v2/categories?per_page=$remain";
            $categories = $this->makeRequest($category_url);

            foreach ($categories as $category){
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
        return $this->url.'/wp-json';
    }

    protected function setInfoData($arrayResponse){
        $item = new Wp2Item();

        $item->setName($arrayResponse['name']);
        $item->setDescription($arrayResponse['name']);
        $item->setUrl($arrayResponse['name']);
        $item->setHome($arrayResponse['home']);
        $item->setNamespaces($arrayResponse['namespaces']);

        $this->info = $item;
    }
}
