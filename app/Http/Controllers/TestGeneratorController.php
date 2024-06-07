<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\SubjectCode;
use Illuminate\Http\Request;

class TestGeneratorController extends Controller
{
    public function showTestGenerator()
    {
        $subjectCodes = SubjectCode::with(['questions' => function ($query){
            $query->with(['author','options']);
        }])->latest()->get();

        $department = Department::with(['subjectCodes' => function($query){
            $query->with(['questions' => function ($query){
                $query->with(['author','options']);
            }]);
        },'divisions'])->get();

      
       // dd($department);
        return inertia('Dashboard/TestGenerator/TestGenearator',[
            'department' => $department,
        ]);
    }

 
    public function showGeneratedExam(Request $request)
    {
       // dd($request);
        return inertia('Dashboard/TestGenerator/GeneratedTest');
    }
}
