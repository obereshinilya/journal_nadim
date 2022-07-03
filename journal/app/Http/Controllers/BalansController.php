<?php

namespace App\Http\Controllers;

use App\Models\BalansReport;
use App\Models\Hour_params;
use App\Models\PlanBalans;
use App\Models\Rezhim_gpa;
use App\Models\Rezhim_gpa_report;
use App\Models\ValDobicha;
use Faker\Core\Number;
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

    public function open_svodniy(){

        return view('web.reports.open_svodniy');
    }
    public function get_svodniy($date){
        $hfrpok_p = 275;
        $hfrpok_q = 297;
        for ($i=0; $i<24; $i++){
            $time_buff = $i+1;
            $data[$i]['p'] = Hour_params::orderby('id')->where('hfrpok_id', '=', $hfrpok_p)
                ->wherebetween('timestamp', [date('Y-m-d '.$i.':00:00', strtotime($date)), date('Y-m-d '.$time_buff.':00:00', strtotime($date))])->select('val')->first();
            $data[$i]['q'] = Hour_params::orderby('id')->where('hfrpok_id', '=', $hfrpok_q)
                ->wherebetween('timestamp', [date('Y-m-d '.$i.':00:00', strtotime($date)), date('Y-m-d '.$time_buff.':00:00', strtotime($date))])->select('val')->first();
            try {
                $data[$i]['q'] = $data[$i]['q']->toArray();
                $data[$i]['q'] = $data[$i]['q']['val'];
            } catch (\Throwable $e){
                $data[$i]['q'] = '...';
            }
            try {
                $data[$i]['p'] = $data[$i]['p']->toArray();
                $data[$i]['p'] = $data[$i]['p']['val'];
            } catch (\Throwable $e){
                $data[$i]['p'] = '...';
            }

        }
        return $data;

    }

    public function print_svodniy($date){

        return view('web.pdf_form.pdf_svodniy', compact( 'date'));
    }

    public function open_val(){

        return view('web.reports.open_val');
    }

    public function save_plan_month($date, $value){
        $data = PlanBalans::where('month', '=', $date)->get();
        if ($data->isEmpty()){
            PlanBalans::create([
                'month'=>$date, 'plan_month'=>$value
            ]);
        } else{
            $data->first()->update(['plan_month'=>$value]);
        }

    }

    public function get_val($date){

        $last_day = date('t', strtotime($date));
        try {
            $data['plan'] = PlanBalans::where('month', '=', $date)->first();
            $data['plan'] = $data['plan']->toArray();
            $data['plan'] = $data['plan']['plan_month'];
        } catch (\Throwable $e){
            $data['plan'] = 0;
        }
        for ($i = 1; $i<=(int)$last_day; $i++){
            $hfrpok_sut = 297;
//            $hfrpok_year = 777;
            $data[$i]['fact_sut']= Hour_params::where('hfrpok_id', '=', $hfrpok_sut)
                ->wherebetween('timestamp', [date('Y-m-'.$i.' 00:00:00', strtotime($date)), date('Y-m-'.$i.' 23:59:00', strtotime($date))])->orderbydesc('id')->select('val')->first();
            try {
                $data[$i]['fact_sut'] = $data[$i]['fact_sut']->toArray();
                $data[$i]['fact_sut'] = $data[$i]['fact_sut']['val'];
                $data[$i]['plan_sut'] = round($data['plan']/(int)$last_day, 3);
                $data[$i]['otkl_sut'] = round($data[$i]['fact_sut'] - $data[$i]['plan_sut'], 3);
            } catch (\Throwable $e){
                $data[$i]['fact_sut'] = '...';
                $data[$i]['plan_sut'] = round($data['plan']/(int)$last_day, 3);
                $data[$i]['otkl_sut'] = round($data['plan']/(int)$last_day, 3);
            }
//            $data[$i]['fact_year']= Hour_params::where('hfrpok_id', '=', $hfrpok_year)
//                ->wherebetween('timestamp', [date('Y-m-'.$i.' 00:00:00', strtotime($date)), date('Y-m-'.$i.' 23:59:00', strtotime($date))])->orderbydesc('id')->select('val')->first();
//            try {
//                $data[$i]['fact_year'] = $data[$i]['fact_year']->toArray();
//                $data[$i]['fact_year'] = $data[$i]['fact_year']['val'];
//                $data[$i]['plan_year'] = $data['plan']*12;
//                $data[$i]['otkl_year'] = round($data[$i]['fact_year'] - $data[$i]['plan_year'], 3);

//            } catch (\Throwable $e){
                $data[$i]['fact_year'] = '...';
                $data[$i]['otkl_year'] = $data['plan']*12;
                $data[$i]['plan_year'] = $data['plan']*12;
//            }
        }
        return $data;
    }

    public function print_val($date){

        return view('web.pdf_form.pdf_val', compact( 'date'));
    }


    public function open_balans(){

        return view('web.reports.open_balans');
    }

    public function get_balans($date){
            $sum = 0;
            $gz_u = BalansReport::wherebetween('data',  [date('Y-m-01', strtotime($date)), date('Y-m-01', strtotime($date. ' +1 month'))])
                ->where('params_resource', '=', 'd91cb427-770e-4fe9-82bb-3c853a3532de')->orderbydesc('id')->first();
            try {
                $gz_u = $gz_u->toArray();
                $to_balans['poteri'] = $gz_u['ymsovey'];
                $sum = $sum + $gz_u['ymsovey'];

            } catch (\Throwable $e){
                $to_balans['poteri'] = '...';
            }
            $gz_uh = BalansReport::wherebetween('data',  [date('Y-m-01', strtotime($date)), date('Y-m-01', strtotime($date. ' +1 month'))])
                ->where('params_resource', '=', 'dd812389-45fe-4dc4-ac99-3d6cfd64730b')->orderbydesc('id')->first();
            try {
                $gz_uh = $gz_uh->toArray();
                $to_balans['rash_val'] = $gz_uh['ymsovey'];
                $sum = $sum + $gz_uh['ymsovey'];


            } catch (\Throwable $e){
                $to_balans['rash_val'] = '...';
            }
            $st_org = BalansReport::wherebetween('data',  [date('Y-m-01', strtotime($date)), date('Y-m-01', strtotime($date. ' +1 month'))])
                ->where('params_resource', '=', '142a3b0b-0b34-4cef-9a8b-728d6629e9e1')->orderbydesc('id')->first();
            try {
                $st_org = $st_org->toArray();
                $to_balans['rash_gaz'] = $st_org['ymsovey'];
                $sum = $sum + $st_org['ymsovey'];

            } catch (\Throwable $e){
                $to_balans['rash_gaz'] = '...';
            }
            $tov_g = BalansReport::wherebetween('data',  [date('Y-m-01', strtotime($date)), date('Y-m-01', strtotime($date. ' +1 month'))])
                ->where('params_resource', '=', 'fbb860e6-225d-4dd3-ac4e-02b83fb0167e')->orderbydesc('id')->first();
            try {
                $tov_g = $tov_g->toArray();
                $to_balans['rash_sobstv'] = $tov_g['ymsovey'];
                $sum = $sum + $tov_g['ymsovey'];

            } catch (\Throwable $e){
                $to_balans['rash_sobstv'] = '...';
            }

            $self = BalansReport::wherebetween('data',  [date('Y-m-01', strtotime($date)), date('Y-m-01', strtotime($date. ' +1 month'))])
                ->where('params_resource', '=', 'be1f7e18-c0b7-42d9-b06c-48dbedabf693')->orderbydesc('id')->first();
            try {
                $self = $self->toArray();
                $to_balans['stor'] = $self['ymsovey'];
                $sum = $sum + $self['ymsovey'];

            } catch (\Throwable $e){
                $to_balans['stor'] = '...';
            }

            $val = BalansReport::wherebetween('data',  [date('Y-m-01', strtotime($date)), date('Y-m-01', strtotime($date. ' +1 month'))])
                ->where('params_resource', '=', '2e0ccf1f-5ccf-493e-b5f1-c99cd243a22f')->orderbydesc('id')->first();
            try {
                $val = $val->toArray();
                $to_balans['rash_tov'] = $val['ymsovey'];
                $sum = $sum + $val['ymsovey'];

            } catch (\Throwable $e){
                $to_balans['rash_tov'] = '...';
            }
            $to_balans['sum'] = $sum;
//            $lost = BalansReport::wherebetween('data',  [date('Y-m-01', strtotime($date)), date('Y-m-01', strtotime($date. ' +1 month'))])
//                ->where('params_resource', '=', '02A7D5B84C784FB78F4F418A13E2B92E')->orderbydesc('id')->first();
//            try {
//                $lost = $lost->toArray();
//                $to_balans['lost'] = $lost['ymsovey'];
//
//            } catch (\Throwable $e){
//                $to_balans['lost'] = '...';
//            }
//            $all = BalansReport::wherebetween('data',  [date('Y-m-01', strtotime($date)), date('Y-m-01', strtotime($date. ' +1 month'))])
//                ->where('params_resource', '=', 'ADE21064148F4E8FABCD4E61E9B2D527')->orderbydesc('id')->first();
//            try {
//                $all = $all->toArray();
//                $to_balans['all'] = $all['ymsovey'];
//
//            } catch (\Throwable $e){
//                $to_balans['all'] = '...';
//            }

        return $to_balans;
    }

    public function print_balans($date){

        return view('web.pdf_form.pdf_bal', compact( 'date'));
    }





}

?>
