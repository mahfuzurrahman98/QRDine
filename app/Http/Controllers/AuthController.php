<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller {
    public function login() {
        return view('auth.login');
    }

    public function authenticate(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $remember = $request->filled('remember');

        if (auth()->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->withError('Invalid credentials');
    }

    public function register() {
        return view('auth.register');
    }

    public function store(Request $request) {
        // It will basically be a api call to the backend
        // the request parameters are, name, slug, email, password
        // name and slug for Restaurant model, email and password for User model
        // slug should be unique, email should be unique

        // so first validate the request
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:restaurants',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        // if the request is not valid, return a response with status code 422
        if ($request->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid data'
            ], 422);
        }

        try {
            DB::startTransaction();

            Restaurant::create([
                'name' => $request->name,
                'slug' => $request->slug
            ]);

            User::create([
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Restaurant created successfully'
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong'
            ], 500);
        }
    }

    public function logout() {
        auth()->logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect()->route('login');
    }
}
