<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DesignLayer extends Model
{
    protected $fillable = [
        'design_id',
        'layer_type',
        'layer_name',
        'source_path',
        'text_content',
        'x_position',
        'y_position',
        'width',
        'height',
        'rotation',
        'scale_x',
        'scale_y',
        'print_position',
        'z_index',
        'layer_json',
    ];

    protected $casts = [
        'x_position' => 'decimal:2',
        'y_position' => 'decimal:2',
        'width' => 'decimal:2',
        'height' => 'decimal:2',
        'rotation' => 'decimal:2',
        'scale_x' => 'decimal:2',
        'scale_y' => 'decimal:2',
        'z_index' => 'integer',
        'layer_json' => 'array',
    ];

    /**
     * Get the design this layer belongs to
     */
    public function design()
    {
        return $this->belongsTo(CustomproductDesign::class, 'design_id');
    }

    /**
     * Check if layer is within printable boundaries
     */
    public function isWithinBounds($printArea)
    {
        return $this->x_position >= $printArea['x'] &&
               $this->y_position >= $printArea['y'] &&
               ($this->x_position + $this->width) <= ($printArea['x'] + $printArea['width']) &&
               ($this->y_position + $this->height) <= ($printArea['y'] + $printArea['height']);
    }
}
