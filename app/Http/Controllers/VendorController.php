<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VendorController extends Controller
{
    // Vendor Dashboard
    public function vendorDashboard(){
        return view('vendor.vendor_dashboard');
    } // End Of vendor Dashboard
}

