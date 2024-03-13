<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Subject\SubjectResource;
use App\Http\Resources\Subject\SubjectCollection;

use App\Http\Requests\Subject\SubjectRequest;
use App\Subject;
use App\Test;
use Illuminate\Support\Facades\DB;
use Session;

class SubjectController extends Controller
{

    public function __construct()
    {
        
    }

    public function index()
    {
        $subjects = DB::table('subjects')
        ->join('users', 'subjects.user_id', '=', 'users.id')
        ->join('classes', 'subjects.class_id', '=', 'classes.id')
        ->select('subjects.id', 'subjects.subjectcode',  'subjects.subjectname', 'classes.classname', 'users.username', 'subjects.subjectstatus','subjects.class_id', 'subjects.user_id')
        ->paginate(7);


        $subjects = collect($subjects);
        

        return new SubjectCollection($subjects);

    }

    public function store(SubjectRequest $request)
    {

        $subject = new Subject;   
        $subject->subjectcode = substr(md5(rand()), 0, 4);
        $subject->subjectname = $request->subjectname;
        $subject->class_id = $request->class_id;
        $subject->user_id =$request->user_id;;
        $subject->save();

        return response()->json(['message' => 'New Subject Created Successfully'], 201);
    }

    public function show(Subject $subject)
    {   
        session_start();
        $_SESSION["subjectid"] = $subject->id;
        return new SubjectResource($subject);
    }

    public function update(Request $request, Subject $subject)
    {  
        if ($subject->subjectstatus == true) {
            return Response()->json("This Subject Can not be Updated",201);
        }
        $subject->update($request->all());
        return Response()->json("Subject Updated Successfully",201);
    }

    public function destroy(Subject $subject)
    {
        $test = Test::where('subject_id', $subject->id)->first();
        if ($test != null) {
            return Response()->json("Subject Can not Removed",304);
        } 
        $subject->delete();
        return Response()->json("Subject Removed Successfully",201);
    }
}
