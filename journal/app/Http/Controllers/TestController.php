<?php

namespace App\Http\Controllers;

use App\Models\ConfigXML;
use App\Models\Hour_params;
use App\Models\Min_params;
use App\Models\Rezhim_gpa;
use App\Models\Rezhim_gpa_report;
use App\Models\Sut_params;
use Illuminate\Http\Request;
use App\Models\WellsCondition;
use App\Models\TableObj;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{

    public function create_record_rezhim_dks()
    {
        $data = Hour_params::orderbyDesc('id')->wherebetween('timestamp', [date('Y-m-d 00:00', strtotime('-1 day')), date('Y-m-d 00:00', strtotime('+1 day'))])->get();
        for ($dks=1; $dks<3; $dks++){
            if ($dks == 1){
                for ($i = 11; $i<17; $i++){
                    $gpa['number_gpa']=$i;
                    $gpa['date']=date('Y-m-d');
                    $gpa['time']=date('H:00');
                    $rezhim = Rezhim_gpa::orderbyDesc('id')->where('number_gpa', '=', $i)->first();
                    $gpa['time_rezhim']=date('Y-m-d H:i', strtotime($rezhim->timestamp));
                    $gpa['rezhim']=$rezhim->rezhim;
                    $gpa['tvd']=$data->where('hfrpok_id', '=', 27+($i-11)*18)->first()->val;
                    $gpa['priv_tvd']=$data->where('hfrpok_id', '=', 28+($i-11)*18)->first()->val;
                    $gpa['tnd']=$data->where('hfrpok_id', '=', 29+($i-11)*18)->first()->val;
                    $gpa['Pin']=$data->where('hfrpok_id', '=', 30+($i-11)*18)->first()->val;
                    $gpa['Pout']=$data->where('hfrpok_id', '=', 31+($i-11)*18)->first()->val;
                    $gpa['Tin']=$data->where('hfrpok_id', '=', 32+($i-11)*18)->first()->val;
                    $gpa['Tout']=$data->where('hfrpok_id', '=', 33+($i-11)*18)->first()->val;
                    $gpa['Tvdv']=$data->where('hfrpok_id', '=', 34+($i-11)*18)->first()->val;
                    $gpa['Pvdv']=$data->where('hfrpok_id', '=', 35+($i-11)*18)->first()->val;
                    $gpa['Qtg']=$data->where('hfrpok_id', '=', 36+($i-11)*18)->first()->val;
                    $gpa['St_sj']=$data->where('hfrpok_id', '=', 37+($i-11)*18)->first()->val;
                    $gpa['Qcbn']=$data->where('hfrpok_id', '=', 38+($i-11)*18)->first()->val;
                    $gpa['Tvozd']=$data->where('hfrpok_id', '=', 39+($i-11)*18)->first()->val;
                    $gpa['q']='0';
                    $gpa['Pkol']=$data->where('hfrpok_id', '=', 40+($i-11)*18)->first()->val;
                    $gpa['Tpodsh']=$data->where('hfrpok_id', '=', 41+($i-11)*18)->first()->val;
                    $gpa['Tgg']=$data->where('hfrpok_id', '=', 42+($i-11)*18)->first()->val;
                    $gpa['Pbuf']=$data->where('hfrpok_id', '=', 43+($i-11)*18)->first()->val;
                    $gpa['Zapas']=$data->where('hfrpok_id', '=', 44+($i-11)*18)->first()->val;
                    $gpa['Tavo']=$data->where('hfrpok_id', '=', 237)->first()->val;
                    $gpa['mokveld_status']=$data->where('hfrpok_id', '=', 240+($i-11)*2)->first()->val;
                    $gpa['mokveld_zadanie']=$data->where('hfrpok_id', '=', 241+($i-11)*2)->first()->val;

                    Rezhim_gpa_report::create($gpa);
                }
            } else{
                for ($i = 21; $i<27; $i++){
                    $gpa['number_gpa']=$i;
                    $gpa['date']=date('Y-m-d');
                    $gpa['time']=date('H:00');
                    $rezhim = Rezhim_gpa::orderbyDesc('id')->where('number_gpa', '=', $i)->first();
                    $gpa['time_rezhim']=date('Y-m-d H:i', strtotime($rezhim->timestamp));
                    $gpa['rezhim']=$rezhim->rezhim;
                    $gpa['tvd']=$data->where('hfrpok_id', '=', 135+($i-21)*17)->first()->val;
                    $gpa['priv_tvd']=$data->where('hfrpok_id', '=', 136+($i-21)*17)->first()->val;
                    $gpa['tnd']=$data->where('hfrpok_id', '=', 137+($i-21)*17)->first()->val;
                    $gpa['Pin']=$data->where('hfrpok_id', '=', 138+($i-21)*17)->first()->val;
                    $gpa['Pout']=$data->where('hfrpok_id', '=', 139+($i-21)*17)->first()->val;
                    $gpa['Tin']=$data->where('hfrpok_id', '=', 140+($i-21)*17)->first()->val;
                    $gpa['Tout']=$data->where('hfrpok_id', '=', 141+($i-21)*17)->first()->val;
                    $gpa['Tvdv']=$data->where('hfrpok_id', '=', 142+($i-21)*17)->first()->val;
                    $gpa['Pvdv']=$data->where('hfrpok_id', '=', 143+($i-21)*17)->first()->val;
                    $gpa['Qtg']=$data->where('hfrpok_id', '=', 144+($i-21)*17)->first()->val;
                    $gpa['St_sj']=$data->where('hfrpok_id', '=', 145+($i-21)*17)->first()->val;
                    $gpa['Qcbn']=$data->where('hfrpok_id', '=', 146+($i-21)*17)->first()->val;
                    $gpa['Tvozd']=$data->where('hfrpok_id', '=', 147+($i-21)*17)->first()->val;
                    $gpa['q']='0';
                    $gpa['Pkol']=$data->where('hfrpok_id', '=', 148+($i-21)*17)->first()->val;
                    $gpa['Tpodsh']=$data->where('hfrpok_id', '=', 149+($i-21)*17)->first()->val;
                    $gpa['Tgg']=$data->where('hfrpok_id', '=', 150+($i-21)*17)->first()->val;
                    $gpa['Pbuf']='0';
                    $gpa['Zapas']=$data->where('hfrpok_id', '=', 151+($i-21)*17)->first()->val;
                    $gpa['Tavo']=$data->where('hfrpok_id', '=', 238)->first()->val;
                    $gpa['mokveld_status']=$data->where('hfrpok_id', '=', 252+($i-21)*2)->first()->val;
                    $gpa['mokveld_zadanie']=$data->where('hfrpok_id', '=', 253+($i-21)*2)->first()->val;
                    Rezhim_gpa_report::create($gpa);
                }
            }
        }
    }

    public function test($params_type)
    {

        $test_table_data = TableObj::select('hfrpok', 'guid_masdu_5min', 'guid_masdu_hours', 'guid_masdu_day', 'id')->get();
        if ($params_type == 1){
            foreach ($test_table_data as $row){
                $data_in_table['val'] = rand(1, 100);
                $data_in_table['hfrpok_id'] = $row['id'];
                $data_in_table['timestamp'] = date('Y-m-d H:00:10');
                Hour_params::create($data_in_table);
            }
        } elseif ($params_type == 24){
            foreach ($test_table_data as $row) {
                $data_in_table['val'] = rand(1, 100);
                $data_in_table['hfrpok_id'] = $row['id'];
                $data_in_table['timestamp'] = date('Y-m-d', strtotime(" - 24 hours"));
                Sut_params::create($data_in_table);
            }
        } else{
            foreach ($test_table_data as $row) {
                $data_in_table['val'] = rand(1, 100);
                $data_in_table['hfrpok_id'] = $row['id'];
                $data_in_table['timestamp'] = date('Y-m-d H:i:s');
                Min_params::create($data_in_table);
            }
        }
    }


    public function get_parent($parentId)
    {
        $data = TableObj::select('id', 'parentId', 'inout')->get();
        $data_parent = TableObj::select('id', 'parentId', 'inout')->orderBy('id')->where('parentId', '=', $parentId)->get();
        $children = [];
        foreach ($data_parent as $row){
            if ($row->inout == '!'){
                $j = $data->where('parentId', '=', $row->id);
                foreach ($j as $row1){
                    if ($row1->inout == '!') {
                        $i = $data->where('parentId', '=', $row1->id);
                        foreach ($i as $row2){
                            if ($row2->inout == '!') {
                                $i = $data->where('parentId', '=', $row2->id);
                                foreach ($i as $row3){
                                    if ($row3->inout == '!'){
                                        $k = $data->where('parentId', '=', $row3->id);
                                    }else{
                                        array_push($children, $row3->id);
                                    }
                                }
                            }else{
                                array_push($children, $row2->id);
                            }
                        }
                    } else{
                        array_push($children, $row1->id);
                    }
                }
            } else{
                array_push($children, $row->id);
            }
        }
        arsort($children);
        $all_id_child = TableObj::where('inout', '!=', '!')->select('id')->orderByDesc('id')->get();
        $all_child = [];
        foreach ($all_id_child as $row){
            array_push($all_child, $row->id);
        }
        foreach ($children as $row){
            $key = array_search($row, $all_child);
            unset($all_child[$key]);
        }
    return $all_child;
    }



}

?>
