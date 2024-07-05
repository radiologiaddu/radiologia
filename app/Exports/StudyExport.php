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
        // Obtener el año actual
        $currentYear = Carbon::now()->year;

        // Consulta para obtener los estudios con sus relaciones cargadas
        $studies = Study::with(['appointment', 'doctor.user', 'study_type.type_question.question_answer.answer'])
                        ->where('status', 'Enviado')
                        ->whereYear('created_at', $currentYear)
                        ->orderByDesc('created_at')
                        ->orderByDesc('date')
                        ->get();

        $exportData = [];

        foreach ($studies as $study) {
            // Obtener el registro relacionado si existe
            $record = Record::where('study_id', $study->id)
                           ->where('action', 'El estudio ha sido terminado')
                           ->first();

            // Determinar la fecha y hora de término del estudio
            if ($study->date) {
                $date = Carbon::createFromFormat('Y-m-d H:i:s', $study->date . ' ' . $study->time);
            } elseif ($record) {
                $date = Carbon::createFromFormat('Y-m-d H:i:s', $record->created_at);
            } else {
                $date = null; // Manejar el caso donde no hay fecha válida
            }

            // Formatear la hora de término
            $horaFin = $record ? Carbon::createFromFormat('Y-m-d H:i:s', $record->created_at)->format('H:i') : '';

            // Determinar el folio del estudio
            $folio = $study->internal == 1 ? 'R' . sprintf('%06d', $study->folio) : 'D' . sprintf('%06d', $study->folio);

            // Determinar el nombre del doctor, correo y teléfono
            if ($study->doctor_id == 0) {
                $doctor = $study->doctor_name;
                $doctorMail = $study->doctor_email;
                $doctorPhone = "";
            } else {
                $doctor = optional($study->doctor)->user->name . ' ' . optional($study->doctor)->paternalSurname . ' ' . optional($study->doctor)->maternalSurname;
                $doctorMail = optional($study->doctor->user)->email;
                $doctorPhone = optional($study->doctor)->phone;
            }

            // Iterar sobre los tipos de estudio, preguntas y respuestas
            foreach ($study->study_type as $studyType) {
                foreach ($studyType->type_question as $typeQuestion) {
                    foreach ($typeQuestion->question_answer as $questionAnswer) {
                        $answer = $questionAnswer->answer;
                        $total = $answer->cost - ($answer->cost * $study->discount / 100);

                        // Construir el objeto de estudio para exportar
                        $exportData[] = [
                            'FECHA' => $date ? $date->format('Y-m-d H:i') : '',
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

        // Crear una colección de datos exportables y ordenar por fecha descendente
        return new Collection($exportData);
    }
}
