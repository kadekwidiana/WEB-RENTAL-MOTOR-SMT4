<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use ReCaptcha\ReCaptcha;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::paginate(10);
        return view('frontpage.contact-admin.index', [
            'title' => 'Contact admin',
            'active' => 'Contact',
            'contacts' => $contacts
        ]);
    }

    public function create()
    {
        return view('frontpage.layouts.contact', [
            'title' => '',
            'active' => 'ds'
        ]);
    }

    public function store(Request $request)
    {
        // Validasi input form
        $recaptchaSecret = env('RECAPTCHA_SECRET');


        if (empty($recaptchaSecret)) {
            throw new \RuntimeException('No secret provided');
        }
        
        $recaptcha = new ReCaptcha($recaptchaSecret);
        $response = $recaptcha->verify($request->input('g-recaptcha-response'));
    
        if (!$response->isSuccess()) {
            return back()->with('error', 'Verifikasi reCAPTCHA gagal. Silakan coba lagi.');
        }
    
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'subjek' => 'required',
            'pesan' => 'required'
        ]);
    
        // Simpan data ke database
        $contact = new Contact();
        $contact->nama = $request->nama;
        $contact->email = $request->email;
        $contact->subjek = $request->subjek;
        $contact->pesan = $request->pesan;
        $contact->save();
    
        return redirect()->route('frontpage.contact')->with('message', 'Pesan berhasil terkirim!');
    }    

    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        return view('frontpage.contact-admin.show', [
            'title' => '',
            'active' => 'ds'
        ], compact('contact'));
    }

    public function edit($id)
    {
        $contact = Contact::findOrFail($id);
        return view('contact.edit', compact('contact'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input form
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'subjek' => 'required',
            'pesan' => 'required'
        ]);

        // Update data di database
        $contact = Contact::findOrFail($id);
        $contact->nama = $request->nama;
        $contact->email = $request->email;
        $contact->subjek = $request->subjek;
        $contact->pesan = $request->pesan;
        $contact->save();

        return redirect()->route('contact-admin.index')->with('success', 'Pesan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('contact-admin.index')->with('success', 'Pesan berhasil dihapus!');
    }
}
