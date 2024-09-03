<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSocialContentController extends Controller
{
    public function list()
    {
        $list = SocialContent::latest()->get();
        return view('panel-v1.online-job.social-content', compact('list'));
    }
    public function create(Request $request)
    {
        $create =  new SocialContent();
        $file = $request->file('image');
        $path = Storage::disk('local')->put('SocialContent/image', $file);
        $create->image = '/uploads/' . $path;
        $create->name = $request->name;
        $create->job_count = $request->job_count;
        $create->price_per_job = $request->price_per_job;
        $create->instructions = $request->instructions;
        $create->save();
        return redirect()->back();
    }
    public function edit(Request $request, $id)
    {
        $create = SocialContent::find($id);
        if ($request->has('image')) {
            $file = $request->file('image');
            $path = Storage::disk('local')->put('SocialContent/image', $file);
            $create->image = '/uploads/' . $path;
        }

        $create->name = $request->name;
        $create->job_count = $request->job_count;
        $create->price_per_job = $request->price_per_job;
        $create->instructions = $request->instructions;
        $create->save();
        $create->save();
        return redirect()->back();
    }
    public function delete($id)
    {
        $create =  SocialContent::find($id);
        if ($create) {
            $create->delete();
        }
        return redirect()->back();
    }
}
