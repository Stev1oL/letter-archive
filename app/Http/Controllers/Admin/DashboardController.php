<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Disposisi;
use Illuminate\Http\Request;

use App\Models\Letter;
use App\Models\Letterout;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $masuk = Letter::where('letter_type', 'Surat Masuk')->get()->count();
        $keluar = Letterout::where('letter_type', 'Surat Keluar')->get()->count();
        $disposisi = Disposisi::get()->count();

        if (Auth::user()->role === 'super_admin') {
            return view('pages.admin.dashboard', [
                'masuk' => $masuk,
                'keluar' => $keluar,
                'disposisi' => $disposisi
            ]);
        } elseif (Auth::user()->role === 'admin') {
            return view('pages.staff.staff-dashboard', [
                'masuk' => $masuk,
                'keluar' => $keluar,
                'disposisi' => $disposisi
            ]);
        } elseif (Auth::user()->role === 'user') {
            return view('pages.user.user-dashboard', [
                'masuk' => $masuk,
                'keluar' => $keluar,
                'disposisi' => $disposisi
            ]);
        }
    }
}
