@extends('panel-v1.layouts.base')
@section('title', 'Transcription Reuqest')
@section('main', 'Transcription Reuqest Management')
@section('link')
    <link rel="stylesheet" href="/panel-v1/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="/panel-v1/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="/panel-v1/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="/panel-v1/assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="/panel-v1/assets/vendor/libs/formvalidation/dist/css/formValidation.min.css" />
    <style>
        .td-text {
            max-width: 200px;
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">

            <!-- Users List Table -->
            <div class="card">

                <div class="card-datatable table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">


                        <div class="row me-2">
                            <div class="col-md-2">
                                <div class="me-3">

                                </div>
                            </div>

                        </div>


                        <table class="table border-top dataTable" id="usersTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User</th>
                                    <th>Translation</th>
                                    <th>Language</th>
                                    <th>Text</th>
                                    <th>Apply Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="searchResults">
                                @foreach ($list as $item)
                                    <tr class="odd">
                                        <td>{{ $loop->iteration }}</td>

                                        <td class="sorting_1">
                                            <div class="d-flex justify-content-start align-items-center user-name">
                                                @if ($item->user->profile_image)
                                                    <div class="avatar-wrapper">
                                                        <div class="avatar avatar-sm me-3"><img
                                                                src="{{ asset($item->user->profile_image != '' ? $item->user->profile_image : 'user.png') }}"
                                                                alt="Avatar" class="rounded-circle">
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="avatar-wrapper">
                                                        <div class="avatar avatar-sm me-3"><span
                                                                class="avatar-initial rounded-circle bg-label-danger">
                                                                {{ strtoupper(substr($item->user->name, 0, 2)) }}</span>
                                                        </div>
                                                    </div>
                                                @endif



                                                <div class="d-flex flex-column"><span
                                                        class="fw-semibold user-name-text">{{ $item->user->name }}
                                                    </span>
                                                    <small
                                                        class="text-muted">&#64;{{ $item->user->email != '' ? $item->user->email : 'No Email' }}</small>
                                                </div>
                                            </div>

                                        </td>

                                        <td>
                                            {{ $item->translation->text }}
                                        </td>
                                        <td >
                                            {{ $item->translation->language }}
                                        </td>
                                        <td class="td-text">
                                            {{ $item->text }}
                                        </td>


                                        <td>
                                            {{ \Carbon\Carbon::createFromTimestamp($item->time)->format('d, F Y h:i A') }}
                                        </td>
                                        <td>
                                            <button class="badge bg-label-secondary btn" data-bs-toggle="modal"
                                                data-bs-target="#verifyModal{{ $item->id }}"
                                                text-capitalized="">Pending
                                            </button>
                                        </td>

                                        <div class="modal fade" data-bs-backdrop='static'
                                            id="verifyModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                                <div class="modal-content verifymodal">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalCenterTitle">Approve Request</h5>
                                                        <button type="button" class="btn modalRemove"
                                                            data-bs-dismiss="modal" id="closeButtonadd"><i
                                                                class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                    <hr>
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="first">
                                                                <a href="#" class="btn" data-bs-toggle="modal"
                                                                    data-bs-target="#cancelRequest{{ $item->id }}"
                                                                    style="color: #a8aaae ">Cancel</a>
                                                            </div>
                                                            <div class="second">
                                                                <a class="btn text-center"
                                                                    href="{{ url('dashboard/request/approve/' . $type . '/' . $item->id) }}">Approve</a>
                                                            </div>
                                                        </div>
                                                    </div>



                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" data-bs-backdrop='static'
                                            id="cancelRequest{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalCenterTitle">Cancel Request</h5>
                                                        <button type="button" class="btn modalRemove"
                                                            data-bs-dismiss="modal" id="closeButtonadd"><i
                                                                class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                    <hr>
                                                    <form action="{{ url('dashboard/request/cancel') }}" id="addForm"
                                                        method="Post" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body pt-0">
                                                            <div class="row">
                                                                <div class="col mb-3">
                                                                    <label class="form-label">Reason</label>
                                                                    <textarea id="" name="reason" class="form-control" rows="3"
                                                                        placeholder="Enter the Reason of cancalation" required></textarea>
                                                                </div>

                                                            </div>
                                                            <input type="hidden" name="type"
                                                                value="{{ $type }}">
                                                            <input type="hidden" name="id"
                                                                value="{{ $item->id }}">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <button type="submit" value="Submit"
                                                                        class="btn btn-primary saveBtn" id="signinButton">
                                                                        <span id="btntext">Cancel Request</span>
                                                                    </button>
                                                                </div>

                                                            </div>
                                                        </div>

                                                    </form>



                                                </div>
                                            </div>
                                        </div>
                                    </tr>
                                @endforeach



                            </tbody>
                        </table>


                        <div id="paginationContainer">
                            <div class="row mx-2">
                                <div class="col-sm-12 col-md-6">
                                    <div class="dataTables_info" id="DataTables_Table_0_info" role="status"
                                        aria-live="polite">Showing {{ $list->firstItem() }} to
                                        {{ $list->lastItem() }}
                                        of
                                        {{ $list->total() }} entries</div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="dataTables_paginate paging_simple_numbers" id="paginationLinks">
                                        {{-- <h1>{{ @json($data) }}</h1> --}}
                                        @if ($list->hasPages())
                                            {{ $list->links('pagination::bootstrap-4') }}
                                        @endif


                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Offcanvas to add new user -->

            </div>
        </div>
    @endsection

    @section('script')

    @endsection
