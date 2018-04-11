<?php
/**
 * Created by PhpStorm.
 * User: tinyporo
 * Date: 09/04/2018
 * Time: 12:51
 */

namespace Dok123\BlogReader\Entities;


class WpItem{
    private $ID;
    private $name;
    private $description;
    private $jetpack;
    private $subscribers_count;
    private $lang;
    private $url;
    private $icon;
    private $logo;
    private $visible;
    private $is_following;
    private $is_private;
    private $meta;

    public function setJetpack($jetpack){
        $this->jetpack = $jetpack;
    }

    public function getJetpack(){
        return $this->jetpack;
    }

    public function setLang($lang){
        $this->lang = $lang;
    }

    public function getLang(){
        return $this->lang;
    }

    public function setID($id){
        $this->ID = $id;
    }

    public function getID(){
        return $this->ID;
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

    public function setSubscribers_count($subscribers_count){
        $this->subscribers_count = $subscribers_count;
    }

    public function getSubscribers_count(){
        return $this->subscribers_count;
    }

    public function setIcon($icon){
        $this->icon = $icon;
    }

    public function getIcon(){
        return $this->icon;
    }

    public function setUrl($url){
        $this->url = $url;
    }

    public function getUrl(){
        return $this->url;
    }

    public function setLogo($logo){
        $this->logo = $logo;
    }

    public function getLogo(){
        return $this->logo;
    }

    public function setVisible($visible){
        $this->visible = $visible;
    }

    public function getVisible(){
        return $this->visible;
    }

    public function setIs_following($is_following){
        $this->is_following = $is_following;
    }

    public function getIs_following(){
        return $this->is_following;
    }

    public function setIs_private($is_private){
        $this->is_private = $is_private;
    }

    public function getIs_private(){
        return $this->is_private;
    }

    public function setMeta($meta){
        $this->meta = $meta;
    }

    public function getMeta(){
        return $this->meta;
    }
}