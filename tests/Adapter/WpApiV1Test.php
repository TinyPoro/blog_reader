<?php
/**
 * Created by PhpStorm.
 * User: tinyporo
 * Date: 09/04/2018
 * Time: 13:32
 */

namespace Dok123\TestReader\Adapter;

use Dok123\BlogReader\Adapter\WpApiV1;
use Dok123\BlogReader\Adapter\WpApiV2;
use Dok123\BlogReader\BlogReader;
use Dok123\BlogReader\Exceptions\BlogNotFoundException;
use PHPUnit\Framework\TestCase;

final class WpApiV1Test extends TestCase {
    public function testWp1Reader(){
        $reader = BlogReader::fromUrl("en.blog.wordpress.com");

        $this->assertSame('The WordPress.com Blog', $reader->getInfo()['name']);

        $post_array = ['ID'];
        $this->assertSame(1409, $reader->posts($post_array, null, 5)['found']);

        $this->assertSame(true, $reader->next());
        $this->assertSame(2, $reader->current_page());

        $this->assertSame(0, $reader->setKeyword('Nguyễn Văn Vĩnh')['found']);
        $reader->resetKeyword();
        $this->assertSame('', $reader->keyword);

        $this->assertSame(true, count($reader->labels(10)) <= 10);
    }
}