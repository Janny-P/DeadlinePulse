<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    // ===== AUTHENTICATION =====
    
    public function login_form()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::where('email', $request->email)->first();
        
        if (!$user || !Hash::check($request->password, $user->password)) {
            return redirect()->back()->with('error', 'Invalid email or password');
        }

        // Log in without using built-in auth (session-based manual login)
        $request->session()->put('user_id', $user->id);
        $request->session()->put('logged_in', true);
        $request->session()->put('user_email', $user->email);

        return redirect()->route('task.index')->with('success', 'Logged in successfully');
    }

    public function signup_form()
    {
        return view('auth.signup');
    }

    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Email verification (log to file for now)
        Log::info("Email verification for: {$user->email}");

        $request->session()->put('user_id', $user->id);
        $request->session()->put('logged_in', true);
        $request->session()->put('user_email', $user->email);

        return redirect()->route('task.index')->with('success', 'Account created and logged in');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('task.login_form')->with('success', 'Logged out');
    }

    // ===== USER PROFILE =====

    public function profile()
    {
        if (!session('logged_in')) {
            return redirect()->route('task.login_form');
        }

        $user = User::find(session('user_id'));
        return view('auth.profile', compact('user'));
    }

    public function profile_update(Request $request)
    {
        if (!session('logged_in')) {
            return redirect()->route('task.login_form');
        }

        $user = User::find(session('user_id'));

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $file = $request->file('avatar');
            $fileName = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $user->avatar = $file->storeAs('avatars', $fileName, 'public');
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($user->avatar) {
            $user->save();
        }

        return redirect()->route('task.profile')->with('success', 'Profile updated');
    }

    // ===== TASK CRUD =====

    public function index(Request $request)
    {
        if (!session('logged_in')) {
            return redirect()->route('task.login_form');
        }

        $search = $request->input('search');
        $status = $request->input('status');
        $priority = $request->input('priority');
        $due_date = $request->input('due_date');

        $query = Task::where('user_id', session('user_id'));

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereJsonContains('tags', $search);
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($priority) {
            $query->where('priority', $priority);
        }

        if ($due_date) {
            $query->whereDate('due_at', $due_date);
        }

        $tasks = $query->orderBy('due_at', 'asc')->paginate(10)->withQueryString();

        return view('tasks.index', compact('tasks', 'search', 'status', 'priority', 'due_date'));
    }

    public function create()
    {
        if (!session('logged_in')) {
            return redirect()->route('task.login_form');
        }

        return view('tasks.create');
    }

    public function store(Request $request)
    {
        if (!session('logged_in')) {
            return redirect()->route('task.login_form');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_at' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
            'tags' => 'nullable|string',
            'attachment' => 'nullable|file|max:5120'
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $attachmentPath = $file->storeAs('tasks', $fileName, 'public');
        }

        Task::create([
            'user_id' => session('user_id'),
            'title' => $request->title,
            'description' => $request->description,
            'due_at' => $request->due_at ?: null,
            'priority' => $request->priority,
            'tags' => $request->tags ? array_map('trim', explode(',', $request->tags)) : null,
            'attachment' => $attachmentPath,
            'status' => 'pending',
        ]);

        return redirect()->route('task.index')->with('success', 'Task created successfully');
    }

    public function show(Task $task)
    {
        if (!session('logged_in') || $task->user_id !== session('user_id')) {
            return redirect()->route('task.login_form');
        }

        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        if (!session('logged_in') || $task->user_id !== session('user_id')) {
            return redirect()->route('task.login_form');
        }

        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        if (!session('logged_in') || $task->user_id !== session('user_id')) {
            return redirect()->route('task.login_form');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_at' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
            'tags' => 'nullable|string',
            'attachment' => 'nullable|file|max:5120',
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        if ($request->hasFile('attachment')) {
            if ($task->attachment) {
                Storage::disk('public')->delete($task->attachment);
            }
            $file = $request->file('attachment');
            $fileName = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $task->attachment = $file->storeAs('tasks', $fileName, 'public');
        }

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'due_at' => $request->due_at ?: null,
            'priority' => $request->priority,
            'tags' => $request->tags ? array_map('trim', explode(',', $request->tags)) : null,
            'status' => $request->status,
        ]);

        return redirect()->route('task.show', $task)->with('success', 'Task updated');
    }

    public function destroy(Task $task)
    {
        if (!session('logged_in') || $task->user_id !== session('user_id')) {
            return redirect()->route('task.login_form');
        }

        if ($task->attachment) {
            Storage::disk('public')->delete($task->attachment);
        }

        $task->delete();
        return redirect()->route('task.index')->with('success', 'Task deleted');
    }

    public function toggleStatus(Task $task)
    {
        if (!session('logged_in') || $task->user_id !== session('user_id')) {
            return redirect()->route('task.login_form');
        }

        $task->status = ($task->status === 'completed') ? 'pending' : 'completed';
        $task->save();
        return redirect()->back();
    }

    public function completed()
    {
        if (!session('logged_in')) {
            return redirect()->route('task.login_form');
        }

        $tasks = Task::where('user_id', session('user_id'))
            ->where('status', 'completed')
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('tasks.completed', compact('tasks'));
    }

    public function downloadAttachment(Task $task)
    {
        if (!session('logged_in') || $task->user_id !== session('user_id')) {
            return redirect()->route('task.login_form');
        }

        if (!$task->attachment) {
            return redirect()->back()->with('error', 'No attachment found');
        }

        $filePath = storage_path('app/public/' . $task->attachment);
        return Response::download($filePath);
    }

    public function viewAttachment(Task $task)
    {
        if (!session('logged_in') || $task->user_id !== session('user_id')) {
            return redirect()->route('task.login_form');
        }

        if (!$task->attachment) {
            return redirect()->back()->with('error', 'No attachment found');
        }

        $filePath = storage_path('app/public/' . $task->attachment);
        $mimeType = mime_content_type($filePath);

        // For images and PDFs, display inline. For others, download.
        if (str_starts_with($mimeType, 'image/') || str_starts_with($mimeType, 'application/pdf')) {
            return response()->file($filePath, ['Content-Type' => $mimeType]);
        }

        return Response::download($filePath);
    }
}
