<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'gender' => 'required|in:male,female',
            'age' => 'nullable|integer|min:0|max:120',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'age' => $request->age,
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario creado');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$user->id}",
            'password' => 'nullable|string|min:6',
            'gender' => 'required|in:male,female',
            'age' => 'nullable|integer|min:0|max:120',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->age = $request->age;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Usuario actualizado');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuario eliminado');
    }

    public function stats()
    {
        $hombres = User::where('gender', 'male')->count();
        $mujeres = User::where('gender', 'female')->count();

        $menores = User::where('age', '<', 18)->count();
        $mayores = User::where('age', '>=', 18)->count();

        $hombres_menores = User::where('gender', 'male')->where('age', '<', 18)->count();
        $hombres_mayores = User::where('gender', 'male')->where('age', '>=', 18)->count();

        $mujeres_menores = User::where('gender', 'female')->where('age', '<', 18)->count();
        $mujeres_mayores = User::where('gender', 'female')->where('age', '>=', 18)->count();

        $poblacion = [
            'hombres' => $hombres,
            'mujeres' => $mujeres,
            'mujeres_mayores' => $mujeres_mayores,
            'mujeres_menores' => $mujeres_menores,
            'hombres_mayores' => $hombres_mayores,
            'hombres_menores' => $hombres_menores
        ];

        return view('users.stats', compact('poblacion'));
    }

}