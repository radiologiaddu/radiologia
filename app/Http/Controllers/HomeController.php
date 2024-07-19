<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Study;
use Carbon\Carbon;
use App\Models\Record;
use App\Models\Cupon;
use App\Models\DoctorReport;

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
    /* Editado para actualizar
    public function index()
    {
        $id = auth()->user()->doctor->id;
        $doctor = Doctor::findOrFail($id);
        $studies = Study::where('doctor_id',$doctor->id)->with('appointment')->orderBy('created_at', 'DESC')->paginate(10);
        return view('dashboardDr', compact('studies'));
    }*/

public function index()
{
    $id = auth()->user()->doctor->id;
    $doctor = Doctor::findOrFail($id);

    // Consultar el estado de doctor_reports para el doctor activo
    $doctorReport = DoctorReport::where('doctor_id', $doctor->id)
                               ->value('status');

    // Consultar los cupones del doctor con estatus activo
    $cupones = Cupon::where('id_doctor', $doctor->id)
                    ->where('estatus', 'Activo')
                    ->get();

    // Consultar los estudios del doctor
    $studies = Study::where('doctor_id', $doctor->id)
                    ->with('appointment')
                    ->orderBy('created_at', 'DESC')
                    ->paginate(6);

    // Calcular el monto total de los estudios para el año actual
    $currentYear = Carbon::now()->year;
    $startOfYear = Carbon::create($currentYear, 1, 1)->startOfDay();
    $endOfYear = Carbon::create($currentYear, 12, 31)->endOfDay();

    $totalSum = Study::where('doctor_id', $doctor->id)
                     ->whereBetween('date', [$startOfYear, $endOfYear])
                     ->sum('total');

    $totalSumFormatted = number_format($totalSum, 2, ',', '.');
    $annualReturn = $totalSum * 0.02;
    $annualReturnFormatted = number_format($annualReturn, 2, ',', '.');

    return view('dashboardDr', compact('studies', 'cupones', 'doctorReport', 'totalSumFormatted', 'annualReturnFormatted'));
}

}