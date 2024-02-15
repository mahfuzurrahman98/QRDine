<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model {
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'image', 'active', 'category_id'];

    // define accessors
    public function getImageAttribute($value) {
        return $value ? asset('storage/' . $value) : null;
    }

    // define relationships
    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function allergens() {
        return Allergen::findByItem($this->id);
    }
}
