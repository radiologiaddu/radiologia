<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discount;

class discountController extends Controller
{
    public function index()
    {
        $discounts = Discount::all();
        return view('discounts',compact('discounts'));
    }

    public function create()
    {
        return view('newDiscount');
    }

    public function store(Request $request)
    {   
        $discount = Discount::create([
            'type' => $request->descuento,
            'percentage' => $request->porcentaje,
        ]);

        return redirect()->route('discounts') ;
    }
    
    public function destroy($id)
    {
        $discount = Discount::findOrFail($id);
        $discount->delete();
        return 200;
    }

    public function update(Request $request, $id)
    {
        $discount = Discount::findOrFail($id);
        $discount->type = $request->type;
        $discount->percentage = $request->porcentaje;
        $discount->save();
        
        return 200;
    }
}
