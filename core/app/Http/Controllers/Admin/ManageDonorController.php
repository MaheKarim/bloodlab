<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Blood;
use App\Models\City;
use App\Models\Donor;
use App\Models\Location;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class ManageDonorController extends Controller
{
    public function index()
    {
        $pageTitle = 'Manage Donor';
        $donors = Donor::latest()->with('blood', 'location')->paginate(getPaginate());
        $bloods = Blood::where('status', Status::ENABLE)->get();

        return view('admin.donor.index', compact('pageTitle', 'donors', 'bloods'));
    }

    public function pending()
    {
        $pageTitle = "Pending Donor List";
        $emptyMessage = "No data found";
        $bloods = Blood::where('status', Status::ENABLE)->select('id', 'name')->get();
        $donors = Donor::where('status', Status::UNVERIFIED)->latest()->with('blood', 'location')->paginate(getPaginate());

        return view('admin.donor.index', compact('pageTitle', 'emptyMessage', 'donors', 'bloods'));
    }

    public function approved()
    {
        $pageTitle = "Approved Donor List";
        $emptyMessage = "No data found";
        $bloods = Blood::where('status', Status::ENABLE)->select('id', 'name')->get();
        $donors = Donor::where('status', Status::VERIFIED)->latest()->with('blood', 'location')->paginate(getPaginate());

        return view('admin.donor.index', compact('pageTitle', 'emptyMessage', 'donors', 'bloods'));
    }

    public function banned()
    {
        $pageTitle = "Banned Donor List";
        $emptyMessage = "No data found";
        $bloods = Blood::where('status', Status::ENABLE)->select('id', 'name')->get();
        $donors = Donor::where('status', Status::BANNED)->latest()->with('blood', 'location')->paginate(getPaginate());
        return view('admin.donor.index', compact('pageTitle', 'emptyMessage', 'donors', 'bloods'));
    }

    public function create($id=0)
    {
        $pageTitle = "Donor Create";
        $cities = City::with('locations')->where('status', Status::ENABLE)
            ->get();
        $bloods = Blood::where('status', Status::ENABLE)->select('id', 'name')->get();
        $donor = $id ? Donor::findOrFail($id) : '';
        $locations = Location::where('status', Status::ENABLE)->with('city')->select('id', 'name')->get();
        return view('admin.donor.create', compact('pageTitle', 'cities', 'bloods', 'donor', 'locations'));
    }

    public function donorBloodSearch(Request $request)
    {
        $request->validate([
            'blood_id' => 'required|exists:bloods,id'
        ]);
        $bloodId = $request->blood_id;
        $blood = Blood::findOrFail($request->blood_id);
        $pageTitle = $blood->name . " Blood Group Donor List";
        $emptyMessage = "No data found";
        $bloods = Blood::where('status', 1)->select('id', 'name')->get();
        $donors = Donor::where('blood_id', $request->blood_id)->latest()->with('blood', 'location')->paginate(getPaginate());
        return view('admin.donor.index', compact('pageTitle', 'emptyMessage', 'donors', 'bloods', 'bloodId'));
    }

    public function search(Request $request)
    {
        $pageTitle = "Donor Search";
        $emptyMessage = "No data found";
        $search = $request->search;
        $bloods = Blood::where('status', 1)->select('id', 'name')->get();
        $donors = Donor::where('name', 'like', "%$search%")->latest()->with('blood', 'location')->paginate(getPaginate());
        return view('admin.donor.index', compact('pageTitle', 'emptyMessage', 'donors', 'bloods', 'search'));
    }

    public function approvedStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:donors,id'
        ]);
        $donor = Donor::findOrFail($request->id);
        $donor->status = Status::VERIFIED;
        $donor->save();
        $notify[] = ['success', 'Donor has been approved'];
        return back()->withNotify($notify);
    }

    public function bannedStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:donors,id'
        ]);
        $donor = Donor::findOrFail($request->id);
        $donor->status = 2;
        $donor->save();
        $notify[] = ['success', 'Donor has been canceled'];
        return back()->withNotify($notify);
    }


    public function featuredInclude(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:donors,id'
        ]);
        $donor = Donor::findOrFail($request->id);
        $donor->featured = 1;
        $donor->save();
        $notify[] = ['success', 'Include this donor featured list'];
        return back()->withNotify($notify);
    }

    public function featuredNotInclude(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:donors,id'
        ]);
        $donor = Donor::findOrFail($request->id);
        $donor->featured = 0;
        $donor->save();
        $notify[] = ['success', 'Remove this donor featured list'];
        return back()->withNotify($notify);
    }

    public function store(Request $request, $id=0)
    {
        $imgValidation = $id ? 'nullable' : 'required';

        $request->validate([
            'name' => 'required|max:80',
            'email' => 'required|email|max:60|unique:donors,email',
            'phone' => 'required|max:40|unique:donors,phone',
            'city_id' => 'required|exists:cities,id',
            'location_id' => 'required|exists:locations,id',
            'blood_id' => 'required|exists:bloods,id',
            'gender' => 'required|in:1,2',
            'religion' => 'required|max:40',
            'profession' => 'required|max:80',
            'donate' => 'required|integer',
            'address' => 'required|max:255',
            'details' => 'required',
            'birth_date' => 'required|date',
            'last_donate' => 'required|date',
            'facebook' => 'required',
            'twitter' => 'required',
            'linkedinIn' => 'required',
            'instagram' => 'required',
            'image'       => ["$imgValidation", 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);
        if ($id) {
            $donor = Donor::findOrFail($id);
            $notification = 'updated';
        } else {
            $donor = new Donor();
            $notification        = 'added';
        }
        $donor->name = $request->name;
        $donor->email = $request->email;
        $donor->phone = $request->phone;
        $donor->city_id = $request->city_id;
        $donor->blood_id = $request->blood_id;
        $donor->location_id = $request->location_id;
        $donor->gender = $request->gender;
        $donor->religion = $request->religion;
        $donor->profession = $request->profession;
        $donor->address = $request->address;
        $donor->details = $request->details;
        $donor->total_donate = $request->total_donate;
        $donor->birth_date =  $request->birth_date;
        $donor->last_donate = $request->last_donate;
        $socialMedia = [
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'linkedinIn' => $request->linkedinIn,
            'instagram' => $request->instagram
        ];
        $donor->socialMedia = $socialMedia;

        if ($request->hasFile('image')) {
            try {
                $old            = $donor->image;
                $donor->image = fileUploader($request->image, getFilePath('donor'), getFileSize('donor'), $old);
            } catch (\Exception $e) {
                $notify[] = ['error', 'Could not upload your image'];
                return back()->withNotify($notify);
            }
        }
        $donor->status = $request->status ? Status::ENABLE : Status::DISABLE;
        $donor->save();
        $notify[] = ['success', "Donor $notification successfully"];
        return back()->withNotify($notify);
    }

    public function edit($id=0)
    {
        $pageTitle = "Donor Update";
        $donor = $id ? Donor::findOrFail($id) : '';
        $cities = City::where('status', Status::ENABLE)->select('id', 'name')->with('locations')->get();
        $bloods = Blood::where('status', Status::ENABLE)->select('id', 'name')->get();
        return view('admin.donor.create', compact('pageTitle', 'cities', 'bloods', 'donor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:80',
            'email' => 'required|email|max:60|unique:donors,email,'.$id,
            'phone' => 'required|max:40|unique:donors,phone,'.$id,
            'city' => 'required|exists:cities,id',
            'location' => 'required|exists:locations,id',
            'blood' => 'required|exists:bloods,id',
            'gender' => 'required|in:1,2',
            'religion' => 'required|max:40',
            'profession' => 'required|max:80',
            'donate' => 'required|integer',
            'address' => 'required|max:255',
            'details' => 'required',
            'birth_date' => 'required|date',
            'last_donate' =>'required|date',
            'facebook' => 'required',
            'twitter' => 'required',
            'linkedinIn' => 'required',
            'instagram' => 'required',
            'image' => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);
        $donor = Donor::findOrFail($id);
        $donor->name = $request->name;
        $donor->email = $request->email;
        $donor->phone = $request->phone;
        $donor->city_id = $request->city;
        $donor->blood_id = $request->blood;
        $donor->location_id = $request->location;
        $donor->gender = $request->gender;
        $donor->religion = $request->religion;
        $donor->profession = $request->profession;
        $donor->address = $request->address;
        $donor->details = $request->details;
        $donor->total_donate = $request->donate;
        $donor->birth_date =  $request->birth_date;
        $donor->last_donate = $request->last_donate;
        $socialMedia = [
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'linkedinIn' => $request->linkedinIn,
            'instagram' => $request->instagram
        ];
        $donor->socialMedia = $socialMedia;
        $path = imagePath()['donor']['path'];
        $size = imagePath()['donor']['size'];
        if ($request->hasFile('image')) {
            try {
                $filename = uploadImage($request->image, $path, $size, $donor->image);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
            $donor->image = $filename;
        }
        $donor->status = $request->status ? 1 : 2;
        $donor->save();
        $notify[] = ['success', 'Donor has been updated'];
        return back()->withNotify($notify);
    }

}
