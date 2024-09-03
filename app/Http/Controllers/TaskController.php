<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarCorreo;
use App\Mail\TaskReminder;
use App\Models\Task;
use phpDocumentor\Reflection\PseudoTypes\True_;
use Carbon\Carbon; 

class TaskController extends Controller
{
    public $Tasks;


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Tasks = Task::all();
        return view('TaskView.index', compact('Tasks')); // Pasa ambas variables a la vista
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'priority' => 'required|integer|min:1|max:3',
            'due_time' => 'nullable|date_format:H:i', 
            'due_date' => 'nullable|date',
        ]);

        $data = $request->all();
        $data['due_time'] = Carbon::createFromFormat('H:i', $request->input('due_time'))->format('H:i');
        $task = Task::create($data);    

       

        return redirect()->route('Tasks.index')->with('success', 'Task created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, Request $request)
    {
        $task = Task::findOrFail($id);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'priority' => 'required|integer|min:1|max:3',
            'due_time' => 'nullable|date_format:H:i', 
            'due_date' => 'nullable|date',
        ]);
    
        $task = Task::findOrFail($id);
        $data = $request->all();
    
        if ($request->has('due_time')) {
            $data['due_time'] = Carbon::createFromFormat('H:i', $request->input('due_time'))->format('H:i');
        }
    
        if ($request->has('due_date')) {
            $data['due_date'] = Carbon::createFromFormat('d-m-Y', $request->input('due_date'))->format('d-m-Y');
        }
    
        $task->update($data);
        
        return redirect()->route('Tasks.index')->with('success', 'Task updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        if ($task) {
            $task->delete();
            return redirect()->route('Tasks.index')->with('success', 'Task deleted successfully.');
        } else {
            return redirect()->route('Tasks.index')->with('error', 'Task not found.');
        }
    }

    
}
