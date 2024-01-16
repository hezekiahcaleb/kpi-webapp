<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\KpiResult;
use App\Models\Form;
use App\Models\FormDetail;

class KPIController extends Controller
{
    public function saveKpi(Request $request){
        $validator = Validator::make($request->all(),[
            'period' => 'required',
            'selectform' => 'required',
            'result' => 'required|array|min:1'
        ]);

        if($validator->fails()){
            return back()->withErrors($validator);
        }

        $formattedDate = $request->period."-01";
        $form = Form::find($request->selectform);
        $score = 0;
        $indicators = array();

        foreach($request->result as $result){
            $formDetail = FormDetail::find($result['indicator']);
            if($formDetail != null){
                $score += $this->calculateScore($result['value'], $formDetail->target, $formDetail->weight);
                $indicators[] = [
                    'name' => $formDetail->indicator_name,
                    'weight' => $formDetail->weight,
                    'target' => $formDetail->target,
                    'value' => $result['value']
                ];
            }
        }

        $summary = [
            'name' => auth()->user()->name,
            'form' => $form->form_name,
            'score' => $score,
            'indicators' => $indicators
        ];

        $kpiResult = new KpiResult();
        $kpiResult->user_id = auth()->user()->id;
        $kpiResult->period = $formattedDate;
        $kpiResult->score = $score;
        $kpiResult->summary = json_encode($summary);
        $kpiResult->is_approved = 0;
        $kpiResult->save();

        session()->flash('message', 'KPI successfully submitted!');
        return redirect()->back();
    }

    public function calculateScore($value, $target, $weight){
        if($target == 0){
            return $weight;
        }

        $score = ($value/$target)*100;

        if($score > 150){
            return 150 * ($weight/100);
        }

        return $score * ($weight/100);
    }

    public function getReport($period){
        $kpiResult = KpiResult::where('period', $period."-01")->where('user_id', auth()->user()->id)->get()->first();

        return view('report')->with('summary', json_decode($kpiResult->summary));
    }

    public function getChildReport($period, $userId){
        $kpiResult = KpiResult::where('period', $period."-01")->where('user_id', $userId)->get()->first();

        return view('report')->with('summary', json_decode($kpiResult->summary));
    }

    public function getUserKpiByYear($year, $employee){
        $from = $year.'-01-01';
        $to = $year.'-12-31';
        $kpiResult = KpiResult::whereIn('user_id', json_decode($employee))->whereBetween('period', [$from, $to])->get();

        return response()->json($kpiResult);
    }

    public function getChildrenKpiByDate($date){

    }
}
