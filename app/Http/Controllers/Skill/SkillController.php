<?php

namespace App\Http\Controllers\Skill;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Skill;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return json_encode([
            'Skills' =>  Skill::all()
        ]);
    }

    public function show($id)
    {
        $skill = Skill::find($id);

        if ($skill != null) {
            return json_encode([
                'Skill' => $skill
            ]);
        } else {
            return json_encode([
                'message' => 'skill Not Found'
            ]);
        }
    }

    
    public function getCoursesThatHaveSkill($id)
    {
        $skill = Skill::find($id);

        if ($skill != null) {
            $courses = $skill->courses;

            if (count($courses) == 0) {
                return json_encode([
                    'message' => "no courses for this skill"
                ]);
            } else {
                return json_encode([
                    'Courses' => $courses
                ]);
            }
        } else {
            return json_encode([
                'message' => 'no skill'
            ]);
        }
    }

    
    public function getStudentsThatHaveSkill($id)
    {
        $skill = Skill::find($id);

        if ($skill != null) {
            $students = $skill->students;

            if (count($students) == 0) {
                return json_encode([
                    'message' => "no students for this skill"
                ]);
            } else {
                return json_encode([
                    'Students' => $students
                ]);
            }
        } else {
            return json_encode([
                'message' => 'no skill'
            ]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'skill'=> 'required',
        ]);
        return Skill::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $skill=Skill::find($id);
        $skill->update($request->all());
        return $skill;
    }

    public function destroy($id)
    {
        return Skill::destroy($id);
    }

}
