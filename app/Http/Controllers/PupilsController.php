<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Pupils\PupilsResource;
use App\Http\Resources\Pupils\PupilsCollection;
use App\Http\Resources\Pupils\PupilsTestCollection;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Pupils\PupilsRequest;
use App\Pupils;
use App\Subject;

use App\Classes;
class PupilsController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth:api');
    }

    public function index()
    {

        $user = auth()->user();

        $grades = DB::table('users')
        ->join('grades', 'grades.user_id', '=', 'users.id')
        ->join('tests', 'grades.test_id', '=', 'tests.id')
        ->join('subjects', 'subjects.id', '=', 'tests.subject_id')
        ->where('users.id', $user->id)
        ->select(DB::raw("subjects.id, subjects.subjectname, avg(grades.grade) as grade"))
        ->groupBy('subjects.id')
        ->paginate(1);

        $grades = collect($grades);


        return new PupilsCollection($grades);
    }

    public function store(PupilsRequest $request)
    {
        $class = Classes::where('classname',$request->classname)->first();
  
        $checkpupil = Pupils::where('user_id', $request->user_id)->first();
        if ($checkpupil != null) {
            $checkpupil->delete();
        }
        $pupils = new Pupils;  
        $pupils->class_id = $class->id; 
        $pupils->user_id = $request->user_id;
        $pupils->save();

        return response()->json(['message' => 'New pupil assigned Successfully'], 201);
    }

    public function show($id)
    {
        $user = auth()->user();

        $grades = DB::table('users')
        ->join('grades', 'grades.user_id', '=', 'users.id')
        ->join('tests', 'grades.test_id', '=', 'tests.id')
        ->join('subjects', 'subjects.id', '=', 'tests.subject_id')
        ->where([['users.id', $user->id],['subjects.id', $id]])
        ->select(DB::raw("tests.name, grades.grade"))
        ->paginate(1);

        $grades = collect($grades);

        return new PupilsTestCollection($grades);
    
    }

    public function update(Request $request)
    {

    }

    public function destroy($id)
    {
      $pupil = Pupils::where('user_id', $id)->first();
      $pupil->delete();

      // More Work Here

      return response()->json(['message' => 'Pupil Removed Successfully'], 200);
  }
}
