<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notification;
use App\Events\StatusLiked;
use App\Events\myEvent;
use Twilio\Rest\Client;
use Twilio\Exceptions;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/testTwilio', function () {
    $sid    = "AC3d4c52a4c8b37bb0f5f52845cccc46ef";
    $token  = "c9e766aa6392c7efb5a56b8dda1d5bca";
    $twilio = new Client($sid, $token);
    $body = "HOLA Nombre de Usuario\n Los datos de tu estudio: ".route('showDetails' ,['id' =>'5eCukRD4xGNKbnXOZTclYtgz9H6qsIh1167'])." \nHAZ TU CITA: ".route('appointment' ,['id' => '5eCukRD4xGNKbnXOZTclYtgz9H6qsIh1167']);
    //dd($body);
    $message = $twilio->messages
      ->create("whatsapp:+521"."4448588272", // to
        array(
          "from" => "whatsapp:+14155238886",
          "body" => $body
        )
      );
    $message = $twilio->messages
    ->create("whatsapp:+521"."5552172412", // to
    array(
        "from" => "whatsapp:+14155238886",
        "body" => $body
    )
    );

print($message->sid);
/*
$sid    = "AC3d4c52a4c8b37bb0f5f52845cccc46ef";
$token  = "c9e766aa6392c7efb5a56b8dda1d5bca";
$twilio = new Client($sid, $token);

$message = $twilio->messages
  ->create("+524448588272", // to
    array(
      "from" => "+12184234928",
      "body" => "Your Message"
    )
  );

print($message->sid);
*/
});
//Vista imagenes
Route::get('/viewVerification', function () {
    $details = [
        'token' => "qwertyuiop"
    ];

    return view('mail/verification',compact('details'));
});

Route::get('/mail/newStudy', function () {

})->name('testNewStudy');

Route::get('/viewSend', function () {

    return view('mail/sendStudy');
});

Route::get('/docsdepo', [App\Http\Controllers\UserController::class, 'docsdepo'])->name('docsdepo');
Route::post('/completeDocsdepo', [App\Http\Controllers\UserController::class, 'completeDocsdepo'])->name('completeDocsdepo');

Route::get('/code/{id}', [App\Http\Controllers\QRController::class, 'index'])->name('code');
Route::get('/statusCode', [App\Http\Controllers\QRController::class, 'status'])->name('statusCode');

Route::get('/appointment/{id}', [App\Http\Controllers\StudyController::class, 'index'])->name('appointment');
Route::get('/showDetails/{id}', [App\Http\Controllers\StudyController::class, 'showDetails'])->name('showDetails');


Route::put('/schedule/{id}', [App\Http\Controllers\StudyController::class, 'store'])->name('schedule');
Route::post('/getHour', [App\Http\Controllers\StudyController::class, 'getHour'])->name('getHour');
Route::get('/successAppointment/{id}', [App\Http\Controllers\StudyController::class, 'success'])->name('successAppointment');
Route::get('/invoice/{id}', [App\Http\Controllers\StudyController::class, 'invoice'])->name('invoice');
Route::put('/addInvoice/{id}', [App\Http\Controllers\StudyController::class, 'addInvoice'])->name('addInvoice');

Auth::routes(['register' => false, 'verify' => true]);

