<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Category;
use App\Settings;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminPostController extends AdminController
{
    public function post_settings(Request $request)
    {

        if (isset($request->logo)) {

            $validator = Validator::make($request->all(), [
                'logo' => 'mimes:jpg,jpeg,png,gif',
            ]);

            if ($validator->fails()) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Images extentions must be "jpg,jpeg,png,gif" !']);
            }
            $logo = $request->file('logo');
            $logo_extention = $request->file('logo')->getClientOriginalExtension();
            $logo_name = 'logo.' . $logo_extention;
            Storage::disk('uploads')->makeDirectory('img');
            Image::make($logo->getRealPath())->resize(222, 108)->save('uploads/img/' . $logo_name);
        }
        try {
            unset($request['_token']);
            if (isset($request->logo)) {
                unset($request['prevLogo']);

                Settings::where('id', 1)->update($request->all());
                Settings::where('id', 1)->update(['logo' => $logo_name]);

            } else {
                $prevLogo = $request->prevLogo;
                unset($request['prevLogo']);
                Settings::where('id', 1)->update($request->all());
                Settings::where('id', 1)->update(['logo' => $prevLogo]);
            }
            return response(['processStatus' => 'success', 'processTitle' => 'Successful', 'processDesc' => 'Changes saved successfully !']);

        } catch
        (\Exception $e) {
            return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Changes could not saved !']);
        }
    }

    public function post_blog(Request $request)
    {
//        Add Blog Section

        if ($request->get('check') == 'blogForm') {
            $validator = Validator::make($request->all(), [
                'photos[]' => 'nullable|mimes:jpg,jpeg,png,gif',
                'title' => 'required|max:250',
                'short_content' => 'max:250',
                'description' => 'required',
                'tags' => 'required|max:250',
            ]);
            if ($validator->fails()) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Fill the required blanks !']);
            }
            $date = Str::slug(Carbon::now());
            $slug = Str::slug($request->title) . '-' . $date;

            $photos = $request->file('photos');
            if (!empty($photos)) {

                foreach ($photos as $photo) {
                    $randName = rand(1, 9999) . rand(1, 9999) . rand(1, 9999);
                    $photo_extention = $photo->getClientOriginalExtension();
                    $photo_name = $randName . '.' . $photo_extention;
                    Storage::disk('uploads')->makeDirectory('img/blog/' . $slug);
                    Storage::disk('uploads')->put('img/blog/' . $slug . '/' . $photo_name, file_get_contents($photo));
                }
            }

            try {

                $request->merge(['slug' => $slug]);

                Blog::create($request->all());
                return response(['processStatus' => 'success', 'processTitle' => 'Successful', 'processDesc' => 'Blog added successfully !']);
            } catch (\Exception $e) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Blog could not added !', $e]);
            }


        } else {

//           Delete Blog Section

//            try {
            Blog::where('slug', $request->slug)->delete();
            Storage::disk('uploads')->deleteDirectory('img/blog/' . $request->slug);
            return response(['processStatus' => 'success', 'processTitle' => 'Successful', 'processDesc' => 'Blog deleted successfully !']);
//            } catch (\Exception $e) {
            return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Blog could not deleted !', $e]);
//            }
        }

    }

    public function post_edit_blog($slug, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photos[].' => 'image|mimes:jpg,jpeg,png,gif',
            'title' => 'required|max:250',
            'short_content' => 'max:250',
            'description' => 'required',
            'tags' => 'required|max:250',
            'category' => 'required',
        ]);
        if ($validator->fails()) {
            return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Fill the required blanks !']);
        }
        if (isset($request->photo)) {
            try {
                Storage::disk('uploads')->delete($request->photo);
                return response(['processStatus' => 'success', 'processTitle' => 'Successful', 'processDesc' => 'Image deleted successfully !']);
            } catch (\Exception $e) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Image could not deleted !', 'error' => $e]);
            }

        } else {
            $photos = $request->file('photos');
            if (!empty($photos)) {
                foreach ($photos as $photo) {
                    $photo_extention = $photo->getClientOriginalExtension();
                    $photo_name = rand(1, 9999) . rand(1, 9999) . rand(1, 9999) . '.' . $photo_extention;
                    Storage::disk('uploads')->makeDirectory('img/blog/' . $slug);
                    Storage::disk('uploads')->put('img/blog/' . $slug . '/' . $photo_name, file_get_contents($photo));
                }
            }

            try {
                Blog::where('slug', $slug)->update([
                    'title' => $request->title,
                    'short_content' => $request->short_content,
                    'description' => $request->description,
                    'tags' => $request->tags,
                    'category' => $request->category,
                ]);
                return response(['processStatus' => 'success', 'processTitle' => 'Successful', 'processDesc' => 'Blog updated successfully !']);

            } catch (\Exception $e) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Blog could not updated !', 'error' => $e]);
            }


        }
    }

    public function post_category(Request $request)
    {
        if ($request->get('name')) {

            $validator = Validator::make($request->all(), [
                'name' => 'required| max:250',
            ]);

            if ($validator->fails()) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Please fill <u>Category Name</u> !']);
            }
            try {
                $slug = str::slug($request->name);
                $request->merge(['slug' => $slug]);
                Category::create($request->all());
                return response(['processStatus' => 'success', 'processTitle' => 'Successful', 'processDesc' => 'Category added successfully !']);

            } catch (\Exception $e) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Category could not added !', 'error' => $e]);
            }
        }else{
            try {
                Category::where('id',$request->id)->delete();
                return response(['processStatus' => 'success', 'processTitle' => 'Successful', 'processDesc' => 'Category deleted successfully !']);

            } catch (\Exception $e) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Category could not deleted !', 'error' => $e]);
            }
        }
    }
}
