<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sample extends Model
{
    protected $fillable = [
        'title',
        'category',
        'description',
        'image',
        'badge',
        'badge_type',
        'features',
        'is_active',
        'sort_order',
        'price', // Added from subsequent migration hint
        'sizes', // Added from subsequent migration hint
        'gsm',
        'colors',
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'sizes' => 'array',
        'price' => 'decimal:2',
        'gsm' => 'array',
        'colors' => 'array',
    ];

    /**
     * Get the features attribute, handling both proper JSON and malformed string data
     *
     * @return array
     */
    public function getFeaturesAttribute($value)
    {
        // First try to decode as JSON (for properly formatted data)
        $decoded = json_decode($value, true);

        // If json_decode failed and returned null, try to handle malformed string format
        if ($decoded === null && json_last_error() !== JSON_ERROR_NONE) {
            // Try to decode the string content (for malformed data like "[\"value\"]")
            $cleaned = trim($value, '"');
            $decoded = json_decode($cleaned, true);

            // If still null, return empty array as fallback
            if ($decoded === null) {
                return [];
            }
        }

        // Ensure we always return an array
        return is_array($decoded) ? $decoded : [];
    }

    public function getGsmAttribute($value)
    {
        $decoded = json_decode($value, true);
        if ($decoded === null && json_last_error() !== JSON_ERROR_NONE) {
            $cleaned = trim($value, '"');
            $decoded = json_decode($cleaned, true);
            if ($decoded === null) return [];
        }
        return is_array($decoded) ? $decoded : [];
    }

    public function getColorsAttribute($value)
    {
        $decoded = json_decode($value, true);
        if ($decoded === null && json_last_error() !== JSON_ERROR_NONE) {
            $cleaned = trim($value, '"');
            $decoded = json_decode($cleaned, true);
            if ($decoded === null) return [];
        }
        return is_array($decoded) ? $decoded : [];
    }
}
