<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;


class HomePostController extends HomeController
{
    public function post_blog_comment(Request $request, $slug)
    {
        if (Auth::check()) {
            $validator = Validator::make($request->all(), [
                'content' => 'required',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:250',
                'email' => 'required|email',
                'content' => 'required',
            ]);
        }
        if ($validator->fails()) {
            return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Fill the required blanks !']);
        }
        $category = explode('/', $slug); //Explodes category slugs
        $request->merge(['blog' => $category[count($category) - 1]]);
        if(Auth::check()){
        $request->merge(['user_id'=>Auth::user()->id]);
        }
        Comment::create($request->all());
        return response(['processStatus' => 'success', 'processTitle' => 'Successful', 'processDesc' => 'Comment sended successfully !']);


    }
}
