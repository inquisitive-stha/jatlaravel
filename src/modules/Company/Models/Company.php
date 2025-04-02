<?php

namespace Modules\Company\Models;

use App\Http\Filters\V1\QueryFilter;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Company\database\factories\CompanyFactory;

class Company extends Model
{
    use HasFactory;

    protected $table = "companies";
    protected $primaryKey = 'id';

    public $fillable = [
        'name',
        'slug',
        'location',
        'user_id',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return CompanyFactory|\Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory(): CompanyFactory|\Illuminate\Database\Eloquent\Factories\Factory
    {
        return CompanyFactory::new();
    }

    public function scopeFilter(Builder $builder, QueryFilter $filters): Builder
    {
        return $filters->apply($builder);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
       return $this->belongsTo(User::class);
    }

}
