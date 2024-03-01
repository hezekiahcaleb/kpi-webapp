<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
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
                $score += $this->calculateScore($result['value'], $formDetail->target, $formDetail->weight, $formDetail->higher_better);
                $indicators[] = [
                    'name' => $formDetail->indicator_name,
                    'weight' => $formDetail->weight,
                    'target' => $formDetail->target,
                    'higherbetter' => $formDetail->higher_better,
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
        $kpiResult->is_approved = (auth()->user()->role->parent == null) ? 1 : 0;
        $kpiResult->save();

        session()->flash('message', 'KPI successfully submitted!');
        return redirect()->back();
    }

    public function calculateScore($value, $target, $weight, $higher_better){
        $score = 0;

        if($higher_better == 1){
            if($target == 0){
                return $weight;
            }

            $score = ($value/$target)*100;
        } else {
            if($target == 0){
                if($score == 0){
                    return $weight;
                } else {
                    $score = ($target/($target+$value)*100);
                }
            } else if($score == 0){
                $score = $target*100;
            }

            $score = ($target/$value)*100;
        }

        if($score > 150){
            return 150 * ($weight/100);
        }

        if($score < 0){
            return 0;
        }

        return $score * ($weight/100);
    }

    public function getApprovalDetail($id){
        $data = KpiResult::find($id);

        return view('approvedatadetail')->with('header', $data)->with('detail', json_decode($data->summary));
    }

    public function approve($id){
        $kpiResult = KpiResult::find($id);
        if($kpiResult == null){
            return redirect()->back();
        }
        $kpiResult->is_approved = 1;
        $kpiResult->save();
        return redirect()->back();
    }

    public function getReport($period){
        $kpiResult = KpiResult::where('is_approved', 1)->where('period', $period."-01")->where('user_id', auth()->user()->id)->get()->first();
        if($kpiResult == null){
            return response('Data not found.');
        }

        return view('report')->with('summary', json_decode($kpiResult->summary));
    }

    public function getChildReport($period, $userId){
        $kpiResult = KpiResult::where('is_approved', 1)->where('period', $period."-01")->where('user_id', $userId)->get()->first();
        if($kpiResult == null){
            return response('Data not found.');
        }

        return view('report')->with('summary', json_decode($kpiResult->summary));
    }

    public function getKpiByYear($year, $employee){
        $kpiResult = DB::table('kpi_results')
                    ->join('users', 'kpi_results.user_id', '=', 'users.id')
                    ->select('user_id', 'users.name', DB::raw('MONTH(period) as month'), 'score')
                    ->where('is_approved', 1)
                    ->whereIn('user_id', json_decode($employee))
                    ->whereYear('period', $year)
                    ->get();

        if($kpiResult == null){
            return response('Data not found.');
        }

        return response()->json($kpiResult);
    }

    public function getChildrenKpiByDate($date){

    }
}
