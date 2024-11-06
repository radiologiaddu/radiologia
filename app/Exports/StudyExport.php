<?php
namespace App\Exports;
use App\Models\Study;
use App\Models\Record;
use App\Models\Type;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class StudyExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'FECHA',
            'FOLIO',
            'SAE',
            'PACIENTE',
            'TELEFONO',
            'CANTIDAD',
            'ESTUDIO',
            'SUBTOTAL',
            'DESCUENTO',
            'TOTAL',
            'DOCTOR',
            'RADIOLOGO',
            'HORA DE INICIO',
            'HORA DE TÉRMINO',
            'OBSERVACIONES',
            'CORREO DR.',
            'TELEFONO DR.',
            'REFERIDOR',
            'ESTATUS'
        ];
    }
    public function collection()
    {
        $arrayStudies = [];
        $horaFin = '';
        $studies = Study::with('appointment', 'doctor')
            ->where('status', 'Enviado')
            ->orderBy('created_at', 'DESC')
            ->orderBy('date', 'DESC')
            ->take(200)
            ->get();

        foreach ($studies as $study){
            $record = Record::where('study_id',$study->id)->where('action','El estudio ha sido terminado')->first();
            if(is_null($study->date)){
                if(!is_null($record)){
                    $fecha1 = date_create($record->created_at);
                    $date = $fecha1->format('Y-m-d H:m');
                    $horaFin = $fecha1->format('H:m');
                }
            }else{
                $fecha1 = date_create($study->date);
                $date = $fecha1->format('Y-m-d').' '.$study->time;
                if(!is_null($record)){
                    $fechaFin = date_create($record->created_at);
                    $horaFin = $fechaFin->format('H:m');
                }
            }
            if ($study->internal == 1)
                $folio = "R".sprintf('%06d',$study->folio);
            else{
                $folio = "D".sprintf('%06d',$study->folio);
            }
            if ($study->doctor_id == 0){
                $doctor = $study->doctor_name;
                $doctorMail = $study->doctor_email;
                $doctorPhone = "";
            }
            else{
                if(!is_null($study->doctor)){
                    $doctor = $study->doctor->user->name.' '.$study->doctor->paternalSurname.' '.$study->doctor->maternalSurname;
                    $doctorMail = $study->doctor->user->email;
                    $doctorPhone = $study->doctor->phone;
                }else{
                    $doctor = null;
                    $doctorMail = null;
                    $doctorPhone = null;
                }
            }
            $estudios = "";
            foreach($study->study_type as $study_type){
                foreach($study_type->type_question as $type_question){
                    foreach($type_question->question_answer as $question_answer){
                        $answer = $question_answer->answer;
                        $total = $answer->cost-($answer->cost*$study->discount/100);
                        if(!is_null($answer->study_time)){
                            $objStudy = (object)[
                                'FECHA' => $date,
                                'FOLIO' => $folio,
                                'SAE' => $study->sae,
                                'PACIENTE' => $study->patient_name.' '.$study->paternal_surname.' '.$study->maternal_surname,
                                'TELEFONO' => $study->patient_phone,
                                'CANTIDAD' => 1,
                                'ESTUDIO'  => $answer->answer,
                                'SUBTOTAL'  => sprintf('$ %s', number_format($answer->cost, 2))." MXN.",
                                'DESCUENTO' => $study->discount."%",
                                'TOTAL'  => sprintf('$ %s', number_format($total, 2))." MXN.",
                                'DOCTOR'  => $doctor,
                                'RADIOLOGO'  => $study->radiologist,
                                'HORA DE INICIO' => $study->time,
                                'HORA DE TÉRMINO' => $horaFin,
                                'OBSERVACIONES'  => $study->observations,
                                'CORREO DR.' => $doctorMail ,
                                'TELEFONO DR.'  => $doctorPhone,
                                'REFERIDOR'  => $study->referral,
                                'ESTATUS'  => $study->status
                            ];
                            array_push($arrayStudies,$objStudy);
                        }
                    }
                }
            }
        }
        $collection = collect($arrayStudies);
        return  $collection->sortByDesc('FECHA');
    }
}