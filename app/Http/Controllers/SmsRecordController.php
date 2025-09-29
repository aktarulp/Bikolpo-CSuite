<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SmsRecord;

class SmsRecordController extends Controller
{
    public function index()
    {
        $smsRecords = SmsRecord::with('partner')->latest()->paginate(15);
        return view('partner.sms.index', compact('smsRecords'));
    }
}
