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
//    public function testFromUrlBlogNotFound(){
//        $this->expectException(BlogNotFoundException::class);

//        BlogReader::fromUrl("abc");
//        BlogReader::fromUrl("https://www.facebook.com/");
//    }

    public function testFromUrl(){
        $this->assertInstanceOf(\Dok123\BlogReader\Adapter\BlogReader::class, BlogReader::fromUrl("http://nhilinhblog.blogspot.com/"));
//        $this->assertInstanceOf(WpApiV1::class, BlogReader::fromUrl("http://shes.vn/"));
//        $this->assertInstanceOf(WpApiV2::class, BlogReader::fromUrl("http://shes.vn/"));
    }

    public function testBlogReader(){
        $reader = BlogReader::fromUrl("http://nhilinhblog.blogspot.com/");

        $this->assertSame('Nhị Linh', $reader->getInfo()['name']);

        $post_array = ['kind', 'id', 'author', 'url'];
        $this->assertSame(5, count($reader->posts($post_array, null, 5)['items']));
        $this->assertSame('http://nhilinhblog.blogspot.com/2018/03/maiakovski-o-viet-nam.html', $reader->posts($post_array)['items'][19]->url);

        $this->assertSame(true, $reader->next());
        $this->assertSame($reader->posts()['nextPageToken'], $reader->current_page());

        $this->assertSame(10, count($reader->setKeyword('Nguyễn Văn Vĩnh')['items']));
        $reader->resetKeyword();
        $this->assertSame('', $reader->keyword);

        $this->assertSame(10, count($reader->labels(10)));
    }
}