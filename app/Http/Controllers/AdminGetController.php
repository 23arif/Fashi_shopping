<?php

namespace App\Http\Controllers;

use App\Settings;

class AdminGetController extends AdminController
{
    public function get_index()
    {
        return view('backend.index');
    }

    public function get_settings()
    {
        $settings = Settings::where('id', 1)->select('settings.*')->first();
        return view('backend.settings')->with('settings', $settings);
    }
    public function get_blog()
    {
        return view('backend.blog');
    }
}
