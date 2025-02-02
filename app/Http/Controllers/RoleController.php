<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function redirect(Request $request)
    {
        $validated = $request->validate([
            'role' => 'required|in:student,teacher,admin,developer',
        ]);

        return redirect()->route($validated['role']);
    }
}