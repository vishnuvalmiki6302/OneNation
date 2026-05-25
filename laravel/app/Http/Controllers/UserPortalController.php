<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Transaction;
use App\Models\Certificate;
use App\Models\SupportTicket;
use Illuminate\Support\Facades\Storage;

class UserPortalController extends Controller
{
    // TRANSACTIONS
    public function transactions()
    {
        $citizen = auth()->user()->citizen;
        $transactions = $citizen ? Transaction::where('citizen_id', $citizen->id)->orderBy('transaction_date', 'desc')->get() : collect();
        return view('user.transactions.index', compact('transactions'));
    }

    // CERTIFICATES
    public function certificates()
    {
        $citizen = auth()->user()->citizen;
        $certificates = $citizen ? Certificate::where('citizen_id', $citizen->id)->latest()->get() : collect();
        return view('user.certificates.index', compact('certificates'));
    }

    public function storeCertificate(Request $request)
    {
        $request->validate([
            'document_name' => 'required|string|max:255',
            'document_type' => 'required|string',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $citizen = auth()->user()->citizen;
        if (!$citizen) {
            return back()->with('error', 'Please complete your profile first.');
        }

        $path = $request->file('file')->store('certificates', 'public');

        Certificate::create([
            'citizen_id' => $citizen->id,
            'document_name' => $request->document_name,
            'document_type' => $request->document_type,
            'file_path' => $path,
            'status' => 'Pending',
        ]);

        return back()->with('success', 'Certificate uploaded successfully.');
    }

    // SUPPORT DESK
    public function support()
    {
        $tickets = SupportTicket::where('user_id', auth()->id())->latest()->get();
        return view('user.support.create', compact('tickets'));
    }

    public function storeSupport(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('support_tickets', 'public');
        }

        SupportTicket::create([
            'user_id' => auth()->id(),
            'ticket_number' => 'TCK-' . strtoupper(uniqid()),
            'subject' => $request->subject,
            'description' => $request->description,
            'image_path' => $path,
            'status' => 'Open',
        ]);

        return back()->with('success', 'Support ticket submitted successfully. Our team will review it shortly.');
    }
}
