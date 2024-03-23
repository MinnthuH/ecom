@extends('admin.admin_dashboard')


@section('admin')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Products</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">All Product<span
                                class="badge rounded-pill bg-danger ms-2">{{ count($products) }}</span></li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('add.product') }}" class="btn btn-primary">Add Prodcut</a>

                </div>
            </div>
        </div>
        <!--end breadcrumb-->

        <h6>Product List : </h6>
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>QTY</th>
                                <th>Discount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $key => $product)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><img src="{{ asset($product->product_thambnail) }}" style="width:70px; height:40px">
                                    </td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->selling_price }}</td>
                                    <td>{{ $product->product_qty }}</td>
                                    <td>
                                        @if ($product->discount_price == null)
                                            <span class="badge rounded-pill bg-info">No Dis</span>
                                        @else
                                            @php
                                                $amout = $product->selling_price - $product->discount_price;
                                                $discount = ($amout / $product->selling_price) * 100;

                                            @endphp
                                            <span class="badge rounded-pill bg-danger">{{ round($discount) }}%</span>
                                        @endif


                                    </td>
                                    <td>
                                        @if ($product->status == 1)
                                            <span class="badge rounded-pill bg-success">Active</span>
                                        @else
                                            <span class="badge rounded-pill bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('edit.product', $product->id) }}" class="btn btn-info sm"
                                            title="Detail"><i class='lni lni-eye'></i></a>

                                        @if ($product->status == 1)
                                            <a href="{{ route('product.inactive', $product->id) }}" class="btn btn-info sm"
                                                title="Inactive"><i class='lni lni-thumbs-down'></i></a>
                                        @else
                                            <a href="{{ route('product.active', $product->id) }}" class="btn btn-info sm"
                                                title="Active"><i class='lni lni-thumbs-up'></i></a>
                                        @endif


                                        <a href="{{ route('edit.product', $product->id) }}" class="btn btn-info sm"
                                            title="Edit Data"><i class='bx bx-message-square-edit'></i></a>

                                        <a href="{{ route('delete.product', $product->id) }}" class="btn btn-danger sm"
                                            title="Delete Data" id="delete"><i class="lni lni-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Sl</th>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>QTY</th>
                                <th>Discount</th>
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