Route::group(['middleware'=>['verified','auth']],function(){
    Route::get('/export/{id}', [App\Http\Controllers\recordController::class, 'downloadExcel'])->name('export');

    Route::group(['middleware'=>['role:Administrador']],function(){
        Route::get('/', function () {
            return redirect()->route('users');
        });
        Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users');
        Route::get('/doctores', [App\Http\Controllers\UserController::class, 'doctores'])->name('doctores');
        Route::get('/doctoresddu', [App\Http\Controllers\UserController::class, 'doctoresDDU'])->name('DoctoresDDU');
        Route::get('/seeDoctorddu/{id}', [App\Http\Controllers\UserController::class, 'showDoctroDDU'])->name('seeDoctorDDU');  
        Route::get('/statisticsAdmin', [App\Http\Controllers\statisticController::class, 'index'])->name('statisticsAdmin');
       
        Route::get('/discounts', [App\Http\Controllers\discountController::class, 'index'])->name('discounts');        
        Route::get('/newDiscount', [App\Http\Controllers\discountController::class, 'create'])->name('newDiscount');        
        Route::post('/addDiscount', [App\Http\Controllers\discountController::class, 'store'])->name('addDiscount');
        Route::delete('/removeDiscount/{id}', [App\Http\Controllers\discountController::class, 'destroy'])->name('deleteDiscount');
        Route::put('/updateDiscount/{id}', [App\Http\Controllers\discountController::class, 'update'])->name('updateDiscount');        

        Route::get('/referidos', [App\Http\Controllers\referralController::class, 'index'])->name('referidos');        
        Route::post('/addReferral', [App\Http\Controllers\referralController::class, 'store'])->name('addReferral');
        Route::delete('/removeReferral/{id}', [App\Http\Controllers\referralController::class, 'destroy'])->name('deleteReferral');
        Route::put('/updateReferral/{id}', [App\Http\Controllers\referralController::class, 'update'])->name('updateReferral');        

        Route::put('admin/updateDoctor/{id}', [App\Http\Controllers\UserController::class, 'updateDoctor'])->name('adminUpdateDoctor');
        Route::delete('/removeDoctor/{id}', [App\Http\Controllers\UserController::class, 'removeDoctor'])->name('removeDoctor');
        Route::put('validarDoctor/{id}', [App\Http\Controllers\UserController::class, 'validarDoctor'])->name('validarDoctor');

        Route::get('/radiologia', [App\Http\Controllers\UserController::class, 'radiologist'])->name('radiologia');
        Route::get('/newUser', [App\Http\Controllers\UserController::class, 'create'])->name('newUser');
        Route::get('/nuevoDoctor', [App\Http\Controllers\UserController::class, 'createDoctor'])->name('nuevoDoctor');
        Route::post('/addUser', [App\Http\Controllers\UserController::class, 'store'])->name('addUser');
        Route::post('/addDoctor', [App\Http\Controllers\UserController::class, 'storeDoctor'])->name('addDoctor');
        Route::post('/addRadiologo', [App\Http\Controllers\UserController::class, 'storeRadiologo'])->name('addRadiologo');
        Route::get('/editarUsuario/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('editarUsuario');
        Route::put('/updateUser/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('updateUser');
        Route::put('/updateRadiologo/{id}', [App\Http\Controllers\UserController::class, 'updateRadiologo'])->name('updateRadiologo');
        Route::put('/changePassword/{id}', [App\Http\Controllers\UserController::class, 'changePassword'])->name('changePassword');
        Route::delete('/deleteUser/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('deleteUser');
        Route::put('/RestUser/{id}', [App\Http\Controllers\UserController::class, 'reset'])->name('RestUser');        
        Route::delete('/deleteDoctor/{id}', [App\Http\Controllers\UserController::class, 'destroyDoctor'])->name('deleteDoctor');
        Route::put('/RestDoctor/{id}', [App\Http\Controllers\UserController::class, 'reset'])->name('RestDoctor');        
        Route::delete('/deleteRadiolog/{id}', [App\Http\Controllers\UserController::class, 'destroyRadiolog'])->name('deleteRadiolog');
        Route::put('/RestRadiologo/{id}', [App\Http\Controllers\UserController::class, 'resetRadiologo'])->name('RestRadiologo');        
        Route::post('/resendMail/{id}', [App\Http\Controllers\UserController::class, 'resendMail'])->name('resendMail');
        Route::get('/seeDoctor/{id}', [App\Http\Controllers\UserController::class, 'show'])->name('seeDoctor');  
        Route::get('/TodosestudiosDoctor/{id}', [App\Http\Controllers\UserController::class, 'all'])->name('TodosestudiosAdmin');  
        Route::get('/seeStudy/{id}', [App\Http\Controllers\UserController::class, 'showStudy'])->name('seeStudy');  

        Route::get('/historial/{id}', [App\Http\Controllers\recordController::class, 'records'])->name('historial');  
        Route::get('/record', [App\Http\Controllers\recordController::class, 'all'])->name('record');  
        Route::post('/allRecordReload', [App\Http\Controllers\recordController::class, 'allReload'])->name('allRecordReload');  

        
        Route::get('/tiposEstudios', [App\Http\Controllers\TypeStudiesController::class, 'index'])->name('types');
        Route::get('/nuevoTipo', [App\Http\Controllers\TypeStudiesController::class, 'create'])->name('newType');
        Route::post('/addType', [App\Http\Controllers\TypeStudiesController::class, 'store'])->name('addType');
        Route::delete('/deleteType/{id}', [App\Http\Controllers\TypeStudiesController::class, 'destroy'])->name('deleteType');
        Route::get('/editarTipo/{id}', [App\Http\Controllers\TypeStudiesController::class, 'edit'])->name('editType');
        Route::put('/updateType/{id}', [App\Http\Controllers\TypeStudiesController::class, 'update'])->name('updateType');
        Route::get('/seeType/{id}', [App\Http\Controllers\TypeStudiesController::class, 'show'])->name('seeType'); 
        Route::get('/newQuestion/{id}', [App\Http\Controllers\QuestionController::class, 'new'])->name('newQuestion');          
        Route::post('/addQuestion/{id}', [App\Http\Controllers\QuestionController::class, 'add'])->name('addQuestion');
        Route::get('/editQuestion/{id}', [App\Http\Controllers\QuestionController::class, 'edit'])->name('editQuestion'); 
        Route::put('/updateQuestion/{id}', [App\Http\Controllers\QuestionController::class, 'update'])->name('updateQuestion');
        Route::delete('/deleteQuestion/{id}', [App\Http\Controllers\QuestionController::class, 'destroy'])->name('deleteQuestion');        
        
        Route::get('/AgendaAdmin', [App\Http\Controllers\coorController::class, 'agendaAdmin'])->name('AgendaAdmin');
        Route::post('/newDateAdmin', [App\Http\Controllers\coorController::class, 'newDate'])->name('newDateAdmin');
        
    });
    Route::group(['middleware'=>['role:Doctor']],function(){
        Route::get('/Bienvenido', [App\Http\Controllers\HomeController::class, 'index'])->name('welcome');
        Route::get('/Misestudios', [App\Http\Controllers\DoctorController::class, 'index'])->name('Misestudios');
        Route::get('/Perfil', [App\Http\Controllers\DoctorController::class, 'profil'])->name('Perfil');
        Route::get('/Editarperfil', [App\Http\Controllers\DoctorController::class, 'edit'])->name('EditProfil');
        Route::put('/updateDoctor/{id}', [App\Http\Controllers\DoctorController::class, 'update'])->name('updateDoctor');
        Route::put('/changePasswordDr/{id}', [App\Http\Controllers\DoctorController::class, 'changePassword'])->name('changePasswordDr');

        Route::get('/Todosestudios', [App\Http\Controllers\DoctorController::class, 'all'])->name('Todosestudios');
        Route::get('/Nuevoestudio', [App\Http\Controllers\DoctorController::class, 'create'])->name('Nuevoestudio');
        Route::post('/question', [App\Http\Controllers\DoctorController::class, 'question'])->name('question');
        Route::post('/addStudy/{id}', [App\Http\Controllers\DoctorController::class, 'store'])->name('addStudy');
        Route::get('/showStudy/{id}', [App\Http\Controllers\DoctorController::class, 'show'])->name('showStudy');
    });
    Route::group(['middleware'=>['role:Recepcion']],function(){
        Route::get('/Recepcion', [App\Http\Controllers\ReceptionController::class, 'index'])->name('recepcion');
        Route::post('/RecepcionReload', [App\Http\Controllers\ReceptionController::class, 'indexReload'])->name('RecepcionReload');  
        Route::get('/verEstudioRecep/{id}', [App\Http\Controllers\ReceptionController::class, 'show'])->name('showStudyRecep');
        Route::get('/enviarEstudios/{id?}', [App\Http\Controllers\ReceptionController::class, 'sendStudy'])->name('sendStudy');
        Route::post('/getStudy', [App\Http\Controllers\ReceptionController::class, 'getStudy'])->name('getStudy');
        Route::post('/sendEmailStudy/{id?}', [App\Http\Controllers\ReceptionController::class, 'sendEmailStudy'])->name('sendEmailStudy');
        Route::post('/cashier', [App\Http\Controllers\ReceptionController::class, 'cashier'])->name('cashier');
        Route::put('/addInvoiceRec/{id}', [App\Http\Controllers\ReceptionController::class, 'addInvoice'])->name('addInvoiceRec');
        Route::get('/historialRec/{id}', [App\Http\Controllers\recordController::class, 'recordsRec'])->name('historialRec');  
        Route::get('/recordRec', [App\Http\Controllers\recordController::class, 'allRec'])->name('recordRec');  
        Route::post('/recordRecReload', [App\Http\Controllers\recordController::class, 'allRecReload'])->name('recordRecReload');  
        Route::get('/editRecepcion/{id}', [App\Http\Controllers\ReceptionController::class, 'editRecepcion'])->name('editRecepcion');  
        Route::post('/questionRec', [App\Http\Controllers\ReceptionController::class, 'question'])->name('questionRec');
        Route::put('/updateStudy/{id}', [App\Http\Controllers\ReceptionController::class, 'updateStudy'])->name('updateStudy');
        Route::post('/folio/{id}', [App\Http\Controllers\ReceptionController::class, 'folio'])->name('folio');
        Route::post('/finishRecepcion/{id}', [App\Http\Controllers\ReceptionController::class, 'finish'])->name('finishRecepcion');
        Route::get('/nuevoEstudioRec', [App\Http\Controllers\ReceptionController::class, 'create'])->name('nuevoEstudioRec');
        //Route::post('/questionRec', [App\Http\Controllers\DoctorController::class, 'question'])->name('questionRec');
        Route::post('/addStudyRec', [App\Http\Controllers\ReceptionController::class, 'store'])->name('addStudyRec');
        Route::get('/AgendaRecepcion', [App\Http\Controllers\coorController::class, 'agendaRecepcion'])->name('AgendaRecepcion');
        Route::post('/newDateRecepcion', [App\Http\Controllers\coorController::class, 'newDate'])->name('newDateRecepcion');      
    });
    
    Route::group(['middleware'=>['role:Hostess']],function(){
        Route::get('/Hostess', [App\Http\Controllers\HostessController::class, 'index'])->name('hostess');
        Route::get('/Pasados', [App\Http\Controllers\HostessController::class, 'past'])->name('pasados');
        Route::get('/Precios', [App\Http\Controllers\HostessController::class, 'prices'])->name('prices');

        Route::post('/HostessReload', [App\Http\Controllers\HostessController::class, 'indexReload'])->name('HostessReload');  
        Route::get('/statusAppointment/{id}', [App\Http\Controllers\QRController::class, 'status'])->name('statusAppointment');
        Route::post('/changeStatus', [App\Http\Controllers\QRController::class, 'change'])->name('changeStatus');
        //Route::get('/nuevoEstudioHostess', [App\Http\Controllers\HostessController::class, 'create'])->name('newStudyHostess');
        Route::post('/questionH', [App\Http\Controllers\DoctorController::class, 'question'])->name('questionH');
        Route::post('/addStudyH', [App\Http\Controllers\HostessController::class, 'store'])->name('addStudyH');

    });

    Route::group(['middleware'=>['role:Caja']],function(){
        Route::get('/Caja', [App\Http\Controllers\cashController::class, 'index'])->name('caja');
        Route::post('/CajaReload', [App\Http\Controllers\cashController::class, 'indexReload'])->name('CajaReload');  
        Route::get('/verEstudioCaja/{id}', [App\Http\Controllers\cashController::class, 'show'])->name('showStudyCaja');
        Route::post('/pay', [App\Http\Controllers\cashController::class, 'pay'])->name('pay');
    });

    
    Route::group(['middleware'=>['role:Coordinador']],function(){
        Route::get('/doctoresCoor', [App\Http\Controllers\coorController::class, 'doctores'])->name('doctoresCoor');
        Route::get('/nuevoDoctorCoo', [App\Http\Controllers\coorController::class, 'createDoctorCoo'])->name('nuevoDoctorCoo');
        Route::post('/addDoctorCoo', [App\Http\Controllers\coorController::class, 'storeDoctor'])->name('addDoctorCoo');
        Route::delete('/removeDoctorCoo/{id}', [App\Http\Controllers\UserController::class, 'removeDoctor'])->name('removeDoctorCoo');
        Route::put('admin/updateDoctorCoo/{id}', [App\Http\Controllers\coorController::class, 'updateDoctor'])->name('adminUpdateDoctorCoo');

        Route::get('/Agenda', [App\Http\Controllers\coorController::class, 'agenda'])->name('agenda');
        Route::post('/newEventDrop', [App\Http\Controllers\coorController::class, 'newEventDrop'])->name('newEventDrop');
        Route::post('/eventDrop', [App\Http\Controllers\coorController::class, 'eventDrop'])->name('eventDrop');
        Route::post('/newDate', [App\Http\Controllers\coorController::class, 'newDate'])->name('newDate');        
        Route::get('/Coordinador', [App\Http\Controllers\coorController::class, 'index'])->name('coordinador');
        Route::post('/CoordinadorReload', [App\Http\Controllers\coorController::class, 'indexReload'])->name('CoordinadorReload');  
        Route::get('/verEstudioCoordinacion/{id}', [App\Http\Controllers\coorController::class, 'show'])->name('showStudyCoo');
        Route::post('/start', [App\Http\Controllers\coorController::class, 'start'])->name('start');
        Route::post('/finish', [App\Http\Controllers\coorController::class, 'finish'])->name('finish');
        Route::get('/historialCoo/{id}', [App\Http\Controllers\recordController::class, 'recordsCoo'])->name('historialCoo');  
        Route::get('/recordCoo', [App\Http\Controllers\recordController::class, 'allCoo'])->name('recordCoo');  
        Route::post('/recordCooReload', [App\Http\Controllers\recordController::class, 'allCooReload'])->name('recordCooReload');
        Route::get('/perfil-doctor/{userId}', [App\Http\Controllers\DoctorController::class, 'showProfile'])->name('profile');  
    });

    Route::group(['middleware'=>['role:Radiologo']],function(){
        Route::get('/AgendaRadiologo', [App\Http\Controllers\radiologistController::class, 'agenda'])->name('AgendaRadiologo'); 
        Route::get('/Radiologo', [App\Http\Controllers\radiologistController::class, 'index'])->name('Radiologo');  
        Route::post('/RadiologoReload', [App\Http\Controllers\radiologistController::class, 'indexReload'])->name('RadiologoReload');  
        Route::post('/finishRadio', [App\Http\Controllers\radiologistController::class, 'finish'])->name('finishRadio');
        Route::post('/newDateRadio', [App\Http\Controllers\coorController::class, 'newDate'])->name('newDateRadio');        
    });
});

Route::get('/emailVerification/{token}', [App\Http\Controllers\UserController::class, 'verification'])->name('emailVerification');
Route::put('/complete/{id}', [App\Http\Controllers\UserController::class, 'complete'])->name('complete');


Route::get('/home', function () {
    return redirect()->route('welcome');
})->name('home');

Route::get('/Terminos', function () {
    return view('Term');
})->name('Terminos');
Route::get('/Aviso-Privacidad', function () {
    return view('Privacy');
})->name('Privacy');

Route::get('/logout',  '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::get('test', function () {
    event(new StatusLiked('Someone'));
    event(new myEvent('Someone'));
    return "Event has been sent!";
});
// Ruta en web.php
Route::post('/actualizar-estatus/{userId}', [App\Http\Controllers\DoctorController::class, 'actualizarEstatusReport']);
