<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blood;
use Illuminate\Http\Request;

class BloodController extends Controller
{

    public function index()
    {
        $pageTitle = 'Manage Blood Group';
        $bloods = Blood::latest()->paginate(getPaginate());

        return view('admin.blood.index', compact('pageTitle', 'bloods'));
    }

    public function update(Request $request, $id=0)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        if (!$id) {
            $blood = new Blood();
        } else {
            $blood = Blood::find($id);
        }
        $blood->name = $request->name;
        $blood->save();
        $notify[] = ['success', 'Blood group updated successfully'];

        return back()->withNotify($notify);
    }

    public function status($id)
    {
        return Blood::changeStatus($id);
    }
}
