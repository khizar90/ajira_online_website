@extends('panel-v1.layouts.base')
@section('title', 'Content Creation')
@section('main', 'Content Creation Management')
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
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div id="DataTables_Table_0_filter" class="dataTables_filter">
                        </div>
                        <div class="">
                            <button class="btn btn-secondary add-new btn-primary" tabindex="0"
                                aria-controls="DataTables_Table_0" type="button" data-bs-toggle="modal"
                                data-bs-target="#addNewBus"><span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span
                                        class="d-none d-sm-inline-block">Add New Content</span></span></button>
                        </div>
                    </div>

                </div>
                <div class="card-datatable table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <table class="table border-top dataTable" id="usersTable">
                            <thead class="">
                                <tr>
                                    <th>logo</th>
                                    <th>Task Name</th>
                                    <th>No. of tasks</th>
                                    <th>Price Per Task (tsh)</th>
                                    <th>instructions</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody id="">
                                @foreach ($list as $item)
                                    <tr class="odd">
                                        <td>
                                            <img src="{{ $item->image }}" width="100" alt="">
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->job_count }}</td>
                                        <td>{{ $item->price_per_job }}</td>
                                        <td>{{ $item->instructions }}</td>
                                        <td class="" style="">
                                            <div class="d-flex align-items-center">
                                                <a data-bs-toggle="modal" data-bs-target="#edit{{ $item->id }}"
                                                    class="text-body delete-record">
                                                    <i class="ti ti-edit x`ti-sm mx-2"></i>
                                                </a>

                                                <a data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}"
                                                    class="text-body delete-record">
                                                    <i class="ti ti-trash x`ti-sm mx-2"></i>
                                                </a>
                                            </div>
                                            <div class="modal fade" data-bs-backdrop='static'
                                                id="deleteModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                                    <div class="modal-content deleteModal verifymodal">
                                                        <div class="modal-header">
                                                            <div class="modal-title" id="modalCenterTitle">Are you sure you
                                                                want to delete
                                                                this Content?
                                                            </div>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="body">After deleting the Content you will add a
                                                                new Content</div>
                                                        </div>
                                                        <hr class="hr">

                                                        <div class="container">
                                                            <div class="row">
                                                                <div class="first">
                                                                    <a href="" class="btn" data-bs-dismiss="modal"
                                                                        style="color: #a8aaae ">Cancel</a>
                                                                </div>
                                                                <div class="second">
                                                                    <a class="btn text-center"
                                                                        href="{{ route('dashboard-content-delete', $item->id) }}">Delete</a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" data-bs-backdrop='static' id="edit{{ $item->id }}"
                                                tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalCenterTitle">Edit Content
                                                            </h5>
                                                        </div>
                                                        <form action="{{ route('dashboard-content-edit', $item->id) }}"
                                                            id="addBusForm" method="POST" enctype="multipart/form-data">
                                                            @csrf

                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col mb-2">
                                                                        <label for="nameWithTitle"
                                                                            class="form-label">Logo</label>
                                                                        <input type="file" id="" name="image"
                                                                            class="form-control" accept="image/*" />
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col mb-2">
                                                                        <label for="nameWithTitle"
                                                                            class="form-label">Task name</label>
                                                                        <input type="text" id=""
                                                                            name="name" class="form-control"
                                                                            placeholder="Task Name"
                                                                            value="{{ $item->name }}" required />
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col mb-2">
                                                                        <label for="nameWithTitle"
                                                                            class="form-label">No. of Tasks</label>
                                                                        <input type="text" id=""
                                                                            name="job_count" class="form-control"
                                                                            placeholder="No. of Tasks"
                                                                            value="{{ $item->job_count }}" required />
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col mb-2">
                                                                        <label for="nameWithTitle"
                                                                            class="form-label">Price Per Task(tsh)</label>
                                                                        <input type="text" id=""
                                                                            name="price_per_job" class="form-control"
                                                                            placeholder="Price Per Task(tsh)" required
                                                                            value="{{ $item->price_per_job }}" />
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col mb-3">
                                                                        <label for="nameWithTitle"
                                                                            class="form-label">Instructions</label>
                                                                        <textarea class="form-control" name="instructions" id="" cols="3" rows="3" required>{{ $item->instructions }}</textarea>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-label-secondary"
                                                                    id="closeButton" data-bs-dismiss="modal">
                                                                    Close
                                                                </button>
                                                                <button type="submit" class="btn btn-primary">Edit
                                                                    Content</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
                <div class="modal fade" id="addNewBus" data-bs-backdrop='static' tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalCenterTitle">Add New Content</h5>
                            </div>
                            <form action="{{ route('dashboard-content-create') }}" id="addBusForm" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col mb-2">
                                            <label for="nameWithTitle" class="form-label">Logo</label>
                                            <input type="file" id="" name="image" class="form-control"
                                                accept="image/*" required />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col mb-2">
                                            <label for="nameWithTitle" class="form-label">Task Name</label>
                                            <input type="text" id="" name="name" class="form-control"
                                                placeholder="Task Name" required />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col mb-2">
                                            <label for="nameWithTitle" class="form-label">No. of Tasks</label>
                                            <input type="text" id="" name="job_count" class="form-control"
                                                placeholder="No. of Tasks" required />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col mb-2">
                                            <label for="nameWithTitle" class="form-label">Price Per Task(tsh)</label>
                                            <input type="text" id="" name="price_per_job"
                                                class="form-control" placeholder="Price Per Task(tsh)" required />
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col mb-3">
                                            <label for="nameWithTitle" class="form-label">Instructions</label>
                                            <textarea class="form-control" name="instructions" id="" cols="3" rows="3" required></textarea>
                                        </div>
                                    </div>

                                </div>


                                <div class="modal-footer">
                                    <button type="button" class="btn btn-label-secondary" id="closeButton"
                                        data-bs-dismiss="modal">
                                        Close
                                    </button>
                                    <button type="submit" class="btn btn-primary">Add Content</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('script')

    @endsection
