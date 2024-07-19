<?php

namespace App\Http\Controllers;

use App\Models\DoctorReport;
use Illuminate\Http\Request;

class DoctorReportController extends Controller
{
    public function updateStatus(Request $request, $id)
    {
        $report = DoctorReport::find($id);
        $report->status = $request->status;
        $report->save();

        return response()->json(['message' => 'Status updated successfully.']);
    }

    public function create(Request $request)
    {
        $report = DoctorReport::create([
            'user_id' => $request->user_id,
            'doctor_id' => $request->doctor_id,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'Report created successfully.', 'report' => $report]);
    }
}
