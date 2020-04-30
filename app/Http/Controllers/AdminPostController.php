<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Category;
use App\FAQs;
use App\PrBrand;
use App\PrCategory;
use App\PrColor;
use App\Product;
use App\PrSize;
use App\Settings;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use function foo\func;

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
            $check = $request->slider;
            if (!empty($check)) {
                $request->merge(['slider' => '1']);
            } else {
                $request->merge(['slider' => '0']);
            }

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
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Fill the required fields !']);
            }
            $date = Str::slug(Carbon::now());
            $slug = Str::slug($request->title) . '-' . $date;
            $author = Auth::id();

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

                $request->merge(['slug' => $slug, 'author' => $author]);

                Blog::create($request->all());
                return response(['processStatus' => 'success', 'processTitle' => 'Successful', 'processDesc' => 'Blog added successfully !']);
            } catch (\Exception $e) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Blog could not added !', $e]);
            }


        } else {

//           Delete Blog Section

            try {
                Blog::where('slug', $request->slug)->delete();
                Storage::disk('uploads')->deleteDirectory('img/blog/' . $request->slug);
                return response(['processStatus' => 'success', 'processTitle' => 'Successful', 'processDesc' => 'Blog deleted successfully !']);
            } catch (\Exception $e) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Blog could not deleted !', $e]);
            }
        }

    }

    public function post_products(Request $request)
    {
        if ($request->pr_name) {
            $validator = Validator::make($request->all(), [
                'photos[].' => 'image|mimes:jpg,jpeg,png,gif',
                'pr_category' => 'required | max:250',
                'pr_brand' => 'required | max:250',
                'pr_size' => 'required | max:250',
                'pr_name' => 'required | max:250',
                'pr_desc' => 'required',
                'pr_color' => 'required | max:250',
                'pr_tags' => 'required | max:250',
                'pr_last_price' => 'required | max:250',

            ]);
            if ($validator->fails()) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Fill the required fields !']);
            }

            foreach ($request->photos as $photo) {
                $logo_extention = $photo->getClientOriginalExtension();
                $date = Str::slug(Carbon::now());
                $slug = str::slug($request->pr_name) . '-' . $date;
                $image_name = rand(1, 99999) . rand(1, 99999) . rand(1, 99999) . '.' . $logo_extention;
                Storage::disk('uploads')->makeDirectory('img/products/' . $slug);
                Image::make($photo->getRealPath())->resize(226, 226)->save('uploads/img/products/' . $slug . '/' . $image_name);
            }

            try {
                $request->merge(['pr_prev_price' => $request->pr_last_price, 'slug' => $slug]);
                Product::create($request->all());
                return response(['processStatus' => 'success', 'processTitle' => 'Success', 'processDesc' => 'Congratulations , product added successfully !']);
            } catch (\Exception $e) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Product could not added !', 'error' => $e]);
            }
        } elseif ($request->category_name) {
            $validator = Validator::make($request->all(), [
                'category_name' => 'required | max:250 | unique:pr_categories',
                'category_desc' => 'required'
            ]);

            if ($validator->fails()) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Fill the required fields !']);
            }

            $slug = str::slug($request->category_name);

            try {
                $request->merge(['slug' => $slug]);
                PrCategory::create($request->all());
                return response(['processStatus' => 'success', 'processTitle' => 'Success', 'processDesc' => 'Congratulations ,Product category created successfully !']);
            } catch (\Exception $e) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Product Category could not created !', 'error' => $e]);
            }
        } elseif ($request->size) {
            $validator = Validator::make($request->all(), [
                'size' => 'required|unique:pr_size'
            ]);
            if ($validator->fails()) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Fill the required fields correctly !']);
            }

            $slug = str::slug($request->size);


            try {
                $request->merge(['slug' => $slug]);
                PrSize::create($request->all());
                return response(['processStatus' => 'success', 'processTitle' => 'Success', 'processDesc' => 'Congratulations ,Product size created successfully !']);
            } catch (\Exception $e) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Product size could not created !', 'error' => $e]);
            }
        }elseif ($request->brand_desc){
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:pr_brands',
                'brand_desc' => 'required'
            ]);
            if ($validator->fails()) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Fill the required fields correctly !']);
            }

            $slug = str::slug($request->name);

            try {
                $request->merge(['slug' => $slug]);
                PrBrand::create($request->all());
                return response(['processStatus' => 'success', 'processTitle' => 'Success', 'processDesc' => 'Congratulations ,Product brand created successfully !']);
            } catch (\Exception $e) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Product brand could not created !', 'error' => $e]);
            }
        }
    }


    public function post_edit_blog($slug, Request $request)
    {
        if (isset($request->photo)) {
            try {
                Storage::disk('uploads')->delete($request->photo);
                return response(['processStatus' => 'success', 'processTitle' => 'Successful', 'processDesc' => 'Image deleted successfully !']);
            } catch (\Exception $e) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Image could not deleted !', 'error' => $e]);
            }

        }
        $validator = Validator::make($request->all(), [
            'photos[].' => 'image|mimes:jpg,jpeg,png,gif',
            'title' => 'required|max:250',
            'short_content' => 'max:250',
            'description' => 'required',
            'tags' => 'required|max:250',
            'category' => 'required',
        ]);
        if ($validator->fails()) {
            return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Fill the required fields !']);
        }
        if (!isset($request->photo)) {
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

    public
    function post_category(Request $request)
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
        } else {
            try {
                Category::where('id', $request->id)->delete();
                return response(['processStatus' => 'success', 'processTitle' => 'Successful', 'processDesc' => 'Category deleted successfully !']);

            } catch (\Exception $e) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Category could not deleted !', 'error' => $e]);
            }
        }
    }

    public
    function post_faq(Request $request)
    {
        if ($request->only('slug')) {
            try {
                FAQs::where('slug', $request->slug)->delete();
                return response(['processStatus' => 'success', 'processTitle' => 'Success', 'processDesc' => 'FAQ title deleted successfully !']);
            } catch (\Exception $e) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'FAQ title could not deleted !']);
            }

        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required| max:250',
                'short_content' => 'required| max:250',
            ]);

            if ($validator->fails()) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Please fill required blanks !']);
            }
            try {
                $slug = str::slug($request->name);
                $request->merge(['slug' => $slug]);
                FAQs::create($request->all());
                return response(['processStatus' => 'success', 'processTitle' => 'Successful', 'processDesc' => 'FAQ title added successfully !']);

            } catch (\Exception $e) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'FAQ title could not added !', 'error' => $e]);
            }
        }
    }

    public
    function post_edit_faq(Request $request, $slug)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required| max:250',
            'short_content' => 'required| max:250',
        ]);

        if ($validator->fails()) {
            return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Please fill required blanks !']);
        }
        try {
            $newSlug = Str::slug($request->name);
            unset($request['_token']);
            FAQs::where('slug', $slug)->update($request->all());

            return response(['processStatus' => 'success', 'processTitle' => 'Successful', 'processDesc' => 'FAQ title updated successfully !']);

        } catch (\Exception $e) {
            return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'FAQ title could not updated !', 'error' => $e]);
        }

    }

    public
    function post_profile_user(Request $request, $username)
    {
        if ($request->only('logo')) {

            $validator = Validator::make($request->all(), [
                'logo' => 'mimes:jpg,jpeg,png,gif',
            ]);

            if ($validator->fails()) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Please select image for change profile image !']);
            }

            $pr = explode('-', $username);
            $profileName = $pr[0] . '-' . $pr[1];

            $logo = $request->file('logo');
            $logo_extention = $request->file('logo')->getClientOriginalExtension();
            $logo_name = 'profileImage.' . $logo_extention;
            Storage::disk('uploads')->makeDirectory('img/profileImages/' . $profileName);
            Image::make($logo->getRealPath())->resize(226, 226)->save('uploads/img/profileImages/' . $profileName . '/' . $logo_name);


            unset($request['_token']);

            try {
                User::where('id', $pr[count($pr) - 1])->update(['profile_image' => $logo_name]);
                return response(['processStatus' => 'success', 'processTitle' => 'Success', 'processDesc' => 'Congratulations , profile image updated!']);
            } catch (\Exception $e) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Profile image could not updated !', 'error' => $e]);
            }

        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:250',
                'email' => 'required|email|max:250 ',
            ]);

            if ($validator->fails()) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Please fill required blanks !']);
            }
            unset($request['_token']);
            $u = explode('-', $username);
            try {
                User::where('id', $u[count($u) - 1])->update($request->all());
                return response(['processStatus' => 'success', 'processTitle' => 'Success', 'processDesc' => 'Congratulations , profile information updated!']);
            } catch (\Exception $e) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Profile information could not updated !', 'error' => $e]);
            }
        }
    }
}
