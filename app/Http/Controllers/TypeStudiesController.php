<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Type;
use App\Models\Question;
use App\Models\Answer;

class TypeStudiesController extends Controller
{
    //
    public function index()
    {
        $types = Type::orderBy('id')->get();
        return view('types', compact('types'));
    }

    public function show($id)
    {
        $type = Type::with('questions')->findOrFail($id);

        return view('showType', compact('type'));
    }

    public function create()
    {
        return view('addType');
    }

    public function store(Request $request)
    {   
        $type = Type::create([
            'type' => $request->typeStudie,
        ]);
        if($request->gridRadios != 'none'){
            $type->class_note  = $request->gridRadios;
            $type->note  = $request->note;
            $type->save();
        }
        
        return redirect()->route('types');
    }

    public function edit($id)
    {
        $type = Type::with('questions')->findOrFail($id);

        return view('editType', compact('type'));
    }

    public function update(Request $request, $id)
    {
        $type = Type::findOrFail($id);
        $type->type  = $request->typeStudie;
        if($request->gridRadios != 'none'){
            $type->class_note  = $request->gridRadios;
            $type->note  = $request->note;
        }else{
            $type->class_note  = null;
            $type->note  = null;
        }
        $type->save();

        
        return redirect()->route('types');
    }

    public function destroy($id)
    {
        $type = Type::findOrFail($id);

        $questions = Question::where('type_id',$id)->get();
        foreach($questions as $question){
            $answers = Answer::where('question_id',$question->id)->get();
            foreach($answers as $answer){
                $answer->delete();
            }
            $question->delete();
        }        

        $type->delete();

        return 200;
    }
}
