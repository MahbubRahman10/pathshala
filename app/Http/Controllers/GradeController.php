<?php

namespace App\Http\Controllers;

use App\Grade;
use Illuminate\Http\Request;
use App\Http\Resources\Grade\GradeResource;
use App\Http\Resources\Grade\GradeCollection;
use App\Http\Resources\Grade\TestGradeCollection;
use App\Http\Requests\Grade\GradeRequest;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Storage;
use App\User;
use Session;

class GradeController extends Controller
{

    public function index()
    { 
        $grades = DB::table('users')
        ->join('role_user', 'role_user.user_id', '=', 'users.id')
        ->join('roles', 'role_user.role_id', '=', 'roles.id')
        ->join('grades', 'grades.user_id', '=', 'users.id')
        ->join('tests', 'grades.test_id', '=', 'tests.id')
        ->join('subjects', 'tests.subject_id', '=', 'subjects.id')
        ->where('roles.id',3)
        ->get();

        return new GradeCollection($grades);
    }

    public function store(GradeRequest $request)
    {
        if ($request->flag == 0) {
            $user = User::where('username',$request->user_name)->first();
            if ($user == null) {
                return response()->json(['message' => 'Pupils not found'], 203);
            }
            $grade = new Grade;  
            $grade->grade = $request->grade; 
            $grade->test_id = $request->test_id;
            $grade->user_id =$user->id;
            $grade->save();

            return response()->json(['message' => 'Grade Added Successfully'], 201);
        }
        else{

            $exploded = explode(',',$request->file);
            $decode = base64_decode($exploded[1]);
            $ext ='xlsx';
            $rnd = substr(md5(rand()), 0, 6);
            $filename = $rnd.'.'.$ext;
            $path =  public_path().'/upload/'.$filename;
            $image = file_put_contents($path, $decode);


            // $path =$request->file('file')->getRealPath();
         
            $collection = (new FastExcel)->import($path);
            if (count($collection) == 0) {
                return response()->json(['message' => 'Failed! File is empty'], 400);
            }
            $pupilsgrades = []; 
            foreach ($collection as $key => $value) { 
                $arraykey = array_keys($value);
                $arraydata = array('Studentname','Grade');
                if ($arraykey == $arraydata) {
                    $user = User::where('username',$value['Studentname'])->first();
                    if ($user == null) {
                        return response()->json(['message' => 'Failed! Pupils not found'], 400);
                    }
                    else{
                       $grade = $value['Grade']; 
                       $test_id = $request->test_id;
                       $user_id = $user->id;
                        $pupilsgrades[] = [
                            'grade' => $grade, 
                            'test_id' => $test_id,
                            'user_id' => $user_id
                        ];
                    }    
                }
                else{
                    return response()->json(['message' => 'Failed! Key Pairs must be Studentname and Grade'], 401);
                }
            }
            Grade::insert($pupilsgrades);
            Storage::delete($path);
            return response()->json(['message' => 'Grade Added Successfully'], 201);
        }
    }

    public function show($id)
    {
        $grades = DB::table('users')
        ->join('grades', 'grades.user_id', '=', 'users.id')
        ->where('grades.test_id',$id)
        ->paginate(1);
        
        $grades = collect($grades);

        return new TestGradeCollection($grades);
    }
    public function update(Request $request, Grade $grade)
    {
        $grade->update($request->all());
        return Response()->json("Grade Updated Successfully",201);
    }

    public function destroy(Grade $grade)
    {
        //
    }
}
