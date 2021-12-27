<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Student;
use Illuminate\Http\Client\ResponseSequence;
use DB;

class StudentController extends Controller
{
    public function index(){
        return view('student.index');
    }
    public function store(Request $request){
        $validator=Validator::make($request->all(),
            ['name'=>'required',
            'email'=>'required',
            'phone'=>'required',
            'course'=>'required'
        ]);
   

        if($validator->fails()){
            return response()->json(
                ['status'=>400,
                'errors'=>$validator->messages(),
                ]
            );
        }
        else{
            $student=new Student;
            $student->name=$request->name;
            $student->email=$request->email;
            $student->phone=$request->phone;
            $student->course=$request->course;

            $student->save();
            return response()->json(
                ['status'=>200,'message'=>'student added succesfully']
            );
        }



    }

     public function fetchStudent(){
        $all=Student::all();
        $total=DB::table('students')->count();
       
        return response()->json(
            ['students'=>$all,'total'=>$total]
        );
    }

    public function deleteStudent($id){
    $del=Student::find($id);
    $del->delete();
    return response()->json(['message'=>'Student deleted successfully','status'=>200]);
    }


    public function EditStudent($id){
  
        $find=Student::find($id);
        return response()->json([
            'editStudent'=>$find,
        ]);


    }

    public function updateStudent(Request $request,$id){
        $validator=Validator::make($request->all(),
        ['name'=>'required',
        'email'=>'required',
        'phone'=>'required',
        'course'=>'required'
    ]);


    if($validator->fails()){
        return response()->json(
            ['status'=>400,
            'errors'=>$validator->messages(),
            ]
        );
    }
    else{
        $student=Student::find($id);
        $student->name=$request->name;
        $student->email=$request->email;
        $student->phone=$request->phone;
        $student->course=$request->course;

        $student->update();
        return response()->json(
            ['status'=>200,'message'=>'student Updated succesfully']
        );
    }

    }

}
