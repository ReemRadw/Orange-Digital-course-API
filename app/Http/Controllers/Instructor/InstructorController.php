<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return json_encode([
            'Instructors' => Instructor::all()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

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
        $instructor = Instructor::find($id);

        if ($instructor != null) {
            return $instructor;
        } else {
            return json_encode([
                'message' => 'no courses'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    
    public function getCoursesThatBelongToInstructor($id)
    {
        $instructor = Instructor::find($id);
        if ($instructor != null) {

            $courses = $instructor->courses;

            if (count($courses) == 0) {
                return json_encode([
                    'message' => "This Instructor does not Have Any Courses"
                ]);
            } else {
                return json_encode([
                    'Courses' => $courses
                ]);
            }
        } else {
            return json_encode([
                'message' => 'no instructor'
            ]);
        }
    }

    public function store(Request $request)
    {
        $formFilds=$request->validate([
            'fname'=> 'required',
            'lname'=>'required',
            'national_id'=>'required|national_id|unique:instructor,national_id|string',
            'email'=>'required|email|unique:instructor,email|string',
            'password'=>'required|confirmed|string',
            'phone'=>'required|phone|unique:instructor,phone|string',
            
        ]);
        return Instructor::create($request->all());

        $formFilds['password'] = bcrypt($formFilds['password']);
    }

    public function update(Request $request, $id)
    {
        $instructor=Instructor::find($id);
        $instructor->update($request->all());
        return $instructor;
    }

    public function destroy($id)
    {
        return Instructor::destroy($id);
    }

}
