<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Menu;
use App\Models\Order;
use App\Models\MenuItem;
use App\Models\Payement;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomResetPassword;
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

    public function payments(){
        return $this->hasMany(Payement::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    // User.php
    public function getOrderOfTheDay()
    {
        return Order::getOrderOfTheDay($this->id);
    }
    
    public function pendingOrder()
    {
        return $this->hasOne(Order::class)->where('payment_status', 'pending');
    }
    
    public function getDailyOrder()
    {
        $currentDate = now()->toDateString(); // Comparer uniquement la date
        return Order::where('user_id', $this->id)
                    ->whereDate('created_at', $currentDate)
                    ->where('payment_status', 'pending')
                    ->first();
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }
    
}
