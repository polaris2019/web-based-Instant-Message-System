<?php
namespace app\controller;

use app\BaseController;
use think\facade\View;

class IndexController extends BaseController
{
    public function index()
    {
        return View::fetch('index/index');
    }
}
