@php
    $employmentRequest = \App\Models\EmploymentRequest::where('status', 0)->count();
    $internshipOpportunity = \App\Models\InternshipOpportunity::where('status', 0)->count();
    $apprenticeshipOpportunity = \App\Models\ApprenticeshipOpportunity::where('status', 0)->count();
    $transcriptionRequest = \App\Models\TranscriptionRequest::where('status', 0)->count();
    $translationRequest = \App\Models\TranslationRequest::where('status', 0)->count();
    $socialContentRequest = \App\Models\SocialContentRequest::where('status', 0)->count();
    $dataEntryRequest = \App\Models\DataEntryRequest::where('status', 0)->count();
    $paidSurveyRequest = \App\Models\PaidSurveyRequest::where('status', 0)->count();
    $appTestRequest = \App\Models\AppTestRequest::where('status', 0)->count();
    $writingRequest = \App\Models\WritingRequest::where('status', 0)->count();

@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a class="app-brand-link">

            <span class="app-brand-text demo menu-text fw-bold"><img src="/panel-v1/assets/img/App logo.png"
                    alt=""></span>
        </a>

        {{-- <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a> --}}
    </div>
    <div class="brandborder">

    </div>

    {{-- <div class="menu-inner-shadow"></div> --}}




    <ul class="menu-inner py-1">
        <!-- Dashboards -->




        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Dashboard</span>
        </li>
        <li class="menu-item {{ Request::url() == route('dashboard-') ? 'active' : '' }}">
            <a href="{{ route('dashboard-') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-circle"></i>
                <div data-i18n="Statistics">Statistics</div>
            </a>
        </li>


        <!-- Apps & Pages -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">User Managements</span>
        </li>
        <li
            class="menu-item {{ Request::url() == route('dashboard-users') ? 'active' : '' }} ||  {{ Str::contains(Request::url(), 'dashboard/users/') ? 'active' : '' }}">
            <a href="{{ route('dashboard-users') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-circle"></i>
                <div data-i18n="User">Users</div>
            </a>
        </li>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Employment</span>
        </li>
        <li
            class="menu-item {{ Request::url() == route('dashboard-category-', 'employment') ? 'active' : '' }} ||  {{ Str::contains(Request::url(), 'dashboard/category/sub') ? 'active' : '' }}">
            <a href="{{ route('dashboard-category-', 'employment') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-circle"></i>
                <div data-i18n="User">Category</div>
            </a>
        </li>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Internship</span>
        </li>
        <li
            class="menu-item {{ Request::url() == route('dashboard-category-', 'internship-college') ? 'active' : '' }} ||  {{ Str::contains(Request::url(), 'dashboard/category/list/internship-college') ? 'active' : '' }}">
            <a href="{{ route('dashboard-category-', 'internship-college') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-circle"></i>
                <div data-i18n="User">College</div>
            </a>
        </li>
        <li
            class="menu-item {{ Request::url() == route('dashboard-category-', 'internship-department') ? 'active' : '' }} ||  {{ Str::contains(Request::url(), 'dashboard/category/list/internship-department') ? 'active' : '' }}">
            <a href="{{ route('dashboard-category-', 'internship-department') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-circle"></i>
                <div data-i18n="User">Department</div>
            </a>
        </li>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Apprenticeship</span>
        </li>
        {{-- <li class="menu-item {{ Request::url() == route('dashboard-category-','apprenticeship-college') ? 'active' : '' }} ||  {{ Str::contains(Request::url(), 'dashboard/category/list/apprenticeship-college') ? 'active' : '' }}">
            <a href="{{ route('dashboard-category-','apprenticeship-college') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-circle"></i>
                <div data-i18n="User">College</div>
            </a>
        </li> --}}
        <li
            class="menu-item {{ Request::url() == route('dashboard-category-', 'apprenticeship-department') ? 'active' : '' }} ||  {{ Str::contains(Request::url(), 'dashboard/category/list/apprenticeship-department') ? 'active' : '' }}">
            <a href="{{ route('dashboard-category-', 'apprenticeship-department') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-circle"></i>
                <div data-i18n="User">Department</div>
            </a>
        </li>
        <li
            class="menu-item {{ Request::url() == route('dashboard-category-', 'apprenticeship-skill') ? 'active' : '' }} ||  {{ Str::contains(Request::url(), 'dashboard/category/list/apprenticeship-skill') ? 'active' : '' }}">
            <a href="{{ route('dashboard-category-', 'apprenticeship-skill') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-circle"></i>
                <div data-i18n="User">Skill</div>
            </a>
        </li>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Online Jobs / Tasks</span>
        </li>
        <li class="menu-item {{ Request::url() == route('dashboard-transcription-') ? 'active' : '' }} ">
            <a href="{{ route('dashboard-transcription-') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-circle"></i>
                <div data-i18n="User">Transcription</div>
            </a>
        </li>
        <li class="menu-item {{ Request::url() == route('dashboard-translation-') ? 'active' : '' }} ">
            <a href="{{ route('dashboard-translation-') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-circle"></i>
                <div data-i18n="User">Translation</div>
            </a>
        </li>
        <li class="menu-item {{ Request::url() == route('dashboard-content-') ? 'active' : '' }} ">
            <a href="{{ route('dashboard-content-') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-circle"></i>
                <div data-i18n="User">Content Creation</div>
            </a>
        </li>
        <li class="menu-item {{ Request::url() == route('dashboard-data-entry-') ? 'active' : '' }} ">
            <a href="{{ route('dashboard-data-entry-') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-circle"></i>
                <div data-i18n="User">Data Entry</div>
            </a>
        </li>
        <li class="menu-item {{ Request::url() == route('dashboard-writing-') ? 'active' : '' }} ">
            <a href="{{ route('dashboard-writing-') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-circle"></i>
                <div data-i18n="User">Writing</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Pending Requests</span>
        </li>

        <li class="menu-item {{ Request::url() == route('dashboard-request-', 'employment') ? 'active' : '' }} ">
            <a href="{{ route('dashboard-request-', 'employment') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-circle"></i>
                <div data-i18n="Employment">Employment Request</div>
                @if ($employmentRequest != 0)
                    <div class="badge bg-danger rounded-pill ms-auto">{{ $employmentRequest }}</div>
                @endif
            </a>
        </li>
        <li class="menu-item {{ Request::url() == route('dashboard-request-', 'internship') ? 'active' : '' }} ">
            <a href="{{ route('dashboard-request-', 'internship') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-circle"></i>
                <div data-i18n="Employment">Internship Request</div>
                @if ($internshipOpportunity != 0)
                    <div class="badge bg-danger rounded-pill ms-auto">{{ $internshipOpportunity }}</div>
                @endif
            </a>
        </li>
        <li class="menu-item {{ Request::url() == route('dashboard-request-', 'apprenticeship') ? 'active' : '' }} ">
            <a href="{{ route('dashboard-request-', 'apprenticeship') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-circle"></i>
                <div data-i18n="apprenticeship">Apprenticeship Request</div>
                @if ($apprenticeshipOpportunity != 0)
                    <div class="badge bg-danger rounded-pill ms-auto">{{ $apprenticeshipOpportunity }}</div>
                @endif
            </a>
        </li>
        <li class="menu-item {{ Request::url() == route('dashboard-request-', 'transcription') ? 'active' : '' }} ">
            <a href="{{ route('dashboard-request-', 'transcription') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-circle"></i>
                <div data-i18n="Transcription">Transcription Request</div>
                @if ($transcriptionRequest != 0)
                    <div class="badge bg-danger rounded-pill ms-auto">{{ $transcriptionRequest }}</div>
                @endif
            </a>
        </li>
        <li class="menu-item {{ Request::url() == route('dashboard-request-', 'translation') ? 'active' : '' }} ">
            <a href="{{ route('dashboard-request-', 'translation') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-circle"></i>
                <div data-i18n="Translation">Translation Request</div>
                @if ($translationRequest != 0)
                    <div class="badge bg-danger rounded-pill ms-auto">{{ $translationRequest }}</div>
                @endif
            </a>
        </li>
        <li class="menu-item {{ Request::url() == route('dashboard-request-', 'content') ? 'active' : '' }} ">
            <a href="{{ route('dashboard-request-', 'content') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-circle"></i>
                <div data-i18n="Translation">Content Request</div>
                @if ($socialContentRequest != 0)
                    <div class="badge bg-danger rounded-pill ms-auto">{{ $socialContentRequest }}</div>
                @endif
            </a>
        </li>
        <li class="menu-item {{ Request::url() == route('dashboard-request-', 'data-entry') ? 'active' : '' }} ">
            <a href="{{ route('dashboard-request-', 'data-entry') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-circle"></i>
                <div data-i18n="Translation">Data Entry Request</div>
                @if ($dataEntryRequest != 0)
                    <div class="badge bg-danger rounded-pill ms-auto">{{ $dataEntryRequest }}</div>
                @endif
            </a>
        </li>
        <li class="menu-item {{ Request::url() == route('dashboard-request-', 'paid-survey') ? 'active' : '' }} ">
            <a href="{{ route('dashboard-request-', 'paid-survey') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-circle"></i>
                <div data-i18n="Translation">Paid Survey Request</div>
                @if ($paidSurveyRequest != 0)
                    <div class="badge bg-danger rounded-pill ms-auto">{{ $paidSurveyRequest }}</div>
                @endif
            </a>
        </li>

        <li class="menu-item {{ Request::url() == route('dashboard-request-', 'app-test') ? 'active' : '' }} ">
            <a href="{{ route('dashboard-request-', 'app-test') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-circle"></i>
                <div data-i18n="Translation">App Test Request</div>
                @if ($appTestRequest != 0)
                    <div class="badge bg-danger rounded-pill ms-auto">{{ $appTestRequest }}</div>
                @endif
            </a>
        </li>

        <li class="menu-item {{ Request::url() == route('dashboard-request-', 'writing') ? 'active' : '' }} ">
            <a href="{{ route('dashboard-request-', 'writing') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-circle"></i>
                <div data-i18n="Translation">Writing Request</div>
                @if ($writingRequest != 0)
                    <div class="badge bg-danger rounded-pill ms-auto">{{ $writingRequest }}</div>
                @endif
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Approved Requests</span>
        </li>
        <li class="menu-item {{ Request::url() == route('dashboard-request-approved-list', 'employment') ? 'active' : '' }} ">
            <a href="{{ route('dashboard-request-approved-list', 'employment') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-circle"></i>
                <div data-i18n="Employment">Employment Approve</div>
              
            </a>
        </li>
        <li class="menu-item {{ Request::url() == route('dashboard-request-approved-list', 'internship') ? 'active' : '' }} ">
            <a href="{{ route('dashboard-request-approved-list', 'internship') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-circle"></i>
                <div data-i18n="Employment">Internship Approve</div>
           
            </a>
        </li>
        <li class="menu-item {{ Request::url() == route('dashboard-request-approved-list', 'apprenticeship') ? 'active' : '' }} ">
            <a href="{{ route('dashboard-request-approved-list', 'apprenticeship') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-circle"></i>
                <div data-i18n="apprenticeship">Apprenticeship Approve</div>
             
            </a>
        </li>
        <li class="menu-item {{ Request::url() == route('dashboard-request-approved-list', 'transcription') ? 'active' : '' }} ">
            <a href="{{ route('dashboard-request-approved-list', 'transcription') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-circle"></i>
                <div data-i18n="Transcription">Transcription Approve</div>
                
            </a>
        </li>
        <li class="menu-item {{ Request::url() == route('dashboard-request-approved-list', 'translation') ? 'active' : '' }} ">
            <a href="{{ route('dashboard-request-approved-list', 'translation') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-circle"></i>
                <div data-i18n="Translation">Translation Approve</div>
              
            </a>
        </li>
        <li class="menu-item {{ Request::url() == route('dashboard-request-approved-list', 'content') ? 'active' : '' }} ">
            <a href="{{ route('dashboard-request-approved-list', 'content') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-circle"></i>
                <div data-i18n="Translation">Content Approve</div>
               
            </a>
        </li>
        <li class="menu-item {{ Request::url() == route('dashboard-request-approved-list', 'data-entry') ? 'active' : '' }} ">
            <a href="{{ route('dashboard-request-approved-list', 'data-entry') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-circle"></i>
                <div data-i18n="Translation">Data Entry Approve</div>
              
            </a>
        </li>
        <li class="menu-item {{ Request::url() == route('dashboard-request-approved-list', 'paid-survey') ? 'active' : '' }} ">
            <a href="{{ route('dashboard-request-approved-list', 'paid-survey') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-circle"></i>
                <div data-i18n="Translation">Paid Survey Approve</div>
                
            </a>
        </li>

        <li class="menu-item {{ Request::url() == route('dashboard-request-approved-list', 'app-test') ? 'active' : '' }} ">
            <a href="{{ route('dashboard-request-approved-list', 'app-test') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-circle"></i>
                <div data-i18n="Translation">App Test Approve</div>
             
            </a>
        </li>

        <li class="menu-item {{ Request::url() == route('dashboard-request-approved-list', 'writing') ? 'active' : '' }} ">
            <a href="{{ route('dashboard-request-approved-list', 'writing') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-circle"></i>
                <div data-i18n="Translation">Writing Approve</div>
               
            </a>
        </li>
    </ul>
</aside>
