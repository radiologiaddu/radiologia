<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;
use App\Models\Study;
use App\Models\Doctor;
use App\Models\CFDI;
use App\Models\Cedula;
use App\Models\City;
use App\Models\Colleague;
use App\Models\Docdepo;
use App\Models\Job;
use App\Models\Office;
use App\Models\Social_Network;
use App\Models\Career;
use App\Models\Radiologist;
use App\Models\Error;
use App\Mail\errorMail;
use App\Mail\Verification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withTrashed()->notRole(['Doctor','SuperAdministrador'])->orderBy('id')->get();
        return view('users', compact('users'));
    }

    public function doctores()
    {
        $users = User::withTrashed()->Role(['Doctor'])->with('doctor')->orderBy('id')->get();
        return view('doctors', compact('users'));
    }

    public function doctoresDDU()
    {
        $doctors = Docdepo::orderBy('id')->get();
        return view('doctorsDDU', compact('doctors'));
    }

    public function updateDoctor(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validation = Validator::make($request->all(), [
            'email' => ['unique:users,email,'.$user->id],
        ],[
            'email.unique' => "El email de usuario ya esta registrado",
        ]);

        if( $validation->fails() )
        {
            return response()->json([
                'status'  => false,
                'data'    => "El email de usuario ya esta registrado"
            ]);
        } 
        $user->name  = $request->name;
        $user->email  = $request->email;
        $user->save();

        return response()->json([
            'status'  => true,
            'data'    => $user
        ]);
    }
    
    public function removeDoctor($id)
    {
        $user = User::findOrFail($id);
        $user->roles()->detach();
        $user->delete();
        return 200;
    }

    public function radiologist()
    {
        $radiologists = Radiologist::orderBy('id')->get();
        return view('radiologo', compact('radiologists'));
    }

    public function create()
    {
        return view('newUser');
    }
    public function createDoctor()
    {
        return view('newDoctor');
    }
    

    public function store(Request $request)
    {   
        $validation = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'type' => ['required'],
        ],[
            'name.required' => "El campo nombre es obligatorio",
            'name.string' => "El nombre debe ser texto",
            'email.required' => "El campo email es obligatorio",
            'email.unique' => "El email de usuario ya esta registrado",
            'password.required' => "El campo contraseña es requerido",
            'password.string' => "La contraseña debe ser texto",
            'password.min' => "La contraseña debe contener por lo menos 6 caracteres",
            'password.confirmed' => "La contraseña y confirmacion no coinciden",
            'type.required' => "El campo tipo es obligatorio",
        ]);

        if( $validation->fails() )
        {
            return redirect()->back()
            ->withErrors( $validation->errors() )
            ->withInput();
        } 

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        
        $user->email_verified_at  = Carbon::now()->format('Y-m-d H:i:s');
        $user->save();
        
        $user->assignRole($request->type);
        return redirect()->route('users') ;
    }
    public function storeDoctor(Request $request)
    {   
        $validation = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'unique:users'],
        ],[
            'name.required' => "El campo nombre es obligatorio",
            'name.string' => "El nombre debe ser texto",
            'email.required' => "El campo email es obligatorio",
            'email.unique' => "El email de usuario ya esta registrado",
        ]);

        if( $validation->fails() )
        {
            return redirect()->back()
            ->withErrors( $validation->errors() )
            ->withInput();
        } 

        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // Output: video-g6swmAP8X5VG4jCi.mp4
        $token = substr(str_shuffle($permitted_chars), 0, 32);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $token,
        ]);

        $user->assignRole('Doctor');
        $details = [
            'token' => $token
        ];
        Mail::to($request->email)->send(new Verification($details));

        return redirect()->route('doctores') ;
    }
    public function storeRadiologo(Request $request)
    {   

        $radiologist = Radiologist::create([
            'name' => $request->name,
        ]);

        return true ;
    }
    
    public function verification($id)
    {
        $user = User::where("password", $id)->first();
        if(is_null($user)){
            return redirect()->route('login') ;
        }
        $mytime = Carbon::now()->timezone("America/Mexico_City");
        $year = strftime("%Y",strtotime($mytime->toDateString()));
        return view('auth.complete', compact('user','year'));
    }

    public function docsdepo()
    {
        $mytime = Carbon::now()->timezone("America/Mexico_City");
        $year = strftime("%Y",strtotime($mytime->toDateString()));
        return view('docsdepo', compact('year'));
    }

    public function completeDocsdepo(Request $request)
    {  
        if(is_null($request->rfc)){
            $rfc = "NO";
        }else{
            $rfc = strtoupper($request->rfc);
        }

        $docdepo = Docdepo::create([
            'name' => strtoupper($request->name),
            'paternalSurname' => strtoupper($request->paternalSurname),
            'maternalSurname' => strtoupper($request->maternalSurname),
            'birthday' => $request->year."-".$request->month."-".$request->day,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'email' => $request->email,
            'rfc' => $rfc,
            'specialty' => $request->specialty,
            'alias' => $request->alias,
        ]);

        //
        if($request->specialty == "Soy Estudiante"){
            $cedula = Career::create([
                'docdepo_id' => $docdepo->id,
                'career' => $request->career,
                'campus' => $request->plantelSchool,
                'year'=> $request->yearSchool, 
                'degree' => $request->degreeSchool,
            ]);
        }else{
            $cedula = Cedula::create([
                'docdepo_id' => $docdepo->id,
                'campus' => $request->plantel1,
                'year'=> $request->year1, 
                'order' => 1,
            ]);

            if(isset($request->plantel2)){
                $cedula = Cedula::create([
                    'docdepo_id' => $docdepo->id,
                    'campus' => $request->plantel2,
                    'year'=> $request->year2, 
                    'order' => 2,
                ]);
            }

            if(isset($request->plantel3)){
                $cedula = Cedula::create([
                    'docdepo_id' => $docdepo->id,
                    'campus' => $request->plantel3,
                    'year'=> $request->year3, 
                    'order' => 3,
                ]);
            }

            if(isset($request->plantel4)){
                $cedula = Cedula::create([
                    'docdepo_id' => $docdepo->id,
                    'campus' => $request->plantel4,
                    'year'=> $request->year4, 
                    'order' => 4,
                ]);
            }
        }



        if(isset($request->ownOffice)){ 
            $job = Job::create([
                'docdepo_id' => $docdepo->id,
                'type' => 'ownOffice',
                'address' => $request->officeAddress,
                'location' => $request->officeLink,
                'phone' => $request->officePhone,
                'name'  => null,
                'nameAssistant' => null,
                'nameDoctor' => null,
            ]);
            if(isset($request->ownAssistant)){
                $job->nameAssistant = strtoupper($request->nameAssistant);
                $job->save();
            }            
        }
        
        if(isset($request->clinic)){ 
            $job = Job::create([
                'docdepo_id' => $docdepo->id,
                'type' => 'clinic',
                'address' => $request->clinicAddress,
                'location' => $request->clinicLink,
                'phone' => null,
                'name'  => $request->clinicName,
                'nameAssistant' => null,
                'nameDoctor' => null,
            ]);
            if(!is_null($request->colleagues)){
                $colleagues_arr = explode (",", $request->colleagues);
                foreach($colleagues_arr as $colleague_arr){
                    $colleague = Colleague::create([
                        'job_id' => $job->id,
                        'name'  => $colleague_arr,
                    ]);
                    
                }
            }            
        }

        if(isset($request->variousClinics)){ 
            $job = Job::create([
                'docdepo_id' => $docdepo->id,
                'type' => 'variousClinics',
                'address' => null,
                'location' => null,
                'phone' => null,
                'name'  => null,
                'nameAssistant' => null,
                'nameDoctor' => null,
            ]);
            if(!is_null($request->variousClinicsName)){
                $variousClinicsName_arr = explode (",", $request->variousClinicsName);
                foreach($variousClinicsName_arr as $variousClinicsName_obj){
                    $office = Office::create([
                        'job_id' => $job->id,
                        'name'  => $variousClinicsName_obj,
                    ]);
                    
                }
            }   
            if(!is_null($request->variousClinicsCity)){
                $variousClinicsCity_arr = explode (",", $request->variousClinicsCity);
                foreach($variousClinicsCity_arr as $variousClinicsCity_obj){
                    $office = City::create([
                        'job_id' => $job->id,
                        'name'  => $variousClinicsCity_obj,
                    ]);
                    
                }
            }       
        }

        if(isset($request->student)){ 
            $job = Job::create([
                'docdepo_id' => $docdepo->id,
                'type' => 'student',
                'address' => null,
                'location' => $request->studentLink,
                'phone' => null,
                'name'  => $request->studentName,
                'nameAssistant' => null,
                'nameDoctor' => $request->studentDoctor,
            ]);           
        }

        if(isset($request->noWork)){ 
            $job = Job::create([
                'docdepo_id' => $docdepo->id,
                'type' => 'noWork',
                'address' => null,
                'location' => null,
                'phone' => null,
                'name'  => null,
                'nameAssistant' => null,
                'nameDoctor' => null,
            ]);           
        }
        

        if(isset($request->personalBranding)){ 
            $socialNetwork = Social_Network::create([

                'docdepo_id' => $docdepo->id,
                'type' => 'personalBranding',
                'name' => null,
                'facebook' => $request->personalBrandingFB,
                'instagram' => $request->personalBrandingIg,
                'tiktok'  => $request->personalBrandingTik,
                'linkedin' => $request->personalBrandingLI,
                'website'  => $request->personalBrandingWeb,
                'doctoralia'  => $request->doctoralia,
            ]);
        }else{
            if(isset($request->doctoralia)){ 
                $socialNetwork = Social_Network::create([

                    'docdepo_id' => $docdepo->id,
                    'type' => 'personalBranding',
                    'name' => null,
                    'doctoralia'  => $request->doctoralia,
                ]);
            }
        }

        if(isset($request->trademark)){ 
            $socialNetwork = Social_Network::create([

                'docdepo_id' => $docdepo->id,
                'type' => 'trademark',
                'name' => $request->trademarkName,
                'facebook' => $request->trademarkFB,
                'instagram' => $request->trademarkIg,
                'tiktok'  => $request->trademarkTik,
                'linkedin' => $request->trademarkLI,
                'website'  => $request->trademarkWeb,
            ]);
        }
        
        if(isset($request->workClinic)){ 
            $socialNetwork = Social_Network::create([

                'docdepo_id' => $docdepo->id,
                'type' => 'workClinic',
                'name' => $request->workClinicName,
                'facebook' => $request->workClinicFB,
                'instagram' => $request->workClinicIg,
                'tiktok'  => $request->workClinicTik,
                'linkedin' => $request->workClinicLI,
                'website'  => $request->workClinicWeb,
            ]);
        }

        return redirect()->route('docsdepo')->with('success', 'success');

    }

    public function showDoctroDDU($id)
    {
        $doctor = Docdepo::findOrFail($id);

        return view('showDoctorDDU', compact('doctor'));
    }
    
    public function complete(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validation = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'paternalSurname' => ['required', 'string'],
            'maternalSurname' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
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
            'password.required' => "El campo CONTRASEÑA es requerido",
            'password.string' => "La CONTRASEÑA debe ser texto",
            'password.min' => "La CONTRASEÑA debe contener por lo menos 6 caracteres",
            'password.confirmed' => "CONTRASEÑA y CONFIRMAR no coinciden",
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
        try {
            $doctor = Doctor::create([
                'user_id' => $user->id,
                'paternalSurname' => strtoupper($request->paternalSurname),
                'maternalSurname'=> strtoupper($request->maternalSurname),
                'alias' =>  $request->alias,
                //'title' => $request->title,
                'phone' => $request->phone,
                'birthday' => $request->year."-".$request->month."-".$request->day,
                'gender' => $request->gender,
                'specialty' => $request->specialty,
            ]);
        } catch (\Exception $e) {
            $error = Error::create([
                'url' => 'https://novu.mx/complete/'.$user->id,
                'error' =>  $e->getMessage(),
                'request'=> implode(",", $request->all()),
            ]);

            
            $details = [
                'url' => $error->url,
                'error' => $error->error,
                'request' => $error->request,
            ];
            Mail::to('nach.diaz@happeningnm.com')->send(new errorMail($details));

            return redirect()->back()
            ->withErrors(  $e->getMessage() )
            ->withInput();

        }
        if(isset($doctor)){
            $user->name = strtoupper($request->name);
            $user->password = bcrypt($request->password);
            $user->email_verified_at  = Carbon::now()->format('Y-m-d H:i:s');
            $user->save();

            $error = Error::create([
                'url' => 'https://novu.mx/complete/'.$user->id,
                'error' =>  "NO OCURRIO NINGUN ERROR",
                'request'=> implode(",", $request->all()),
            ]);

            $details = [
                'url' => $error->url,
                'error' => $error->error,
                'request' => $error->request,
            ];
            Mail::to('nach.diaz@happeningnm.com')->send(new errorMail($details));

            Auth::login($user);

            // Crear entradas en la tabla Cupones para actualizar
    $cupones = [
        ['id_doctor' => $doctor->id, 'nombre_cupon' => 'Cupon75', 'estatus' => 'Activo'],
        ['id_doctor' => $doctor->id, 'nombre_cupon' => 'Cupon50', 'estatus' => 'Activo'],
        ['id_doctor' => $doctor->id, 'nombre_cupon' => 'Cupon25_1', 'estatus' => 'Activo'],
        ['id_doctor' => $doctor->id, 'nombre_cupon' => 'Cupon25_2', 'estatus' => 'Activo'],
        ['id_doctor' => $doctor->id, 'nombre_cupon' => 'Cupon25_3', 'estatus' => 'Activo'],
    ];
    // Insertar las entradas en la tabla Cupones
    DB::table('cupones')->insert($cupones);
    
            return redirect()->route('login');
        }else{
            $details = [
                'url' => 'https://novu.mx/complete/'.$user->id,
                'error' => "Error",
                'request' => implode(",", $request->all()),
            ];
            Mail::to('nach.diaz@happeningnm.com')->send(new errorMail($details));

            return redirect()->back()
            ->withErrors( ['name' => 'Ha ocurrido un error, por favor vuelva a ingresar los datos.'] )
            ->withInput();
        }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $role = $user->getRoleNames()->first();
        $vA = session('flagUser');
        session()->forget('flagUser');
        return view('editUser', compact('user','role','vA'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validation = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'max:255', 'unique:users,email,'.$user->id],
            'type' => ['required'],
        ],[
            'name.required' => "El campo nombre es obligatorio",
            'name.string' => "El nombre debe ser texto",
            'email.required' => "El campo email es obligatorio",
            'email.unique' => "El email de usuario ya esta registrado",
            'type.required' => "El campo tipo es obligatorio",
        ]);

        if( $validation->fails() )
        {
            return redirect()->back()
            ->withErrors( $validation->errors() )
            ->withInput();
        } 
        
        $user->name  = $request->name;
        $user->email  = $request->email;
        $user->save();

        $roles = $user->getRoleNames();
        foreach($roles as $role){
            $user->removeRole($role);
        }
        
        $user->assignRole($request->type);
        session(['flagUser' => true]);
        return redirect()->route('editarUsuario',['id' => $user->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::withTrashed()->with('doctor')->findOrFail($id);
        if(is_null($user->email_verified_at)){
            $studies = null;
        }else{
            $studies = Study::where('doctor_id',$user->doctor->id)->with('appointment')->orderBy('created_at', 'DESC')->paginate(10);
        }

        return view('showDoctor', compact('user','studies'));
    }    

    public function all($id)
    {
        $doctor = Doctor::findOrFail($id);
        $studies = Study::where('doctor_id',$doctor->id)->with('appointment')->orderBy('created_at', 'DESC')->get();

        return view('allStudyAdmin', compact('studies'));
    }

    public function showStudy($id)
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

        return view('showStudyAdmin',compact('study','arrayStudies','cfdis'));
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
        $user->assignRole($request->type);
        session(['flagUser' => true]);
        return redirect()->route('editarUsuario',['id' => $user->id]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        /*
        $user->roles()->detach();
        */
        $user->delete();
        return 200;
    }
    public function reset($id)
    {
        $user = User::withTrashed()->where('id', $id)->restore();

        return 200;
    }
    public function resetRadiologo($id)
    {
        $radiologist = Radiologist::findOrFail($id);
        $radiologist->status = null;
        $radiologist->save();
        
        return 200;
    }
    
    

    public function destroyDoctor($id)
    {
        $user = User::with('doctor')->findOrFail($id);
        /*
        $user->roles()->detach();
        if(!is_null($user->doctor)){
            $user->doctor->delete();
        }
        */
        $user->delete();
        
        return 200;
    }
    
    public function destroyRadiolog($id)
    {
        $radiologist = Radiologist::findOrFail($id);
        $radiologist->status = "BAJA";
        $radiologist->save();
        return 200;
    }
    
    public function resendMail($id)
    {   
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // Output: video-g6swmAP8X5VG4jCi.mp4
        $token = substr(str_shuffle($permitted_chars), 0, 32);

        $user = User::findOrFail($id);
        $user->password  = $token;
        $user->save();

        $details = [
            'token' => $token
        ];
        Mail::to($user->email)->send(new Verification($details));

        return 200;
    }
    

    public function updateRadiologo(Request $request, $id)
    {
        $radiologist = Radiologist::findOrFail($request->id);
        $radiologist->name = $request->name;
        $radiologist->save();
        
        return 200;
    }

    public function validarDoctor($id)
    {
        $user = User::findOrFail($id);
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // Output: video-g6swmAP8X5VG4jCi.mp4
        $token = substr(str_shuffle($permitted_chars), 0, 32);

        $user->status  = true;
        $user->password  = $token;

        $details = [
            'token' => $token
        ];
        Mail::to($user->email)->send(new Verification($details));
        
        $user->save();

        return 200;
    }
}
