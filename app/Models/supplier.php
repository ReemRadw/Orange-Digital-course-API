<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Course;
class supplier extends Model
{
    use HasFactory;
    protected $fillable=[
        'course_id',
        'course_state',
        'course_place',
        'spplier',
    ];

    public function courses()
    {
        return $this->belongsToMany(Admin::class, 'course_id');
    }
}
