<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_name' => 'required|string|max:150',
            'student_roll' => 'required|digits:8|unique:student_info',
            'student_reg' => 'required|integer|min:1000|max:999999|unique:student_info',
            'student_session' => 'required|string|max:20',
            'student_department' => 'required|string|max:150',
            'student_email' => 'required|email|unique:student_info|max:255',
            'student_phone' => 'required|string|max:20|unique:student_info',
            'student_password' => 'required|min:6',
            'student_fingerprint' => 'nullable|file|max:2048'
        ]);

        $validated['student_password'] = Hash::make($validated['student_password']);

        if ($request->hasFile('student_fingerprint')) {
            $validated['student_fingerprint'] = $request->file('student_fingerprint')->get();
        }

        Student::create($validated);

        return redirect()->back()->with('success', 'Student registered successfully!');
    }
}