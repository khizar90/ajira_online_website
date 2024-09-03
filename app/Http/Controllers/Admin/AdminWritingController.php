<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Writing;
use Illuminate\Http\Request;

class AdminWritingController extends Controller
{
    public function list()
    {
        $find = Writing::latest()->first();
        return view('panel-v1.online-job.writing', compact('find'));
    }
    public function create(Request $request)
    {
        $create =  new Writing();
        $create->instructions = $request->instructions;
        $create->save();
        return redirect()->back();
    }
    public function edit(Request $request, $id)
    {
        $create =  Writing::find($id);
        $create->instructions = $request->instructions;
        $create->save();
        return redirect()->back();
    }
    public function delete($id)
    {
        $create =  Writing::find($id);
        if ($create) {
            $create->delete();
        }
        return redirect()->back();
    }
}
