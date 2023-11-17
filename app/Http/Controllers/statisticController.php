<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Study;
use App\Models\Record;

class statisticController extends Controller
{
    public function index()
    {
        $doctors = User::withTrashed()->Role(['Doctor'])->count();
        $studies = Study::all()->count();
        $total = Study::where('status','Pagado')->orWhere('status','Empezado')->orWhere('status','Realizado')->orWhere('status','Enviado')->sum('total');
        $ene = Study::whereYear('created_at', '=', '2023')->whereMonth('created_at', '=', '01')->count();
        $feb = Study::whereYear('created_at', '=', '2023')->whereMonth('created_at', '=', '02')->count();
        $mar = Study::whereYear('created_at', '=', '2023')->whereMonth('created_at', '=', '03')->count();
        $abr = Study::whereYear('created_at', '=', '2023')->whereMonth('created_at', '=', '04')->count();
        $may = Study::whereYear('created_at', '=', '2023')->whereMonth('created_at', '=', '05')->count();
        $jun = Study::whereYear('created_at', '=', '2023')->whereMonth('created_at', '=', '06')->count();
        $jul = Study::whereYear('created_at', '=', '2023')->whereMonth('created_at', '=', '07')->count();
        $ago = Study::whereYear('created_at', '=', '2023')->whereMonth('created_at', '=', '08')->count();
        $sep = Study::whereYear('created_at', '=', '2023')->whereMonth('created_at', '=', '09')->count();
        $oct = Study::whereYear('created_at', '=', '2023')->whereMonth('created_at', '=', '10')->count();
        $nov = Study::whereYear('created_at', '=', '2023')->whereMonth('created_at', '=', '11')->count();
        $dic = Study::whereYear('created_at', '=', '2023')->whereMonth('created_at', '=', '12')->count();
        
        $eneT = Record::where('action','El estudio ha sido terminado')->whereYear('created_at', '=', '2023')->whereMonth('created_at', '=', '01')->count();
        $febT = Record::where('action','El estudio ha sido terminado')->whereYear('created_at', '=', '2023')->whereMonth('created_at', '=', '02')->count();
        $marT = Record::where('action','El estudio ha sido terminado')->whereYear('created_at', '=', '2023')->whereMonth('created_at', '=', '03')->count();
        $abrT = Record::where('action','El estudio ha sido terminado')->whereYear('created_at', '=', '2023')->whereMonth('created_at', '=', '04')->count();
        $mayT = Record::where('action','El estudio ha sido terminado')->whereYear('created_at', '=', '2023')->whereMonth('created_at', '=', '05')->count();
        $junT = Record::where('action','El estudio ha sido terminado')->whereYear('created_at', '=', '2023')->whereMonth('created_at', '=', '06')->count();
        $julT = Record::where('action','El estudio ha sido terminado')->whereYear('created_at', '=', '2023')->whereMonth('created_at', '=', '07')->count();
        $agoT = Record::where('action','El estudio ha sido terminado')->whereYear('created_at', '=', '2023')->whereMonth('created_at', '=', '08')->count();
        $sepT = Record::where('action','El estudio ha sido terminado')->whereYear('created_at', '=', '2023')->whereMonth('created_at', '=', '09')->count();
        $octT = Record::where('action','El estudio ha sido terminado')->whereYear('created_at', '=', '2023')->whereMonth('created_at', '=', '10')->count();
        $novT = Record::where('action','El estudio ha sido terminado')->whereYear('created_at', '=', '2023')->whereMonth('created_at', '=', '11')->count();
        $dicT = Record::where('action','El estudio ha sido terminado')->whereYear('created_at', '=', '2023')->whereMonth('created_at', '=', '12')->count();
        
        return view('statistics', compact('doctors','studies','total','ene','feb','mar','abr','may','jun','jul','ago','sep','oct','nov','dic','eneT','febT','marT','abrT','mayT','junT','julT','agoT','sepT','octT','novT','dicT'));
    }

}
