<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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

            session()->flash('status', 'Welcome, You are logged in!');

            return redirect()->intended('/dashboard');
        }

        return back()->withError('Invalid credentials');
    }

    public function register() {
        return view('auth.register');
    }

    public function store(Request $request) {
        // the request parameters are, name, slug, email, password
        // name and slug for Restaurant model, email and password for User model
        // slug should be unique, email should be unique

        // so first validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|alpha_dash|unique:restaurants,slug',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        // if the request is not valid, return back with the first error
        if ($validator->fails()) {
            $errors = $validator->errors();

            // cahtch teh first key of the errors and return it as the message
            // also redirect with the old input
            return redirect()
                ->back()
                ->withError($errors->first())
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

            Restaurant::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'user_id' => $user->id
            ]);


            DB::commit();

            // authneticate the user and redirect to dashboard
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if (auth()->attempt($credentials)) {
                $request->session()->regenerate();

                session()->flash('status', 'Welcome to QRDine, Setup your restaurant to get started!');

                return redirect()
                    ->intended('/dashboard')
                    ->withSuccess('Restaurant created successfully');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withError($e->getMessage());
        }
    }

    public function loginAsRestaurant(Restaurant $restaurant) {
        // keep track of current user
        // And login as the restaurant user

        session()->put('original_user', auth()->user());

        auth()->login($restaurant->user);
        session()->flash('status', 'You are now logged in as ' . $restaurant->name);

        return redirect()->route('dashboard');
    }

    public function logout() {
        auth()->logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect()->route('login');
    }
}
