<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\UserApprenticeshipRequest;
use App\Http\Requests\Api\User\UserAppTestRequest;
use App\Http\Requests\Api\User\UserContactUsReuqest;
use App\Http\Requests\Api\User\UserDataEntryRequest;
use App\Http\Requests\Api\User\UserEmploymentRequest;
use App\Http\Requests\Api\User\UserInternshipRequest;
use App\Http\Requests\Api\User\UserPaidSurveyRequest;
use App\Http\Requests\Api\User\UserTranscriptionRequest;
use App\Http\Requests\Api\User\UserTranslationRequest;
use App\Http\Requests\Api\User\UserWritingRequest;
use App\Models\ApprenticeshipOpportunity;
use App\Models\AppTestRequest;
use App\Models\Category;
use App\Models\ContactUs;
use App\Models\DataEntry;
use App\Models\DataEntryRequest;
use App\Models\EmploymentRequest;
use App\Models\InternshipOpportunity;
use App\Models\PaidSurveyRequest;
use App\Models\SocialContent;
use App\Models\SocialContentRequest;
use App\Models\Transcription;
use App\Models\TranscriptionRequest;
use App\Models\TranslateAudio;
use App\Models\Translation;
use App\Models\TranslationRequest;
use App\Models\User;
use App\Models\Writing;
use App\Models\WritingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use stdClass;

