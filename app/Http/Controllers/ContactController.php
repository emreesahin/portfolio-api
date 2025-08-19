<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{

    // SEND NEW CONTACT MESSAGE
    public function store(ContactRequest $request) {
        try{

            $contact = Contact::create($request -> validated());

            Mail::to(config('mail.admin'))->send(new ContactMail($contact));

            return response->json([
                'status'=> true,
                'message' => 'Mesajınız başarıyla gönderildi.',
                'data' => $contact
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'=> false,
                'message' => 'Mesaj gönderilirken bir hata ile karşılaşıldı.',
                'data' => $e->getMessage(),
            ], 500);
        }

    }

    // SHOW CONTACT MESSAGES
    public function index () {

        try{
            $contacts = Contact::latest()->paginate(10);

            return response()->json([
            'status' => true,
            'message' => 'İletişim mesajları başarıyla alındı.',
            'data' => $contacts
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'İletişim mesajları alınırken bir hata ile karşılaşıldı.',
            'data' => $e->getMessage(),
        ], 500);
    }

    }
}
