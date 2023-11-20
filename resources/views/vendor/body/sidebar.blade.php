@php
    $id = Auth::user()->id;
    $vendorId = App\Models\User::find($id);
    $status = $vendorId->status;
@endphp

<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ asset('adminbackend/assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">Vendor</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="{{ route('vendor.dashboard') }}">
                <div class="parent-icon"><i class='bx bx-cookie'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>


        @if ($status === 'active')
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-cart'></i>
                    </div>
                    <div class="menu-title">Porduct Manage</div>
                </a>
                <ul>
                    <li> <a href="{{ route('inactive.vendor') }}"><i class="bx bx-right-arrow-alt"></i>All Product</a>
                    </li>
                    <li> <a href="{{ route('active.vendor') }}"><i class="bx bx-right-arrow-alt"></i>Add Product</a>
                    </li>

                </ul>
            </li>
        @endif
    </ul>
    <!--end navigation-->
</div>
