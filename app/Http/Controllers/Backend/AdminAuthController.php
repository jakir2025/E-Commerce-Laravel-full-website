<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function loginForm()
    {
        return view('backend.admin-login');

    }

   public function logoutAdmin()
   {
       Auth::logout();
       return redirect('/admin/login');
   }

}
 