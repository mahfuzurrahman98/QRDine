<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DineinTable extends Model {
    use HasFactory;

    protected $fillable = ['name', 'restaurant_id', 'active'];

    // define relationships
    public function restaurant() {
        return $this->belongsTo(Restaurant::class);
    }
}