class UserController extends Controller
{
    public function home(Request $request, $mian_type, $sub_type)
    {
        $user = User::find($request->user()->uuid);
        if ($mian_type == 'employment' && $sub_type == 'submitted') {
            $submitted = EmploymentRequest::where('status', 0)->where('user_id', $user->uuid)->latest()->first();
            if ($submitted) {
                $sub_categories = explode(',', $submitted->categories);
                $index1 = Category::find($sub_categories[0]);
                $main_catgroy = Category::find($index1->parent_id)->first();
                $submitted->main_categories = $main_catgroy;
                $submitted->sub_categories = Category::whereIn('id', $sub_categories)->get();
            } else {
                $submitted = new stdClass();
            }
            return response()->json([
                'status' => true,
                'data' => $submitted,
                'action' => 'Employment Request'
            ]);
        }

        if ($mian_type == 'internship' && $sub_type == 'submitted') {
            $submitted = InternshipOpportunity::where('status', 0)->where('user_id', $user->uuid)->latest()->first();
            if (!$submitted) {
                $submitted = new stdClass();
            }
            return response()->json([
                'status' => true,
                'data' => $submitted,
                'action' => 'Internship Request'
            ]);
        }

        if ($mian_type == 'apprenticeship' && $sub_type == 'submitted') {
            $submitted = ApprenticeshipOpportunity::where('status', 0)->where('user_id', $user->uuid)->latest()->first();
            if (!$submitted) {
                $submitted = new stdClass();
            }
            return response()->json([
                'status' => true,
                'data' => $submitted,
                'action' => 'Apprenticeship Request'
            ]);
        }

        if ($mian_type == 'transcription' && $sub_type == 'submitted') {
            $submitted = TranscriptionRequest::with(['transcription'])->where('user_id', $user->uuid)->where('status', 0)->latest()->get();
            if (!$submitted) {
                $submitted = new stdClass();
            }
            return response()->json([
                'status' => true,
                'data' => $submitted,
                'action' => 'Transcription Request'
            ]);
        }

        if ($mian_type == 'translation' && $sub_type == 'submitted') {
            $submitted = TranslationRequest::with(['translation'])->where('status', 0)->where('user_id', $user->uuid)->latest()->get();
            if (!$submitted) {
                $submitted = new stdClass();
            }
            return response()->json([
                'status' => true,
                'data' => $submitted,
                'action' => 'Translation Request'
            ]);
        }

        if ($mian_type == 'content' && $sub_type == 'submitted') {
            $submitted = SocialContentRequest::with(['content'])->where('status', 0)->where('user_id', $user->uuid)->latest()->get();
            if (!$submitted) {
                $submitted = new stdClass();
            }
            return response()->json([
                'status' => true,
                'data' => $submitted,
                'action' => 'Transcription Request'
            ]);
        }

        if ($mian_type == 'data-entry' && $sub_type == 'submitted') {
            $submitted = DataEntryRequest::with(['job'])->where('status', 0)->where('user_id', $user->uuid)->latest()->get();
            if (!$submitted) {
                $submitted = new stdClass();
            }
            return response()->json([
                'status' => true,
                'data' => $submitted,
                'action' => 'Data Entry Request'
            ]);
        }

        if ($mian_type == 'paid-survey' && $sub_type == 'submitted') {
            $submitted = PaidSurveyRequest::where('status', 0)->where('user_id', $user->uuid)->latest()->first();
            if (!$submitted) {
                $submitted = new stdClass();
            }
            return response()->json([
                'status' => true,
                'data' => $submitted,
                'action' => 'Paid Survey Request'
            ]);
        }

        if ($mian_type == 'app-test' && $sub_type == 'submitted') {
            $submitted = AppTestRequest::where('status', 0)->where('user_id', $user->uuid)->latest()->first();
            if (!$submitted) {
                $submitted = new stdClass();
            }
            return response()->json([
                'status' => true,
                'data' => $submitted,
                'action' => 'App Test Request'
            ]);
        }

        if ($mian_type == 'writing' && $sub_type == 'submitted') {
            $submitted = WritingRequest::where('status', 0)->where('user_id', $user->uuid)->latest()->get();
            if (!$submitted) {
                $submitted = new stdClass();
            }
            return response()->json([
                'status' => true,
                'data' => $submitted,
                'action' => 'Writing Request'
            ]);
        }

        if ($mian_type == 'employment' && $sub_type == 'approved') {
            $approved = EmploymentRequest::where('status', 1)->where('user_id', $user->uuid)->latest()->get();

            foreach ($approved as $item) {
                $sub_categories = explode(',', $item->categories);
                $index1 = Category::find($sub_categories[0]);
                $main_catgroy = Category::find($index1->parent_id)->first();
                $item->main_categories = $main_catgroy;
                $item->sub_categories = Category::whereIn('id', $sub_categories)->get();
            }


            return response()->json([
                'status' => true,
                'data' => $approved,
                'action' => 'Employment Request Approved'
            ]);
        }

        if ($mian_type == 'internship' && $sub_type == 'approved') {
            $approved = InternshipOpportunity::where('status', 1)->where('user_id', $user->uuid)->latest()->get();

            return response()->json([
                'status' => true,
                'data' => $approved,
                'action' => 'Internship Request Approved'
            ]);
        }
        if ($mian_type == 'apprenticeship' && $sub_type == 'approved') {
            $approved = ApprenticeshipOpportunity::where('status', 1)->where('user_id', $user->uuid)->latest()->get();

            return response()->json([
                'status' => true,
                'data' => $approved,
                'action' => 'Apprenticeship Request Approved'
            ]);
        }

        if ($mian_type == 'transcription' && $sub_type == 'approved') {
            $approved = TranscriptionRequest::with(['transcription'])->where('status', 1)->where('user_id', $user->uuid)->latest()->get();
            if (!$approved) {
                $approved = new stdClass();
            }
            return response()->json([
                'status' => true,
                'data' => $approved,
                'action' => 'Transcription Request Approved'
            ]);
        }
        if ($mian_type == 'translation' && $sub_type == 'approved') {
            $approved = TranslationRequest::with(['translation'])->where('status', 1)->where('user_id', $user->uuid)->latest()->get();
            if (!$approved) {
                $approved = new stdClass();
            }
            return response()->json([
                'status' => true,
                'data' => $approved,
                'action' => 'Translation Request Approved'
            ]);
        }
        if ($mian_type == 'content' && $sub_type == 'approved') {
            $approved = SocialContentRequest::with(['content'])->where('status', 1)->where('user_id', $user->uuid)->latest()->get();
            if (!$approved) {
                $approved = new stdClass();
            }
            return response()->json([
                'status' => true,
                'data' => $approved,
                'action' => 'Socail Content Request Approved'
            ]);
        }
        if ($mian_type == 'data-entry' && $sub_type == 'approved') {
            $approved = DataEntryRequest::with(['job'])->where('status', 1)->where('user_id', $user->uuid)->latest()->get();
            if (!$approved) {
                $approved = new stdClass();
            }
            return response()->json([
                'status' => true,
                'data' => $approved,
                'action' => 'Data Entry Request Approved'
            ]);
        }

        if ($mian_type == 'paid-survey' && $sub_type == 'approved') {
            $approved = PaidSurveyRequest::where('status', 1)->where('user_id', $user->uuid)->latest()->get();

            return response()->json([
                'status' => true,
                'data' => $approved,
                'action' => 'Paid Survey Request Approved'
            ]);
        }

        if ($mian_type == 'app-test' && $sub_type == 'approved') {
            $approved = AppTestRequest::where('status', 1)->where('user_id', $user->uuid)->latest()->get();

            return response()->json([
                'status' => true,
                'data' => $approved,
                'action' => 'App Test Request Approved'
            ]);
        }

        if ($mian_type == 'writing' && $sub_type == 'approved') {
            $approved = WritingRequest::where('status', 1)->where('user_id', $user->uuid)->latest()->get();

            return response()->json([
                'status' => true,
                'data' => $approved,
                'action' => 'Writing Request Approved'
            ]);
        }

        if ($mian_type == 'employment' && $sub_type == 'user') {
            $canceled = EmploymentRequest::where('status', 2)->where('user_id', $user->uuid)->where('change_by', 'user')->latest()->get();

            foreach ($canceled as $item) {
                $sub_categories = explode(',', $item->categories);
                $index1 = Category::find($sub_categories[0]);
                $main_catgroy = Category::find($index1->parent_id)->first();
                $item->main_categories = $main_catgroy;
                $item->sub_categories = Category::whereIn('id', $sub_categories)->get();
            }


            return response()->json([
                'status' => true,
                'data' => $canceled,
                'action' => 'User Canceled'
            ]);
        }

        if ($mian_type == 'employment' && $sub_type == 'admin') {
            $canceled = EmploymentRequest::where('status', 2)->where('user_id', $user->uuid)->where('change_by', 'admin')->latest()->get();

            foreach ($canceled as $item) {
                $sub_categories = explode(',', $item->categories);
                $index1 = Category::find($sub_categories[0]);
                $main_catgroy = Category::find($index1->parent_id)->first();
                $item->main_categories = $main_catgroy;
                $item->sub_categories = Category::whereIn('id', $sub_categories)->get();
            }


            return response()->json([
                'status' => true,
                'data' => $canceled,
                'action' => 'Admin Canceled'
            ]);
        }

        if ($mian_type == 'internship' && $sub_type == 'user') {
            $canceled = InternshipOpportunity::where('status', 2)->where('user_id', $user->uuid)->where('change_by', 'user')->latest()->get();

            return response()->json([
                'status' => true,
                'data' => $canceled,
                'action' => 'User Canceled'
            ]);
        }

        if ($mian_type == 'internship' && $sub_type == 'admin') {
            $canceled = InternshipOpportunity::where('status', 2)->where('user_id', $user->uuid)->where('change_by', 'admin')->latest()->get();

            return response()->json([
                'status' => true,
                'data' => $canceled,
                'action' => 'Admin Canceled'
            ]);
        }

        if ($mian_type == 'apprenticeship' && $sub_type == 'admin') {
            $canceled = ApprenticeshipOpportunity::where('status', 2)->where('user_id', $user->uuid)->where('change_by', 'admin')->latest()->get();

            return response()->json([
                'status' => true,
                'data' => $canceled,
                'action' => 'Admin Canceled'
            ]);
        }

        if ($mian_type == 'apprenticeship' && $sub_type == 'user') {
            $canceled = ApprenticeshipOpportunity::where('status', 2)->where('user_id', $user->uuid)->where('change_by', 'user')->latest()->get();

            return response()->json([
                'status' => true,
                'data' => $canceled,
                'action' => 'User Canceled'
            ]);
        }

        if ($mian_type == 'transcription' && $sub_type == 'user') {
            $canceled = TranscriptionRequest::with(['transcription'])->where('status', 2)->where('user_id', $user->uuid)->where('change_by', 'user')->latest()->get();
            if (!$canceled) {
                $canceled = new stdClass();
            }
            return response()->json([
                'status' => true,
                'data' => $canceled,
                'action' => 'User Canceled'
            ]);
        }

        if ($mian_type == 'transcription' && $sub_type == 'admin') {
            $canceled = TranscriptionRequest::with(['transcription'])->where('status', 2)->where('user_id', $user->uuid)->where('change_by', 'admin')->latest()->get();
            if (!$canceled) {
                $canceled = new stdClass();
            }
            return response()->json([
                'status' => true,
                'data' => $canceled,
                'action' => 'Admin Canceled'
            ]);
        }
        if ($mian_type == 'translation' && $sub_type == 'user') {
            $canceled = TranslationRequest::with(['translation'])->where('status', 2)->where('user_id', $user->uuid)->where('change_by', 'user')->latest()->get();
            if (!$canceled) {
                $canceled = new stdClass();
            }
            return response()->json([
                'status' => true,
                'data' => $canceled,
                'action' => 'User Canceled'
            ]);
        }

        if ($mian_type == 'translation' && $sub_type == 'admin') {
            $canceled = TranslationRequest::with(['translation'])->where('status', 2)->where('user_id', $user->uuid)->where('change_by', 'admin')->latest()->get();
            if (!$canceled) {
                $canceled = new stdClass();
            }
            return response()->json([
                'status' => true,
                'data' => $canceled,
                'action' => 'Admin Canceled'
            ]);
        }
        if ($mian_type == 'content' && $sub_type == 'user') {
            $canceled = SocialContentRequest::with(['content'])->where('status', 2)->where('user_id', $user->uuid)->where('change_by', 'user')->latest()->get();
            if (!$canceled) {
                $canceled = new stdClass();
            }
            return response()->json([
                'status' => true,
                'data' => $canceled,
                'action' => 'User Canceled'
            ]);
        }

        if ($mian_type == 'content' && $sub_type == 'admin') {
            $canceled = SocialContentRequest::with(['content'])->where('status', 2)->where('user_id', $user->uuid)->where('change_by', 'admin')->latest()->get();
            if (!$canceled) {
                $canceled = new stdClass();
            }
            return response()->json([
                'status' => true,
                'data' => $canceled,
                'action' => 'Admin Canceled'
            ]);
        }

        if ($mian_type == 'data-entry' && $sub_type == 'user') {
            $canceled = DataEntryRequest::with(['job'])->where('status', 2)->where('user_id', $user->uuid)->where('change_by', 'user')->latest()->get();
            if (!$canceled) {
                $canceled = new stdClass();
            }
            return response()->json([
                'status' => true,
                'data' => $canceled,
                'action' => 'User Canceled'
            ]);
        }

        if ($mian_type == 'data-entry' && $sub_type == 'admin') {
            $canceled = DataEntryRequest::with(['job'])->where('status', 2)->where('user_id', $user->uuid)->where('change_by', 'admin')->latest()->get();
            if (!$canceled) {
                $canceled = new stdClass();
            }
            return response()->json([
                'status' => true,
                'data' => $canceled,
                'action' => 'Admin Canceled'
            ]);
        }

        if ($mian_type == 'paid-survey' && $sub_type == 'user') {
            $canceled = PaidSurveyRequest::where('status', 2)->where('change_by', 'user')->where('user_id', $user->uuid)->latest()->get();

            return response()->json([
                'status' => true,
                'data' => $canceled,
                'action' => 'User Canceled'
            ]);
        }

        if ($mian_type == 'paid-survey' && $sub_type == 'admin') {
            $canceled = PaidSurveyRequest::where('status', 2)->where('change_by', 'admin')->where('user_id', $user->uuid)->latest()->get();

            return response()->json([
                'status' => true,
                'data' => $canceled,
                'action' => 'Admin Canceled'
            ]);
        }

        if ($mian_type == 'app-test' && $sub_type == 'user') {
            $canceled = AppTestRequest::where('status', 2)->where('change_by', 'user')->where('user_id', $user->uuid)->latest()->get();

            return response()->json([
                'status' => true,
                'data' => $canceled,
                'action' => 'User Canceled'
            ]);
        }

        if ($mian_type == 'app-test' && $sub_type == 'admin') {
            $canceled = AppTestRequest::where('status', 2)->where('change_by', 'admin')->where('user_id', $user->uuid)->latest()->get();

            return response()->json([
                'status' => true,
                'data' => $canceled,
                'action' => 'Admin Canceled'
            ]);
        }

        if ($mian_type == 'writing' && $sub_type == 'user') {
            $canceled = WritingRequest::where('status', 2)->where('user_id', $user->uuid)->where('change_by', 'user')->latest()->get();

            return response()->json([
                'status' => true,
                'data' => $canceled,
                'action' => 'User Canceled'
            ]);
        }

        if ($mian_type == 'writing' && $sub_type == 'admin') {
            $canceled = WritingRequest::where('status', 2)->where('user_id', $user->uuid)->where('change_by', 'admin')->latest()->get();

            return response()->json([
                'status' => true,
                'data' => $canceled,
                'action' => 'Admin Canceled'
            ]);
        }
    }
    public function category(Request $request, $type)
    {
        $user = User::find($request->user()->uuid);
        if ($type == 'employment') {
            $categories = Category::select('id', 'name')->where('type', 'employment')->where('parent_id', null)->get();
            foreach ($categories as $item) {
                $sub_categories  = Category::select('id', 'name')->where('parent_id', $item->id)->get();
                $item->sub_categories = $sub_categories;
            }
            $find = EmploymentRequest::where('user_id', $user->uuid)->where('status', 0)->latest()->first();
            if ($find) {
                $is_added = true;
            } else {
                $is_added = false;
            }
            return response()->json([
                'status' => true,
                'is_added' => $is_added,
                'data' => $categories,
                'action' => 'Employment Categories'
            ]);
        }
        if ($type == 'internship') {
            $college = Category::select('id', 'name')->where('type', 'internship-college')->get();
            $department = Category::select('id', 'name')->where('type', 'internship-department')->get();

            $find = InternshipOpportunity::where('user_id', $user->uuid)->where('status', 0)->latest()->first();
            if ($find) {
                $is_added = true;
            } else {
                $is_added = false;
            }
            return response()->json([
                'status' => true,
                'is_added' => $is_added,
                'data' => array(
                    'college' => $college,
                    'department' => $department
                ),
                'action' => 'Internship Categories'
            ]);
        }
        if ($type == 'apprenticeship') {
            $college = Category::select('id', 'name')->where('type', 'apprenticeship-college')->get();
            $department = Category::select('id', 'name')->where('type', 'apprenticeship-department')->get();
            $skills = Category::select('id', 'name')->where('type', 'apprenticeship-skill')->get();

            $find = ApprenticeshipOpportunity::where('user_id', $user->uuid)->where('status', 0)->latest()->first();
            if ($find) {
                $is_added = true;
            } else {
                $is_added = false;
            }
            return response()->json([
                'status' => true,
                'is_added' => $is_added,
                'data' => array(
                    'college' => $college,
                    'department' => $department,
                    'skill' => $skills
                ),
                'action' => 'Apprenticeship Categories'
            ]);
        }
    }

