<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class IndicatorWeight implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        $totalWeight = 0;
        foreach($value as $indicator){
            $totalWeight += $indicator['weight'];
        }

        // $totalWeight = collect($value)->sum('weight');
        if($totalWeight !== 100){
            $fail('Total indicators weight must be exactly 100.');
        }
    }
}
