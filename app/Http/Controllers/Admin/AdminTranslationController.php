<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Translation;
use Illuminate\Http\Request;

class AdminTranslationController extends Controller
{
    public function list()
    {
        $list = Translation::latest()->get();
        return view('panel-v1.online-job.translation', compact('list'));
    }
    public function create(Request $request)
    {
        $create =  new Translation();
        $create->text = $request->text;
        $create->language = $request->language;
        $create->save();
        return redirect()->back();
    }
    public function edit(Request $request, $id)
    {
        $create =  Translation::find($id);
        $create->text = $request->text;
        $create->language = $request->language;
        $create->save();
        return redirect()->back();
    }
    public function delete($id)
    {
        $create =  Translation::find($id);
        if ($create) {
            $create->delete();
        }
        return redirect()->back();
    }
}
