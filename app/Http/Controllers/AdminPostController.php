<?php

namespace App\Http\Controllers;

use App\Blog;
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
        $date = Str::slug(Carbon::now());
        $slug = Str::slug($request->title) . '-' . $date;

        $photos = $request->file('photos');
        if (!empty($photos)) {

            $i = 0;

            foreach ($photos as $photo) {
                $photo_extention = $photo->getClientOriginalExtension();
                $photo_name = $i . '.' . $photo_extention;
                Storage::disk('uploads')->makeDirectory('img/blog/' . $slug);
                Storage::disk('uploads')->put('img/blog/' . $slug . '/' . $photo_name, file_get_contents($photo));
                $i++;
            }
        }

        try {

            $request->merge(['slug' => $slug]);

            Blog::create($request->all());
            return response(['processStatus' => 'success', 'processTitle' => 'Successful', 'processDesc' => 'Blog added successfully !']);

        } catch (\Exception $e) {
            return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Blog could not added !', $e]);
        }
    }
}