    public function employmentRequest(UserEmploymentRequest $request)
    {
        $user = User::find($request->user()->uuid);
        $create = new EmploymentRequest();
        $create->user_id = $user->uuid;
        $create->categories = $request->categories;
        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $path = Storage::disk('local')->put('user/' . $user->uuid . '/employment', $file);
            $create->media = '/uploads/' . $path;
        }
        $create->time = time();
        $create->save();
        $find = EmploymentRequest::find($create->id);
        return response()->json([
            'status' => true,
            'data' => $find,
            'action' => 'Request Submited!'
        ]);
    }

    public function internshipRequest(UserInternshipRequest $request)
    {
        $user = User::find($request->user()->uuid);
        $create = new InternshipOpportunity();
        $create->user_id = $user->uuid;
        $create->name = $request->name;
        $create->country_code = $request->country_code;
        $create->phone = $request->phone;
        $create->email = $request->email;
        $create->college = $request->college;
        $create->country = $request->country;
        $create->city = $request->city;
        $create->department = $request->department;
        $create->date = $request->date;
        $create->time = time();
        $create->save();
        $find = InternshipOpportunity::find($create->id);
        return response()->json([
            'status' => true,
            'data' => $find,
            'action' => 'Request Submit!'
        ]);
    }

    public function apprenticeshipRequest(UserApprenticeshipRequest $request)
    {
        $user = User::find($request->user()->uuid);
        $create = new ApprenticeshipOpportunity();
        $create->user_id = $user->uuid;
        $create->name = $request->name;
        $create->country_code = $request->country_code;
        $create->phone = $request->phone;
        $create->email = $request->email ?: '';
        $create->country = $request->country;
        $create->city = $request->city;
        $create->department = $request->department;
        $create->skill = $request->skill;
        $create->date = $request->date;
        $create->time = time();
        $create->save();
        $find = ApprenticeshipOpportunity::find($create->id);
        return response()->json([
            'status' => true,
            'data' => $find,
            'action' => 'Request Submit!'
        ]);
    }

    public function transcriptionList(Request $request)
    {
        $user = User::find($request->user()->uuid);

        $list = Transcription::latest()->get();
        foreach ($list as $item) {
            $find = TranscriptionRequest::where('transcription_id', $item->id)->where('user_id', $user->uuid)->where('status', 0)->first();
            if ($find) {
                $item->is_sumbited = true;
            } else {
                $item->is_sumbited = false;
            }
        }
        return response()->json([
            'status' => true,
            'data' => $list,
            'action' => 'Transcription List!'
        ]);
    }

    public function translationList(Request $request)
    {
        $user = User::find($request->user()->uuid);

        $list = Translation::latest()->get();
        foreach ($list as $item) {
            $find = TranslationRequest::where('translation_id', $item->id)->where('user_id', $user->uuid)->where('status', 0)->first();
            if ($find) {
                $item->is_sumbited = true;
            } else {
                $item->is_sumbited = false;
            }
        }
        return response()->json([
            'status' => true,
            'data' => $list,
            'action' => 'Translation List!'
        ]);
    }

    public function contentList(Request $request)
    {
        $user = User::find($request->user()->uuid);
        $list = SocialContent::latest()->get();
        foreach ($list as $item) {
            $find = SocialContentRequest::where('content_id', $item->id)->where('user_id', $user->uuid)->where('status', 0)->first();
            if ($find) {
                $item->is_sumbited = true;
            } else {
                $item->is_sumbited = false;
            }
        }
        return response()->json([
            'status' => true,
            'data' => $list,
            'action' => 'Social Media List!'
        ]);
    }

    public function dataEntryList(Request $request)
    {
        $user = User::find($request->user()->uuid);
        $list = DataEntry::latest()->get();
        foreach ($list as $item) {
            $find = DataEntryRequest::where('job_id', $item->id)->where('user_id', $user->uuid)->where('status', 0)->first();
            if ($find) {
                $item->is_sumbited = true;
            } else {
                $item->is_sumbited = false;
            }
        }
        return response()->json([
            'status' => true,
            'data' => $list,
            'action' => 'Jobs List!'
        ]);
    }

    public function paidSurveyCheck(Request $request)
    {
        $user = User::find($request->user()->uuid);
        $check = PaidSurveyRequest::where('user_id', $user->uuid)->where('status', 0)->latest()->first();
        if ($check) {
            $is_submitted = true;
        } else {
            $is_submitted = false;
        }
        return response()->json([
            'status' => true,
            'is_sumbitted' => $is_submitted,
            'action' => 'Paid Survey!'
        ]);
    }
    public function appTestCheck(Request $request)
    {
        $user = User::find($request->user()->uuid);
        $check = AppTestRequest::where('user_id', $user->uuid)->where('status', 0)->latest()->first();
        if ($check) {
            $is_submitted = true;
        } else {
            $is_submitted = false;
        }
        return response()->json([
            'status' => true,
            'is_sumbitted' => $is_submitted,
            'action' => 'App Test!'
        ]);
    }

    public function writingCheck(Request $request)
    {
        $user = User::find($request->user()->uuid);
        $writing = Writing::latest()->first();
        return response()->json([
            'status' => true,
            'data' => $writing,
            'action' => 'Writing Instructions!'
        ]);
    }
    public function translationRequest(UserTranslationRequest $request)
    {
        $user = User::find($request->user()->uuid);
        $create = new TranslationRequest();
        $create->user_id = $user->uuid;
        $create->translation_id = $request->translation_id;
        $create->text = $request->text;
        $create->time = time();
        $create->save();
        return response()->json([
            'status' => true,
            'action' => 'Translation Request Sumbited!'
        ]);
    }

    public function transcriptionRequest(UserTranscriptionRequest $request)
    {
        $user = User::find($request->user()->uuid);
        $create = new TranscriptionRequest();
        $create->user_id = $user->uuid;
        $create->transcription_id = $request->transcription_id;
        $create->text = $request->text;
        $create->time = time();
        $create->save();
        return response()->json([
            'status' => true,
            'action' => 'Transcription Request Sumbited!'
        ]);
    }

    public function contentRequest(Request $request, $content_id)
    {
        $user = User::find($request->user()->uuid);
        $create = new SocialContentRequest();
        $create->user_id = $user->uuid;
        $create->content_id = $content_id;
        $create->time = time();
        $create->save();
        return response()->json([
            'status' => true,
            'action' => 'Content Request Sumbited!'
        ]);
    }

    public function dataEntryRequest(Request $request, $job_id)
    {
        $user = User::find($request->user()->uuid);
        $create = new DataEntryRequest();
        $create->user_id = $user->uuid;
        $create->job_id = $job_id;
        $create->time = time();
        $create->save();
        return response()->json([
            'status' => true,
            'action' => 'Job Request Submitted!'
        ]);
    }

    public function paidSurveyRequest(UserPaidSurveyRequest $request)
    {
        $user = User::find($request->user()->uuid);
        $create = new PaidSurveyRequest();
        $create->user_id = $user->uuid;
        $create->what_car = $request->what_car;
        $create->where_gas_buy = $request->where_gas_buy;
        $create->color = $request->color;
        $create->age = $request->age;
        $create->time = time();
        $create->save();
        return response()->json([
            'status' => true,
            'action' => 'Paid Survey Request Submitted!'
        ]);
    }

    public function appTestRequest(UserAppTestRequest $request)
    {
        $user = User::find($request->user()->uuid);
        $create =  new AppTestRequest();
        $create->user_id = $user->uuid;
        $create->full_name = $request->full_name;
        $create->email = $request->email;
        $create->country_code = $request->country_code;
        $create->phone = $request->phone;
        $create->smart_phone = $request->smart_phone;
        $create->tested = $request->tested ?: '';
        $create->time = time();
        $create->save();
        return response()->json([
            'status' => true,
            'action' => 'App Test Request Submitted!'
        ]);
    }

    public function writingRequest(UserWritingRequest $request)
    {
        $user = User::find($request->user()->uuid);
        $create =  new WritingRequest();
        $create->user_id = $user->uuid;
        $file = $request->file('media');
        $path = Storage::disk('local')->put('Writing/file', $file);
        $create->media = '/uploads/' . $path;
        $create->time = time();
        $create->save();
        return response()->json([
            'status' => true,
            'action' => 'Writing Request Submitted!'
        ]);
    }

    public function cancelRequest(Request $request, $type, $id)
    {
        $user = User::find($request->user()->uuid);

        if ($type == 'employment') {
            $find = EmploymentRequest::find($id);
            if ($find) {
                $find->status = 2;
                $find->change_by = 'user';
                $find->cancel_time = time();
                $find->save();
            }
        }
        if ($type == 'internship') {
            $find = InternshipOpportunity::find($id);
            if ($find) {
                $find->status = 2;
                $find->change_by = 'user';
                $find->cancel_time = time();
                $find->save();
            }
        }
        if ($type == 'apprenticeship') {
            $find = ApprenticeshipOpportunity::find($id);
            if ($find) {
                $find->status = 2;
                $find->change_by = 'user';
                $find->cancel_time = time();
                $find->save();
            }
        }

        if ($type == 'transcription') {
            $find = TranscriptionRequest::find($id);
            if ($find) {
                $find->status = 2;
                $find->change_by = 'user';
                $find->cancel_time = time();
                $find->save();
            }
        }
        if ($type == 'translation') {
            $find = TranslationRequest::find($id);
            if ($find) {
                $find->status = 2;
                $find->change_by = 'user';
                $find->cancel_time = time();
                $find->save();
            }
        }
        if ($type == 'content') {
            $find = SocialContentRequest::find($id);
            if ($find) {
                $find->status = 2;
                $find->change_by = 'user';
                $find->cancel_time = time();
                $find->save();
            }
        }
        if ($type == 'data-entry') {
            $find = DataEntryRequest::find($id);
            if ($find) {
                $find->status = 2;
                $find->change_by = 'user';
                $find->cancel_time = time();
                $find->save();
            }
        }
        if ($type == 'paid-survey') {
            $find = PaidSurveyRequest::find($id);
            if ($find) {
                $find->status = 2;
                $find->change_by = 'user';
                $find->cancel_time = time();
                $find->save();
            }
        }
        if ($type == 'app-test') {
            $find = AppTestRequest::find($id);
            if ($find) {
                $find->status = 2;
                $find->change_by = 'user';
                $find->cancel_time = time();
                $find->save();
            }
        }
        if ($type == 'writing') {
            $find = WritingRequest::find($id);
            if ($find) {
                $find->status = 2;
                $find->change_by = 'user';
                $find->cancel_time = time();
                $find->save();
            }
        }
        return response()->json([
            'status' => true,
            'action' => 'Request Cancel!'
        ]);
    }

    public function contactUs(UserContactUsReuqest $request)
    {
        $user = User::find($request->user()->uuid);
        $create =  new ContactUs();
        $create->user_id = $user->uuid;
        $create->subject = $request->subject;
        $create->full_name = $request->full_name;
        $create->email = $request->email;
        $create->message = $request->message;
        $create->save();
        return response()->json([
            'status' => true,
            'action' => 'Form Submitted!'
        ]);
    }


    public function updateUser(Request $request)
    {
        $user = User::find($request->user()->uuid);
        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email')) {
            if (User::where('email', $request->email)->where('uuid', '!=', $user->uuid)->exists()) {
                return response()->json([
                    'status' => false,
                    'action' => 'Email Address is already registered'
                ]);
            } else {
                $user->email = $request->email;
            }
        }


        if ($request->has('phone_number')) {
            if (User::where('phone_number', $request->phone_number)->where('uuid', '!=', $user->uuid)->exists()) {
                return response()->json([
                    'status' => false,
                    'action' => 'Phone Number is already registered'
                ]);
            } else {
                $user->phone_number = $request->phone_number;
                $user->country_code = $request->country_code;
                $user->phone = $request->phone;
            }
        }

        if ($request->has('country')) {
            $user->country = $request->country;
        }

        $user->save();
        return response()->json([
            'status' => true,
            'data' => $user,
            'action' => 'User Updated'
        ]);
    }
}
