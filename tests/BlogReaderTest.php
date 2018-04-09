<?php
/**
 * Created by PhpStorm.
 * User: tinyporo
 * Date: 09/04/2018
 * Time: 13:32
 */

namespace Dok123\TestReader;

use Dok123\BlogReader\BlogReader;
use Dok123\BlogReader\Exceptions\BlogNotFoundException;
use PHPUnit\Framework\TestCase;

final class BlogReaderTest extends TestCase {
    protected $reader;

    protected function setUp(){
        $this->reader = new BlogReader();
    }

    public function testFromUrlBlogNotFound(){
        $this->expectException(BlogNotFoundException::class);
    }

    public function testFromUrl(){
        $this->assertInstanceOf("a", "b");
        $this->assertInstanceOf("a", "b");
        $this->assertInstanceOf("a", "b");
        $this->assertInstanceOf("a", "b");
    }
}