<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Motor;

class FrontPageController extends Controller
{
    public function viewMotor(Request $request)
    {
        $search = $request->search;
        $motors = Motor::where('nama_motor', 'like', '%' . $search . '%')
            ->orWhere('status', 'like', '%' . $search . '%')
            ->orWhere('tipe', 'like', '%' . $search . '%')
            ->latest()
            ->paginate(6);
        return view('frontpage.motors', [
            'title' => 'Motor',
            'active' => 'Motor'
        ], compact('motors'));
    }

    public function viewHome(Request $request)
    {
        $search = $request->search;
        $motors = Motor::where('nama_motor', 'like', '%' . $search . '%')
            ->paginate(6);
        return view('frontpage.home', [
            'title' => 'Home',
            'active' => 'Home'
        ], compact('motors'));
    }
}
