<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerImage extends Model {
    use HasFactory;

    protected $fillable  = [ 'banner_image', 'banner_position', 'title', 'subtitle' ];
    protected $table = 'banner_images';
}
