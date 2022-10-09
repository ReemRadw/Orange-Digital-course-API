<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Instructor;
use Illuminate\Contracts\Database\Eloquent\SupportsPartialRelations;

class Course extends Model
{
    use HasFactory;


    protected $fillable = [
        'title', 'type', 'technologies', 'description', 'duration', 'instructor_id','headline'
    ];

    protected $hidden = ['pivot', 'created_at', 'updated_at', 'instructor_id'];




    //////////////////////////////////// Relations //////////////////////////////////////////////////////////////////

    //Course Instructor
    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }


    //Students In Courses
    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_course', 'course_id', 'student_id');
    }


    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'course_skills', 'course_id', 'skill_id');
    }

    public function supplier()
    {
        return $this->belongsTo(supplier::class, 'course_id');
    }

    
}
