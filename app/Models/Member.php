<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use App\Scopes\where_language;
class Member extends Model
{
    protected $fillable = ['name', 'slug','lang','origin_id'];
    
    /**
     * Một member có nhiều portfolio
     */
    public function portfolios(): HasMany
    {
        return $this->hasMany(Portfolio::class);
    }
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->withoutGlobalScope(\App\Scopes\where_language::class)
                    ->where($field ?? $this->getRouteKeyName(), $value)
                    ->first();
    }
    protected static function boot()
    {
        static::addGlobalScope(new where_language());
        parent::boot();
        
        static::creating(function ($member) {
            if (empty($member->slug)) {
                $member->slug = static::generateUniqueSlug($member->name);
            }
        });
        
        static::updating(function ($member) {
            if ($member->isDirty('name')) {
                $member->slug = static::generateUniqueSlug($member->name, $member->id);
            }
        });
    }

    protected static function generateUniqueSlug($name, $ignoreId = null)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;
        
        while (static::withoutGlobalScopes() // BỎ GLOBAL SCOPE
                ->where('slug', $slug)
                ->when($ignoreId, function ($query, $ignoreId) {
                    return $query->where('id', '!=', $ignoreId);
                })
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $count++;
        }
        
        return $slug;
    }
}


?>