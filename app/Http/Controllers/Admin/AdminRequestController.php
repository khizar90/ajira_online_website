<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApprenticeshipOpportunity;
use App\Models\AppTestRequest;
use App\Models\Category;
use App\Models\DataEntryRequest;
use App\Models\EmploymentRequest;
use App\Models\InternshipOpportunity;
use App\Models\PaidSurveyAnswer;
use App\Models\PaidSurveyRequest;
use App\Models\SocialContentRequest;
use App\Models\TranscriptionRequest;
use App\Models\TranslationRequest;
use App\Models\WritingRequest;
use Illuminate\Http\Request;

class AdminRequestController extends Controller
{
    public function list($type)
    {
        if ($type == 'employment') {
            $list = EmploymentRequest::with(['user'])->where('status', 0)->latest()->paginate(50);
            foreach ($list as $item) {
                $sub_categories = explode(',', $item->categories);
                $index1 = Category::find($sub_categories[0]);
                $main_catgroy = Category::find($index1->parent_id);
                $item->main_categories = $main_catgroy;
                $item->sub_categories = Category::whereIn('id', $sub_categories)->get();
            }
            return view('panel-v1.request.employment', compact('list', 'type'));
        }

        if ($type == 'internship') {
            $list = InternshipOpportunity::with(['user'])->where('status', 0)->latest()->paginate(50);
            return view('panel-v1.request.internship', compact('list', 'type'));
        }
        if ($type == 'apprenticeship') {
            $list = ApprenticeshipOpportunity::with(['user'])->where('status', 0)->latest()->paginate(50);
            return view('panel-v1.request.apprenticeship', compact('list', 'type'));
        }
        if ($type == 'transcription') {
            $list = TranscriptionRequest::with(['user'])->with(['transcription'])->where('status', 0)->latest()->paginate(50);
            return view('panel-v1.request.transcription', compact('list', 'type'));
        }
        if ($type == 'translation') {
            $list = TranslationRequest::with(['user'])->with(['translation'])->where('status', 0)->latest()->paginate(50);
            return view('panel-v1.request.translation', compact('list', 'type'));
        }
        if ($type == 'content') {
            $list = SocialContentRequest::with(['user'])->with(['content'])->where('status', 0)->latest()->paginate(50);
            return view('panel-v1.request.content', compact('list', 'type'));
        }
        if ($type == 'data-entry') {
            $list = DataEntryRequest::with(['user'])->with(['job'])->where('status', 0)->latest()->paginate(50);
            return view('panel-v1.request.data-entry', compact('list', 'type'));
        }
        if ($type == 'paid-survey') {
            $list = PaidSurveyRequest::with(['user'])->where('status', 0)->latest()->paginate(50);
            return view('panel-v1.request.paid-survey', compact('list', 'type'));
        }
        if ($type == 'app-test') {
            $list = AppTestRequest::with(['user'])->where('status', 0)->latest()->paginate(50);
            return view('panel-v1.request.app-test', compact('list', 'type'));
        }
        if ($type == 'writing') {
            $list = WritingRequest::with(['user'])->where('status', 0)->latest()->paginate(50);
            return view('panel-v1.request.writing', compact('list', 'type'));
        }
    }

