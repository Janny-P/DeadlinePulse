<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Temporary authentication
    public function loginForm() {
        return view('auth.login');
    }

    public function login(Request $request) {
        // For temporary login, any credentials accepted
        $request->session()->put('logged_in', true);
        return redirect()->route('task.index');
    }

    public function signupForm() {
        return view('auth.signup');
    }

    public function signup(Request $request) {
        // Temporary signup just redirects
        return redirect()->route('login.form');
    }

    public function logout(Request $request) {
        $request->session()->flush();
        return redirect()->route('login.form');
    }

    // Dashboard with tasks including completed
    public function index(Request $request){
        $tasks = $request->session()->get('tasks', []);
        return view('tasks.index', compact('tasks'));
    }

    public function create(){ return view('tasks.create'); }

    public function store(Request $request){
        $request->validate([
            'title'=>'required','description'=>'required',
            'due_date'=>'required','due_time'=>'required','priority'=>'required'
        ]);

        $tasks = $request->session()->get('tasks', []);
        $tasks[] = [
            'title'=>$request->title,
            'description'=>$request->description,
            'due_date'=>$request->due_date,
            'due_time'=>$request->due_time,
            'priority'=>$request->priority,
            'completed'=>false,
        ];

        $request->session()->put('tasks', $tasks);
        return redirect()->route('task.index');
    }

    public function edit(Request $request,$index){
        $tasks = $request->session()->get('tasks', []);
        if(!isset($tasks[$index])) return redirect()->route('task.index');
        return view('tasks.edit',['task'=>$tasks[$index],'index'=>$index]);
    }

    public function update(Request $request,$index){
        $tasks = $request->session()->get('tasks', []);
        $tasks[$index] = [
            'title'=>$request->title,
            'description'=>$request->description,
            'due_date'=>$request->due_date,
            'due_time'=>$request->due_time,
            'priority'=>$request->priority,
            'completed'=>$tasks[$index]['completed']
        ];
        $request->session()->put('tasks',$tasks);
        return redirect()->route('task.index');
    }

    public function delete(Request $request,$index){
        $tasks = $request->session()->get('tasks', []);
        unset($tasks[$index]);
        $request->session()->put('tasks', array_values($tasks));
        return redirect()->route('task.index');
    }

    public function complete(Request $request,$index){
        $tasks = $request->session()->get('tasks', []);
        $tasks[$index]['completed']=true;
        $request->session()->put('tasks',$tasks);
        return redirect()->route('task.index');
    }

    public function view(Request $request,$index){
        $tasks = $request->session()->get('tasks', []);
        if(!isset($tasks[$index])) return redirect()->route('task.index');
        return view('tasks.view',['task'=>$tasks[$index]]);
    }

    public function search(Request $request){
        $tasks = $request->session()->get('tasks', []);
        $query = $request->input('query');

        if($query){
            $tasks = array_filter($tasks,function($task) use ($query){
                return stripos($task['title'],$query)!==false;
            });
        }

        return view('tasks.index',['tasks'=>$tasks]);
    }
    public function completedTasks(Request $request)
{
    // Get all tasks from session
    $tasks = $request->session()->get('tasks', []);

    // Filter only completed tasks
    $completedTasks = array_filter($tasks, function($task){
        return ($task['completed'] ?? false) == true;
    });

    return view('tasks.completed', ['tasks' => $completedTasks]);
}
}
