<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $pageTitle = 'Locations';
        $locations = Location::latest()->with('city')->paginate(getPaginate());
        $cities = City::where('status', Status::ENABLE)->get();

        return view('admin.location.index',compact('pageTitle','locations', 'cities'));
    }

    public function update(Request $request, $id=0)
    {
        $request->validate([
           'name' => 'required|string|max:255',
//           'city_id' => 'required|exists:city,id',
        ]);

        if ($id) {
            $location = Location::findOrFail($id);
            $notify[] = ['success', 'Location updated successfully'];
        } else {
            $location = new Location();
            $notify[] = ['success', 'Location added successfully'];
        }
        $location->name = $request->name;
        $location->city_id = $request->city_id;
        $location->save();
        return redirect()->route('admin.location.index')->withNotify($notify);
    }

    public function status($id)
    {
        return Location::changeStatus($id);
    }
}
