<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Study;
use App\Models\CFDI;
use App\Models\Record;
use App\Events\buyEvent;

class cashController extends Controller
{
    public function index()
    {
        $studies = Study::with('appointment','doctor')->where('status','Caja')->orderBy('created_at', 'DESC')->get();
        return view('dashboardCash',compact('studies'));
    }

    public function indexReload()
    {
        $studies = Study::with('appointment','doctor')->where('status','Caja')->orderBy('created_at', 'DESC')->get();
        
        $weekMap = [
            0 => 'Dom',
            1 => 'Lun',
            2 => 'Mar',
            3 => 'Mie',
            4 => 'Jue',
            5 => 'Vie',
            6 => 'Sáb',
        ];
        $months = [
            '01' => 'Enero',
            '02' => 'Febrero',
            '03' => 'Marzo',
            '04' => 'Abril',
            '05' => 'Mayo',
            '06' => 'Junio',
            '07' => 'Julio',
            '08' => 'Agosto',
            '09' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre',
        ];
        $opciones = '
        <table id="zero-configurationo" class="display table nowrap table-striped table-hover" style="width:100%">
            <thead>
                <tr>
                    <th class="tMovil">Folio</th>
                    <th>Paciente</th>
                    <th class="tMovil">Cita</th>
                    <th class="tMovil">Factura</th>
                    <th class="tMovil">Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>';
                foreach ($studies as $study){
                $opciones .= '
                <tr>
                    <td class="tMovil">';
                    if ($study->internal == 1){
                        $opciones .='R'.sprintf('%06d',$study->folio);
                    }else{
                        $opciones .='D'.sprintf('%06d',$study->folio);
                    }
                    $opciones .='</td>
                    <td>'.$study->patient_name.' '.$study->paternal_surname.' '.$study->maternal_surname.'</td>
                    <td class="tMovil">';
                        if (isset($study->appointment)){
                            $opciones .= '<span class="d-none">'.$study->appointment->date.' '.$study->appointment->time.'</span>';
                            $opciones .= 
                            $weekMap[strftime("%w",strtotime($study->appointment->date))].' '.
                            strftime("%d",strtotime($study->appointment->date)).' '.
                            strtoupper($months[strftime("%m",strtotime($study->appointment->date))]).' '.
                            strftime("%Y",strtotime($study->appointment->date)).
                            '<br>'.
                            $study->appointment->time;
                        }else{
                            $opciones .= 'Sin agendar cita';
                        }
                    $opciones .= '
                    </td>
                    <td class="tMovil">';
                        if (is_null($study->rfc)){
                            $opciones .= 'No solicitada';
                        }else{
                            $opciones .= 'Solicitada';
                        }
                    $opciones .= '
                    </td>
                    <td class="tMovil">'.
                        sprintf('$ %s', number_format($study->total, 2)).
                    '</td>
                    <td>
                        <a href="'.route('showStudyCaja',['id' => $study->id]).'"title="VER" class="label theme-bg text-white f-12 btn-rounded"><i class="feather icon-eye mr-0"></i></a>
                    </td>
                </tr>';
                }
            $opciones .= '
            </tbody>
        </table>';

        return $opciones;      
    }

    public function show($id)
    {
        $study = Study::with('appointment','doctor')->findOrFail($id);
        $cfdis = CFDI::all();

        $arrayStudies = [];
        foreach($study->study_type as $study_type){
            $arrayQuestions = [];
            $type = $study_type->type;
            foreach($study_type->type_question as $type_question){
                $arrayAnswer = [];
                $question = $type_question->question;
                if($question->kind == "texto"){
                    array_push($arrayAnswer,$type_question->answer);
                }else{
                    foreach($type_question->question_answer as $question_answer){
                        $answer = $question_answer->answer;
                        array_push($arrayAnswer,$answer->answer);
                    }
                }
                $objQuestion = (object)[
                    'question' => $question->question,
                    'answers' => $arrayAnswer,
                    'note' => $question->note,
                    'class_note' => $question->class_note,
                ];
                array_push($arrayQuestions,$objQuestion);
            }  
            $objStudy = (object)[
                'title' => $type->type,
                'questions' => $arrayQuestions,
                'note' => $type->note,
                'class_note' => $type->class_note,
            ];
        
            array_push($arrayStudies,$objStudy);
        }

        return view('showStudyCaja',compact('study','arrayStudies','cfdis'));
    }

    public function pay(Request $request)
    {
        $id = $request->id;
        $study = Study::with('appointment','doctor.user')->where('qr',$id)->first();
        if($study->status == 'Caja'){
            $study->status = 'Pagado';
            $study->payment = $request->payment;
            $study->detail = $request->detail;
            $study->save();
            $pay = "Marcó que el usuario pagó con: ". $request->payment;
            if(!is_null($request->detail)){
                $pay = $pay." ".$request->detail;
            }
            $newRecord = Record::create([
                'study_id' => $study->id,
                'action' => $pay,
                'user' => auth()->user()->name,
                'user_email' => auth()->user()->email,
                'folio' => $study->folio,

            ]);

            $arrayStudies = [];
            foreach($study->study_type as $study_type){
                $arrayQuestions = [];
                $type = $study_type->type;
                foreach($study_type->type_question as $type_question){
                    $arrayAnswer = [];
                    $question = $type_question->question;
                    if($question->kind == "texto"){
                        array_push($arrayAnswer,$type_question->answer);
                    }else{
                        foreach($type_question->question_answer as $question_answer){
                            $answer = $question_answer->answer;
                            array_push($arrayAnswer,$answer->answer);
                        }
                    }
                    $objQuestion = (object)[
                        'question' => $question->question,
                        'answers' => $arrayAnswer,
                        'note' => $question->note,
                        'class_note' => $question->class_note,
                    ];
                    array_push($arrayQuestions,$objQuestion);
                }  
                $objStudy = (object)[
                    'title' => $type->type,
                    'questions' => $arrayQuestions,
                    'note' => $type->note,
                    'class_note' => $type->class_note,
                ];
            
                array_push($arrayStudies,$objStudy);
            }

            $info = (object) [
                'study' => $study,
                'arrayStudies' => $arrayStudies,
                'old' => $study->edad()  + 0

            ];
            event(new buyEvent($info));
            return true;
        }
        return false;
    }
}
