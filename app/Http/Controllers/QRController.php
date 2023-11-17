<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Study;
use App\Models\Record;
use App\Events\checkEvent;

class QRController extends Controller
{
    public function index($id)
    {
        $user = auth()->user();
        if(is_null($user)){
            $permiso = false;
            return view('error',compact('permiso'));
        }else{
            $roles = $user->getRoleNames();
            if($roles[0] == "Hostess"){
                $study = Study::where('qr',$id)->first();
                if(is_null($study)){
                    $permiso = true;
                    return view('error',compact('permiso'));
                }else{
                    return redirect()->route('statusAppointment',['id' => $id]);
                }
            }else{
                $permiso = false;
                return view('error',compact('permiso'));
            }
        }
    }

    public function change(Request $request)
    {
        $id = $request->id;
        $study = Study::where('qr',$id)->with('appointment')->first();
        switch($study->status){
            case 'Creado':                 
                $study->status = 'Llegada';
                $study->save();
                $newRecord = Record::create([
                    'study_id' => $study->id,
                    'action' => "Ha marcado que el usuario ha llegado.",
                    'user' => auth()->user()->name,
                    'user_email' => auth()->user()->email,
                    'folio' => $study->folio,
                ]);
                event(new checkEvent());
                return true;
                break;
            case 'Agendado':
                $study->status = 'Llegada';
                $study->save();
                $newRecord = Record::create([
                    'study_id' => $study->id,
                    'action' => "Ha marcado que el usuario ha llegado.",
                    'user' => auth()->user()->name,
                    'user_email' => auth()->user()->email,
                    'folio' => $study->folio,
                ]);
                event(new checkEvent());
                return true;
            default:
                return false;
                break;
        }
    }
    public function status($id)
    {
        $study = Study::where('qr',$id)->with('appointment','doctor')->first();
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

        return view('statusAppointment',compact('study','arrayStudies'));
    }
}
