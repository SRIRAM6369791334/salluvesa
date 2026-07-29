<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ourcodeworld\NameThatColor\ColorInterpreter;

class ProductColor extends Model
{
    use HasFactory;

    protected $fillable = [
        'customproduct_id',
        'color_name',
        'color_code',
        'status',
        'front_image',
        'back_image',
    ];

    public function customProduct()
    {
        return $this->belongsTo(CustomProduct::class, 'customproduct_id');
    }

    public function images()
    {
        return $this->hasMany(ProductColorImage::class, 'product_color_id');
    }

    public static function getColorName($code)
    {
        if (empty($code)) return $code;
        $cleanCode = strtolower(trim($code));

        $codeWithHash = str_starts_with($cleanCode, '#') ? $cleanCode : '#' . $cleanCode;
        $codeWithoutHash = ltrim($cleanCode, '#');

        // 1. Check Database (Priority)
        $color = self::where('color_code', $codeWithHash)
                     ->orWhere('color_code', $codeWithoutHash)
                     ->orWhere('color_code', strtoupper($codeWithHash))
                     ->orWhere('color_code', strtoupper($codeWithoutHash))
                     ->first();

        if ($color) return $color->color_name;

        // 2. Automatic naming using the package
        try {
            $instance = new ColorInterpreter();
            $result = $instance->name($codeWithHash);
            return $result['name'] ?? $code;
        } catch (\Exception $e) {
            return $code;
        }
    }

    public static function getNamesByCodes($codes)
    {
        if (empty($codes)) return '';
        if ($codes == 'Default') return 'Default';
        $codesArray = explode(',', $codes);
        $names = [];
        foreach ($codesArray as $code) {
            $names[] = self::getColorName($code);
        }
        return implode(', ', $names);
    }
}
