<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    protected $primaryKey = 'category_id';
    protected $keyType = 'integer';
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'status',
        'parent_id',
    ];

    public function Products()
    {
        return $this->hasMany(Product::class, 'category_id', 'category_id');
    }

    public function parentCategoriesForeignKLey()
    {
        return $this->belongsTo(ParentCategory::class, 'parent_id', 'parent_id');
    }

    public function CategorySale()
    {
        return $this->hasMany(CategorySale::class, 'category_id', 'category_id');
    }

}
