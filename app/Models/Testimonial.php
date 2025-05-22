<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Testimonial extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'author_name',
        'author_title',
        'content',
        'rating',
    ];
    
    /**
     * Attribute casts
     */
    protected function casts(): array
    {
        return [
            'rating' => 'integer',
        ];
    }

    /**
     * Get the product that owns the testimonial.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
} 