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

final class WpApiV2Test extends TestCase {
    public function testWp2Reader(){
        $reader = BlogReader::fromUrl("http://demo.wp-api.org");

        $this->assertSame('WP REST API Demo', $reader->getInfo()['name']);

        $post_array = ['embed'];
        $this->assertSame(5, count($reader->posts($post_array, null, 5)));

        $this->assertSame(true, $reader->next());
        $this->assertSame(2, $reader->current_page());

        $this->assertSame(1, count($reader->setKeyword('demo')));
        $reader->resetKeyword();
        $this->assertSame('', $reader->keyword);

        $this->assertSame(true, count($reader->labels(10)) <= 10);
    }
}