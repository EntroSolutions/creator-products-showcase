<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'creator_id',
        'name',
        'description',
        'long_description',
        'image_path',
        'mrr',
        'live_users',
        'arr',
        'website_url',
    ];

    /**
     * Calculated attributes
     */
    protected function casts(): array
    {
        return [
            'arr' => 'float',
            'mrr' => 'float',
            'live_users' => 'integer',
        ];
    }

    /**
     * Get the creator that owns the product.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
    
    /**
     * Get the tags for the product.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
    
    /**
     * Get the features for the product.
     */
    public function features()
    {
        return $this->hasMany(Feature::class);
    }
    
    /**
     * Get the testimonials for the product.
     */
    public function testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }
}
