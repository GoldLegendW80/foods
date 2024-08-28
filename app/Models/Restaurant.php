<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'adresse', 'latitude', 'longitude', 'note'];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
