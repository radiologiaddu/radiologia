<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\Type;
use App\Models\Answer;
use App\Models\Doctor;
use App\Models\Study;
use App\Models\Study_type;
use App\Models\Question;
use App\Models\Type_question;
use App\Models\Question_answer;
use App\Mail\newStudy;
use App\Models\User;
use App\Models\Record;
use Illuminate\Support\Facades\Validator;
use App\Events\hostEvent;
use Twilio\Rest\Client;
use Twilio\Exceptions;
use App\Models\Cupon;
use Illuminate\Support\Facades\Auth;
use App\Models\DoctorReport;

class DoctorController extends Controller
{
    public function actualizarEstatusReport($userId, Request $request)
{
    $status = $request->status;

    // Encuentra el DoctorReport por user_id y actualiza el estado
    $doctorReport = DoctorReport::where('user_id', $userId)->first();

    if ($doctorReport) {
        $doctorReport->status = $status;
        $doctorReport->save();

        return response()->json(['status' => true, 'message' => 'Estado actualizado correctamente']);
    }

    return response()->json(['status' => false, 'message' => 'No se encontró el reporte del doctor']);
}

    public function actualizarEstatus($id)
{
    $doctorReport = DoctorReport::where('user_id', $id)->first();

    if ($doctorReport) {
        $doctorReport->update([
            'status' => request('status')  // 'status' aquí será 1 o 0 según el valor enviado desde el frontend
        ]);
    }

    return response()->json(['success' => true]);
}
    //
    public function index()
    {
        $id = auth()->user()->doctor->id;
        $doctor = Doctor::findOrFail($id);
        $studies = Study::where('doctor_id',$doctor->id)->with('appointment')->orderBy('created_at', 'DESC')->paginate(6);
        $vA = session('flagModal');

        // Consultar el estado de doctor_reports para el doctor activo
        $doctorReport = DoctorReport::where('doctor_id', $doctor->id)
        ->value('status');
        
        // Consultar los cupones del doctor con estatus activo
        $cupones = Cupon::where('id_doctor', $doctor->id)
        ->where('estatus', 'Activo')
        ->get();

        // Calcular el monto total de los estudios para el año actual
    $currentYear = Carbon::now()->year;
    $startOfYear = Carbon::create($currentYear, 1, 1)->startOfDay();
    $endOfYear = Carbon::create($currentYear, 12, 31)->endOfDay();

    $totalSum = Study::where('doctor_id', $doctor->id)
                     ->whereBetween('date', [$startOfYear, $endOfYear])
                     ->sum('total');

    $totalSumFormatted = number_format($totalSum, 2, ',', '.');
    $annualReturn = $totalSum * 0.02;
    $annualReturnFormatted = number_format($annualReturn, 2, ',', '.');

        return view('mis-estudios', compact('studies','vA','cupones','doctorReport','totalSumFormatted', 'annualReturnFormatted'));
    }

