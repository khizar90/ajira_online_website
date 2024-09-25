@extends('panel-v1.layouts.base')
@section('title', 'Survey Detail')
@section('main', 'Survey Detail Management')
@section('link')
    <link rel="stylesheet" href="/panel-v1/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="/panel-v1/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="/panel-v1/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="/panel-v1/assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="/panel-v1/assets/vendor/libs/formvalidation/dist/css/formValidation.min.css" />
    <link rel="stylesheet" href="/panel-v1/assets/vendor/libs/toastr/toastr.css" />
    <link rel="stylesheet" href="/panel-v1/assets/vendor/libs/animate-css/animate.css" />
    <link rel="stylesheet" href="/panel-v1/assets/vendor/libs/typeahead-js/typeahead.css" />

@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-start align-items-center user-name">
                                @if ($find->user->profile_image)
                                    <div class="avatar-wrapper">
                                        <div class="avatar avatar-sm me-3"><img
                                                src="{{ asset($find->user->profile_image != '' ? $find->user->profile_image : 'user.png') }}"
                                                alt="Avatar" class="rounded-circle">
                                        </div>
                                    </div>
                                @else
                                    <div class="avatar-wrapper">
                                        <div class="avatar avatar-sm me-3"><span
                                                class="avatar-initial rounded-circle bg-label-danger">
                                                {{ strtoupper(substr($find->user->name, 0, 2)) }}</span>
                                        </div>
                                    </div>
                                @endif



                                <div class="d-flex flex-column"><a class="text-body text-truncate"><span
                                            class="fw-semibold user-name-text">{{ $find->user->name }}
                                        </span></a><small class="text-muted">#{{ $find->user->email }}</small>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3>Paid Survey Answers</h3>
                                @if ($find->status == 0)
                                    <button class="badge bg-label-secondary btn" data-bs-toggle="modal"
                                        data-bs-target="#verifyModal{{ $find->id }}" text-capitalized="">Pending
                                    </button>
                                @endif
                            </div>
                            <ul>
                                @foreach ($answers as $answer)
                                    <div class="mb-3">
                                        <h6 class="mb-0">
                                            {{ $answer->question }}
                                        </h6>
                                        <div>{{ $answer->answer }}</div>
                                    </div>
                                @endforeach
                            </ul>

                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="modal fade" data-bs-backdrop='static' id="verifyModal{{ $find->id }}" tabindex="-1"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content verifymodal">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Approve Request</h5>
                        <button type="button" class="btn modalRemove" data-bs-dismiss="modal" id="closeButtonadd"><i
                                class="fas fa-times"></i>
                        </button>
                    </div>
                    <hr>
                    <div class="container">
                        <div class="row">
                            <div class="first">
                                <a href="#" class="btn" data-bs-toggle="modal"
                                    data-bs-target="#cancelRequest{{ $find->id }}" style="color: #a8aaae ">Cancel</a>
                            </div>
                            <div class="second">
                                <a class="btn text-center"
                                    href="{{ url('dashboard/request/approve/' . $type . '/' . $find->id) }}">Approve</a>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>

        <div class="modal fade" data-bs-backdrop='static' id="cancelRequest{{ $find->id }}" tabindex="-1"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Cancel Request</h5>
                        <button type="button" class="btn modalRemove" data-bs-dismiss="modal" id="closeButtonadd"><i
                                class="fas fa-times"></i>
                        </button>
                    </div>
                    <hr>
                    <form action="{{ url('dashboard/request/cancel') }}" id="addForm" method="Post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body pt-0">
                            <div class="row">
                                <div class="col mb-3">
                                    <label class="form-label">Reason</label>
                                    <textarea id="" name="reason" class="form-control" rows="3"
                                        placeholder="Enter the Reason of cancalation" required></textarea>
                                </div>

                            </div>
                            <input type="hidden" name="type" value="{{ $type }}">
                            <input type="hidden" name="id" value="{{ $find->id }}">
                            <div class="row">
                                <div class="col">
                                    <button type="submit" value="Submit" class="btn btn-primary saveBtn"
                                        id="signinButton">
                                        <span id="btntext">Cancel Request</span>
                                    </button>
                                </div>

                            </div>
                        </div>

                    </form>



                </div>
            </div>
        </div>
    @endsection

    @section('script')
        <script src="/panel-v1/assets/js/ui-toasts.js"></script>
        <script src="/panel-v1/assets/vendor/libs/toastr/toastr.js"></script>
        <script src="/panel-v1/assets/vendor/libs/typeahead-js/typeahead.js"></script>

    @endsection
