<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transcription;
use App\Models\TranslateAudio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminTranscriptionController extends Controller
{
    public function list()
    {
        $list = Transcription::latest()->get();
        return view('panel-v1.online-job.translate-audio', compact('list'));
    }
    public function create(Request $request)
    {
        $create =  new Transcription();
        $file = $request->file('media');
        $path = Storage::disk('local')->put('/', $file);
        $create->media = '/uploads/' . $path;
        $create->name = $request->name;
        $create->save();
        return redirect()->back();
    }
    public function edit(Request $request, $id)
    {
        $create =  Transcription::find($id);
        if ($request->has('media')) {
            $file = $request->file('media');
            $path = Storage::disk('local')->put('/', $file);
            $create->media = '/uploads/' . $path;
        }
        $create->name = $request->name;

        $create->save();
        return redirect()->back();
    }
    public function delete($id)
    {
        $create =  Transcription::find($id);
        if ($create) {
            $create->delete();
        }
        return redirect()->back();
    }
}
