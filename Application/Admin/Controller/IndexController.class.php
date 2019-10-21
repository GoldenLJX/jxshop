<?php
namespace Admin\Controller;
class IndexController extends CommonController {
    public function index(){
       $this->display();
    }
    public function top(){
        $this->display();
    }
    public function menu(){
        $this->display();
    }
    public function main(){
        $this->display();
    }
    public function testUrl(){
    echo U('index','id=2');
}
}