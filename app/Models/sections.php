<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class sections extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'section_name',
        'description',
        'Created_by',
    ];

    protected $date=['deleted_at'];

    public function products(){
        return $this->hasMany(Products::class, 'product_id');
    }
}
