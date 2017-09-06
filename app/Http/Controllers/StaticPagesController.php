<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPagesController extends Controller
{
    public function home()
    {
        return view('static_pages/home');
    }

    public function help()
    {
        // 关闭调试工具
        \Debugbar::disable();
        return view('static_pages/help');
    }

    public function about()
    {
        return view('static_pages/about');
    }
}
