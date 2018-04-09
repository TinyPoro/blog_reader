<?php
/**
 * Created by PhpStorm.
 * User: tinyporo
 * Date: 08/04/2018
 * Time: 22:31
 */

namespace Dok123\BlogReader;

use Dok123\BlogReader\Adapter\WpApiV1;
use Dok123\BlogReader\Adapter\WpApiV2;
use Dok123\BlogReader\Exceptions\BlogNotFoundException;

class BlogReader
{
    public static function fromUrl($url){
        try{
            $adapter = new Adapter\BlogReader($url);
        }catch (\Exception $e){dump("a");
            try{
                $adapter = new WpApiV1($url);
            }catch (\Exception $e){
                try{
                    $adapter = new WpApiV2($url);
                }catch (\Exception $e){
                    throw new BlogNotFoundException('Not support');
                }
            }
        }
        return $adapter;
    }

    public function test(){
        $url = 'https://www.googleapis.com/blogger/v3/blogs/2399953?key=YOUR-API-KEY';
    }
}