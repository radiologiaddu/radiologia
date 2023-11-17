<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Study;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Hour;
use App\Models\Appointment;
use App\Models\CFDI;
use App\Models\Tax;
use App\Models\Record;
use App\Models\Doctor;
use App\Models\Type;
use App\Models\Question;
use App\Models\Answer;

use App\Events\hostEvent;

use Carbon\Carbon;

class StudyController extends Controller
{
    public function index($id)
    {
        $study = Study::where('qr',$id)->first();

        if($study->status == "Agendado"){
            $newAppointment = Appointment::where('study_id',$study->id)->first();
            $success=false;
            return view('successAppointment',compact('newAppointment','success','study'));
        }
        return view('appointment',compact('study'));        
    }
    public function showDetails($id)
    {
        $study = Study::where('qr',$id)->first();
        $doctor = Doctor::where('id',$study->doctor_id)->first();
        //dd($study->doctor_id);
        $arrayStudies = [];
        foreach ($study->study_type as $study_type) {
            $findType = Type::findOrFail($study_type->type_id);
            $arrayQuestions = [];
            foreach ($study_type->type_question as $type_question) {
                $findQuestion = Question::findOrFail($type_question->question_id);
                $arrayAnswer = [];

                if($findQuestion->kind == "texto"){
                    array_push($arrayAnswer,$type_question->answer);
                }else{
                    foreach($type_question->question_answer as $question_answer){
                        $findAnswer = Answer::findOrFail($question_answer->answer_id);
                        array_push($arrayAnswer,$findAnswer->answer);
                    }
                }

                $objQuestion = (object)[
                    'question' => $findQuestion->question,
                    'answers' => $arrayAnswer,
                    'note' => $findQuestion->note,
                    'class_note' => $findQuestion->note,
                ];
                array_push($arrayQuestions,$objQuestion);
            }
            $objStudy = (object)[
                'title' => $findType->type,
                'questions' => $arrayQuestions,
                'note' => $findType->note,
                'class_note' => $findType->class_note,
            ];
        
            array_push($arrayStudies,$objStudy);

        }
    
        $details = [
            'qr' => $study->qr,
            'name' => $study->patient_name,
            'doctor' => $doctor->alias,
            'studies' => $arrayStudies,///
            'notes' => $study->observations,
            'duration' => $study->duration, 
            'total' => sprintf('$ %s', number_format($study->total, 2))
        ];

        return view('newStudyMail',compact('details'));
    }

    public function success($id)
    {
        $study = Study::where('qr',$id)->first();
        $newAppointment = Appointment::where('study_id',$study->id)->first();
        $success=true;
        return view('successAppointment',compact('newAppointment','success','id','study'));
    }

    public function invoice($id)
    {
        $study = Study::where('qr',$id)->first();
        $cfdis = CFDI::all();
        $taxes = Tax::all();
        return view('invoice',compact('study','cfdis','taxes'));
    }

    public function addInvoice(Request $request, $id)
    { 
        $study = Study::findOrFail($id);
        $study->rfc  = strtoupper($request->rfc);
        $study->company_name  = strtoupper($request->razon);
        $study->address  = "No requerido";
        $study->CFDI  = $request->cfdi;
        $study->tax  = $request->tax;
        $study->cp  = $request->cp;
        $study->save();
        $newRecord = Record::create([
            'study_id' => $study->id,
            'action' => "El usuario agregó sus datos de facturación.",
            'user' => $study->patient_name,
            'user_email' => $study->patient_email,
            'folio' => $study->folio,
        ]);

        return redirect()->route('appointment', $study->qr);
    }
    
    public function store(Request $request, $id)
    {   
        $study = Study::findOrFail($id);
        $study->status  = "Agendado";
        
        $newAppointment = Appointment::create([
            'study_id' => $study->id,
            'date' => $request->personal_date,
            'time' => $request->hour,
        ]);

        $study->save();
        $newRecord = Record::create([
            'study_id' => $study->id,
            'action' => "El usuario agendó cita.",
            'user' => $study->patient_name,
            'user_email' => $study->patient_email,
            'folio' => $study->folio,
        ]);
        event(new hostEvent());

        return redirect()->route('successAppointment', $study->qr);

    }

    public function getHour(Request $request)
    {
        $fecha1 = date_create($request->fecha);
        $dias = array("Zero","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado","Domingo");
        $mytime = Carbon::now()->timezone("America/Mexico_City");
        $today = $mytime->toDateString();
        $send = $fecha1->format('Y-m-d');

        $numberM = $fecha1->format('n');
        $schedules = Schedule::all();
        $id_schedule = 0;
        foreach($schedules as $schedule){
            if($schedule->start <= $schedule->end){
                if($numberM >= $schedule->start && $numberM <= $schedule->end){
                    $id_schedule = $schedule->id;
                }
            }else{
                if($numberM >= $schedule->start || $numberM <= $schedule->end){
                    $id_schedule = $schedule->id;
                }
            }
            
        }

        $horas = Hour::where('schedule_id',$id_schedule)->get();
        $numberWeek = $fecha1->format('N');//Dia de la semana
        $opciones = '<option value="" selected disabled>Selecciona un horario</option>';

        foreach($horas as $hora){
            $index_start = array_search($hora->start,$dias);
            $index_end = array_search($hora->end,$dias);
            $flag = false;
            if($index_start <= $index_end){
                if($numberWeek >= $index_start && $numberWeek <= $index_end){
                    $flag = true;    
                }
            }else{
                if($numberWeek >= $index_end || $numberWeek <= $index_start){
                    $flag = true;    
                }
            }

            if($flag){
                $hora_inicio = date_create($hora->start_time);
                $hora_fin = date_create($hora->end_time);
                $hora_fin->modify('-30 minute'); 
                if($today === $send ){
                    $now = date_create($mytime->format('H:i'));
                    while($hora_inicio < $now){
                        $hora_inicio->modify('+15 minute'); 
                    }
                }
                while($hora_inicio <= $hora_fin){
                    $opciones .= '<option value="'.$hora_inicio->format('H:i').'">'.$hora_inicio->format('H:i').'</option>';
                    $hora_inicio->modify('+15 minute'); 
                }
                return $opciones; 
            }
        }

        return $opciones;      
    }
}