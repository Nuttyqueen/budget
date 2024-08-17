<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'members';

    protected $fillable = [
        'prefix',
        'first_name',
        'last_name',
        'birthdate',
        'profile_image',
        'total_income',
        'total_expense',
    ];

    protected $dates = ['birthdate'];


    public function getAgeAttribute()
    {
        return Carbon::parse($this->attributes['birthdate'])->age;
    }


    public function getProfileImageUrlAttribute()
    {
        return $this->profile_image ? asset('storage/' . $this->profile_image) : null;
    }
}
