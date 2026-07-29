<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'category_name',
        'category_image',
        'status',
    ];

    /**
     * Get the subcategories for this category
     */
    public function subCategories(): HasMany
    {
        return $this->hasMany(SubCategory::class, 'category_name', 'category_name');
    }
}
