<?php

namespace App\Http\Controllers;

use App\Models\Hour_params;
use App\Models\Rezhim_gpa;
use App\Models\Rezhim_gpa_report;
use Illuminate\Http\Request;
use DOMDocument;

class BalansController extends Controller
{
    public function reports(){
        return view('web.reports.REPORTS_MAIN');
    }

    public function gpa_rezhim()
    {
        return view('web.reports.open_gpa_rezhim');
    }

    public function get_gpa_rezhim()
    {
        $gpa_rezhim =[];
        for ($i = 11; $i<27; $i++){
            $data = Rezhim_gpa::orderbyDesc('id')->where('number_gpa', '=', $i)->first();
            if ($data){
                $gpa_rezhim[$i] = $data;
            }
        }
        return $gpa_rezhim;
    }

    public function post_gpa_rezhim(Request $request)
    {
        date_default_timezone_set('Europe/Moscow');
        $data = $request->all();
        for ($i = 11; $i<17; $i++){
            if (Rezhim_gpa::orderbyDesc('id')->where('number_gpa', '=', $i)->first()->rezhim != $data['gpa'.$i]){
                Rezhim_gpa::create(['number_gpa'=>$i, 'rezhim'=>$data['gpa'.$i], 'timestamp'=>date('Y-m-d H:i:s')]);
            }
        }
        for ($i = 21; $i<27; $i++){
            if (Rezhim_gpa::orderbyDesc('id')->where('number_gpa', '=', $i)->first()->rezhim != $data['gpa'.$i]){
                Rezhim_gpa::create(['number_gpa'=>$i, 'rezhim'=>$data['gpa'.$i], 'timestamp'=>date('Y-m-d H:i:s')]);
            }
        }
    }


    public function get_gpa_rezhim_report($dks)
    {
        return view('web.reports.open_gpa_rezhim_report', compact('dks'));
    }
    public function get_gpa_rezhim_report_data($date, $dks)
    {
        $present_day = date('Y-m-d', strtotime($date.' +1 day'));
        if ($dks == 1){
            $data16 = Rezhim_gpa_report::where([['date', '=', $date], ['time', '=', '16:00'], ['number_gpa', 'like', '1%']])->orderby('number_gpa')->get();
            $data20 = Rezhim_gpa_report::where([['date', '=', $date], ['time', '=', '20:00'], ['number_gpa', 'like', '1%']])->orderby('number_gpa')->get();
            $data00 = Rezhim_gpa_report::where([['date', '=', $present_day], ['time', '=', '00:00'], ['number_gpa', 'like', '1%']])->orderby('number_gpa')->get();
            $data04 = Rezhim_gpa_report::where([['date', '=', $present_day], ['time', '=', '04:00'], ['number_gpa', 'like', '1%']])->orderby('number_gpa')->get();
            $data08 = Rezhim_gpa_report::where([['date', '=', $present_day], ['time', '=', '08:00'], ['number_gpa', 'like', '1%']])->orderby('number_gpa')->get();
            $data12 = Rezhim_gpa_report::where([['date', '=', $present_day], ['time', '=', '12:00'], ['number_gpa', 'like', '1%']])->orderby('number_gpa')->get();
        } else{
            $data16 = Rezhim_gpa_report::where([['date', '=', $date], ['time', '=', '16:00'], ['number_gpa', 'like', '2%']])->orderby('number_gpa')->get();
            $data20 = Rezhim_gpa_report::where([['date', '=', $date], ['time', '=', '20:00'], ['number_gpa', 'like', '2%']])->orderby('number_gpa')->get();
            $data00 = Rezhim_gpa_report::where([['date', '=', $present_day], ['time', '=', '00:00'], ['number_gpa', 'like', '2%']])->orderby('number_gpa')->get();
            $data04 = Rezhim_gpa_report::where([['date', '=', $present_day], ['time', '=', '04:00'], ['number_gpa', 'like', '2%']])->orderby('number_gpa')->get();
            $data08 = Rezhim_gpa_report::where([['date', '=', $present_day], ['time', '=', '08:00'], ['number_gpa', 'like', '2%']])->orderby('number_gpa')->get();
            $data12 = Rezhim_gpa_report::where([['date', '=', $present_day], ['time', '=', '12:00'], ['number_gpa', 'like', '2%']])->orderby('number_gpa')->get();
        }
        $arr = ['data16'=>$data16,
            'data20'=>$data20,
            'data00'=>$data00,
            'data04'=>$data04,
            'data08'=>$data08,
            'data12'=>$data12,
            ];
        return $arr;
    }

    public function print_gpa_rezhim_report($date, $dks){

        return view('web.pdf_form.pdf_rezhim_dks', compact( 'dks', 'date'));
    }


}

?>
