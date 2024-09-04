<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Client\Request;

class Joob extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'joobs';
    protected $guarded = [];
    public static array $experience = ['entry', 'intermediate', 'senior'];
    public static array $category = [
        'IT',
        'Finance',
        'Sales',
        'Marketing'
    ];
    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }
    public function jobAplications(): HasMany
    {
        return $this->hasMany(JobAplications::class,);
    }
        
    // Authenticatable: Laravel'de kimlik doğrulama işlemleri için kullanılan arayüzdür.
    // User: Genellikle kullanıcı modelini temsil eder (App\Models\User).
    // int: Kullanıcının ID'sini direkt olarak alabilir.
    public function hasUserApplied(Authenticatable|User|int $user): bool
    {
        return $this->where('id', $this->id)->whereHas(
            'jobAplications',
            fn($query) => $query->where('user_id', '=', $user->id ?? $user)
        )->exists();
    }

    public function scopeFilter(Builder|QueryBuilder $builder, array $filters): Builder|QueryBuilder
    {
        return $builder->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%')
                    ->orWhere('location', 'LIKE', '%' . $search . '%')
                    ->orWhereHas('employer', function ($query) use ($search) {
                        $query->where('company_name', 'LIKE', '%' . $search . '%');
                    });
            });
        })->when($filters['min_salary'] ?? null, function ($query, $minsalary) {
            $query->where('salary', '>=', $minsalary);
        })->when($filters['max_salary'] ?? null, function ($query, $maxsalary) {
            $query->where('salary', '<=', $maxsalary);
        })->when($filters['experience'] ?? null, function ($query, $experience) {
            $query->where('experience', $experience);
        })->when($filters['category'] ?? null, function ($query, $category) {
            $query->where('category', $category);
        });
    }
}
