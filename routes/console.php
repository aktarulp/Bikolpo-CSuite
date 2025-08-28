<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Exam Status Update Command
Artisan::command('exams:status', function () {
    $this->call('exams:update-statuses');
})->purpose('Quick command to update exam statuses');
