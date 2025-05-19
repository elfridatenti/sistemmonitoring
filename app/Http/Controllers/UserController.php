<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
class UserController extends Controller
{   
    public function index(Request $request)
    {
        $perPage = $request->input('show', 10);
        $search = $request->input('search');
        $filterType = $request->input('filter_type', 'all');

        $users = User::latest()
            ->when($search, function ($query) use ($search, $filterType) {
                switch ($filterType) {
                    case 'name':
                        $query->where('nama', 'like', '%' . $search . '%');
                        break;
                    case 'badge':
                        $query->where('badge', 'like', '%' . $search . '%'); 
                        break;
                    case 'level_user':
                    $query->where('department', 'like', '%' . $search . '%');
                        break;
                    case 'role':
                        $query->where('role', 'like', '%' . $search . '%');
                        break;
                    
                    default:
                        $query->where('nama', 'like', '%' . $search . '%')
                              ->orWhere('badge', 'like', '%' . $search . '%')
                              ->orWhere('role', 'like', '%' . $search . '%')
                        ->orWhere('department', 'like', '%' . $search . '%');
                }
            })
            ->paginate($perPage);

        // if ($users->isEmpty()) {
        //     return redirect()->route('datauser.index')
        //                    ->with('info', 'Tidak ada data user yang sesuai dengan pencarian.');
        // }

        return view('datauser.index', compact('users', 'perPage', 'search', 'filterType'));
    }

    public function create()
    {
        try {
            return view('datauser.create', [
                'roles' => ['admin', 'leader', 'teknisi', 'ipqc'],
                
            ]);
        } catch (\Exception $e) {
            return redirect()->route('datauser.index')
                           ->with('error', 'Terjadi kesalahan saat membuka form tambah user.');
        }
    }

    public function show(User $user)
    {
        try {
            if (!$user->exists) {
                return redirect()->route('datauser.index')
                               ->with('error', 'User tidak ditemukan.');
            }
            return view('datauser.show', compact('user'));
        } catch (\Exception $e) {
            return redirect()->route('datauser.index')
                           ->with('error', 'Terjadi kesalahan saat menampilkan data user.');
        }
    }
    
    public function edit(User $user)
    {
        try {
            if (!$user->exists) {
                return redirect()->route('datauser.index')
                               ->with('error', 'User tidak ditemukan.');
            }
            return view('datauser.edit', [
                'user' => $user,
                'roles' => ['admin', 'leader', 'teknisi', 'ipqc'],
                'level_users' => ['admin_teknisi', 'teknisi_molding', 'leader', 'ipqc']
            ]);
        } catch (\Exception $e) {
            return redirect()->route('datauser.index')
                           ->with('error', 'Terjadi kesalahan saat mengakses halaman edit.');
        }
    }

    

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect()->route('datauser.index')
                           ->with('success', 'User berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('datauser.index')
                           ->with('error', 'User tidak ditemukan atau sudah dihapus.');
        }
    }

    public function store(Request $request)
{
    try {
        $validator = Validator::make($request->all(), [
            'badge' => 'required|int|unique:users,badge',
            'nama' => 'required|string|max:255',
                'department' => 'required|string',  // Dihapus Rule::in
                'email' => 'required|email|unique:users,email',
            'no_tlpn' => 'required|string',
            'username' => 'required|string|unique:users,username|min:4',
            'password' => 'required|string|min:8',
            'role' => ['required', 'string', Rule::in(['admin', 'leader', 'teknisi', 'ipqc'])]
        ], [
            'password.min' => 'Password harus minimal 8 karakter.',
            'no_tlpn' => 'No tlpn harus berupa angka.',
            'username' => 'Username harus minimal 4 karakter.',
            'email' => 'Email sudah terdaftar.',
            'nama' => 'Nama tidak boleh kosong.',
            'badge' => 'Badge harus berupa angka.',

        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        $validated = $validator->validated();
        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);
       
        return redirect()->route('datauser.create')
                       ->with('success', 'User baru berhasil ditambahkan.');
    } catch (\Exception $e) {
        return redirect()->route('datauser.index')
                       ->with('error', 'Terjadi kesalahan saat menambahkan user baru.');
    }
}

public function update(Request $request, User $user)
{
    try {
        if (!$user->exists) {
            return redirect()->route('datauser.index')
                           ->with('error', 'User tidak ditemukan.');
        }

        $rules = [
            'badge' => ['required', 'int', Rule::unique('users')->ignore($user->id)],
            'nama' => 'required|string|max:255',
                'department' => 'required|string',  // Dihapus Rule::in
                'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'no_tlpn' => 'required|string',
            'username' => ['required', 'string', 'min:4', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', 'string', Rule::in(['admin', 'leader', 'teknisi', 'ipqc'])]
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:8';
        }

        $validated = $request->validate($rules);
        
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);
        
        return redirect()->route('datauser.index')
                       ->with('success', 'Data user berhasil diperbarui.');
    } catch (\Exception $e) {
        return redirect()->route('datauser.index')
                       ->with('error', 'Terjadi kesalahan saat memperbarui data user.');
    }
}

public function getUnfinishedUser()
{
    $count = User::where('role', '!=', 'Completed')->count();
    return response()->json(['count' => $count]);
}


}