<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $courses = Course::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = Course::find($id);

        if ($course != null) {
            return $course;
        } else {
            return json_encode([
                'message' => 'no courses'
            ]);
        }
    }

    

    public function getSkillsAfterCompletionOfCourse($id)
    {
        $course = Course::find($id);

        if ($course != null) {
            return json_encode([
                'Skills' => $course->skills
            ]);
        } else {
            return json_encode([
                'message' => 'no courses'
            ]);
        }
    }

    
    public function checkCourseHasRequiredSkills($id)
    {
        $course = Course::find($id);

        if ($course != null) {
            if ($course->type == "PreRequiste") {
                return json_encode([
                    'RequiredSkills' => $course->reqSkills
                ]);
            } else {
                return json_encode([
                    'message' => 'Course Has No PreRequiste Skills'
                ]);
            }
        } else {
            return json_encode([
                'message' => 'no courses'
            ]);
        }
    }

    public function getCourseStudents($id)
    {
        $course = Course::with(['students' => function ($query) {
            $query->select('students.id', 'fname', 'lname', 'email');
        }])->find($id);

        if ($course != null) {

            $students = $course->students;

            if (count($students) == 0) {
                return json_encode([
                    'message' => 'no students for this course'
                ]);
            } else {
                return json_encode([
                    'Students' => $students
                ]);
            }
        } else {
            return json_encode([
                'message' => 'no courses'
            ]);
        }
    }

    //Get Instructor Of Course
    public function getCourseInstructor($id)
    {
        $course = Course::with(['instructor' => function ($query) {
            $query->select('instructors.id', 'fname', 'lname', 'email');
        }])->find($id);

        if ($course != null) {

            $instructor = $course->instructor;

            return json_encode([
                'instructor' => $instructor
            ]);
        } else {
            return json_encode([
                'message' => 'no courses'
            ]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'=> 'required',
            'description'=>'required',
            'duration'=>'required',
            'technologies'=>'required',
            'instructor_id'=>'required',
            'headline'=>'required',
        ]);
        return Course::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $course=Course::find($id);
        $course->update($request->all());
        return $course;
    }

    public function delete($id)
    {
        return Course::destroy($id);
    }
    
    public function updateSkills($id)
    {
        $course = Course::find($id);

        if ($course != null) {
            $skills = Course::with(['skills' => function ($q) {
                $q->select('skill');
            }])->find($id)["skills"];
            $technologies = "";
            foreach ($skills as $skill) {

                $technologies .= " " . $skill['skill'] . " ,";
            }
            $course->technologies = rtrim($technologies, ',');
            $course->save();

            return $course;
        } else {
            return json_encode([
                'message' => 'no courses'
            ]);
        }
    }

    public function attachNewSkills(Request $request, $id)
    {
        $course = Course::find($id);
        if ($course != null) {

            $course->skills()->syncWithoutDetaching($request->Skills);

            return $course->skills;
        } else {
            return json_encode([
                'message' => 'no course'
            ]);
        }
    }

}
