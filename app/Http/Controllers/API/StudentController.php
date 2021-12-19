<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();

        return response()->json([
            'status' => 200,
            'students' => $students
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required|max:191',
                'course' => 'required|max:191',
                'email' => 'required|email|max:191',
                'phone' => 'required|min:3|max:15',
            ]
        );

        if($validator->fails()){
            return response()->json([
                'validate_err' => $validator->messages(),
            ]);
        }else
        {
            $student = new Student;
            $student->name = $request->input('name');
            $student->email = $request->input('email');
            $student->phone = $request->input('phone');
            $student->course = $request->input('course');
            $student->save();

            return response()->json([
                'status' => 200,
                'message' => 'Student added successfully',
            ]);
        }
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);

        if($student)
        {
            return response()->json([
               'status' => 200,
               'student' => $student
            ]);
        }
        else
        {
            return response()->json([
               'status' => 404,
               'student' => "No student ID found"
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
        [
            'name' => 'required|max:191',
            'course' => 'required|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|min:3|max:15',
        ]);

        if($validator->fails()){
            return response()->json(
                [
                    'validate_err' => $validator->messages()
                ]
            );
        }
        else {
            $student = Student::findOrFail($id);
            if($student){
                $student->name = $request->input('name');
                $student->email = $request->input('email');
                $student->phone = $request->input('phone');
                $student->course = $request->input('course');
                $student->update();

                return response()->json([
                    'status' => 200,
                    'message' => "Student updated successfully"
                ]);
            }
           else
           {
               return response()->json([
                   'status' => 404,
                   'message' => "No Student ID found!"
               ]);
           }
        }
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return response()->json([
           'status' => 200,
           'message' => 'User successfully deleted'
        ]);
    }
}
