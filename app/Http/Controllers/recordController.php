<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Record;
use App\Models\Study;
use App\Models\Question_answer;
use App\Exports\StudyExport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Facades\Excel;

class recordController extends Controller
{
    //
    public function records($id)
    {
        $study = Study::findOrFail($id);
        $records = Record::where('study_id',$study->id)->orderBy('created_at', 'DESC')->get();
        return view('recordsAdmin',compact('records','id','study'));        
    }

    public function recordsRec($id)
    {
        $records = Record::where('study_id', $study->id)
        ->orderBy('created_at', 'DESC')
        ->paginate(50); // Muestra 50 registros por página
        return view('recordsRec', compact('records', 'id', 'study'));
      
    }
    
    public function recordsCoo($id)
    {
        $study = Study::findOrFail($id);
        $records = Record::where('study_id',$study->id)->orderBy('created_at', 'DESC')->get();
        return view('recordsCoo',compact('records','id','study'));        
    }

    public function all()
    {
        $studies = Study::with('appointment','doctor')->where('status','Enviado')->orderBy('created_at', 'DESC')->get();
        return view('allRecord',compact('studies'));
    }
    public function allReload()
    {
        $studies = Study::with('appointment','doctor')->where('status','Enviado')->orderBy('created_at', 'DESC')->get();
        
        $opciones = '
        <table id="zero-configurationo" class="display table nowrap table-striped table-hover" style="width:100%">
            <thead>
                <tr>
                    <th class="tMovil">Folio</th>
                    <th class="tMovil">SAE</th>
                    <th>Paciente</th>
                    <th class="tMovil">Recibido hace</th>
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
                
                    <td class="tMovil">'.$study->sae.'</td>
                    <td>'.$study->patient_name.' '.$study->paternal_surname.' '.$study->maternal_surname.'</td>
                    <td class="tMovil">';
                        $opciones .= '<span class="d-none">'.$study->created_at.'</span>';
                        if (($study->dias() + 0) == 0){
                            if (($study->horas() + 0) == 0){
                                $opciones .=  $study->minutos() + 0 .'Minutos';
                            }else{
                                $opciones .= $study->horas() + 0 . 'Horas';
                            }
                        }else{
                            $opciones .= $study->dias() + 0 . 'Días';
                        }  
                    $opciones .=  
                    '</td>
                    <td>
                        <a href="'.route('seeStudy',['id' => $study->id]).'"title="VER" class="label theme-bg text-white f-12 btn-rounded"><i class="feather icon-eye mr-0"></i></a>
                        <a href="'.route('historial',['id' => $study->id]).'"title="HISTORIAL" class="label theme-record text-white f-12 btn-rounded" ><i class="feather icon-folder mr-0"></i></a>   
                    </td>
                </tr>';
                }
            $opciones .= 
            '</tbody>
        </table>';

        return $opciones;      
    }
    public function allRec()
    {
        $studies = Study::with('appointment','doctor')->where('status','Enviado')->orderBy('created_at', 'DESC')->get();
        return view('allRecordRec',compact('studies'));
    }
    public function allRecReload()
    {
        $studies = Study::with('appointment','doctor')->where('status','Enviado')->orderBy('created_at', 'DESC')->get();
        
        $opciones = '
        <table id="zero-configurationo" class="display table nowrap table-striped table-hover" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th class="tMovil">Folio</th>
                    <th class="tMovil">SAE</th>
                    <th>Paciente</th>
                    <th>Estudio</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>';
                foreach ($studies as $study){
                $opciones .= '
                <tr>
                    <td>'.$study->id.'</td>
                    <td class="tMovil">';
                    if ($study->internal == 1){
                        $opciones .='R'.sprintf('%06d',$study->folio);
                    }else{
                        $opciones .='D'.sprintf('%06d',$study->folio);
                    }
                    $opciones .='</td>
                    <td class="tMovil">'.$study->sae.'</td>

                    <td>'.$study->patient_name.' '.$study->paternal_surname.' '.$study->maternal_surname.'</td>
                    <td>';
                    if($study->study_type->count() > 0){
                        $opciones .= $study->study_type[0]->type->type;
                    }
                    $opciones .=' 
                    </td>
                    <td>
                        <a href="'.route('showStudyRecep',['id' => $study->id]).'"title="VER" class="label theme-bg text-white f-12 btn-rounded"><i class="feather icon-eye mr-0"></i></a>
                        <a href="'.route('historialRec',['id' => $study->id]).'"title="HISTORIAL" class="label theme-record text-white f-12 btn-rounded" ><i class="feather icon-folder mr-0"></i></a>                    
                    </td>
                </tr>';
                }
            $opciones .= 
            '</tbody>
        </table>';

        return $opciones;      
    }
    
    public function allCoo()
    {
        $studies = Study::with('appointment','doctor')->where('status','Enviado')->orderBy('created_at', 'DESC')->get();
        return view('allRecordCoo',compact('studies'));
    }
    public function allCooReload()
    {
        $studies = Study::with('appointment','doctor')->where('status','Enviado')->orderBy('created_at', 'DESC')->get();
        
        $opciones = '
        <table id="zero-configurationo" class="display table nowrap table-striped table-hover" style="width:100%">
            <thead>
                <tr>
                    <th class="tMovil">Folio</th>
                    <th class="tMovil">SAE</th>
                    <th>Paciente</th>
                    <th class="tMovil">Recibido hace</th>
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
                    <td class="tMovil">'.$study->sae.'</td>
                    <td>'.$study->patient_name.' '.$study->paternal_surname.' '.$study->maternal_surname.'</td>
                    <td class="tMovil">';
                        $opciones .= '<span class="d-none">'.$study->created_at.'</span>';
                        if (($study->dias() + 0) == 0){
                            if (($study->horas() + 0) == 0){
                                $opciones .=  $study->minutos() + 0 .' Minutos';
                            }else{
                                $opciones .= $study->horas() + 0 . ' Horas';
                            }
                        }else{
                            $opciones .= $study->dias() + 0 . ' Días';
                        }  
                    $opciones .=  
                    '</td>
                    <td>
                        <a href="'.route('showStudyCoo',['id' => $study->id]).'"title="VER" class="label theme-bg text-white f-12 btn-rounded"><i class="feather icon-eye mr-0"></i></a>
                        <a href="'.route('historialCoo',['id' => $study->id]).'"title="HISTORIAL" class="label theme-record text-white f-12 btn-rounded" ><i class="feather icon-folder mr-0"></i></a> 
                    </td>
                </tr>';
                }
            $opciones .= 
            '</tbody>
        </table>';

        return $opciones;      
    }

    public function downloadExcel($id)
	{
        return Excel::download(new StudyExport, 'Estudios.xlsx');
    }
}
