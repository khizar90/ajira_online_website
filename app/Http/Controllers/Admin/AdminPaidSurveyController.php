<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaidSurvey;
use Illuminate\Http\Request;

class AdminPaidSurveyController extends Controller
{
    public function list()
    {
        $list = PaidSurvey::get();
        return view('panel-v1.online-job.paid-survey', compact('list'));
    }

    public function create(Request $request)
    {
        $create = new PaidSurvey();
        $create->question = $request->question;
        $create->is_required = $request->is_required;
        $create->save();
        return redirect()->back();
    }
    public function edit(Request $request, $id)
    {
        $find = PaidSurvey::find($id);
        $find->question = $request->question;
        $find->is_required = $request->is_required;
        $find->save();
        return redirect()->back();
    }

    public function delete($id)
    {
        $find = PaidSurvey::find($id);
        if ($find) {
            $find->delete();
        }
        return redirect()->back();
    }
}
