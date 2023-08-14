<?php

namespace App\Http\Controllers;

use App\Models\MainTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MainTaskController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return Inertia::render('Toppage', ['maintasks' => MainTask::all()->where('user_id', $user->id), 'user' => Auth::user()]);
    }

    public function store(Request $request)
    {
        $mainTask = new MainTask;
        $mainTask->user_id = Auth::user()->id;
        $mainTask->title = $request->title;
        $mainTask->purpose = $request->purpose;
        $mainTask->save();

        return to_route('toppage');
    }

    public function create()
    {
        return Inertia::render('CreateTask');
    }
}
