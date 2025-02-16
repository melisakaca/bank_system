<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    public function __construct()
    {  
        $this->middleware(['permission:manage_clients'])->only('index', 'create', 'store', 'update', 'destroy');
       
    }
    public function index()
    {
        $clients = User::role('client')->get();
        return view('backend.clients.index', compact('clients'));
    }
    public function create()
    {
        return view('backend.clients.create');
    }

  
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('client');

        return redirect()->route('clients.index')->with('success', 'Client created successfully.');
    }


    public function edit(User $user)
    {
        return view('backend.clients.edit', compact('user'));
    }

   
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->password) {
            $user->update(['password' => Has::make($request->password)]);
        }

        return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
    }

    
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('clients.index')->with('success', 'Client deleted successfully.');
    }
}
