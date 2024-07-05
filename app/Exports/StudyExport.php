<?php
namespace App\Exports;
use App\Models\Study;
use App\Models\Record;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class StudyExport implements FromCollection, WithHeadings
{
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
        $currentYear = Carbon::now()->year;
        $studies = Study::with(['appointment', 'doctor', 'study_type.type_question.question_answer.answer'])
                        ->where('status', 'Enviado')
                        ->whereYear('created_at', $currentYear)
                        ->orderBy('created_at', 'DESC')
                        ->orderBy('date', 'DESC')
                        ->get();
        $exportData = [];
        foreach ($studies as $study) {
            $record = $study->records()->where('action', 'El estudio ha sido terminado')->first();
            $date = $study->date ? Carbon::createFromFormat('Y-m-d H:i:s', $study->date . ' ' . $study->time) : Carbon::createFromFormat('Y-m-d H:i:s', $record->created_at);
            $horaFin = $record ? Carbon::createFromFormat('Y-m-d H:i:s', $record->created_at)->format('H:i') : '';
            $folio = $study->internal == 1 ? 'R' . sprintf('%06d', $study->folio) : 'D' . sprintf('%06d', $study->folio);
            if ($study->doctor_id == 0) {
                $doctor = $study->doctor_name;
                $doctorMail = $study->doctor_email;
                $doctorPhone = '';
            } else {
                $doctor = optional($study->doctor)->user->name . ' ' . optional($study->doctor)->paternalSurname . ' ' . optional($study->doctor)->maternalSurname;
                $doctorMail = optional($study->doctor)->user->email;
                $doctorPhone = optional($study->doctor)->phone;
            }
            foreach ($study->study_type as $studyType) {
                foreach ($studyType->type_question as $typeQuestion) {
                    foreach ($typeQuestion->question_answer as $questionAnswer) {
                        $answer = $questionAnswer->answer;
                        $total = $answer->cost - ($answer->cost * $study->discount / 100);
                        $exportData[] = [
                            'FECHA' => $date->format('Y-m-d H:i'),
                            'FOLIO' => $folio,
                            'SAE' => $study->sae,
                            'PACIENTE' => $study->patient_name . ' ' . $study->paternal_surname . ' ' . $study->maternal_surname,
                            'TELEFONO' => $study->patient_phone,
                            'CANTIDAD' => 1,
                            'ESTUDIO' => $answer->answer,
                            'SUBTOTAL' => '$ ' . number_format($answer->cost, 2) . ' MXN.',
                            'DESCUENTO' => $study->discount . '%',
                            'TOTAL' => '$ ' . number_format($total, 2) . ' MXN.',
                            'DOCTOR' => $doctor,
                            'RADIOLOGO' => $study->radiologist,
                            'HORA DE INICIO' => $study->time,
                            'HORA DE TÉRMINO' => $horaFin,
                            'OBSERVACIONES' => $study->observations,
                            'CORREO DR.' => $doctorMail,
                            'TELEFONO DR.' => $doctorPhone,
                            'REFERIDOR' => $study->referral,
                            'ESTATUS' => $study->status,
                        ];
                    }
                }
            }
        }
        return new Collection($exportData);
    }
}