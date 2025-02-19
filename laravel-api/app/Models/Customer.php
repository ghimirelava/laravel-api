<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory;

    // Define the fillable array fields
    protected $fillable = [
        'name',
        'type',
        'email',
        'address',
        'city',
        'state',
        'postal_code',
    ];

    // Define the relationship between the Customer and Invoice models (1:M)
    public function invoices() {
        return $this->hasMany(Invoice::class);
    }
        
}
