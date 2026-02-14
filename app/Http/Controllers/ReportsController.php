<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medication;
use App\Models\Donations;

class ReportsController extends Controller
{
    public function medications(Request $request)
    {
        $query = Medication::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('presentation')) {
            $query->where('presentation', $request->presentation);
        }

        if ($request->filled('date_start')) {
            $query->whereDate('expiration_date', '>=', $request->date_start);
        }

        if ($request->filled('date_end')) {
            $query->whereDate('expiration_date', '<=', $request->date_end);
        }

        $medications = $query->orderBy('name')->get();
        $presentations = Medication::select('presentation')->distinct()->pluck('presentation');

        return view('reports.medications', compact('medications', 'presentations'));
    }

    public function donations(Request $request)
    {
        $query = Donations::with(['medication', 'user']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('medication_id')) {
            $query->where('medication_id', $request->medication_id);
        }

        if ($request->filled('date')) {
            $query->whereDate('donation_date', $request->date);
        }

        $donations = $query->orderBy('donation_date', 'desc')->get();
        $medications = Medication::orderBy('name')->get();

        return view('reports.donations', compact('donations', 'medications'));
    }
}
