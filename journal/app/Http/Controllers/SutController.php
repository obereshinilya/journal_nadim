<?php

namespace App\Http\Controllers;


use App\Models\Hour_params;
use App\Models\Sut_params;
use App\Models\TableObj;
use Illuminate\Support\Facades\DB;

class SutController extends Controller
{


    public function get_sut_param($month)
    {
        $all_param_sut = TableObj::where('sut_param', '=', true)->select('hfrpok', 'namepar1', 'shortname')->get()->toArray();
        for ($l=0; $l<count($all_param_sut); $l++){
            $disp_date_time = date('Y-m-d', strtotime($month));
            $day_in_month = cal_days_in_month(CAL_GREGORIAN,  date('m', strtotime($month)), date('Y', strtotime($month)));
            for ($i=1; $i<=$day_in_month; $i++){
                $arr = Sut_params::where('hfrpok_id','=', $all_param_sut[$l]['hfrpok'])
                    ->where('timestamp', '=', $disp_date_time)->orderbyDesc('id')->first();
                try {
                    $all_param_sut[$l][$i]['id'] = $arr->id;
                    $all_param_sut[$l][$i]['hfrpok_id'] = $arr->hfrpok_id;
                    $all_param_sut[$l][$i]['val'] = $arr->val;
                    $all_param_sut[$l][$i]['xml_create'] = $arr->xml_create;
                    $all_param_sut[$l][$i]['manual'] = $arr->manual;
                    $all_param_sut[$l][$i]['timestamp'] = $arr->timestamp;
                    $all_param_sut[$l]['charts'] = true;
                } catch (\Throwable $e){
                    $all_param_sut[$l][$i]['id'] = false;
                    $all_param_sut[$l]['charts'] = false;
                }
                $disp_date_time = date('Y-m-d H:i', strtotime($disp_date_time. '+1 days'));
            }
        }
        return $all_param_sut;
    }



}

?>
