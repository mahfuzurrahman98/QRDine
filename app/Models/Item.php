<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model {
    use HasFactory;

    protected $fillable = [
        'name', 'description',
        'price', 'image', 'active',
        'category_id', 'allergens'
    ];

    // define accessors
    public function getLogoAttribute() {
        return $this->image == '' ? '' : asset("uploads/restaurants/{$this->category->restaurant->slug}/items/{$this->image}_small.jpg");
    }

    public function getCoverAttribute() {
        return $this->image == '' ? '' : asset("uploads/restaurants/{$this->category->restaurant->slug}/items/{$this->image}_large.jpg");
    }

    public function getOriginalImageAttribute() {
        return $this->image == '' ? '' : asset("uploads/restaurants/{$this->category->restaurant->slug}/items/{$this->image}_original.jpg");
    }

    // define relationships
    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function getItemAllergensAttribute() {
        return json_decode($this->allergens, true);
    }
}
