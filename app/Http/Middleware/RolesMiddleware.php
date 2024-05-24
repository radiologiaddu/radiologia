<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Http\Middleware\Role;
use Illuminate\Support\Facades\URL;

class RolesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$role)
    {   
        //URL::forceScheme('https');

        if(!$request->user()->hasAnyRole($role)){
            $roles = $request->user()->getRoleNames();

            switch($roles[0]){
                case 'SuperAdministrador':
                    if($role != 'Administrador'){
                        return redirect()->route('users');
                    }
                    break;
                case 'Administrador':
                    return redirect()->route('users');
                    break;
                case 'Doctor':
                    return redirect()->route('welcome');
                    break;
                case 'Recepcion':
                    return redirect()->route('recepcion');
                    break;
                case 'Hostess':
                    return redirect()->route('hostess');
                    break;
                case 'Caja':
                    return redirect()->route('caja');
                    break;
                case 'Coordinador':
                    return redirect()->route('agenda');
                    break;
                case 'Radiologo':
                    return redirect()->route('AgendaRadiologo');
                    break;
                default:
                    Auth::logout();
                    return redirect('login');
                    break;
            }
        }
        return $next($request);       
    }
}
