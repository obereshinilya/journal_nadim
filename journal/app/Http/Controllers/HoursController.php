<?php

namespace App\Http\Controllers;


use App\Models\Hour_params;
use App\Models\TableObj;
use Illuminate\Support\Facades\DB;

class HoursController extends Controller
{


    public function get_hour_param($date)
    {
        $all_param_hour = TableObj::where('hour_param', '=', true)->select('hfrpok', 'namepar1', 'shortname')->get()->toArray();
        for ($l=0; $l<count($all_param_hour); $l++){
            $disp_date_time = date('Y-m-d 09:00', strtotime($date));
            for ($i=1; $i<=24; $i++){
                $arr = Hour_params::where('hfrpok_id','=', $all_param_hour[$l]['hfrpok'])
                    ->wherebetween('timestamp', [$disp_date_time, date('Y-m-d H:i', strtotime($disp_date_time. '+59 minutes'))])->orderbyDesc('id')->first();
                try {
                    $all_param_hour[$l][$i]['id'] = $arr->id;
                    $all_param_hour[$l][$i]['hfrpok_id'] = $arr->hfrpok_id;
                    $all_param_hour[$l][$i]['val'] = $arr->val;
                    $all_param_hour[$l][$i]['change_by'] = $arr->change_by;
                    $all_param_hour[$l][$i]['xml_create'] = $arr->xml_create;
                    $all_param_hour[$l][$i]['manual'] = $arr->manual;
                    $all_param_hour[$l][$i]['timestamp'] = $arr->timestamp;
                    $all_param_hour[$l]['charts'] = true;
                } catch (\Throwable $e){
                    $all_param_hour[$l][$i]['id'] = false;
                }
                $disp_date_time = date('Y-m-d H:i', strtotime($disp_date_time. '+1 hours'));
            }
        }
        return $all_param_hour;
    }



}

?>
