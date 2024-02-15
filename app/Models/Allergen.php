<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Allergen extends Model {
    use HasFactory;


    public static function findByItem($itemId) {
        DB::table('item_allergen')
            ->where('item_id', $itemId)
            ->get();
    }
}
