<?php

namespace App\Http\Controllers;

use App\Models\Mesin;
use App\Models\Downtime;
use App\Models\Setup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MesinController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('show', 10); // Nilai default 10

        $mesins = Mesin::query()
            ->when($search, function ($query, $search) {
                return $query->where('molding_mc', 'LIKE', "%{$search}%");
            })
            ->orderBy('id', 'asc')
            ->paginate($perPage) // Menggunakan paginate dengan jumlah sesuai $perPage
            ->withQueryString(); // Ini akan menjaga parameter URL saat pindah halaman

        return view('mesin.index', compact('mesins', 'search', 'perPage'));
    }

    public function create()
    {
        return view('mesin.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'molding_mc' => 'required|unique:mesin,molding_mc',
        ]);

        Mesin::create($validated);

        return redirect()->route('mesin.index')
            ->with('success', 'Machine successfully added');
    }

    public function edit(Mesin $mesin)
    {
        return view('mesin.edit', compact('mesin'));
    }

    public function update(Request $request, Mesin $mesin)
    {
        $validated = $request->validate([
            'molding_mc' => 'required|unique:mesin,molding_mc,' . $mesin->id,

        ]);

        $mesin->update($validated);

        return redirect()->route('mesin.index')
            ->with('success', 'Machine  successfully updated');
    }
    public function destroy(Mesin $mesin)
    {
        // Periksa status di model Downtime
        $pendingDowntime = Downtime::where('molding_machine', $mesin->id)
            ->whereIn('status', ['Waiting', 'In Progress', 'Waiting QC Approve'])
            ->first();

        // Periksa status di model Setup
        $pendingSetup = Setup::where('molding_machine', $mesin->id)
            ->whereIn('status', ['Waiting', 'In Progress', 'Waiting QC Approve', 'Pending QC'])
            ->first();

        // Jika ada downtime yang masih aktif
        if ($pendingDowntime) {
            return redirect()->route('mesin.index')
                ->with('error', 'Machine is still in active downtime with status ' . $pendingDowntime->status);
        }

        // Jika ada setup yang masih aktif
        if ($pendingSetup) {
            return redirect()->route('mesin.index')
                ->with('error', 'Machine is still in active setup with status ' . $pendingSetup->status);
        }

        // Jika semua pengecekan berhasil, lanjutkan dengan penghapusan
        $mesin->delete();
        return redirect()->route('mesin.index')
            ->with('success', 'Machine successfully deleted');
    }
}
