<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        \Log::info('Dashboard index accessed by user: ' . Auth::user()->role);
        if (Auth::user()->role == "ADMIN_KLINIK") {
            return redirect()->intended(route("dashboard-klinik"));
        }

        if (Auth::user()->role == "ADMIN_FARMASI") {
            return redirect()->intended(route("dashboard-farmasi"));
        }

        if (Auth::user()->role == "ADMIN_GUDANG") {
            return redirect()->intended(route("dashboard.gudang.index"));
        }
    }

    public function indexKlinik()
    {
        return view('dashboard.klinik.index', [
            "title" => "Dashboard Klinik"
        ]);
    }
}
