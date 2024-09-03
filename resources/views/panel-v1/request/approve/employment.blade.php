@extends('panel-v1.layouts.base')
@section('title', 'Employment Reuqest')
@section('main', 'Employment Reuqest Management')
@section('link')
    <link rel="stylesheet" href="/panel-v1/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="/panel-v1/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="/panel-v1/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="/panel-v1/assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="/panel-v1/assets/vendor/libs/formvalidation/dist/css/formValidation.min.css" />
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
                                    <th>Category</th>
                                    <th>Sub Categories</th>
                                    <th>PDF</th>
                                    <th>Apply Time</th>
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
                                        <td>{{ $item->main_categories->name }}</td>
                                        <td>
                                            @foreach ($item->sub_categories as $item1)
                                                {{ $item1->name }},
                                            @endforeach
                                        </td>

                                        <td>
                                            <a href="{{ $item->media }}" target="_blank">
                                                <img src="/pdf.png" alt="" width="50" height="50"
                                                    class="rounded">
                                            </a>
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::createFromTimestamp($item->time)->format('d, F Y h:i A') }}
                                        </td>
                                       
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
