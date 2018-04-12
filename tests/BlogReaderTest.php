<?php
/**
 * Created by PhpStorm.
 * User: tinyporo
 * Date: 09/04/2018
 * Time: 13:32
 */

namespace Dok123\TestReader;

use Dok123\BlogReader\Adapter\WpApiV1;
use Dok123\BlogReader\Adapter\WpApiV2;
use Dok123\BlogReader\BlogReader;
use Dok123\BlogReader\Exceptions\BlogNotFoundException;
use PHPUnit\Framework\TestCase;

final class BlogReaderTest extends TestCase {
    public function testFromUrlBlogNotFound(){
        $this->expectException(BlogNotFoundException::class);

        BlogReader::fromUrl("abc");
        BlogReader::fromUrl("https://www.facebook.com/");
    }

    public function testFromUrl(){
        $this->assertInstanceOf(\Dok123\BlogReader\Adapter\BlogReader::class, BlogReader::fromUrl("http://nhilinhblog.blogspot.com/"));
        $this->assertInstanceOf(WpApiV1::class, BlogReader::fromUrl("en.blog.wordpress.com"));
        $this->assertInstanceOf(WpApiV2::class, BlogReader::fromUrl("http://shes.vn/"));
    }
}