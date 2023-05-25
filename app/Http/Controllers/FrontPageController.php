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
        $motors = [
            [
                'nama_motor' => 'Beat',
                'cc' => '115',
                'tipe' => 'Honda',
                'harga_sewa' => '100000',
                'status' => 1
            ],
            [
                'nama_motor' => 'Nmax',
                'cc' => '150',
                'tipe' => 'Yamaha',
                'harga_sewa' => '100000',
                'status' => 1
            ],
            [
                'nama_motor' => 'Lexi',
                'cc' => '135',
                'tipe' => 'Yamaha',
                'harga_sewa' => '100000',
                'status' => 1
            ],
            [
                'nama_motor' => 'Scoopy',
                'cc' => '115',
                'tipe' => 'Honda',
                'harga_sewa' => '100000',
                'status' => 1
            ],
            [
                'nama_motor' => 'Vario',
                'cc' => '125',
                'tipe' => 'Honda',
                'harga_sewa' => '100000',
                'status' => 1
            ],
            [
                'nama_motor' => 'PCX',
                'cc' => '150',
                'tipe' => 'Honda',
                'harga_sewa' => '100000',
                'status' => 1
            ],
            [
                'nama_motor' => 'ADV',
                'cc' => '160',
                'tipe' => 'Honda',
                'harga_sewa' => '100000',
                'status' => 1
            ],
        ];
        return view('frontpage.home', [
            'title' => 'Home',
            'active' => 'Home'
        ], compact('motors'));
    }

    public function viewAbout(Request $request)
    {
        return view('frontpage.about', [
            'title' => 'About',
            'active' => 'About'
        ]);
    }

    public function viewContact(Request $request)
    {
        return view('frontpage.contact', [
            'title' => 'Contact',
            'active' => 'Contact'
        ]);
    }
}