    public function edit()
    {
        $user = auth()->user();
        $doctor  = Doctor::findOrFail(auth()->user()->doctor->id);
        $mytime = Carbon::now()->timezone("America/Mexico_City");
        $year = strftime("%Y",strtotime($mytime->toDateString()));
        return view('editPerfil', compact('user','doctor','year'));

    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validation = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'paternalSurname' => ['required', 'string'],
            'maternalSurname' => ['required', 'string'],
            'alias' => ['required'],
            //'title' => ['required'],
            'specialty' => ['required'],
            'gender' => ['required'],
            'phone' => ['required'],            
        ],[
            'name.required' => "El campo NOMBRE es obligatorio",
            'name.string' => "El NOMBRE debe ser texto",
            'paternalSurname.required' => "El campo APELLIDO PATERNO es obligatorio",
            'paternalSurname.string' => "El APELLIDO PATERNO debe ser texto",
            'maternalSurname.required' => "El campo APELLIDO MATERNO es obligatorio",
            'maternalSurname.string' => "El APELLIDO MATERNO debe ser texto",
            'alias.required' => "El campo ALIAS es obligatorio",
            //'title.required' => "El campo TÍTULO es obligatorio",
            'specialty.required' => "El campo ESPECIALIDAD es obligatorio",
            'gender.required' => "El campo GÉNERO es obligatorio",
            'phone.required' => "El campo NÚMERO DE CONTACTO es obligatorio",
        ]);

        if( $validation->fails() )
        {
            return redirect()->back()
            ->withErrors( $validation->errors() )
            ->withInput();
        } 

        $doctor = Doctor::where("user_id", $user->id)->first();

        if($request->hasFile('customFileLang'))
        {
            $corte = explode("ddu/", $doctor->photo);

            if(sizeof($corte) > 1){
                $idCloudinary = explode(".", $corte[2]);
                cloudinary()->uploadApi()->destroy("ddu/".$idCloudinary[0]);
            }
            $file = $request->file('customFileLang');

            $response = cloudinary()->upload($file->getRealPath(), $options = array ('folder' => "ddu"))->getSecurePath();
            $doctor->photo = $response;
            
            /*
            $ruta = public_path().'/assets/images/user/';
            $imagenOriginal = $request->file('customFileLang');
    
            // generar un nombre aleatorio para la imagen
            $temp_name = Carbon::now()->format('ymdhhmmss').".".$imagenOriginal->getClientOriginalExtension();
            if(!is_null($doctor->photo)){
                if(file_exists($ruta.$doctor->photo)){
                    unlink($ruta.$doctor->photo);
                }
            }
            $ruta = $ruta.$temp_name;
            if(move_uploaded_file($imagenOriginal, $ruta)){
                $doctor->photo = $temp_name;
            }*/
        }

        $doctor->paternalSurname = strtoupper($request->paternalSurname);
        $doctor->maternalSurname = strtoupper($request->maternalSurname);
        $doctor->alias = $request->alias;
        //$doctor->title = $request->title;
        $doctor->phone = $request->phone;
        $doctor->birthday = $request->year."-".$request->month."-".$request->day;
        $doctor->gender = $request->gender;
        $doctor->specialty = $request->specialty;
        $doctor->save();

        $user->name = strtoupper($request->name);
        $user->save();

        return redirect()->route('Perfil') ;
    }

    public function changePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validation = Validator::make($request->all(), [
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ],[
            'password.required' => "El campo contraseña es requerido",
            'password.string' => "La contraseña debe ser texto",
            'password.min' => "La contraseña debe contener por lo menos 6 caracteres",
            'password.confirmed' => "La contraseña y confirmacion no coinciden",
        ]);

        if( $validation->fails() )
        {
            return redirect()->back()
            ->withErrors( $validation->errors() )
            ->withInput();
        } 
       
        $user->password  = bcrypt($request->password);
        $user->save();

        return redirect()->route('editarUsuario',['id' => $user->id]);
    }

    public function profil()
{
    $user = Auth::user();
    $doctor = $user->doctor;
    $doctorId = $doctor->id;
    $currentYear = Carbon::now()->year;
    $startOfYear = Carbon::create($currentYear, 1, 1)->startOfDay();
    $endOfYear = Carbon::create($currentYear, 12, 31)->endOfDay();
    $studies = $doctor->studies()
        ->whereBetween('date', [$startOfYear, $endOfYear])
        ->orderBy('date')
        ->get();
    
    // Obtener el status desde DoctorReport
    $doctorReport = DoctorReport::where('doctor_id', $doctorId)->first();
    $status = $doctorReport ? $doctorReport->status : null;

    setlocale(LC_TIME, 'es_ES.UTF-8');
    $totalSum = 0;
    foreach ($studies as $study) {
        $study->formatted_date = Carbon::parse($study->date)->locale('es')->isoFormat('D [de] MMMM [de] YYYY');
        $totalSum += $study->total;
    }
    $totalSumFormatted = number_format($totalSum, 2, ',', '.');
    $annualReturn = $totalSum * 0.02;
    $annualReturnFormatted = number_format($annualReturn, 2, ',', '.');

    return view('perfil', compact('user', 'doctor', 'studies', 'doctorId', 'totalSumFormatted', 'annualReturnFormatted', 'status'));
}

    
    public function showProfile($userId)
    {
        // Buscar al usuario por su ID
        $user = User::find($userId);
        if (!$user) {
            abort(404, 'Usuario no encontrado');
        }
    
        // Obtener al doctor asociado al usuario (si existe)
        $doctor = $user->doctor;
        if (!$doctor) {
            abort(404, 'No se encontró un doctor asociado a este usuario');
        }
    
        // Obtener los estudios del doctor para el año actual
        $currentYear = Carbon::now()->year;
        $startOfYear = Carbon::create($currentYear, 1, 1)->startOfDay();
        $endOfYear = Carbon::create($currentYear, 12, 31)->endOfDay();
        $studies = $doctor->studies()
            ->whereBetween('date', [$startOfYear, $endOfYear])
            ->orderBy('date')
            ->get();
    
        // Formatear fechas y calcular totales
        setlocale(LC_TIME, 'es_ES.UTF-8');
        $totalSum = 0;
        foreach ($studies as $study) {
            $study->formatted_date = Carbon::parse($study->date)->locale('es')->isoFormat('D [de] MMMM [de] YYYY');
            $totalSum += $study->total;
        }
        $totalSumFormatted = number_format($totalSum, 2, ',', '.');
        $annualReturn = $totalSum * 0.02;
        $annualReturnFormatted = number_format($annualReturn, 2, ',', '.');
    
        // Indicador para mostrar solo el cash back
        $showCashBackOnly = request()->input('showCashBackOnly', false);
    
        return view('profile', compact('user', 'doctor', 'studies', 'totalSumFormatted', 'annualReturnFormatted', 'showCashBackOnly'));
    }
    

    public function all()
    {
        $id = auth()->user()->doctor->id;
        $doctor = Doctor::findOrFail($id);
        $studies = Study::where('doctor_id',$doctor->id)->with('appointment')->orderBy('created_at', 'DESC')->get();

        return view('allStudy', compact('studies'));
    }

    public function create()
    {
        $types = Type::orderBy('id')->get();
        $mytime = Carbon::now()->timezone("America/Mexico_City");
        $year = strftime("%Y",strtotime($mytime->toDateString()));
        // Obtener los cupones disponibles del doctor
        $id = auth()->user()->doctor->id;
        $cupones = Cupon::where('id_doctor', $id)
                        ->where('estatus', 'Activo')
                        ->get();
        return view('newStudy', compact('types', 'year', 'cupones'));
    }
    public function store(Request $request, $id)
    {   
        $doctor = Doctor::where('user_id',$id)->first();
        $study = Study::orderBy('id', 'desc')->first();
        $folio = 1;
        if(!is_null($study)){
            $folio = $study->folio + 1;
        }
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // Output: video-g6swmAP8X5VG4jCi.mp4
        $token = substr(str_shuffle($permitted_chars), 0, 31).$folio;

        $couponCode = $request->input('coupon_code');
    // Busca el cupón en la base de datos usando el nombre del cupón y el ID del doctor
    $coupon = Cupon::where('nombre_cupon', $couponCode)
        ->where('id_doctor', $doctor->id)
        ->first();
    $couponMessage = '';
    //dd($doctor->id);
    //dd($coupon->id_doctor);
    // Verifica si se encontró un cupón válido
    if ($coupon) {
        // Actualiza el estatus del cupón a “Usado”
        //dd($coupon->id_doctor);
        Cupon::where('id_cupon', $coupon->id_cupon)
         ->update(['estatus' => 'Usado']);
        //dd($coupon);
        // Genera el mensaje del cupón
        switch ($couponCode) {
            /*case 'Cupon75':
                $couponMessage = 'El doctor hizo un descuento del 75%';
                break;*/
            case 'Cupon50':
                $couponMessage = 'El doctor hizo un descuento del 50%';
                break;
            case 'Cupon25':
                $couponMessage = 'El doctor hizo un descuento del 25%';
                break;
            case 'Cupon10_1':
            case 'Cupon10_2':
            case 'Cupon10_3':
                $couponMessage = 'El doctor hizo un descuento del 10%';
                break;
            default:
                $couponMessage = 'Cupón desconocido';
                break;
        }
    }
        
        $newStudy = Study::create([
            'doctor_id' => $doctor->id,
            'folio' => $folio,
            'patient_name' => strtoupper($request->patient_name),
            'paternal_surname' => strtoupper($request->paternal_surname),
            'maternal_surname' => strtoupper($request->maternal_surname),
            'patient_email' => strtolower($request->patient_email),
            'patient_phone' => $request->patient_phone,
            'observations' => $request->note . ' ' . $couponMessage,
            'status' => "Creado",
            'qr' => $token,
            'total' => $request->total,
            'birthday' => $request->year."-".$request->month."-".$request->day,

        ]);
        if($request->duration != '00:00'){
            $newStudy->duration  = $request->duration;
            $newStudy->save();
        }
        $newRecord = Record::create([
            'study_id' => $newStudy->id,
            'action' => "El doctor ha generado un nuevo estudio.",
            'user' => auth()->user()->name,
            'user_email' => auth()->user()->email,
            'folio' => $newStudy->folio,
        ]);
        //$newStudy->id
        $arrayStudies = [];
        foreach ($request->arrayType as $arrayType) {

            $newStudy_type = Study_type::create([
                'study_id' => $newStudy->id,
                'type_id' => request($arrayType),
            ]);
            $findType = Type::findOrFail($newStudy_type->type_id);
            $arrayQuestions = [];

            //$newStudy_type->id
            if(!is_null(request($arrayType.'question'))){
                foreach (request($arrayType.'question') as $question_id) {
                    if(!is_null(request($arrayType.'question'.$question_id))){
                        $findQuestion = Question::findOrFail($question_id);
                        $arrayAnswer = [];
                        if($findQuestion->kind == "texto"){

                            $newType_question = Type_question::create([
                                's_t_id' => $newStudy_type->id,
                                'question_id' => $question_id,
                                'answer' => request($arrayType.'question'.$question_id)
                            ]);
                            array_push($arrayAnswer,$newType_question->answer);
                        }else{
                            $newType_question = Type_question::create([
                                's_t_id' => $newStudy_type->id,
                                'question_id' => $question_id,
                            ]);
                            //$newType_question->id
                            if($findQuestion->kind == "radio"){
                                if($findQuestion->answer()->count() > 1){
                                    $newQuestion_answer = Question_answer::create([
                                        't_q_id' => $newType_question->id,
                                        'answer_id' => request($arrayType.'question'.$question_id),
                                        
                                    ]);
                                    $findAnswer = Answer::findOrFail($newQuestion_answer->answer_id);
                                    array_push($arrayAnswer,$findAnswer->answer);
                                    $newQuestion_answer->cost = $findAnswer->costDoctor;
                                    $newQuestion_answer->save();
                                }else{
                                    foreach (request($arrayType.'question'.$question_id) as $answer_id) {
                                        $newQuestion_answer = Question_answer::create([
                                            't_q_id' => $newType_question->id,
                                            'answer_id' => $answer_id,
                                        ]);
                                        $findAnswer = Answer::findOrFail($newQuestion_answer->answer_id);
                                        array_push($arrayAnswer,$findAnswer->answer);
                                        $newQuestion_answer->cost = $findAnswer->costDoctor;
                                        $newQuestion_answer->save();
                                    }
                                }
                                
                            }else{
                                foreach (request($arrayType.'question'.$question_id) as $answer_id) {
                                    $newQuestion_answer = Question_answer::create([
                                        't_q_id' => $newType_question->id,
                                        'answer_id' => $answer_id,
                                    ]);
                                    $findAnswer = Answer::findOrFail($newQuestion_answer->answer_id);
                                    array_push($arrayAnswer,$findAnswer->answer);
                                    $newQuestion_answer->cost = $findAnswer->costDoctor;
                                    $newQuestion_answer->save();
                                }
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
                }    
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
            //'qr' => bcrypt("1"),
            'qr' => $newStudy->qr,
            'name' => $newStudy->patient_name,
            'doctor' => $doctor->alias,
            'studies' => $arrayStudies,
            'notes' => $newStudy->observations,
            'duration' => $newStudy->duration, 
            'total' => sprintf('$ %s', number_format($newStudy->total, 2))
        ];

        Mail::to($request->patient_email)->send(new newStudy($details));
        event(new hostEvent());

        //Mail::to("nach.diaz@happeningnm.com")->send(new newStudy($details));
        /*
        $sid    = "AC3d4c52a4c8b37bb0f5f52845cccc46ef";
        $token  = "c9e766aa6392c7efb5a56b8dda1d5bca";
        $twilio = new Client($sid, $token);
        $body = "Los datos de tu estudio: ".route('showDetails' ,['id' =>$details['qr']])." \nHAZ TU CITA: ".route('appointment' ,['id' =>$details['qr']]);
        //dd($body);
        $message = $twilio->messages
          ->create("whatsapp:+521"."4448588272", // to
            array(
              "from" => "whatsapp:+14155238886",
              "body" => $body
            )
          );
        */
        session(['flagModal' => true]);
        
        return redirect()->route('Misestudios') ;
    }
    public function show($id)
    {
        $study = Study::with('appointment')->findOrFail($id);
        
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
                    'class_note' => $question->class_note,
                    'note' => $question->note,
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

        return view('showStudy',compact('study','arrayStudies'));
    }

    public function question(Request $request)
    {
        $type = Type::with('questions')->findOrFail($request->id);
        $opciones = "";
        foreach($type->questions as $question){
            $opciones .= '<div class="form-group col-12 p-0 mb-0 text-left">
                            <div class="title-block">
                                <input name="'.$request->idElement.'question[]" type="hidden" value="'.$question->id.'">
                                <h6 class="title'.$request->idElement.'" id="question'.$question->id.'">'.$question->question.'</h6>
                            </div>
                        </div>';
            if($question->kind == "radio"){
                if(count($question->answer)>1){
                    foreach($question->answer as $answer){
                        if($answer->answer == "11" || $answer->answer == "21"){
                            $opciones .='<div class="col-6">';
                        }
                        if($answer->answer == "31" || $answer->answer == "41"){
                            $opciones .='<div class="col-6 mt-4">';
                        }
                        $labelCost = '';
                        $cost = 0;
                        if(!is_null($answer->costDoctor)){
                            $labelCost = ' ('.sprintf('$ %s', number_format($answer->costDoctor, 2)).')';
                            $cost = $answer->costDoctor;
                        }
                        $opciones .='<div class="form-check col-12 pl-5">
                                        <input study_time="'.$answer->study_time.'" preparation_time="'.$answer->preparation_time.'" exit_time="'.$answer->exit_time.'" cost="'.$cost.'"';
                                        if(count($answer->dependency)>0){
                                            $opciones .= 'class="dependency ';
                                            foreach($answer->dependency as $dependency){
                                                $opciones .= $request->idElement.'question'.$dependency->question_id;
                                            }
                                        }else{
                                            $opciones .= 'class="';
                                        }
                                        $opciones .= ' form-check-input answer-input'.$request->idElement.'" type="radio" name="'.$request->idElement.'question'.$question->id.'" value="'.$answer->id.'" data-name="'.$answer->answer.'">
                                        <label class="form-check-label" for="'.$request->idElement.'question'.$question->id.'" style="font-size: 14px;">'.$answer->answer.$labelCost.'</label>
                                    </div>';
                        if($answer->answer == "18" || $answer->answer == "28" || $answer->answer == "38" || $answer->answer == "48"){
                            $opciones .='</div>';
                        }
                    }
                    
                }else{
                    foreach($question->answer as $answer){
                        $labelCost = '';
                        $cost = 0;
                        if(!is_null($answer->costDoctor)){
                            $labelCost = ' ('.sprintf('$ %s', number_format($answer->costDoctor, 2)).')';
                            $cost = $answer->costDoctor;
                        }
                        $opciones .='<div class="custom-control custom-checkbox col-12 pl-5">
                                        <input study_time="'.$answer->study_time.'" preparation_time="'.$answer->preparation_time.'" exit_time="'.$answer->exit_time.'" cost="'.$cost.'"';
                                        if(count($answer->dependency)>0){
                                            $opciones .= 'disabled class="dependency ';
                                            foreach($answer->dependency as $dependency){
                                                $opciones .= $request->idElement.'question'.$dependency->question_id;
                                            }
                                        }else{
                                            $opciones .= 'class="';
                                        }
                                        $opciones .= ' custom-control-input answer-input'.$request->idElement.'" type="checkbox" id="element'.$request->idElement.'question'.$question->id.'answer'.$answer->id.'" name="'.$request->idElement.'question'.$question->id.'[]" value="'.$answer->id.'">
                                        <label class="custom-control-label" for="element'.$request->idElement.'question'.$question->id.'answer'.$answer->id.'" style="font-size: 14px;">'.$answer->answer.$labelCost.'</label>
                                    </div>';
                    }
                }
            }elseif ($question->kind == "check"){
                foreach($question->answer as $answer){
                    if($answer->answer == "11" || $answer->answer == "21"){
                        $opciones .='<div class="col-6">';
                    }
                    if($answer->answer == "31" || $answer->answer == "41"){
                        $opciones .='<div class="col-6 mt-4">';
                    }
                    $labelCost = '';
                    $cost = 0;
                    if(!is_null($answer->costDoctor)){
                        $labelCost = ' ('.sprintf('$ %s', number_format($answer->costDoctor, 2)).')';
                        $cost = $answer->costDoctor;
                    }
                    $opciones .='<div class="custom-control custom-checkbox col-12 pl-5">
                                    <input study_time="'.$answer->study_time.'" preparation_time="'.$answer->preparation_time.'" exit_time="'.$answer->exit_time.'" cost="'.$cost.'"';
                                    if(count($answer->dependency)>0){
                                        $opciones .= 'class="dependency ';
                                        foreach($answer->dependency as $dependency){
                                            $opciones .= $request->idElement.'question'.$dependency->question_id;
                                        }
                                    }else{
                                        $opciones .= 'class="';
                                    }
                                    $opciones .= ' custom-control-input answer-input'.$request->idElement.'" type="checkbox" id="element'.$request->idElement.'question'.$question->id.'answer'.$answer->id.'" name="'.$request->idElement.'question'.$question->id.'[]" value="'.$answer->id.'">
                                    <label class="custom-control-label" for="element'.$request->idElement.'question'.$question->id.'answer'.$answer->id.'" style="font-size: 14px;">'.$answer->answer.$labelCost.'</label>
                                </div>';
                    if($answer->answer == "18" || $answer->answer == "28" || $answer->answer == "38" || $answer->answer == "48"){
                        $opciones .='</div>';
                    }
                }
            }else{
                $opciones .='<div class="form-group">
                                <div class="input-group">
                                    <input name="'.$request->idElement.'question'.$question->id.'" type="text"';
                                    if(count($question->dependency)>0){
                                        $opciones .= 'disabled class="dependent';
                                    }else{
                                        $opciones .= 'class="';
                                    }
                                    $opciones .= ' form-control answer answer-input'.$request->idElement.'" placeholder="Respuesta" >
                                </div>
                            </div>';
            }
            
            if(!is_null($question->class_note)){
                $opciones .='<div class="col-12">';

                if($question->class_note == "simpleNote"){
                    $opciones .='<div class="form-group">
                                    <label class="form-check-label" for="simpleNote" style="font-size: 14px;">'.nl2br($question->note).'</label>
                                </div>';
                }else{
                    $opciones .='<div class="form-group">
                                        <label class="form-check-label" for="highlightedNote" style="font-size: 14px;">
                                        <div style="background: rgb(110,123,222);
                                        border-radius: 50%;
                                        height: 30px;
                                        width: 30px;
                                        text-align: center;
                                        align-items: center;
                                        display: flex;
                                        float: left;">
                                            <img src="'.asset("/image/blanco100.png").'" style="width: 20px;
                                            height: 20px;
                                            margin-left: auto;
                                            margin-right: auto;" alt="User-Profile-Image">
                                        </div>
                                        <span style="background: rgb(110,123,222);
                                        color: white;
                                        font-size: 16px;
                                        margin-left: 5px;
                                        padding: 5px;
                                        align-items: center;
                                        display: flex;">
                                        '.nl2br($question->note).'
                                        </span>
                                        <div class="clearfix"></div>
    
                                    </label>
                                </div>';
                }
                $opciones .='</div>';
            }

        }
        if(!is_null($type->class_note)){
            if($type->class_note == "simpleNote"){
                $opciones .='<div class="form-group mt-3 col-12">
                                <label class="form-check-label" for="simpleNote" style="font-size: 14px;">'.nl2br($type->note).'</label>
                            </div>';
            }else{
                $opciones .='<div class="form-group mt-3 col-12">
                                    <label class="form-check-label" for="highlightedNote" style="font-size: 14px;">
                                    <div style="background: rgb(110,123,222);
                                    border-radius: 50%;
                                    height: 30px;
                                    width: 30px;
                                    text-align: center;
                                    align-items: center;
                                    display: flex;
                                    float: left;">
                                        <img src="'.asset("/image/blanco100.png").'" style="width: 20px;
                                        height: 20px;
                                        margin-left: auto;
                                        margin-right: auto;" alt="User-Profile-Image">
                                    </div>
                                    <span style="background: rgb(110,123,222);
                                    color: white;
                                    font-size: 16px;
                                    margin-left: 5px;
                                    padding: 5px;
                                    align-items: center;
                                    display: flex;">
                                    '.nl2br($type->note).'
                                    </span>
                                    <div class="clearfix"></div>

                                </label>
                            </div>';
            }
            

        }
        
        return $opciones;     
    }
}
