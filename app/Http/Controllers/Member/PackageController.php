<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class PackageController extends Controller
{
    public function package()
    {
        $package = DB::table('packages')->get();
        $session = Session::all();
        return view('member.membership.select-package', compact('package', 'session'));

        // return view('member.membership.select-package')->with('package', $package);
    }

}
