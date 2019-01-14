<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	public $timestamps = false;
    protected $fillable = ['name', 'description', 'price', 'category_id', 'created', 'modified'];
}
