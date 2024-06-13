<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\V1\TaskFilter;
use App\Http\Requests\Api\V1\StoreTaskRequest;
use App\Http\Resources\V1\TaskResource;
use App\Models\AttechmentFile;
use App\Models\Note;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    
    public function index(TaskFilter $filters)
    {
        try {
            return TaskResource::collection(Task::with('notes')->filter($filters)->withCount('notes')->orderByRaw("FIELD(priority, 'High', 'Medium', 'Low')")->orderBy('notes_count', 'desc')->paginate());
        }catch (\Exception $e) {
            return response()->json(['success' => false, 'data' => ['message' => 'Please Try Again', 'error_message'=> $e->getMessage()]], 422);
        }
    }

    public function store(StoreTaskRequest $request)
    {
        try {
           
            $task_id = Task::insertGetId([ 'subject' => $request->subject , 'description' => $request->description , 'startDate' => $request->startDate , 'dueDate' => $request->dueDate , 'status' => $request->status , 'priority' => $request->priority , 'user_id' => Auth::user()->id]);
        
            foreach($request->notes as $noteData){
                    $note_id = Note::insertGetId(['subject' => $noteData['subject'] , 'note' => $noteData['note'] , 'task_id' => $task_id]);
                foreach ($noteData['attachments'] as $attachment) {
                    
                    AttechmentFile::create([ 'note_id' => $note_id , 'File' =>  $attachment->store('attachments') ]);
                }
            }
            return new TaskResource(Task::where('id' , $task_id)->with('notes')->first());
        }catch (\Exception $e) {
            return response()->json(['success' => false, 'data' => ['message' => 'Please Try Again', 'error_message'=> $e->getMessage()]], 422);
        }
    }
}
