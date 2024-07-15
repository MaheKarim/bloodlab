<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $pageTitle = 'Cities';
        $cities = City::latest()->paginate(getPaginate());

        return view('admin.city.index',compact('pageTitle','cities'));
    }

    public function update(Request $request, $id=0)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        if ($id) {
            $city = City::findOrFail($id);
            $notify[] = ['success', 'City updated successfully'];
        } else {
            $city = new City();
            $notify[] = ['success', 'City added successfully'];
        }
        $city->name = $request->name;
        $city->save();
        return redirect()->route('admin.city.index')->withNotify($notify);
    }

    public function status($id)
    {
        return City::changeStatus($id);
    }
}
