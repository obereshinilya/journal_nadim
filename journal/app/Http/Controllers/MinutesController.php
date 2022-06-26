<?php

namespace App\Http\Controllers;


use App\Models\TableObj;
use Illuminate\Support\Facades\DB;

class MinutesController extends Controller
{

    public function index()
    {
        return view('web.main_minutes');
    }

    public function get_min_param($date, $hour)
    {
        if ($hour<10){
            $hour = '0'.$hour;
        }
        $date_start = $date.' '.date("$hour:00");
        $date_stop = date('Y-m-d H:59', strtotime($date_start));

        $data = TableObj::where('min_param', '=', true)->get();
        $i = 0;
        foreach ($data as $row){
            $result[$i]['hfrpok'] = $row->hfrpok;
            $result[$i]['namepar1'] = $row->namepar1;
            $result[$i]['shortname'] = $row->shortname;
            $result[$i]['min_params'] = $data->find($row->hfrpok)->getMinsParam($date_start);
            $i++;
        }


        return view('web.open_minutes', compact('date_start', 'date_stop', 'hour', 'result'));
    }



}

?>
