<?php
namespace app\bis\controller;

use think\Controller;

class Login extends Controller
{
    private $city;
    private $category;
    public function initialize() {
        $this->city = model('city');
        $this->category = model('category');
    }
    public function index() {
        return $this->fetch();
    }

    public function register() {
        $city = [];
        $category = [];
        $this->city->getNormalFirstCity($city);
        $this->category->getNormalFirstCategory($category);
        return $this->fetch('', compact('city', 'category'));
    }
}