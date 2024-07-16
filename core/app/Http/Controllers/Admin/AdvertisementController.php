<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Advertisements';
        $advertisements = Advertisement::latest()->paginate(getPaginate());

        return view('admin.advertisement.index', compact('advertisements', 'pageTitle'));
    }

    public function store(Request $request)
    {
        $validation = [
            'type'         => 'required|in:image,script',
            'name'         => 'required',
            'size'         => 'required|in:220x474,220x303,220x315,220x467,820x213,416x554',
            'image'        => ['nullable', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png', 'gif'])],
            'redirect_url' => 'required_if:type,image|url|nullable',
            'script'       => 'required_if:type,script',
        ];

        $request->validate($validation);

        $advertisement = new Advertisement();
        $advertisement->name = $request->name;
        $advertisement->type = $request->type == 'image' ? 1 : 2;
        $advertisement->size = $request->size;

        if ($request->type == 'image') {
            if ($request->hasFile('image')) {
                $advertisement->image = fileUploader($request->file('image'), getFilePath('advertisement'));
            }
            $advertisement->redirect_url = $request->redirect_url;
        } else {
            $advertisement->script = $request->script;
            $advertisement->redirect_url = null;
        }

        $advertisement->status = Status::ENABLE;
        $advertisement->save();

        $notify[] = ['success', 'Advertisement added successfully'];
        return redirect()->route('admin.advertisement.index')->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $advertisement = Advertisement::findOrFail($id);

        $validation = [
            'type'         => 'required|in:image,script',
            'name'         => 'required',
            'size'         => 'required|in:220x474,220x303,220x315,220x467,820x213,416x554',
            'image'        => ['nullable', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png', 'gif'])],
            'redirect_url' => 'required_if:type,image|url|nullable',
            'script'       => 'required_if:type,script',
            'status'       => 'required|in:0,1',
        ];

        $request->validate($validation);

        $advertisement->name = $request->name;
        $advertisement->type = $request->type == 'image' ? 1 : 2;
        $advertisement->size = $request->size;

        if ($request->type == 'image') {
            if ($request->hasFile('image')) {
                $advertisement->image = fileUploader($request->file('image'), getFilePath('advertisement'), null, $advertisement->image);
            }
            $advertisement->redirect_url = $request->redirect_url;
            $advertisement->script = null;
        } else {
            $advertisement->script = $request->script;
            $advertisement->image = null;
            $advertisement->redirect_url = null;
            if ($advertisement->image) {
                fileManager()->removeFile(getFilePath('advertisement').'/'.$advertisement->image);
            }
        }

        $advertisement->status = $request->status;
        $advertisement->save();

        $notify[] = ['success', 'Advertisement updated successfully'];
        return redirect()->route('admin.advertisement.index')->withNotify($notify);
    }

    public function delete(Request $request)
    {
        $advertisement = Advertisement::findOrFail($request->advertisement_id);
        if ($advertisement->image) {
            fileManager()->removeFile(getFilePath('advertisement').'/'.$advertisement->image);
        }
        $advertisement->delete();

        $notify[] = ['success', 'Advertisement deleted successfully'];
        return back()->withNotify($notify);
    }
}
