<?php

namespace App\Http\Controllers;

use App\Models\Medication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class MedicationController extends Controller
{

    public function index(Request $request)
    {
        $today = Carbon::today();


        $filter = $request->input('filter');
        $only_controlled = $request->input('controlled') == '1';
        $only_donation = ($request->input('donation') == '1') || ($request->input('doacao') == '1');
        $only_expired = $request->input('expired') == '1';


        $presentations = [
            'tablet'  => 'Comprimido',
            'pill'    => 'Drágea',
            'capsule' => 'Cápsula',
            'drop'    => 'Gota',
            'syrup'   => 'Xarope',
            'ampoule' => 'Ampola'
        ];

        $query = Medication::query();

        if ($filter) {
            $query->where('presentation', $filter);
        }

        if ($only_controlled) {

            if (Schema::hasColumn((new Medication)->getTable(), 'controlled')) {
                $query->where('controlled', 1);
            } elseif (Schema::hasColumn((new Medication)->getTable(), 'is_controlled')) {
                $query->where('is_controlled', 1);
            }
        }

        if ($only_donation) {
            if (Schema::hasColumn((new Medication)->getTable(), 'available_for_donation')) {
                $query->where('available_for_donation', 1);
            } elseif (Schema::hasColumn((new Medication)->getTable(), 'is_donation')) {
                $query->where('is_donation', 1);
            } elseif (Schema::hasColumn((new Medication)->getTable(), 'disponivel_para_doacao')) {
                $query->where('disponivel_para_doacao', 1);
            }
        }

        if ($only_expired) {
            $query->whereNotNull('expiration_date')
                ->whereDate('expiration_date', '<', $today);
        }


        $nearDays = 90;

        $medications = $query->orderBy('name')->get()->map(function ($med) use ($today, $nearDays) {
            $exp = $med->expiration_date ? Carbon::parse($med->expiration_date) : null;

            if ($exp) {

                $days = $today->diffInDays($exp, false);

                if ($days < 0) {
                    $med->status = 'expired';
                    $med->days = abs($days);
                } elseif ($days <= $nearDays) {
                    $med->status = 'near_expiration';
                    $med->days = $days;
                } else {
                    $med->status = 'ok';
                    $med->days = $days;
                }
            } else {
                $med->status = 'ok';
                $med->days = null;
            }


            $med->is_controlled = $med->is_controlled ?? ($med->controlled ?? false);
            $med->is_donation = $med->is_donation ?? ($med->available_for_donation ?? ($med->disponivel_para_doacao ?? false));

            return $med;
        });


        $alert_window_days = 180;
        $medications_alerta = Medication::whereNotNull('expiration_date')
            ->whereDate('expiration_date', '>=', $today)
            ->whereDate('expiration_date', '<=', $today->copy()->addDays($alert_window_days))
            ->orderBy('expiration_date')
            ->get();


        $counts = [
            'expired' => Medication::whereNotNull('expiration_date')->whereDate('expiration_date', '<', $today)->count(),
            'near'    => Medication::whereNotNull('expiration_date')->whereDate('expiration_date', '>=', $today)->whereDate('expiration_date', '<=', $today->copy()->addDays($nearDays))->count(),
            'ok'      => Medication::where(function ($q) use ($today, $nearDays) {
                $q->whereNull('expiration_date')
                    ->orWhere('expiration_date', '>', $today->copy()->addDays($nearDays));
            })->count(),
        ];

        return view('medications.index', compact(
            'medications',
            'medications_alerta',
            'presentations',
            'filter',
            'only_controlled',
            'only_donation',
            'only_expired',
            'counts'
        ));
    }

    public function create()
    {
        $presentations = [
            'tablet'  => 'Comprimido',
            'pill'    => 'Drágea',
            'capsule' => 'Cápsula',
            'drop'    => 'Gota',
            'syrup'   => 'Xarope',
            'ampoule' => 'Ampola'
        ];

        return view('medications.create', compact('presentations'));
    }


    public function createDonation()
    {
        $presentations = [
            'tablet'  => 'Comprimido',
            'pill'    => 'Drágea',
            'capsule' => 'Cápsula',
            'drop'    => 'Gota',
            'syrup'   => 'Xarope',
            'ampoule' => 'Ampola'
        ];

        return view('medications.create', [
            'presentations' => $presentations,
            'isDonation' => true
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'dosage' => 'required|string|max:100',
            'expiration_date' => 'nullable|date',
            'quantity' => 'required|integer|min:0',
            'presentation' => 'required|string',
            'batch' => 'nullable|string|max:255',
            'available_for_donation' => 'nullable|in:0,1',
            'controlled' => 'nullable|in:0,1',
        ]);

        $data = [
            'name' => $request->name,
            'dosage' => $request->dosage,
            'batch' => $request->batch,
            'expiration_date' => $request->expiration_date ? Carbon::parse($request->expiration_date) : null,
            'quantity' => $request->quantity,
            'presentation' => $request->presentation,
        ];


        $isControlled = $request->has('controlled') ? 1 : 0;
        $isDonation = $request->has('available_for_donation') ? 1 : 0;


        if (Schema::hasColumn((new Medication)->getTable(), 'controlled')) {
            $data['controlled'] = $isControlled;
        }
        if (Schema::hasColumn((new Medication)->getTable(), 'is_controlled')) {
            $data['is_controlled'] = $isControlled;
        }

        if (Schema::hasColumn((new Medication)->getTable(), 'available_for_donation')) {
            $data['available_for_donation'] = $isDonation;
        }
        if (Schema::hasColumn((new Medication)->getTable(), 'is_donation')) {
            $data['is_donation'] = $isDonation;
        }
        if (Schema::hasColumn((new Medication)->getTable(), 'disponivel_para_doacao')) {
            $data['disponivel_para_doacao'] = $isDonation;
        }

        Medication::create($data);

        return redirect()->route('medications.index')->with('success', 'Medicamento adicionado com sucesso!');
    }

    public function edit($id)
    {
        $medication = Medication::findOrFail($id);

        $presentations = [
            'tablet'  => 'Comprimido',
            'pill'    => 'Drágea',
            'capsule' => 'Cápsula',
            'drop'    => 'Gota',
            'syrup'   => 'Xarope',
            'ampoule' => 'Ampola'
        ];

        return view('medications.edit', compact('medication', 'presentations'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'dosage' => 'required|string|max:100',
            'expiration_date' => 'nullable|date',
            'quantity' => 'required|integer|min:0',
            'presentation' => 'required|string',
            'batch' => 'nullable|string|max:255',
            'available_for_donation' => 'nullable|in:0,1',
            'controlled' => 'nullable|in:0,1',
        ]);

        $medication = Medication::findOrFail($id);

        $data = [
            'name' => $request->name,
            'dosage' => $request->dosage,
            'batch' => $request->batch,
            'expiration_date' => $request->expiration_date ? Carbon::parse($request->expiration_date) : null,
            'quantity' => $request->quantity,
            'presentation' => $request->presentation,
        ];

        $isControlled = $request->has('controlled') ? 1 : 0;
        $isDonation = $request->has('available_for_donation') ? 1 : 0;

        if (Schema::hasColumn((new Medication)->getTable(), 'controlled')) {
            $data['controlled'] = $isControlled;
        }
        if (Schema::hasColumn((new Medication)->getTable(), 'is_controlled')) {
            $data['is_controlled'] = $isControlled;
        }

        if (Schema::hasColumn((new Medication)->getTable(), 'available_for_donation')) {
            $data['available_for_donation'] = $isDonation;
        }
        if (Schema::hasColumn((new Medication)->getTable(), 'is_donation')) {
            $data['is_donation'] = $isDonation;
        }
        if (Schema::hasColumn((new Medication)->getTable(), 'disponivel_para_doacao')) {
            $data['disponivel_para_doacao'] = $isDonation;
        }

        $medication->update($data);

        return redirect()->route('medications.index')->with('success', 'Medicamento atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $medication = Medication::findOrFail($id);
        $medication->delete();

        return redirect()->route('medications.index')->with('success', 'Medicamento excluído com sucesso!');
    }

    public function doacao()
    {
        $today = Carbon::today();

        $table = (new Medication)->getTable();

        $medications = Medication::where(function ($q) use ($table) {
            if (Schema::hasColumn($table, 'available_for_donation')) {
                $q->where('available_for_donation', 1);
            } elseif (Schema::hasColumn($table, 'is_donation')) {
                $q->where('is_donation', 1);
            } elseif (Schema::hasColumn($table, 'disponivel_para_doacao')) {
                $q->where('disponivel_para_doacao', 1);
            }
        })
            ->where(function ($query) use ($today) {
                $query->whereNull('expiration_date')
                    ->orWhere('expiration_date', '>=', $today);
            })
            ->orderBy('name')
            ->get();

        $presentations = [
            'tablet'  => 'Comprimido',
            'pill'    => 'Drágea',
            'capsule' => 'Cápsula',
            'drop'    => 'Gota',
            'syrup'   => 'Xarope',
            'ampoule' => 'Ampola'
        ];

        return view('medications.doacao', compact('medications', 'presentations'));
    }
}