    public function detail($type,$id){
        $find = PaidSurveyRequest::with(['user'])->find($id);
        if($find){
            $answers = PaidSurveyAnswer::where('request_id',$find->id)->get();
            return view('panel-v1.request.detail',compact('answers','find','type'));
        }
    }
    public function approve($type, $id)
    {
        if ($type == 'employment') {
            $find = EmploymentRequest::find($id);
            if ($find) {
                $find->approve_time = time();
                $find->status = 1;
                $find->save();
            }
        }
        if ($type == 'internship') {
            $find = InternshipOpportunity::find($id);
            if ($find) {
                $find->approve_time = time();
                $find->status = 1;
                $find->save();
            }
        }
        if ($type == 'apprenticeship') {
            $find = ApprenticeshipOpportunity::find($id);
            if ($find) {
                $find->approve_time = time();
                $find->status = 1;
                $find->save();
            }
        }
        if ($type == 'transcription') {
            $find = TranscriptionRequest::find($id);
            if ($find) {
                $find->approve_time = time();
                $find->status = 1;
                $find->save();
            }
        }
        if ($type == 'translation') {
            $find = TranslationRequest::find($id);
            if ($find) {
                $find->approve_time = time();
                $find->status = 1;
                $find->save();
            }
        }
        if ($type == 'content') {
            $find = SocialContentRequest::find($id);
            if ($find) {
                $find->approve_time = time();
                $find->status = 1;
                $find->save();
            }
        }
        if ($type == 'data-entry') {
            $find = DataEntryRequest::find($id);
            if ($find) {
                $find->approve_time = time();
                $find->status = 1;
                $find->save();
            }
        }
        if ($type == 'paid-survey') {
            $find = PaidSurveyRequest::find($id);
            if ($find) {
                $find->approve_time = time();
                $find->status = 1;
                $find->save();
            }
        }
        if ($type == 'app-test') {
            $find = AppTestRequest::find($id);
            if ($find) {
                $find->approve_time = time();
                $find->status = 1;
                $find->save();
            }
        }
        if ($type == 'writing') {
            $find = WritingRequest::find($id);
            if ($find) {
                $find->approve_time = time();
                $find->status = 1;
                $find->save();
            }
        }
        return redirect()->back();
    }
    public function cancel(Request $request)
    {
        if ($request->type == 'employment') {
            $find = EmploymentRequest::find($request->id);
            if ($find) {
                $find->change_by = 'admin';
                $find->cancel_time = time();
                $find->reason = $request->reason;
                $find->status = 2;
                $find->save();
            }
        }
        if ($request->type == 'internship') {
            $find = InternshipOpportunity::find($request->id);
            if ($find) {
                $find->change_by = 'admin';
                $find->cancel_time = time();
                $find->reason = $request->reason;
                $find->status = 2;
                $find->save();
            }
        }
        if ($request->type == 'apprenticeship') {
            $find = ApprenticeshipOpportunity::find($request->id);
            if ($find) {
                $find->change_by = 'admin';
                $find->cancel_time = time();
                $find->reason = $request->reason;
                $find->status = 2;
                $find->save();
            }
        }
        if ($request->type == 'transcription') {
            $find = TranscriptionRequest::find($request->id);
            if ($find) {
                $find->change_by = 'admin';
                $find->cancel_time = time();
                $find->reason = $request->reason;
                $find->status = 2;
                $find->save();
            }
        }
        if ($request->type == 'translation') {
            $find = TranslationRequest::find($request->id);
            if ($find) {
                $find->change_by = 'admin';
                $find->cancel_time = time();
                $find->reason = $request->reason;
                $find->status = 2;
                $find->save();
            }
        }
        if ($request->type == 'content') {
            $find = SocialContentRequest::find($request->id);
            if ($find) {
                $find->change_by = 'admin';
                $find->cancel_time = time();
                $find->reason = $request->reason;
                $find->status = 2;
                $find->save();
            }
        }
        if ($request->type == 'data-entry') {
            $find = DataEntryRequest::find($request->id);
            if ($find) {
                $find->change_by = 'admin';
                $find->cancel_time = time();
                $find->reason = $request->reason;
                $find->status = 2;
                $find->save();
            }
        }

        if ($request->type == 'paid-survey') {
            $find = PaidSurveyRequest::find($request->id);
            if ($find) {
                $find->change_by = 'admin';
                $find->cancel_time = time();
                $find->reason = $request->reason;
                $find->status = 2;
                $find->save();
            }
        }
        if ($request->type == 'app-test') {
            $find = AppTestRequest::find($request->id);
            if ($find) {
                $find->change_by = 'admin';
                $find->cancel_time = time();
                $find->reason = $request->reason;
                $find->status = 2;
                $find->save();
            }
        }
        if ($request->type == 'writing') {
            $find = WritingRequest::find($request->id);
            if ($find) {
                $find->change_by = 'admin';
                $find->cancel_time = time();
                $find->reason = $request->reason;
                $find->status = 2;
                $find->save();
            }
        }
        return redirect()->back();
    }

    public function approveRequests($type){
        if ($type == 'employment') {
            $list = EmploymentRequest::with(['user'])->where('status', 1)->latest()->paginate(50);
            foreach ($list as $item) {
                $sub_categories = explode(',', $item->categories);
                $index1 = Category::find($sub_categories[0]);
                $main_catgroy = Category::find($index1->parent_id)->first();
                $item->main_categories = $main_catgroy;
                $item->sub_categories = Category::whereIn('id', $sub_categories)->get();
            }
            return view('panel-v1.request.approve.employment', compact('list', 'type'));
        }

        if ($type == 'internship') {
            $list = InternshipOpportunity::with(['user'])->where('status', 1)->latest()->paginate(50);
            return view('panel-v1.request.approve.internship', compact('list', 'type'));
        }
        if ($type == 'apprenticeship') {
            $list = ApprenticeshipOpportunity::with(['user'])->where('status', 1)->latest()->paginate(50);
            return view('panel-v1.request.approve.apprenticeship', compact('list', 'type'));
        }
        if ($type == 'transcription') {
            $list = TranscriptionRequest::with(['user'])->with(['transcription'])->where('status', 1)->latest()->paginate(50);
            return view('panel-v1.request.approve.transcription', compact('list', 'type'));
        }
        if ($type == 'translation') {
            $list = TranslationRequest::with(['user'])->with(['translation'])->where('status', 1)->latest()->paginate(50);
            return view('panel-v1.request.approve.translation', compact('list', 'type'));
        }
        if ($type == 'content') {
            $list = SocialContentRequest::with(['user'])->with(['content'])->where('status', 1)->latest()->paginate(50);
            return view('panel-v1.request.approve.content', compact('list', 'type'));
        }
        if ($type == 'data-entry') {
            $list = DataEntryRequest::with(['user'])->with(['job'])->where('status', 1)->latest()->paginate(50);
            return view('panel-v1.request.approve.data-entry', compact('list', 'type'));
        }
        if ($type == 'paid-survey') {
            $list = PaidSurveyRequest::with(['user'])->where('status', 1)->latest()->paginate(50);
            return view('panel-v1.request.approve.paid-survey', compact('list', 'type'));
        }
        if ($type == 'app-test') {
            $list = AppTestRequest::with(['user'])->where('status', 1)->latest()->paginate(50);
            return view('panel-v1.request.approve.app-test', compact('list', 'type'));
        }
        if ($type == 'writing') {
            $list = WritingRequest::with(['user'])->where('status', 1)->latest()->paginate(50);
            return view('panel-v1.request.approve.writing', compact('list', 'type'));
        }
    }
}
