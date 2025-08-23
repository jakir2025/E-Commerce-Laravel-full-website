<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Policy;
use App\Models\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showSettings()
    {
        $settings = Settings::first();
        return view('backend.settings.show-settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $settings = Settings::first();

        $settings->phone = $request->phone;
        $settings->email = $request->email;
        $settings->address = $request->address;
        $settings->facebook = $request->facebook;
        $settings->twitter = $request->twitter;
        $settings->instagram = $request->instagram;
        $settings->youtube = $request->youtube;
        $settings->free_shipping_amount = $request->free_shipping_amount;
        
        if(isset($request->logo)){

            if($settings->image && file_exists('backend/images/Settings/'.$settings->logo)){
                unlink('backend/images/Settings/'.$settings->logo);
            }

            $imageName = rand().'-logo'.'.'.$request->logo->extension();
            $request->logo->move('backend/images/Settings/', $imageName);
            
            $settings->logo = $imageName;
        }

         if(isset($request->hero_image)){

            if($settings->hero_image && file_exists('backend/images/Settings/'.$settings->hero_image)){
                unlink('backend/images/Settings/'.$settings->image);
            }

            $sliderName = rand().'-slider'.'.'.$request->hero_image->extension();
            $request->hero_image->move('backend/images/Settings/', $sliderName);
            
            $settings->hero_image = $sliderName;
        }
        $settings->save();
        toastr()->success('Settings update successfully!');
        return redirect()->back();

    }

    public function showPolicies()
    {
        $policiesAboutus = Policy::first();
        return view('backend.settings.show-policies', compact('policiesAboutus'));
    }

    public function updatePolicies(Request $request)
    {
        $policiesAboutus = Policy::first();

        $policiesAboutus->about_us = $request->about_us;
        $policiesAboutus->privacy_policy = $request->privacy_policy;
        $policiesAboutus->terms_conditions = $request->terms_conditions;
        $policiesAboutus->refund_policy = $request->refund_policy;
        $policiesAboutus->payment_policy = $request->payment_policy;
        $policiesAboutus->return_policy = $request->return_policy;

        $policiesAboutus->save();
        toastr()->success('Policies update successfully!');
        return redirect()->back();
    }

    public function showBanners()
    {
        $banners = Banner::get();
        return view('backend.settings.show-banners', compact('banners'));
    }

    public function editBanner($id)
    {
        $banner = Banner::find($id);
        dd($banner);
        return view('backend.settings.edit-banner', compact('banner'));
    }

    public function updateBanner(Request $request, $id)
    {
        $banner = Banner::find($id);

        if(isset($request->image)){

            if($banner->image && file_exists('backend/images/banner/'.$banner->image)){
                unlink('backend/images/banner/'.$banner->image);
            }

            $imageName = rand().'-banner'.'.'.$request->image->extension();
            $request->image->move('backend/images/banner/', $imageName);
            
            $banner->image = $imageName;
        }
        $banner->save();
        toastr()->success("Banner update successfuly!");
        return redirect('admin/show-banner');
    }
}
