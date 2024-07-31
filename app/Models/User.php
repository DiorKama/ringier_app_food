<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Menu;
use App\Models\MenuItem;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'firstName',
        'lastName',
        'position',
        'email',
        'password',
        'phone_number',
        'disable',
        'desactivate_date',
        'is_superadmin',
        'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'desactivate_date' => 'datetime',
        'disable' => 'boolean',
        'is_superadmin' => 'boolean',
    ];

    public function menus(){
        return $this->hasMany(Menu::class);
    }

    public function menuItems(){
        return $this->hasMany(MenuItem::class);
    }
}
