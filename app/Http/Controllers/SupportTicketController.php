<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HaloPsaClient;
use Illuminate\Support\Facades\Auth;

class SupportTicketController extends Controller
{
    private HaloPsaClient $halo;

    public function __construct(HaloPsaClient $halo)
    {
        $this->middleware(['auth', 'verified']);
        $this->halo = $halo;
    }

    public function create()
    {
        return view('support-tickets.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $user = Auth::user();
        $ticketData = [
            'summary' => $data['subject'],
            'details' => $data['message'],
            'clientId' => $user->id,
        ];

        try {
            $this->halo->createTicket($ticketData);
            return redirect()->route('dashboard')->with('success', 'Support ticket logged successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to log ticket: ' . $e->getMessage()]);
        }
    }
}
