<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Models\AdminNotification;
use App\Models\Blood;
use App\Models\City;
use App\Models\Donor;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Location;
use App\Models\Page;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;


class SiteController extends Controller
{
    public function index(){
        $reference = @$_GET['reference'];
        if ($reference) {
            session()->put('reference', $reference);
        }

        $pageTitle = 'Home';
        $sections = Page::where('tempname',activeTemplate())->where('slug','/')->first();
        $seoContents = $sections->seo_content;
        $seoImage = @$seoContents->image ? getImage(getFilePath('seo') . '/' . @$seoContents->image, getFileSize('seo')) : null;
        $bloods = Blood::where('status', Status::ENABLE)->select('id', 'name')->get();
        $cities = City::where('status', Status::ENABLE)->select('id', 'name')->get();

        return view('Template::home', compact('pageTitle','sections','seoContents','seoImage', 'bloods', 'cities'));
    }

    public function pages($slug)
    {
        $page = Page::where('tempname',activeTemplate())->where('slug',$slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections = $page->secs;
        $seoContents = $page->seo_content;
        $seoImage = @$seoContents->image ? getImage(getFilePath('seo') . '/' . @$seoContents->image, getFileSize('seo')) : null;
        return view('Template::pages', compact('pageTitle','sections','seoContents','seoImage'));
    }


    public function contact()
    {
        $pageTitle = "Contact Us";
        $user = auth()->user();
        $sections = Page::where('tempname',activeTemplate())->where('slug','contact')->first();
        $seoContents = $sections->seo_content;
        $seoImage = @$seoContents->image ? getImage(getFilePath('seo') . '/' . @$seoContents->image, getFileSize('seo')) : null;
        return view('Template::contact',compact('pageTitle','user','sections','seoContents','seoImage'));
    }


    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required|string|max:255',
            'message' => 'required',
        ]);

        $request->session()->regenerateToken();

        if(!verifyCaptcha()){
            $notify[] = ['error','Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        $random = getNumber();

        $ticket = new SupportTicket();
        $ticket->user_id = auth()->id() ?? 0;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->priority = Status::PRIORITY_MEDIUM;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = Status::TICKET_OPEN;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title = 'A new contact message has been submitted';
        $adminNotification->click_url = urlPath('admin.ticket.view',$ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->support_ticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $notify[] = ['success', 'Ticket created successfully!'];

        return to_route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function policyPages($slug)
    {
        $policy = Frontend::where('slug',$slug)->where('data_keys','policy_pages.element')->firstOrFail();
        $pageTitle = $policy->data_values->title;
        $seoContents = $policy->seo_content;
        $seoImage = @$seoContents->image ? frontendImage('policy_pages',$seoContents->image,getFileSize('seo'),true) : null;
        return view('Template::policy',compact('policy','pageTitle','seoContents','seoImage'));
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return back();
    }

    public function blogDetails($slug){
        $blog = Frontend::where('slug',$slug)->where('data_keys','blog.element')->firstOrFail();
        $pageTitle = $blog->data_values->title;
        $seoContents = $blog->seo_content;
        $seoImage = @$seoContents->image ? frontendImage('blog',$seoContents->image,getFileSize('seo'),true) : null;
        return view('Template::blog_details',compact('blog','pageTitle','seoContents','seoImage'));
    }


    public function cookieAccept(){
        Cookie::queue('gdpr_cookie',gs('site_name') , 43200);
    }

    public function cookiePolicy(){
        $cookieContent = Frontend::where('data_keys','cookie.data')->first();
        abort_if($cookieContent->data_values->status != Status::ENABLE,404);
        $pageTitle = 'Cookie Policy';
        $cookie = Frontend::where('data_keys','cookie.data')->first();
        return view('Template::cookie',compact('pageTitle','cookie'));
    }

    public function placeholderImage($size = null){
        $imgWidth = explode('x',$size)[0];
        $imgHeight = explode('x',$size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font/solaimanLipi_bold.ttf');
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if($imgHeight < 100 && $fontSize > 30){
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

    public function maintenance()
    {
        $pageTitle = 'Maintenance Mode';
        if(gs('maintenance_mode') == Status::DISABLE){
            return to_route('home');
        }
        $maintenance = Frontend::where('data_keys','maintenance.data')->first();
        return view('Template::maintenance',compact('pageTitle','maintenance'));
    }

    public function donor()
    {
        $pageTitle = "All Donor";
        $emptyMessage = "No data found";
        $bloods = Blood::where('status', Status::ENABLE)->select('id', 'name')->get();
        $cities = City::where('status', Status::ENABLE)->select('id', 'name')->with('locations')->get();
        $donors = Donor::where('status', Status::ENABLE)->with('blood', 'location')->paginate(getPaginate());
        return view('Template::donor', compact('pageTitle','emptyMessage', 'donors', 'cities', 'bloods'));
    }

    public function donorDetails($slug, $id)
    {
        $pageTitle = "Donor Details";
        $donor = Donor::where('status',Status::ENABLE)->where('id', decrypt($id))->firstOrFail();
        return view('Template::donor_details', compact('pageTitle', 'donor'));
    }

    public function donorSearch(Request $request)
    {
        $request->validate([
            'location_id' => 'nullable|exists:locations,id',
            'city_id' => 'nullable|exists:cities,id',
            'blood_id' => 'nullable|exists:bloods,id',
            'gender' => 'nullable|in:1,2'
        ]);
        $locations = Location::where('status', Status::ENABLE)->select('id', 'name')->get();
        $bloods = Blood::where('status', Status::ENABLE)->select('id', 'name')->get();
        $cities = City::where('status', Status::ENABLE)->select('id', 'name')->get();
        $pageTitle = "Donor Search";
        $emptyMessage = "No data found";
        $locationId = $request->location_id;
        $cityId = $request->city_id;
        $bloodId = $request->blood_id;
        $gender = $request->gender;
        $donors = Donor::where('status', Status::ENABLE);
        if($request->blood_id){
            $donors = $donors->where('blood_id', $request->blood_id);
        }
        if($request->city_id){
            $donors = $donors->where('city_id', $request->city_id);
        }
        if($request->location_id){
            $donors = $donors->where('location_id', $request->location_id);
        }
        if($request->gender){
            $donors = $donors->where('gender', $request->gender);
        }
        $donors = $donors->with('blood', 'location')->paginate(getPaginate());
        return view('Template::donor', compact('pageTitle','emptyMessage', 'donors', 'cities', 'locations', 'bloods', 'locationId', 'cityId', 'bloodId', 'gender'));
    }

    public function contactWithDonor(Request $request)
    {
        $request->validate([
            'donor_id' => 'required|exists:donors,id',
            'name' => 'required|max:80',
            'email' => 'required|max:80',
            'message' => 'required|max:500'
        ]);
        $donor = Donor::findOrFail($request->donor_id);
        notify($donor, 'DONOR_CONTACT',[
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message
        ]);
        $notify[] = ['success', 'Request has been submitted'];
        return back()->withNotify($notify);
    }

    public function bloodGroup($slug, $id)
    {
        $blood = Blood::where('status', Status::ENABLE)->where('id', decrypt($id))->firstOrFail();
        $pageTitle = $blood->name." Blood Group Donor";
        $emptyMessage = "No data found";
        $bloods = Blood::where('status', Status::ENABLE)->select('id', 'name')->get();
        $cities = City::where('status', Status::ENABLE)->select('id', 'name')->get();
        $locations = Location::where('status', Status::ENABLE)->select('id', 'name')->get();
        $donors = Donor::where('status',Status::ENABLE)->where('blood_id', $blood->id)->with('blood', 'locations')->paginate(getPaginate());
        return view( 'Template::donor', compact('pageTitle','emptyMessage', 'donors', 'bloods', 'cities', 'locations'));
    }

}
