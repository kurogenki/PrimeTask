<?php

namespace App\Http\Controllers;

use App\Enums\PriorityRank;
use App\Enums\TaskStatus;
use App\Models\MainTask;
use Carbon\Carbon;
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
            'maintasks' => MainTask::where('user_id', $user->id)
                    ->orderByRaw("FIELD(status, '".TaskStatus::NOT_STARTED."', '".TaskStatus::WORKING."', '".TaskStatus::COMPLETED."')")
                    ->get(),
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
            'title' => ['required']
        ]);

        $mainTask = new MainTask;
        $mainTask->user_id = Auth::user()->id;
        $mainTask->title = $request->title;
        $mainTask->priority_rank = $request->priority_rank;
        $mainTask->purpose = $request->purpose;
        $mainTask->status = $request->status ?? TaskStatus::NOT_STARTED;
        $mainTask->start_day = $request->start_day;
        $mainTask->finish_day = $request->finish_day;
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
        $mainTask->priority_rank = $request->priority_rank;
        $mainTask->purpose = $request->purpose;
        $mainTask->status = $request->status ?? TaskStatus::NOT_STARTED;
        $mainTask->start_day = $request->start_day;
        $mainTask->finish_day = $request->finish_day;
        $mainTask->memo = $request->memo;
        $mainTask->save();
        return to_route('mainTask.index') ->with([
        'message' => '更新しました。',
        'status' => 'success' ]);
    }

    public function destroy($id)
    {
        $mainTask = MainTask::findOrFail($id);
        $mainTask->delete();

        return to_route('mainTask.index')->with(['message' => '削除しました。']);
    }

    public function finishMainTask($id)
    {
        $mainTask = MainTask::findOrFail($id);
        $mainTask->update([
            'status' => TaskStatus::COMPLETED,
            'finish_day' => Carbon::now()
        ]);
        $mainTask->save();

        return to_route('mainTask.index')->with(['message' => 'タスクの状態を完了に変更しました。']);
    }
}
