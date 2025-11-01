<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicStudentRegistrationController extends Controller
{
    /**
     * Redirect to the new OTP-based registration process
     */
    public function register(Request $request)
    {
        return redirect()->route('public.student.register.phone');
    }
}