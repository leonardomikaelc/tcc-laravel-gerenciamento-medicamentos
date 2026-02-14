<?php

namespace App\Http\Controllers;

use App\Models\Donations;
use App\Models\Medication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class DonationsController extends Controller
{

    public function index()
    {
        $donations = Donations::with('medication')
            ->orderBy('id', 'desc')
            ->get();

        return view('reuse.donations.index', compact('donations'));
    }


    public function availableMedications()
    {
        $medications = Medication::where('available_for_donation', 1)
            ->orderBy('name')
            ->get();

        return view('reuse.available_medications', compact('medications'));
    }

    public function create()
    {
        $medications = Medication::where('available_for_donation', 1)
            ->orderBy('name')
            ->get();

        return view('reuse.donations.create', compact('medications'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'medication_id' => 'required|exists:medications,id',
            'donation_date' => 'required|date',
        ]);

        Donations::create([
            'user_id'       => Auth::id(),
            'medication_id' => $request->medication_id,
            'donation_date' => $request->donation_date,
            'status'        => 'confirmada',
        ]);

        $med = Medication::find($request->medication_id);
        $med->available_for_donation = 0;
        $med->donation_date = $request->donation_date;
        $med->save();

        return redirect()
            ->route('reuse.doacoes')
            ->with('success', 'Doação registrada e medicamento marcado como DOADO!');
    }


    public function edit($id)
    {
        $donation = Donations::findOrFail($id);

        return view('reuse.donations.edit', compact('donation'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'donation_date' => 'required|date',
            'status'        => 'required|in:pendente,confirmada,recusada',
        ]);

        $donation = Donations::findOrFail($id);

        if ($request->status === 'recusada') {
            $med = Medication::find($donation->medication_id);
            $med->available_for_donation = 1;
            $med->save();
        }

        $donation->update([
            'donation_date' => $request->donation_date,
            'status'        => $request->status
        ]);

        return redirect()
            ->route('reuse.doacoes')
            ->with('success', 'Doação atualizada!');
    }


    public function destroy($id)
    {
        $donation = Donations::findOrFail($id);

        $med = Medication::find($donation->medication_id);
        if ($med) {
            $med->available_for_donation = 1;
            $med->save();
        }

        $donation->delete();

        return redirect()
            ->route('reuse.doacoes')
            ->with('success', 'Doação excluída.');
    }
}
