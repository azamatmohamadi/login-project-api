<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return inertia('Dashboard', [
            'user' => $request->user(),
        ]);
    }
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255'
        ]);
        $request->user()->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        return redirect()->route('dashboard');
    }
}