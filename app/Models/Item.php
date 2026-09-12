<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
protected $fillable = ['name', 'category', 'quantity', 'price', 'description', 'image'];

    public function orders()
{
    return $this->hasMany(Order::class);
}


}
