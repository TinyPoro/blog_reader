<?php
/**
 * Created by PhpStorm.
 * User: tinyporo
 * Date: 08/04/2018
 * Time: 22:40
 */

namespace Dok123\BlogReader\Adapter;


abstract class ReaderAbstract implements ReaderInterface
{
    protected $url;
    protected $api_key;
    protected $client;

    public $keyword;

    protected $info;
    protected $page;
}