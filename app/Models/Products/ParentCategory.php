<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentCategory extends Model
{
    protected $primaryKey = 'parent_id';
    protected $keyType = 'integer';
    use HasFactory;

    protected $fillable = ['parent_id', 'name', 'description', 'status'];

    public function categories()
    {
        return $this->hasMany(Category::class, 'parent_id', 'parent_id');
    }
}
