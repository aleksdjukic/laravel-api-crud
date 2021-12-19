<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

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

    public function edit($id)
    {
        $student = Student::findOrFail($id);

        return response()->json([
            'status' => 200,
            'student' => $student
        ]);
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
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
