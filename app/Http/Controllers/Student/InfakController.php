<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InfakController extends Controller
{
    public function index()
    {
        return view('student.infak.index');
    }
}
