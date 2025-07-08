<?php
namespace App\Http\Controllers;

use App\Models\Defect;
use Illuminate\Http\Request;

class DefectController extends Controller
{
    public function index(Request $request)
    {
        // $defects = Defect::all();
        
        $search = $request->input('search');
        $perPage = $request->input('show', 10); // Default 10 items per page

        $defects = Defect::query()
            ->when($search, function($query, $search) {
                return $query->where('defect_category', 'LIKE', "%{$search}%");
            })
            ->orderBy('id', 'asc')
            ->paginate($perPage) // Menggunakan paginate dengan jumlah sesuai $perPage
            ->withQueryString(); // Ini akan menjaga parameter URL saat pindah halaman
        

        return view('defect.index', compact('defects', 'search', 'perPage'));
    
    }
    public function create()
    {
        return view('defect.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'defect_category' => 'required|unique:defects,defect_category',
        ]);

        Defect::create($validated);

        return redirect()->route('defect.index')
            ->with('success', 'Defect successfully added');
    }

    public function edit(Defect $Defect)
    {
        return view('defect.edit', compact('Defect'));
    }

    public function update(Request $request, Defect $defect)
    {
        $validated = $request->validate([
            'defect_category' => 'required|unique:defects,defect_category,'.$defect->id,
          
        ]);

        $defect->update($validated);

        return redirect()->route('defect.index')
            ->with('success', 'Defect successfully updated');
    }

    public function destroy(Defect $Defect)
    {
        $Defect->delete();

        return redirect()->route('defect.index')
            ->with('success', 'Defect successfully deleted');
    }
}