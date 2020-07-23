<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Category;
use App\Deal;
use App\FaqComment;
use App\FAQs;
use App\FaqTopic;
use App\PrBrand;
use App\PrCategory;
use App\PrColor;
use App\Product;
use App\PrSize;
use App\PrTag;
use App\Settings;
use App\Slider;
use App\User;
use App\UserExtraInfo;
use App\UserStatus;
use Carbon\Carbon;
use foo\bar;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Symfony\Component\Console\Input\Input;
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
                'photos.*' => 'mimes:jpeg,jpg,png',
                'pr_category' => 'required | max:250',
                'pr_brand' => 'required | max:250',
                'pr_size' => 'required | max:250',
                'pr_weight' => 'required | max:250',
                'pr_name' => 'required | max:250',
                'pr_desc' => 'required',
                'pr_color' => 'required | max:250',
                'pr_tags' => 'required | max:250',
                'pr_sku' => 'required | max:250',
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
                $request->merge(['pr_prev_price' => $request->pr_last_price, 'slug' => $slug, 'seller_id' => Auth::id()]);
                Product::create($request->all());
                return response(['processStatus' => 'success', 'processTitle' => 'Success', 'processDesc' => 'Congratulations , product added successfully !']);
            } catch (\Exception $e) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Product could not added !', 'error' => $e]);
            }

        } elseif
        ($request->category_name) {
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
        } elseif
        ($request->size) {
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
        } elseif
        ($request->brand_desc) {
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
        } else {
            try {
                Category::where('id', $request->id)->delete();
                return response(['processStatus' => 'success', 'processTitle' => 'Successful', 'processDesc' => 'Category deleted successfully !']);

            } catch (\Exception $e) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Category could not deleted !', 'error' => $e]);
            }
        }
    }

    public function post_faq(Request $request)
    {
        if ($request->only('slug')) {
            try {
                $deletingFaqId = FAQs::where('slug', $request->slug)->first()->id;
                $deletingFaqTopicSlug = FaqTopic::where('prime_title', $deletingFaqId)->first()->slug;
                $deleteFaq = FAQs::where('slug', $request->slug)->delete();
                if ($deleteFaq) {
                    FaqTopic::where('prime_title', $deletingFaqId)->delete();
                    FaqComment::where('faq', $deletingFaqTopicSlug)->delete();
                    return response(['processStatus' => 'success', 'processTitle' => 'Success', 'processDesc' => 'FAQ title deleted successfully !']);
                }
            } catch (\Exception $e) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'FAQ title could not deleted !', 'error' => $e]);
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

    public function post_edit_faq(Request $request, $slug)
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

    public function post_profile_user(Request $request, $username)
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
                User::where('id', $u[count($u) - 1])->update($request->except(['visa', 'master_card', 'paypal']));
                if (!empty($request->visa || $request->master_card || $request->paypal)) {
                    $userId = $u[count($u) - 1];
                    $request->merge(['user_id' => $userId]);
                    $checkId = UserExtraInfo::where('user_id', '=', $request->input('user_id'))->first();
                    if ($checkId === null) {
                        UserExtraInfo::create($request->only(['user_id', 'visa', 'master_card', 'paypal']));
                    } else {
                        UserExtraInfo::where('user_id', $userId)->update($request->only(['user_id', 'visa', 'master_card', 'paypal']));
                    }


                }
                return response(['processStatus' => 'success', 'processTitle' => 'Success', 'processDesc' => 'Congratulations , profile information updated!']);
            } catch (\Exception $e) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Profile information could not updated !', 'error' => $e]);
            }
        }
    }

    public function post_edit_user(Request $request, $getUser)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required| max:250',
            'surname' => 'max:250',
            'email' => 'required| max:250',
            'phone' => 'max:250',
            'status' => 'required| max:250',
        ]);

        $check = UserStatus::where('status', $request->status)->first();

        if ($check === null) {
            return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'There is not such user status !']);
        } else {
            if ($validator->fails()) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Please fill required blanks !']);
            } else {
                try {
                    unset($request['_token']);
                    User::where('slug', $getUser)->update($request->all());
                    return response(['processStatus' => 'success', 'processTitle' => 'Successful', 'processDesc' => 'User information updated successfully !']);
                } catch (\Exception $e) {
                    return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'User information could not updated !', 'error' => $e]);
                }
            }
        }

    }

    public function post_delete_user(Request $request)
    {
        try {
            unset($request['_token']);
            User::where('slug', $request->slug)->delete();
            return response(['processStatus' => 'success', 'processTitle' => 'Successful', 'processDesc' => 'User deleted successfully !']);
        } catch (\Exception $e) {
            return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'User could not deleted !', 'error' => $e]);
        }
    }

    public function post_deals(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dealBanner' => 'required | mimes:jpeg,jpg,png',
            'title' => 'required | max:250',
            'desc' => 'required',
            'price' => 'required',
            'pr_name' => 'required| max:250',
            'durationDay' => 'required | min:0 | max:365',
            'durationHourse' => 'required | min:0 | max:24',
            'durationMinute' => 'required | min:0 | max:60',
            'durationSeconds' => 'required | min:0 | max:60',
            'link' => 'required | max:250'
        ]);

        if ($validator->fails()) {
            return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Please fill all field correctly for change banner !']);
        }

        $photo = $request->file('dealBanner');
        $photo_extention = $request->file('dealBanner')->getClientOriginalExtension();
        $photo_name = 'banner.' . $photo_extention;
        Storage::disk('uploads')->makeDirectory('img/DealsBanner');
        Storage::disk('uploads')->put('img/DealsBanner/' . $photo_name, file_get_contents($photo));

        try {
            unset($request['_token']);

            $request->merge(['banner' => $photo_name]);
            Deal::where('id', 1)->update([
                'banner' => $request->banner,
                'title' => $request->title,
                'desc' => $request->desc,
                'price' => $request->price,
                'pr_name' => $request->pr_name,
                'day' => $request->durationDay,
                'hourse' => $request->durationHourse,
                'minute' => $request->durationMinute,
                'second' => $request->durationSeconds,
                'link' => $request->link,
            ]);
            return response(['processStatus' => 'success', 'processTitle' => 'Success', 'processDesc' => 'Congratulations , banner changed successfully!']);
        } catch (\Exception $e) {
            return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Banner  could not changed !', 'error' => $e]);
        }

    }

    public function post_switch_deal(Request $request)
    {
        if ($request->switchResult == 1) {
            try {
                unset($request['_token']);
                Deal::where('id', 1)->update(['enable_disable' => $request->switchResult]);
                return response(['processStatus' => 'success', 'processTitle' => 'Successful', 'processDesc' => 'Deal enabled successfully !']);
            } catch (\Exception $e) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'User could not deleted !', 'error' => $e]);
            }
        } elseif ($request->switchResult == 0) {
            try {
                unset($request['_token']);
                Deal::where('id', 1)->update(['enable_disable' => $request->switchResult]);
                return response(['processStatus' => 'success', 'processTitle' => 'Successful', 'processDesc' => 'Deal disabled successfully !']);
            } catch (\Exception $e) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'User could not deleted !', 'error' => $e]);
            }
        }
    }

    public function post_add_slider(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'img' => 'required | mimes:jpeg,jpg,png',
            'title' => 'required | max:250',
            'description' => 'required',
            'sale' => 'max: 3',
            'link' => 'required | max:250'
        ]);

        if ($validator->fails()) {
            return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Please fill all field correctly for add slider !']);
        }

        $date = Str::slug(Carbon::now());
        $photo = $request->file('img');
        $photo_extention = $request->file('img')->getClientOriginalExtension();
        $photo_name = 'slide-' . $date . '.' . $photo_extention;
        Storage::disk('uploads')->makeDirectory('img/Slider');
        Storage::disk('uploads')->put('img/Slider/' . $photo_name, file_get_contents($photo));

        try {
            $slug = Str::slug($request->title);
            $request->merge(['image' => $photo_name, 'slug' => $slug]);
            Slider::create($request->all());
            return response(['processStatus' => 'success', 'processTitle' => 'Success', 'processDesc' => 'Congratulations , slide added successfully!']);
        } catch (\Exception $e) {
            return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Slide  could not added !', 'error' => $e]);
        }

    }

    public function post_edit_slider(Request $request, $slug)
    {
        if ($request->img) {
            $validator = Validator::make($request->all(), [
                'img' => 'required | mimes:jpeg,jpg,png',
                'title' => 'required | max:250',
                'description' => 'required',
                'sale' => 'max: 3',
                'link' => 'required | max:250'
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'title' => 'required | max:250',
                'description' => 'required',
                'sale' => 'max: 3',
                'link' => 'required | max:250'
            ]);
        }

        if ($validator->fails()) {
            return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Please fill all field correctly for update slider !']);
        }
        if (!empty($request->img)) {
            $oldImageName = Slider::where('slug', $slug)->first()->image;
            $deleteOldImage = unlink(public_path() . '/uploads/img/Slider/' . $oldImageName);
            if ($deleteOldImage) {
                $date = Str::slug(Carbon::now());
                $photo = $request->file('img');
                $photo_extention = $request->file('img')->getClientOriginalExtension();
                $photo_name = 'slide-' . $date . '.' . $photo_extention;
                Storage::disk('uploads')->makeDirectory('img/Slider');
                Storage::disk('uploads')->put('img/Slider/' . $photo_name, file_get_contents($photo));
            }
            $request->merge(['image' => $photo_name]);

        }

        try {
            $newslug = Str::slug($request->title);
            $request->merge(['slug' => $newslug]);
            unset($request['_token']);
            Slider::where('slug', $slug)->update($request->except('img'));
            return response(['processStatus' => 'success', 'processTitle' => 'Success', 'processDesc' => 'Congratulations , slide updated successfully!']);
        } catch (\Exception $e) {
            return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Slide  could not updated !', 'error' => $e]);
        }
    }

    public function slider_switcher_and_dlt(Request $request)
    {
        if ($request->only('switchResult')) {
            if ($request->switchResult == 1) {
                try {
                    unset($request['_token']);
                    Settings::where('id', 1)->update(['slider' => $request->switchResult]);
                    return response(['processStatus' => 'success', 'processTitle' => 'Successful', 'processDesc' => 'Slider enabled successfully !']);
                } catch (\Exception $e) {
                    return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Slider could not enabled !', 'error' => $e]);
                }
            } elseif ($request->switchResult == 0) {
                try {
                    unset($request['_token']);
                    Settings::where('id', 1)->update(['slider' => $request->switchResult]);
                    return response(['processStatus' => 'success', 'processTitle' => 'Successful', 'processDesc' => 'Slider disabled successfully !']);
                } catch (\Exception $e) {
                    return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Slider could not disabled !', 'error' => $e]);
                }
            }
        } elseif ($request->only('slug')) {
            try {
                $getSliderImageName = Slider::where('slug', $request->slug)->first()->image;
                unlink(public_path() . '/uploads/img/Slider/' . $getSliderImageName);
                Slider::where('slug', $request->slug)->delete();
                return response(['processStatus' => 'success', 'processTitle' => 'Successful', 'processDesc' => 'Slider deleted successfully !']);

            } catch (\Exception $e) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Slider could not deleted !', 'error' => $e]);

            }
        }

    }
}
