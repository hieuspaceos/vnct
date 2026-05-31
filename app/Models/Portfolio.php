<?php
// app/Models/Portfolio.php
namespace App\Models;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Scopes\where_language;
class Portfolio extends Model
{
    protected $table = 'portfolio';
    public $timestamps = true;
    protected $fillable = [
        'member_id',
        'name',
        'slug',
        'content',
        'avatar',
        'name_company',
        'type',
        'email',
        'username',
        'location',
        'area_of_operation',
        'position',
        'lang','origin_id'
    ];
    public function save(array $options = [])
    {
        // Ép cập nhật thời gian trước khi save
        $this->updateTimestamps(); 
        
        return parent::save($options);
    }
    /**
     * Portfolio thuộc về một member
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
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
        static::addGlobalScope('order_by_newest', function ($builder) {
            $builder->orderBy('updated_at', 'desc'); // Hoặc cột nào bạn muốn
        });
        static::creating(function ($portfolio) {
            if (empty($portfolio->slug)) {
                $portfolio->slug = static::generateUniqueSlug($portfolio->name);
            }
        });
        
        static::updating(function ($portfolio) {
            if ($portfolio->isDirty('name')) {
                $portfolio->slug =static::generateUniqueSlug($portfolio->name, $portfolio->id);
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