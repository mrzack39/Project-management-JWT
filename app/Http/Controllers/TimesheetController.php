<?php

namespace App\Http\Controllers;

use App\Models\Timesheet;
use Illuminate\Http\Request;
use Validator;

class TimesheetController extends Controller
{
    // Create a Timesheet
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'project_id' => 'required|exists:projects,id',
            'task_name' => 'required|string',
            'date' => 'required|date',
            'hours' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $timesheet = Timesheet::create($request->all());
        return response()->json($timesheet, 201);
    }

    // Read a Timesheet
    public function show($id)
    {
        $timesheet = Timesheet::find($id);
        if (!$timesheet) {
            return response()->json(['message' => 'Timesheet not found'], 404);
        }
        return response()->json($timesheet);
    }

    // Read all Timesheets
    public function index(Request $request)
    {
        $query = Timesheet::query();

        // Filtering logic
        if ($request->has('filter')) {
            foreach ($request->filter as $key => $value) {
                $query->where($key, $value);
            }
        }

        $timesheets = $query->get();
        return response()->json($timesheets);
    }

    // Update a Timesheet
    public function update(Request $request, $id)
    {
        $timesheet = Timesheet::find($id);
        if (!$timesheet) {
            return response()->json(['message' => 'Timesheet not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'sometimes|required|exists:users,id',
            'project_id' => 'sometimes|required|exists:projects,id',
            'task_name' => 'sometimes|required|string',
            'date' => 'sometimes|required|date',
            'hours' => 'sometimes|required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $timesheet->update($request->all());
        return response()->json($timesheet);
    }

    // Delete a Timesheet
    public function destroy($id)
    {
        $timesheet = Timesheet::find($id);
        if (!$timesheet) {
            return response()->json(['message' => 'Timesheet not found'], 404);
        }

        $timesheet->delete();
        return response()->json(['message' => 'Timesheet deleted successfully']);
    }
}
