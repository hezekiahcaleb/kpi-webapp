<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Form;
use App\Models\FormMapping;
use App\Models\FormDetail;
use App\Rules\IndicatorWeight;

class FormController extends Controller
{
    public function insertForm(Request $request){
        $validator = Validator::make($request->all(),[
            'formname' => 'required',
            'formdesc' => 'required',
            'mapping' => 'required|array|min:1',
            'indicator' => 'required|array|min:1',
            'indicator' => [new IndicatorWeight]
        ]);

        if($validator->fails()){
            return back()->withErrors($validator);
        }

        $form = new Form();
        $form->form_name = $request->formname;
        $form->form_description = $request->formdesc;
        $form->save();

        foreach($request->mapping as $mapping){
            $formMapping = new FormMapping();
            $formMapping->form_id = $form->id;
            $formMapping->role_id = $mapping;
            $formMapping->save();
        }

        foreach($request->indicator as $indicatorData){
            $indicator = new FormDetail();
            $indicator->form_id = $form->id;
            $indicator->indicator_name = $indicatorData['name'];
            $indicator->description = $indicatorData['description'];
            $indicator->target = $indicatorData['target'];
            $indicator->weight = $indicatorData['weight'];
            $indicator->save();
        }

        session()->flash('message', 'Form successfully added!');
        return redirect()->back();
    }

    public function updateForm(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'formname' => 'required',
            'formdesc' => 'required',
            'mapping' => 'required|array|min:1',
            'indicator' => 'required|array|min:1',
            'indicator' => [new IndicatorWeight]
        ]);

        if($validator->fails()){
            return back()->withErrors($validator);
        }

        $form = Form::find($id);
        if($form != null){
            $form->form_name = $request->formname;
            $form->form_description = $request->formdesc;

            $delIndicators = FormDetail::where('form_id', $id)->get();
            $delMappings = FormMapping::where('form_id', $id)->get();

            $mappings = $request->input('mapping');
            foreach($mappings as $mapping){
                $mappingExist = FormMapping::where('form_id', $id)->where('role_id', $mapping)->get();
                if($mappingExist->isEmpty()){
                    $formMapping = new FormMapping();
                    $formMapping->form_id = $id;
                    $formMapping->role_id = $mapping;
                    $formMapping->save();
                } else{
                    $delMappings = $delMappings->filter(function($item) use ($mappingExist){
                        return $item != $mappingExist->first();
                    });
                }
            }

            foreach($request->indicator as $indicatorData){
                $indicator = new FormDetail();
                $indicator->form_id = $id;

                if($indicatorData['id'] != null){
                    $indicator = FormDetail::find($indicatorData['id']);
                    if($indicator == null){
                        $indicator = new FormDetail();
                    } else {
                        $delIndicators = $delIndicators->filter(function($item) use ($indicator){
                            return $item != $indicator;
                        });
                    }
                }

                $indicator->indicator_name = $indicatorData['name'];
                $indicator->description = $indicatorData['description'];
                $indicator->target = $indicatorData['target'];
                $indicator->weight = $indicatorData['weight'];
                $indicator->save();
            }

            foreach($delIndicators as $delIndicator){
                $delIndicator->delete();
            }
            foreach($delMappings as $delMapping){
                $delMapping->delete();
            }
            $form->save();
        }

        return redirect()->back();
    }

    public function deleteForm($id){
        $form = Form::find($id);

        if($form!=null){
            FormMapping::where('form_id', $id)->delete();
            FormDetail::where('form_id', $id)->delete();

            $form->delete();

            session()->flash('message', 'Form successfully deleted!');
            return redirect()->back();
        }

        session()->flash('message', "Form doesn't exist!");
        return redirect()->back();
    }
}
