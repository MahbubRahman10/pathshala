<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Subject\SubjectResource;
use App\Http\Resources\Subject\SubjectCollection;

use App\Http\Requests\Subject\SubjectRequest;
use App\Subject;
use App\Test;


class ArchiveController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        
    }

    public function store(Request $request)
    {
        $test = Test::where('subject_id', $request->subject_id)->first();
        if ($test != null) {
            $subject = Subject::find($request->subject_id);
            $subject->subjectstatus = true;
            $subject->save();
            return response()->json(['message' => 'Subject Archived Successfully'], 201);
        }
        else{
            return response()->json(['message' => 'This Subject cannot be Archived'], 301);
        }
        

    }

    public function show()
    {
     
    }

    public function update(Request $request)
    {
   
    }

    public function destroy()
    {
       
    }
}
