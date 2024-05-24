<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Study;
use Carbon\Carbon;
use App\Models\Record;
use App\Models\Cupon;
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
    // Consultar los cupones del doctor con estatus activo
    $cupones = Cupon::where('id_doctor', $doctor->id)
                ->where('estatus', 'Activo')
                ->get();
    // Consultar los estudios del doctor
    $studies = Study::where('doctor_id', $doctor->id)
                    ->with('appointment')
                    ->orderBy('created_at', 'DESC')
                    ->paginate(6);
    return view('dashboardDr', compact('studies', 'cupones'));
}
}