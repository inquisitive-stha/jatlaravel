<?php

namespace Modules\JobApplication\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Company\Models\Company;
use Modules\JobApplication\database\factories\JobApplicationFactory;

class JobApplication extends Model
{
    use HasFactory;

    protected $table = "job_applications";
    protected $primaryKey = 'id';

    public $fillable = [
        'job_title',
        'job_post_url',
        'user_id',
        'company_id',
        'status',
        'minimum_salary',
        'maximum_salary',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return JobApplicationFactory|\Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory(): JobApplicationFactory|\Illuminate\Database\Eloquent\Factories\Factory
    {
        return JobApplicationFactory::new();
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
