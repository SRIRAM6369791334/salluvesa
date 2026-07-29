<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubCategory extends Model
{
    protected $table = 'sub_categories';

    protected $fillable = [
        'subcategory_name',
        'subcategory_image',
        'category_name',
        'category_display',
        'status',
    ];

    /**
     * Get the category that this subcategory belongs to
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_name', 'id');
    }
}
