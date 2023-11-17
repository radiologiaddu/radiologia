<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Type;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Dependency;

class QuestionController extends Controller
{
    //
    public function new($id)
    {
        $type = Type::with('questions')->findOrFail($id);
        return view('newQuestion', compact('type'));
    }

    public function add(Request $request,$id)
    {
        $question = Question::create([
            'question' => $request->question,
            'kind' => $request->kind,
            'type_id' => $id,
        ]);
        if($request->gridRadios != 'none'){
            $question->class_note  = $request->gridRadios;
            $question->note  = $request->note;
            $question->save();
        }
        if(isset($request->answers) && $request->kind != "texto")
        {
            foreach ($request->answers as $answer) {
                if(!is_null(request($answer))){
                    if(is_null(request($answer.'cost'))){
                        $cost = null;
                    }else{
                        $cost = str_replace(',','',str_replace('$', '', request($answer.'cost')));
                    }
                    if(is_null(request($answer.'costDoctor'))){
                        $costDoctor = null;
                    }else{
                        $costDoctor = str_replace(',','',str_replace('$', '', request($answer.'costDoctor')));
                    }
                    $newAnswer = new Answer();
                    $newAnswer->answer = request($answer);
                    $newAnswer->question_id = $question->id;
                    $newAnswer->cost = $cost ;
                    $newAnswer->costDoctor = $costDoctor ;
                    $newAnswer->study_time = request($answer.'study_time');
                    $newAnswer->preparation_time = request($answer.'preparation_time');
                    $newAnswer->exit_time = request($answer.'exit_time');
                    $newAnswer->save();
                }
            }
        }else{
            if(isset($request->response) && $request->kind == "texto"){
                foreach($request->response as $response){
                    $dependency = Dependency::create([
                        'question_id' => $question->id,
                        'answer_id' => $response
                    ]);
                }
            }
        }

        return redirect()->route('seeType',['id' => $id]) ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $question = Question::with('dependency')->with('type')->with('answer')->findOrFail($id);
        return view('editQuestion', compact('question'));
    }

    public function update(Request $request, $id)
    {
        $question = Question::findOrFail($id);
        $question->question  = $request->question;
        $question->kind  = $request->kind;
        if($request->gridRadios != 'none'){
            $question->class_note  = $request->gridRadios;
            $question->note  = $request->note;
        }else{
            $question->class_note  = null;
            $question->note  = null;
        }
        $question->save();

        $preloaded = [];
        if(isset($request->prev))
        {
            $preloaded = $request->prev;
        }

        if($request->kind == "texto"){
            $answers = Answer::where('question_id',$id)->delete();
            
            if(isset($request->response)){
                $dependencies = Dependency::where('question_id',$id)->get();
                foreach($dependencies as $dependencyOld){
                    if (!in_array($dependencyOld->answer_id, $request->response)) {
                        $dependencyOld->delete();
                    }
                }
                foreach($request->response as $response){
                    $dependencyOld = Dependency::where('answer_id',$response)->get();
                    if(count($dependencyOld) == 0){
                        $dependency = Dependency::create([
                            'question_id' => $question->id,
                            'answer_id' => $response
                        ]);
                    }
                }
            }else{
                $dependencies = Dependency::where('question_id',$id)->delete();
            }
            
        }else{
            $dependencies = Dependency::where('question_id',$id)->delete();
        
            $answers = Answer::where('question_id',$id)->get();
            foreach($answers as $answer){

                if (!in_array($answer->id, $preloaded)) {
                    $answer->delete();
                }else{
                    if(is_null(request('prev'.$answer->id.'cost'))){
                        $cost = null;
                    }else{
                        $cost = str_replace(',','',str_replace('$', '', request('prev'.$answer->id.'cost')));
                    }
                    if(is_null(request('prev'.$answer->id.'costDoctor'))){
                        $costDoctor = null;
                    }else{
                        $costDoctor = str_replace(',','',str_replace('$', '', request('prev'.$answer->id.'costDoctor')));
                    }
                    $answer->answer = request('prev'.$answer->id);
                    $answer->cost = $cost;
                    $answer->costDoctor = $costDoctor;
                    $answer->study_time = request('prev'.$answer->id.'study_time');
                    $answer->preparation_time = request('prev'.$answer->id.'preparation_time');
                    $answer->exit_time = request('prev'.$answer->id.'exit_time');

                    $answer->save();    
                }
            }
        }

        if(isset($request->answers) && $request->kind != "texto")
        {
            foreach ($request->answers as $answer) {
                if(!is_null(request($answer))){
                    if(is_null(request($answer.'cost'))){
                        $cost = null;
                    }else{
                        $cost = str_replace(',','',str_replace('$', '', request($answer.'cost')));
                    }
                    if(is_null(request($answer.'costDoctor'))){
                        $costDoctor = null;
                    }else{
                        $costDoctor = str_replace(',','',str_replace('$', '', request($answer.'costDoctor')));
                    }
                    $newAnswer = new Answer();
                    $newAnswer->answer = request($answer);
                    $newAnswer->question_id = $question->id;
                    $newAnswer->cost = $cost;
                    $newAnswer->costDoctor = $costDoctor;
                    $newAnswer->study_time = request($answer.'study_time');
                    $newAnswer->preparation_time = request($answer.'preparation_time');
                    $newAnswer->exit_time = request($answer.'exit_time');
                    $newAnswer->save();
                }
            }
        }

        return redirect()->route('seeType',['id' => $question->type_id]) ;
    }


    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        
        $answers = Answer::where('question_id',$id)->get();
        foreach($answers as $answer){
            $answer->delete();
        }

        $question->delete();

        return 200;
    }
}
