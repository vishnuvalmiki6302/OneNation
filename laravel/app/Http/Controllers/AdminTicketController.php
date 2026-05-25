<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SupportTicket;

class AdminTicketController extends Controller
{
    public function index()
    {
        // Get tickets, ordered by status (Open first) and then latest
        $tickets = SupportTicket::with('user')
            ->orderByRaw("FIELD(status, 'Open', 'In Progress', 'Closed')")
            ->latest()
            ->get();
            
        return view('admin.tickets.index', compact('tickets'));
    }

    public function update(Request $request, SupportTicket $ticket)
    {
        $request->validate([
            'admin_reply' => 'required|string',
        ]);

        $ticket->update([
            'admin_reply' => $request->admin_reply,
            'status' => 'Closed',
            'resolved_at' => now(),
        ]);

        return back()->with('success', 'Ticket #' . $ticket->ticket_number . ' has been resolved and closed.');
    }
}
