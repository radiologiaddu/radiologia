<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Referral;


class referralController extends Controller
{
    public function index()
    {
        $referrals = Referral::all();
        return view('referral',compact('referrals'));
    }

    public function store(Request $request)
    {   
        $referral = Referral::create([
            'name' => $request->name,
        ]);

        return 200;
    }

    public function destroy($id)
    {
        $referral = Referral::findOrFail($id);
        $referral->delete();
        return 200;
    }

    public function update(Request $request, $id)
    {
        $referral = Referral::findOrFail($id);
        $referral->name = $request->name;
        $referral->save();
        
        return 200;
    }
}
