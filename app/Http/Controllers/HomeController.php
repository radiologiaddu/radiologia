<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Study;
use Carbon\Carbon;
use App\Models\Record;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $id = auth()->user()->doctor->id;
        $doctor = Doctor::findOrFail($id);
        $studies = Study::where('doctor_id',$doctor->id)->with('appointment')->orderBy('created_at', 'DESC')->paginate(10);
        return view('dashboardDr', compact('studies'));
    }
}
