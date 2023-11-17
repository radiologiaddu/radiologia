<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Study extends Model
{
    use HasFactory;

    protected $table = 'studies';

    protected $fillable = [
        'doctor_id',
        'folio',
        'patient_name',
        'patient_email',
        'paternal_surname',
        'maternal_surname',
        'patient_phone',
        'observations',
        'status',
        'qr',
        'total',
        'birthday',
        'cp',
        'radiologist',
        'payment',
        'detail',
        'invoice',
        'remision',
        'sae',
        'doctor_name',
        'doctor_email',
        'internal',
        'radiologist_id',
        'date',
        'time',
        'duration',
        'CFDI',
        'tax',
        'id_discount',
        'discount',
        'referral'
    ];

    public function dias(){
        $fecha1 = date_create($this->created_at);
        $mytime = Carbon::now()->timezone("America/Mexico_City");
        $today = $mytime->toString();
        $fecha2 = date_create($today);
        $dias = date_diff($fecha1, $fecha2)->format('%R%a');
        return $dias;
    }
    public function horas(){
        $fecha1 = date_create($this->created_at);
        $mytime = Carbon::now()->timezone("America/Mexico_City");
        $today = $mytime->toString();
        $fecha2 = date_create($today);
        $horas = date_diff($fecha1, $fecha2)->format('%R%H');
        return $horas;
    }
    public function minutos(){
        $fecha1 = date_create($this->created_at);
        $mytime = Carbon::now()->timezone("America/Mexico_City");
        $today = $mytime->toString();
        $fecha2 = date_create($today);
        $minutos = date_diff($fecha1, $fecha2)->format('%R%i');
        return $minutos;
    }
    
    public function edad(){
        $dias = null;
        if(!is_null($this->birthday)){
            $fecha1 = date_create($this->birthday);
            $mytime = Carbon::now()->timezone("America/Mexico_City");
            $today = $mytime->toString();
            $fecha2 = date_create($today);
            $dias = date_diff($fecha1, $fecha2)->format('%R%Y');
        }
        
        return $dias;
    }

    public function study_type(){
        return $this->hasMany(Study_type::class,'study_id')->orderBy('id', 'ASC');
    } 

    public function appointment(){
        return $this->hasOne(Appointment::class,'study_id');
    } 

    public function doctor()
    {
        return $this->hasOne(Doctor::class, 'id','doctor_id');
    }

    public function cfdi()
    {
        return $this->hasOne(CFDI::class, 'key_cfdi','CFDI');
    }

    public function TAX()
    {
        return $this->hasOne(Tax::class, 'key_regimen','tax');
    }

    public function descuento()
    {
        return $this->hasOne(Discount::class, 'id','id_discount');
    }
}
