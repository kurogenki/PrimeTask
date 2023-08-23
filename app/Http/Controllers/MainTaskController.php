<?php

namespace App\Http\Controllers;

use App\Enums\PriorityRank;
use App\Enums\TaskStatus;
use App\Models\MainTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MainTaskController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $taskStatuses = TaskStatus::getValues();
        $priorityRanks = PriorityRank::getValues();

        return Inertia::render('MainTask/IndexMainTask', [
            'maintasks' => MainTask::all()->where('user_id', $user->id),
            'user' => Auth::user(),
            'taskStatuses' => $taskStatuses,
            'priorityRanks' => $priorityRanks
        ]);
    }

    public function show($id) {
        $mainTask = MainTask::findOrFail($id);

        return Inertia::render('MainTask/ShowMainTask', ['maintask' => $mainTask]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'max:20']
        ]);

        $mainTask = new MainTask;
        $mainTask->user_id = Auth::user()->id;
        $mainTask->title = $request->title;
        $mainTask->priority_rank = $request->priorityRank;
        $mainTask->purpose = $request->purpose;
        $mainTask->status = $request->status;
        $mainTask->start_at = $request->startAt;
        $mainTask->finish_at = $request->finishAt;
        $mainTask->memo = $request->memo;
        $mainTask->save();

        return to_route('mainTask.index');
    }

    public function create()
    {
        return Inertia::render('MainTask/CreateMainTask');
    }

    public function update(Request $request, $id) {
        $mainTask = MainTask::findOrFail($id);

        $mainTask->title = $request->title;
        $mainTask->priority_rank = $request->priorityRank;
        $mainTask->purpose = $request->purpose;
        $mainTask->status = $request->status;
        $mainTask->start_at = $request->startAt;
        $mainTask->finish_at = $request->finishAt;
        $mainTask->memo = $request->memo;
        $mainTask->save();
        return to_route('mainTask.index') ->with([
        'message' => '更新しました。',
        'status' => 'success' ]);
    }

    public function delete($id)
    {
        $mainTask = MainTask::findOrFail($id);
        $mainTask->delete();

        return to_route('mainTask.index')->with(['message' => '削除しました。']);
    }
}
