@extends('admin.admin_dashboard')


@section('admin')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Banner</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">All Banners</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('add.banner') }}" class="btn btn-primary">Add banner</a>

                </div>
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
                                <th>Banner Title</th>
                                <th>Banner URL</th>
                                <th>Banner Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($banners as $key => $banner)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $banner->banner_title }}</td>
                                    <td>{{ $banner->banner_url }}</td>
                                    <td><img src="{{ asset($banner->banner_image) }}" style="width:70px; height:40px"></td>
                                    <td>
                                        <a href="{{ route('edit.banner', $banner->id) }}" class="btn btn-info sm"
                                            title="Edit Data"><i class='bx bx-message-square-edit'></i></a>

                                        <a href="{{ route('delete.banner', $banner->id) }}" class="btn btn-danger sm"
                                            title="Delete Data" id="delete"><i class="lni lni-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Sl</th>
                                <th>Banner Title</th>
                                <th>Banner URL</th>
                                <th>Banner Image</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>


    </div>
@endsection
