<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'deleted_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Send the password reset notification.
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    //Relación a la table doctors
    public function doctor()
    {
        return $this->hasOne(Doctor::class, 'user_id');
    }

    public function scopeNotRole(Builder $query, $roles, $guard = null): Builder 
    { 
         if ($roles instanceof Collection) { 
             $roles = $roles->all(); 
         } 
  
         if (! is_array($roles)) { 
             $roles = [$roles]; 
         } 
  
         $roles = array_map(function ($role) use ($guard) { 
             if ($role instanceof Role) { 
                 return $role; 
             } 
  
             $method = is_numeric($role) ? 'findById' : 'findByName'; 
             $guard = $guard ?: $this->getDefaultGuardName(); 
  
             return $this->getRoleClass()->{$method}($role, $guard); 
         }, $roles); 
  
         return $query->whereHas('roles', function ($query) use ($roles) { 
             $query->where(function ($query) use ($roles) { 
                 foreach ($roles as $role) { 
                     $query->where(config('permission.table_names.roles').'.id', '!=' , $role->id); 
                 } 
             }); 
         }); 
    }
}
