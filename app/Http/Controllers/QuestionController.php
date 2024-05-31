<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\Question;
use App\Models\SubjectCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    public function showQuestions()
    {
        // user rolse admin, co-admin, department head, faculty
        $loggedUser = Auth::user();
        
        $questions = Question::with(['options', 'author', 'subjectCode'])->latest()->get();
        
        if($loggedUser->role == 'admin' || $loggedUser->role == 'co-admin')
        {
            $subjectCodes = SubjectCode::with(['questions' => function ($query){
                $query->with(['author','options']);
            }])->latest()->get();
            
        }

        if($loggedUser->role == 'department head')
        {
            
            $subjectCodes = SubjectCode::with(['questions' => function ($query){
                $query->with(['author','options']);
            }])->where('department_id', $loggedUser->department_id)->latest()->get();
                
        }

        if($loggedUser->role == 'faculty')
        {
            $hasDivision = $loggedUser->division_id;
            
            if($hasDivision)
            {
                $subjectCodes = SubjectCode::with(['questions' => function ($query){
                    $query->with(['author','options']);
                }])->where('division_id', $loggedUser->division_id)->latest()->get();
            }
            else
            {
                
                $subjectCodes = SubjectCode::with(['questions' => function ($query){
                    $query->with(['author','options']);
                }])->where('department_id', $loggedUser->department_id)->latest()->get();

                
            }
            
        }
        
        return inertia('Dashboard/Questions/QuestionAll', [
            'subjectCodes' => $subjectCodes,
        ]);
    }

    public function showAddQuestion()
    {
        $loggedUser = Auth::user();
        
        if($loggedUser->role == 'admin' || $loggedUser->role == 'co-admin')
        {
            $subjectCodes = SubjectCode::orderBy('id','asc')->get();
        }
        
        if($loggedUser->role == 'department head')
        {
            $subjectCodes = SubjectCode::where('department_id', $loggedUser->department_id)->orderBy('id','asc')->get();
        }

        if($loggedUser->role == 'faculty')
        {
            $hasDivision = $loggedUser->division_id;

            if($hasDivision)
            {
                $subjectCodes = SubjectCode::where('division_id', $loggedUser->division_id)->orderBy('id','asc')->get();
            }
            else
            {
                $subjectCodes = SubjectCode::where('department_id', $loggedUser->department_id)->orderBy('id','asc')->get();
            }
            
        }

        return inertia('Dashboard/Questions/QuestionAdd',[
            'subjectCodes' => $subjectCodes,
        ]);
    }

    public function storeQuestion(Request $request)
    {
        // const form = useForm({
        //     question:'',
        //     type:'text',
        //     term: '',
        //     attached_image:'',
        //     term:'',
        //     subject_code_id:'',
        //     author_id:user.id,
        //     options:[],
        // })
       
        if($request->type == 'text')
        {
            // check if there is an attached image file, if yes then save the to images storage link and save the data to database else save the data to database, save each option
            // to related options
            //dd($request);

            try{
                DB::beginTransaction();

                if ($request->hasFile('attached_image')) {
                    $file = $request->file('attached_image');
                    $path = $file->store('Images', 'public');
                    $imagePath = basename($path); // Get only the filename
                } else {
                    $imagePath = null;
                }
                
                $imageFiles=[$imagePath];
                $question = new Question();
                $question->question         = $request->question;
                $question->type             = $request->type;
                $question->term             = $request->term;
                $question->attached_image   = $imagePath;
                $question->subject_code_id  = $request->subject_code_id;
                $question->author_id        = $request->author_id;
                $question->save();

                throw new \Exception('simulated error');
                //dd($request);
                // Save each option related to the question
                foreach ($request->options as $option) {
                    
                    $questionOption                 = new Option();
                    $questionOption->option         = $option['option'];
                    // Convert boolean to string 'true' or 'false'
                    $questionOption->isCorrect      = $option['isCorrect'] ? 'true' : 'false'; //$questionOption->isCorrect      = $option['isCorrect'];
                    $questionOption->question_id    = $question->id;
                    $questionOption->save();
                }

                DB::commit();
                return redirect()->route('questions.show')->with('success', 'Successfully created new question.');
            }catch (\Exception $e)
            {
                DB::rollback();
                Log::error('error creating new question: '.$e->getMessage());
                
                // Delete all images in the array
                foreach ($imageFiles as $filename) {
                    Storage::disk('public')->delete('Images/' . $filename);
                }

                return redirect()->back()->with('error', 'Failed to create new question.');
            }
            
        }

        if($request->type == 'image')
        {
            if($request->hasFile('attached_image'))
            {
                
                try
                {
                    DB::beginTransaction();

                    // save the attached image 
                    $file = $request->file('attached_image');
                    $path = $file->store('Images', 'public');
                    $imagePath = basename($path);
                    
                     // Array to store filenames of images
                    $imageFiles = [$imagePath];

                    $question = new Question();
                    $question->question         = $request->question;
                    $question->type             = $request->type;
                    $question->attached_image   = $imagePath;
                    $question->term             = $request->term;
                    $question->subject_code_id  = $request->subject_code_id;
                    $question->author_id        = $request->author_id;
                    $question->save();

                    foreach($request->options as $option)
                    {
                       
                        $optionImage    = $option['option'];
                        $path           = $optionImage->store('Images','public');
                        $imagePath      = basename($path);

                        // Add option image filename to the array
                        $imageFiles[] = $imagePath;

                        $newOption = new Option();
                        $newOption->option      = $imagePath;
                        $newOption->isCorrect   = $option['isCorrect'] ? 'true': 'false';
                        $newOption->question_id = $question->id;
                        $newOption->save();

                    }

                    // Simulate an error
                    //throw new \Exception('Simulated error after saving the attached image');

                    DB::commit();
                    return redirect()->route('questions.show')->with('success', 'Successfully created new question.');
                
                }
                catch (\Exception $e)
                {
                    DB::rollback();
                    Log::error('error saving image question: '.$e->getMessage());
                    
                    // Delete all images in the array
                    foreach ($imageFiles as $filename) {
                        Storage::disk('public')->delete('Images/' . $filename);
                    }

                    return redirect()->back()->with('error', 'Failed to create new question');
                }
                
            }
            else
            {
                //     question:'',
                //     type:'text',
                //     term: '',
                //     attached_image:'',
                //     term:'',
                //     subject_code_id:'',
                //     author_id:user.id,
                //     options:[],
                try
                {
                    DB::beginTransaction();

                    $imageFiles = [];
                    $question = new Question();

                    $question->question         = $request->question;
                    $question->type             = $request->type;
                    $question->term             = $request->term;
                    $question->subject_code_id  = $request->subject_code_id;
                    $question->author_id        = $request->author_id;
                    $question->save();

                    foreach($request->options as $option)
                    {
                        $optionImage    = $option['option'];
                        $path           = $optionImage->store('Images','public');
                        $imagePath      = basename($path);

                        // Add option image filename to the array
                        $imageFiles[] = $imagePath;

                        $newOption = new Option();
                        $newOption->option      = $imagePath;
                        $newOption->isCorrect   = $option['isCorrect'] ? 'true': 'false';
                        $newOption->question_id = $question->id;
                        $newOption->save();
                    }

                    //throw new \Exception('simulated error');
                    DB::commit();
                    return redirect()->route('questions.show')->with('success','Successfully created new question.');
                    
                }
                catch(\Exception $e)
                {
                    DB::rollback();
                    Log::error('error creating new question without image_attachment: '.$e->getMessage());

                    foreach($imageFiles as $filename)
                    {
                        Storage::disk('public')->delete('Images/' . $filename);
                    }
                    
                    return redirect()->back()->with('error', 'Failed to create new question.');
                }
            }
        }
    }

    public function showUpdate($id)
    {
        
        // only admin, coadmin, dephead is allowed to update
        // user rolse admin, co-admin, department head, faculty
        $loggedUser = Auth::user();

        $question = Question::with('subjectCode','options')->findOrFail($id);
        

        if($loggedUser->role == 'admin' || $loggedUser->role == 'co-admin')
        {
            $subjectCodes = SubjectCode::orderBy('id','asc')->get();
        }
        
        if($loggedUser->role == 'department head')
        {
            $subjectCodes = SubjectCode::where('department_id', $loggedUser->department_id)->orderBy('id','asc')->get();
        }

        return inertia('Dashboard/Questions/QuestionUpdate', [
            'subjectCodes'  => $subjectCodes,
            'question'      => $question
        ]);
    }

    public function update(Request $request)
    {
        
        //dd($request);
       $questionToUpdate = Question::with('options')->findOrFail($request->question_id);
       
       
        //dd($request);
        //dd($request->attached_image);
        // question_id:data.question.id,
        // question:data.question.question,
        // type:data.question.type,
        // term: data.question.term,
        // attached_image:'',
        // hasExistingAttached_image:data.question.attached_image ? 'true':'false',
        // subject_code_id:'',
        // editor_id:user.id,
        // options:[],
        
        if($request->type == 'text')
        {
            if($questionToUpdate->attached_image)
            {  
                // existing attached image not changed
                if($request->attached_image == $questionToUpdate->attached_image)
                { 
                    //dd($request);
                    $questionToUpdate->question         = $request->question;
                    $questionToUpdate->type             = $request->type;
                    $questionToUpdate->term             = $request->term;
                    $questionToUpdate->subject_code_id  = $request->subject_code_id;
                    $questionToUpdate->editor_id        = $request->editor_id;
                    $questionToUpdate->save();
                   
                    foreach($request->options as $option)
                    {
                        $answer = '';
                        if($option['isCorrect']=='true')
                        {
                            $answer = 'true';
                        }
                        else
                        {
                            $answer = 'false';
                        }

                        $optionToUpdate = Option::findOrFail($option['option_id']);

                        $optionToUpdate->option = $option['option'];
                        $optionToUpdate->isCorrect = $answer;
                        $optionToUpdate->save();
                    }

                   

                    return redirect()->route('questions.show')->with('success', 'Question updated successfully.');
                }
                else
                {
                    //attached image replaced
                    if($request->hasFile('attached_image'))
                    {
                        $filename = $questionToUpdate->attached_image;
                        Storage::disk('public')->delete('Images/' . $filename);
                        
                        $file = $request->file('attached_image');
                        $path = $file->store('Images','public');
                        $imagePath = basename($path);

                        $questionToUpdate->attached_image   = $imagePath;
                        $questionToUpdate->question         = $request->question;
                        $questionToUpdate->type             = $request->type;
                        $questionToUpdate->term             = $request->term;
                        $questionToUpdate->subject_code_id  = $request->subject_code_id;
                        $questionToUpdate->editor_id        = $request->editor_id;
                        $questionToUpdate->save();

                        foreach($request->options as $option)
                        {
                            $answer = '';
                            if($option['isCorrect']=='true')
                            {
                                $answer = 'true';
                            }
                            else
                            {
                                $answer = 'false';
                            }

                            $optionToUpdate = Option::findOrFail($option['option_id']);

                            $optionToUpdate->option = $option['option'];
                            $optionToUpdate->isCorrect = $answer;
                            $optionToUpdate->save();
                        }

                        return redirect()->route('questions.show')->with('success', 'Question updated successfully.');

                    }
                    else
                    {
                        dd('attached image was deleted.');
                    }
                };
            }
            else
            {
                dd('existing question doesnt have attached_image');
            }
        }
        

        
        //dd($questionToUpdate->attached_image == $request->attached_image);
        
    }
    public function destroy($id)
    {
        $questionToDelete = Question::findOrFail($id);

        if($questionToDelete->type == 'text')
        {
            try{
                DB::beginTransaction();

                $optionToDelete = $questionToDelete->options;

                foreach($optionToDelete as $option)
                {
                    $option->delete();
                }

                if($questionToDelete->attached_image)
                {
                    $attachedImagePath = 'public/images/'.$questionToDelete->attached_image;
                    if(Storage::exists($attachedImagePath))
                    {
                         Storage::delete($attachedImagePath);
                    }
                }

                $questionToDelete->delete();

                DB::commit();

                return redirect()->back()->with('success', 'Successfully Deleted a Question.');
            }catch(\Exception $e)
            {
                DB::rollback();
                Log::error('error deleting question: '.$e->getMessage());

                return redirect()->back()->with('error', 'Failed to delete question. Please try again.');
            }
            
        }

        if($questionToDelete->type == 'image')
        {
            try{
                DB::beginTransaction();
                $optionToDelete = $questionToDelete->options;

                foreach($optionToDelete as $option)
                {
                    $imagePath = 'public/Images/'.$option->option; // Adjust 'images/' based on your file storage structure
                    if(Storage::exists($imagePath))
                    {
                         Storage::delete($imagePath);
                    }
                    
                    $option->delete();
                }

                if($questionToDelete->attached_image)
                {
                    $attachedImagePath = 'public/images/'.$questionToDelete->attached_image;
                    if(Storage::exists($attachedImagePath))
                    {
                         Storage::delete($attachedImagePath);
                    }
                }

                $questionToDelete->delete();

                DB::commit();

                return redirect()->back()->with('success', 'Successfully Deleted a Question.');
            }catch(\Exception $e)
            {
                DB::rollback();
                Log::error('error deleting question: '.$e->getMessage());

                return redirect()->back()->with('error', 'Failed to delete question. Please try again.');
            }
            
        }
    }
}
