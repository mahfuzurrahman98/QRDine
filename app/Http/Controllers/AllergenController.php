<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AllergenController extends Controller {
    public function index() {
        return view('allergens.index');
    }
}
