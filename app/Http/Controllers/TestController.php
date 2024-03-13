<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Test\TestResource;
use App\Http\Resources\Test\TestCollection;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Test\TestRequest;
use App\Test;
use Session;

class TestController extends Controller
{

    public function __construct()
    {
      
    }
    
    public function index(Request $request)
    {
        session_start(); 
        $subject_id = $_SESSION["subjectid"]; 

        $grades = DB::table('subjects')
        ->join('tests', 'subjects.id', '=', 'tests.subject_id')
        ->join('grades', 'grades.test_id', '=', 'tests.id')
        ->join('users', 'grades.user_id', '=', 'users.id')
        ->where('subjects.id',$subject_id)
        ->groupBy('users.id')
        ->select(DB::raw("username, firstname, lastname, avg(grade) as grade"))
        ->paginate(1);

        $grades = collect($grades);

        return new TestCollection($grades);
        
    }

    public function store(TestRequest $request)
    {
        $test = new Test;   
        $test->testcode = substr(md5(rand()), 0, 4);
        $test->name = $request->name;
        $test->date = $request->date;
        $test->subject_id = $request->subject_id;
        $test->save();

        return response()->json(['message' => 'New Test Created Successfully'], 201);
    }

    public function show(Test $test)
    {
        return new TestResource($test);
    }

    public function update(Request $request, Test $test)
    {
        $test->update($request->all());
        return Response()->json("Test Updated Successfully",201);
    }

    public function destroy(Test $test)
    {
        $test->delete();
        return Response()->json("Test Removed Successfully",201);
    }
}
