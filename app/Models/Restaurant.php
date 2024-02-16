<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model {
    use HasFactory;

    protected $fillable = [
        'name', 'slug',
        'description', 'address',
        'phone', 'logo', 'cover',
        'enable_ordering', 'enable_wa_notification',
        'minimum_order_amount', 'active',
        'stripe_id', 'user_id'
    ];

    // define accessors
    public function getLogoAttribute($value) {
        return $value ? asset('storage/' . $value) : null;
    }

    public function getCoverAttribute($value) {
        return $value ? asset('storage/' . $value) : null;
    }

    // define relationships
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function categories() {
        return $this->hasMany(Category::class);
    }

    public function dineinTables() {
        return $this->hasMany(DineinTable::class);
    }
}
