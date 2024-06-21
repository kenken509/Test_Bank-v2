<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\SubjectCode;
use Illuminate\Http\Request;

class TestGeneratorController extends Controller
{
    public function showTestGenerator()
    {
        // $subjectCodes = SubjectCode::with(['questions' => function ($query){
        //     $query->with(['author','options']);
        // }])->latest()->get();

        $departments = Department::with(['subjectCodes' => function($query){
            $query->with(['questions' => function ($query){
                $query->with(['author','options']);
            },'problemSets']);
        },'divisions'])->get();

        // $departments = Department::with(['subjectCodes' => function($query){
        //     $query->with(['questions' => function ($query){
        //         $query->with(['author'])
        //               ->with(['options' => function ($query) {
        //                   $query->inRandomOrder();
        //               }])
        //               ->inRandomOrder();
        //     }]);
        // }, 'divisions'])->get();

      
       //dd($departments);
        return inertia('Dashboard/TestGenerator/TestGenearator',[
            'department' => $departments
        ]);
    }

 
    public function showGeneratedExam(Request $request)
    {
       // dd($request);
        return inertia('Dashboard/TestGenerator/GeneratedTest');
    }
}
