<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataEntry;
use Illuminate\Http\Request;

class AdminDataEntryController extends Controller
{
    public function list()
    {
        $list = DataEntry::latest()->get();
        return view('panel-v1.online-job.data-entry', compact('list'));
    }
    public function create(Request $request)
    {
        $create =  new DataEntry();
        $create->job_type = $request->name;
        $create->job_count = $request->job_count;
        $create->price_per_job = $request->price_per_job;
        $create->instructions = $request->instructions;
        $create->save();
        return redirect()->back();
    }
    public function edit(Request $request, $id)
    {
        $create = DataEntry::find($id);
        $create->job_type = $request->name;
        $create->job_count = $request->job_count;
        $create->price_per_job = $request->price_per_job;
        $create->instructions = $request->instructions;
        $create->save();
        $create->save();
        return redirect()->back();
    }
    public function delete($id)
    {
        $create =  DataEntry::find($id);
        if ($create) {
            $create->delete();
        }
        return redirect()->back();
    }
}
