<?php

namespace App\Http\Controllers;

use App\Comment;
use App\FaqComment;
use App\FaqTopic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
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
        if (Auth::check()) {
            $request->merge(['user_id' => Auth::user()->id]);
        }
        Comment::create($request->all());
        return response(['processStatus' => 'success', 'processTitle' => 'Successful', 'processDesc' => 'Comment sended successfully !']);


    }

    public function post_add_faq(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'prime_title' => 'required| max:250',
            'title' => 'required| max:250',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Please fill required blanks !']);
        }
        try {
            $author = Auth::user()->id;
            $date = Str::slug(Carbon::now());
            $slug = Str::slug($request->title) . '-' . $date;
            $request->merge(['slug' => $slug, 'author' => $author]);
            FaqTopic::create($request->all());
            return response(['processStatus' => 'success', 'processTitle' => 'Successful', 'processDesc' => 'Question added successfully !']);

        } catch (\Exception $e) {
            return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Question could not added !', 'error' => $e]);
        }
    }

    public function post_faq_question_comments(Request $request, $topic, $question_details)
    {
        $validator = Validator::make($request->all(), [
            'faq_content' => 'required',
        ]);
        if ($validator->fails()) {
            return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Fill the required blanks !']);
        }
        $request->merge(['user_id' => Auth::user()->id, 'faq' => $question_details]);

        FaqComment::create($request->all());
        return response(['processStatus' => 'success', 'processTitle' => 'Successful', 'processDesc' => 'Comment sended successfully !']);


    }

    public function post_delete_faq(Request $request){
        $status = $request->status;
        if($status == 'delete'){
            try {
                FaqTopic::where('id', $request->id)->delete();
                return response(['processStatus' => 'success', 'processTitle' => 'Successful', 'processDesc' => 'Question deleted successfully !']);
            } catch (\Exception $e) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Question could not deleted !', 'error' => $e]);
            }
        }elseif($status == 'hide'){
            try {
                FaqTopic::where('id',$request->id)->update(['show_hide'=>'0']);
                return response(['processStatus' => 'success', 'processTitle' => 'Successful', 'processDesc' => 'Question hidded successfully !']);
            } catch (\Exception $e) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Question could not hidded !', 'error' => $e]);
            }
        }else{
            try {
                FaqTopic::where('id',$request->id)->update(['show_hide'=>'1']);
                return response(['processStatus' => 'success', 'processTitle' => 'Successful', 'processDesc' => 'Question showed successfully !']);
            } catch (\Exception $e) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Question could not showed !', 'error' => $e]);
            }
        }
    }
}
