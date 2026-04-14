<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\WorkSchedule;
use Illuminate\Http\Request;

class WorkScheduleController extends Controller
{
    public function edit()
    {
        $schedule = WorkSchedule::orderBy('day_of_week')->get();
        return view('admin.settings.schedule', compact('schedule'));
    }

    public function update(Request $request)
    {
        foreach ($request->days as $dayId => $data) {
            WorkSchedule::where('id', $dayId)->update([
                'open_time' => $data['open_time'] ?? null,
                'close_time' => $data['close_time'] ?? null,
                'is_working' => isset($data['is_working']) ? 1 : 0,
            ]);
        }
        return redirect()->route('admin.schedule')->with('success', 'Program salvat!');
    }
}
