@extends('admin.admin_dashboard')

@section('admin')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Inactive Vendor</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">All Inactive Vendor</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Shop Name</th>
                                <th>Vendor Username</th>
                                <th>Join Date</th>
                                <th>Vendor Email</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inActiveVendor as $key => $inact)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $inact->name }}</td>
                                    <td>{{ $inact->username }}</td>
                                    <td>{{ $inact->vendor_join }}</td>
                                    <td>{{ $inact->email }}</td>
                                    <td><span class="btn btn-outline-warning px-2">{{ $inact->status }}</span></td>

                                    <td>
                                        <a href="{{ route('inactive.vendor.detail', $inact->id) }}" class="btn btn-success sm"
                                            title="Detail Inactive Vendor"><i class='lni lni-eye'></i></a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Sl</th>
                                <th>Shop Name</th>
                                <th>Vendor Username</th>
                                <th>Join Date</th>
                                <th>Vendor Email</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>


    </div>
@endsection
