<?php
/**
 * Created by PhpStorm.
 * User: tinyporo
 * Date: 09/04/2018
 * Time: 12:51
 */

namespace Dok123\BlogReader\Entities;


class BlogItem{
    private $kind;
    private $id;
    private $name;
    private $description;
    private $published;
    private $updated;
    private $url;
    private $selfLink;
    private $posts;
    private $pages;
    private $locale;

    public function setKind($kind){
        $this->kind = $kind;
    }

    public function getKind(){
        return $this->kind;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getId(){
        return $this->id;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function getName(){
        return $this->name;
    }

    public function setDescription($description){
        $this->description = $description;
    }

    public function getDescription(){
        return $this->description;
    }

    public function setPublished($published){
        $this->published = $published;
    }

    public function getPublished(){
        return $this->published;
    }

    public function setUpdated($updated){
        $this->updated = $updated;
    }

    public function getUpdated(){
        return $this->updated;
    }

    public function setUrl($url){
        $this->url = $url;
    }

    public function getUrl(){
        return $this->url;
    }

    public function setSelfLink($selfLink){
        $this->selfLink = $selfLink;
    }

    public function getSelfLink(){
        return $this->selfLink;
    }

    public function setPosts($posts){
        $this->posts = $posts;
    }

    public function getPosts(){
        return $this->posts;
    }

    public function setPages($pages){
        $this->pages = $pages;
    }

    public function getPages(){
        return $this->pages;
    }

    public function setLocale($locale){
        $this->locale = $locale;
    }

    public function getLocale(){
        return $this->locale;
    }
}