<?php

namespace App\Models;

use App\Models\Traits\HasQueries;
use App\Models\Traits\HasSettings;
use App\Models\Traits\ModelHelpers;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasSettings;
    use HasQueries;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use ModelHelpers;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];


    public function delete()
    {
        if($this->isSystemAdmin() || $this->isLastAdmin()) return;

        $this->roles()->detach();
        return parent::delete();
    }


    public function isAdmin()
    {
        return $this->hasRole(['admin', 'super user']);
    }

    public function isSuperUser()
    {
        return $this->hasRole('super user');
    }


    public function isLastAdmin()
    {
        return $this->isAdmin() && self::adminCount() === 1;
    }

    public function isSystemAdmin()
    {
        return $this->email === 'admin@admin.com';
    }
    

    public static function adminCount()
    {
        return self::whereHas('roles', function(Builder $query) {
            return $query->where('name', 'admin');
        })->count();
    }

    /**
     * Exclude the user with 'super user' role
     */
    public static function allExceptSU()
    {
        return self::whereDoesntHave('roles', function(Builder $query) {
            return $query->where('name', 'super user');
        })->get();
    }

}
