<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Http\Controllers\auth;
use App\Models\recommendation;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::all();
        return $students;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = Student::find($id);

        if ($student != null) {
            return $student;
        } else {
            return json_encode([
                'message' => 'no student'
            ]);
        }
    }

  



    public function getStudentSkills($id)
    {
        $student = Student::with(['skills' => function ($query) {
            $query->select('skill');
        }])->find($id);

        if ($student != null) {
            $skills = $student->skills;

            if (count($skills) == 0) {
                return json_encode([
                    'message' => 'Student Has No Skills'
                ]);
            } else {

                return $skills;
            }
        } else {
            return json_encode([
                'message' => 'no student'
            ]);
        }
    }


    
    public function getStudentCourses($id)
    {
        $student = Student::with(['courses' => function ($query) {
            $query->select('title');
        }])->find($id);

        if ($student != null) {
            $courses = $student->courses;

            if (count($courses) == 0) {
                return json_encode([
                    'message' => 'Student Has No courses'
                ]);
            } else {

                return $courses;
            }
        } else {
            return json_encode([
                'message' => 'no student'
            ]);
        }
    }

    public function store(Request $request)
    {
        $formFilds= $request->validate([
            'fname'=> 'required',
            'lname'=>'required',
            'national_id'=>'required|national_id|unique:instructor,national_id|string',
            'email'=>'required|email|unique:instructor,email|string',
            'phone'=>'required|phone|unique:instructor,phone|string',
            'password'=>'required|confirmed|string',

        ]);
        return Student::create($request->all());
        $formFilds['password'] = bcrypt($formFilds['password']);
    }

    public function update(Request $request, $id)
    {
        $student=Student::find($id);
        $student->update($request->all());
        return $student;
    }

    public function destroy($id)
    {
        return Student::destroy($id);
    }

    public function attachNewSkills(Request $request, $id)
    {
        $student = Student::find($id);

        $student->skills()->syncWithoutDetaching($request->Skills);

        return $student->skills;
    }

    public function detachSkills(Request $request, $id)
    {
        $student = Student::find($id);

        $student->skills()->detach($request->Skills);

        return $student->skills;
    }
    
    public function search($fname){

        return Student::where('fname','like', '%' .$fname. '%')->get();
    }

    public function recommendation($id){
        $student=Student::find($id);
        $student_skills = $student->skills;
        return $student_skills;
    }


}
