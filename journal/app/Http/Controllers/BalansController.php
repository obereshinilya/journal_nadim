<?php

namespace App\Http\Controllers;

use App\Models\BalansReport;
use App\Models\DayBalans;
use App\Models\Hour_params;
use App\Models\MonthBalans;
use App\Models\PlanBalans;
use App\Models\Rezhim_gpa;
use App\Models\Rezhim_gpa_report;
use App\Models\SvodniyReport;
use App\Models\ValDobicha;
use App\Models\YearBalans;
use Faker\Core\Number;
use http\Exception\BadUrlException;
use Illuminate\Http\Request;
use DOMDocument;
use phpDocumentor\Reflection\Types\False_;
use phpDocumentor\Reflection\Types\True_;
use function PHPUnit\Framework\isEmpty;

class BalansController extends Controller
{
    public function reports(){
        $new_log  = (new MainTableController)->create_log_record('Открыл отчеты');
        return view('web.reports.REPORTS_MAIN');
    }

    public function gpa_rezhim()
    {
        $new_log  = (new MainTableController)->create_log_record('Посмотрел режим работы ГПА');
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
//        date_default_timezone_set('Europe/Moscow');
        $data = $request->all();
        for ($i = 11; $i<17; $i++){
            try {
                $rezhim = Rezhim_gpa::orderbyDesc('id')->where('number_gpa', '=', $i)->first()->rezhim;
            } catch (\Throwable $exception){
                $rezhim = '';
            }
            if ($rezhim != $data['gpa'.$i]){
                $new_log  = (new MainTableController)->create_log_record('Изменил режим работы ГПА'.$i);
                Rezhim_gpa::create(['number_gpa'=>$i, 'rezhim'=>$data['gpa'.$i], 'timestamp'=>date('Y-m-d H:i:s')]);
            }
        }
        for ($i = 21; $i<27; $i++){
            try {
                $rezhim = Rezhim_gpa::orderbyDesc('id')->where('number_gpa', '=', $i)->first()->rezhim;
            } catch (\Throwable $exception){
                $rezhim = '';
            }
            if ($rezhim != $data['gpa'.$i]){
                $new_log  = (new MainTableController)->create_log_record('Изменил режим работы ГПА'.$i);
                Rezhim_gpa::create(['number_gpa'=>$i, 'rezhim'=>$data['gpa'.$i], 'timestamp'=>date('Y-m-d H:i:s')]);
            }
        }
    }

    public function get_gpa_rezhim_report($dks)
    {
        $new_log  = (new MainTableController)->create_log_record('Посмотрел отчет по режимам работы ГПА ДКС'.$dks);
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
        $new_log  = (new MainTableController)->create_log_record('Распечатал отчет по режимам работы ГПА для ДКС'. $dks);
        return view('web.pdf_form.pdf_rezhim_dks', compact( 'dks', 'date'));
    }

    public function open_svodniy(){
        $config = SvodniyReport::orderbyDesc('id')->where('config', '=', true)->first();
        if(!$config || !$config->p_yams || !$config->q_yams || !$config->q_yub || !$config->p_yub ){
            return redirect('/svodniy_setting');
        } else{
            $new_log  = (new MainTableController)->create_log_record('Посмотрел сводный отчет');
            return view('web.reports.open_svodniy');
        }
    }

    public function get_svodniy($date){
        for ($i=0; $i<24; $i++){
            $time_buff = $i+1;
            $data[$i] = SvodniyReport::orderbyDesc('id')->where('config', '=', false)
                ->wherebetween('timestamp', [date('Y-m-d '.$i.':00:00', strtotime($date)), date('Y-m-d '.$time_buff.':00:00', strtotime($date))])
                ->first();
            try {
                $data_to_report[$i]['q_yams'] = $data[$i]->q_yams;
                $data_to_report[$i]['p_yams'] = $data[$i]->p_yams;
                $data_to_report[$i]['q_yub'] = $data[$i]->q_yub;
                $data_to_report[$i]['p_yub'] = $data[$i]->p_yub;
                $data_to_report[$i]['q'] = $data[$i]->q_yams + $data[$i]->q_yub;
            } catch (\Throwable $e){
                $data_to_report[$i]['q_yams'] = '...';
                $data_to_report[$i]['p_yams'] = '...';
                $data_to_report[$i]['q_yub'] = '...';
                $data_to_report[$i]['p_yub'] = '...';
                $data_to_report[$i]['q'] = '...';
            }
        }
        return $data_to_report;
    }

    public function create_record_svodniy(){
        $hfrpok = SvodniyReport::orderbyDesc('id')->where('config', '=', true)->first();
        try {
            $to_table['q_yams'] = Hour_params::orderbyDesc('id')->where('hfrpok_id', '=', stristr($hfrpok->q_yams, '.', true))->first()->val;
        } catch (\Throwable $e){
            $to_table['q_yams'] = 0;
        }
        try {
            $to_table['p_yams'] = Hour_params::orderbyDesc('id')->where('hfrpok_id', '=', stristr($hfrpok->p_yams, '.', true))->first()->val;
        } catch (\Throwable $e){
            $to_table['p_yams'] = 0;
        }
        try {
            $to_table['q_yub'] = Hour_params::orderbyDesc('id')->where('hfrpok_id', '=', stristr($hfrpok->q_yub, '.', true))->first()->val;
        } catch (\Throwable $e){
            $to_table['q_yub'] = 0;
        }
        try {
            $to_table['p_yub'] = Hour_params::orderbyDesc('id')->where('hfrpok_id', '=', stristr($hfrpok->p_yub, '.', true))->first()->val;
        } catch (\Throwable $e){
            $to_table['p_yub'] = 0;
        }
        $to_table['timestamp'] = date('Y-m-d H:i:s');
        SvodniyReport::create($to_table);
    }

    public function print_svodniy($date){
        $new_log  = (new MainTableController)->create_log_record('Распечатал сводный отчет за ' . $date);
        return view('web.pdf_form.pdf_svodniy', compact( 'date'));
    }

    public function svodniy_setting(){
        $new_log  = (new MainTableController)->create_log_record('Открыл настройки сводного отчета');
        $config = SvodniyReport::orderbyDesc('id')->where('config', '=', true)->first();
        if(!$config || !$config->p_yams || !$config->q_yams || !$config->q_yub || !$config->p_yub ){
            $data = 'false';
            return view('web.reports.setting_svodniy', compact('data'));
        } else{
            $data = 'true';
            return view('web.reports.setting_svodniy', compact('data'));
        }
    }

    public function save_param_svodniy($params, $hfrpok){
        $new_log  = (new MainTableController)->create_log_record('Изменил настройки сводного отчета');
        try {
            $config = SvodniyReport::orderbyDesc('id')->where('config', '=', true)->first()->update([$params=>$hfrpok]);
            return true;
        } catch (\Throwable $e){
            $config = SvodniyReport::create(['config'=>true, $params=>$hfrpok]);
            return true;
        }
    }

    public function get_setting_svodniy(){
        $config = SvodniyReport::orderbyDesc('id')->where('config', '=', true)->first();
        return $config;
    }

/////По валовому
    public function open_val(){    //открытие формы
        $config = YearBalans::orderbyDesc('id')->where('config', '=', true)->get();
        if(count($config) < 2){
            return redirect('/valoviy_setting');
        } else{
            $new_log  = (new MainTableController)->create_log_record('Посмотрел годовой балансовый отчет');
            return view('web.reports.open_val_year');
        }
    }
    public function save_plan_month($date, $value, $mestorozhdeniye){   //сохранение годового
        if ($mestorozhdeniye == 'yams'){
            $text = 'Ямсовейского ГКМ';
        } else{
            $text = 'Юбилейного ГКМ';
        }
        $new_log  = (new MainTableController)->create_log_record('Изменил план за '.$date.' '.$text);
        $data = PlanBalans::where('year', '=', $date)->where('yams_yub', '=', $mestorozhdeniye)->get();
        if ($data->isEmpty()){
            PlanBalans::create([
                'year'=>$date, 'plan_year'=>$value, 'yams_yub'=>$mestorozhdeniye
            ]);
        } else{
            $data->first()->update(['plan_year'=>$value]);
        }
    }
    public function get_plan($date){  //получение планов на год по месторождениям
        $data = PlanBalans::where('year', '=', $date)->where('yams_yub', '=', 'yams')->get();
        if ($data->isEmpty()){
            $data_to_table['yams'] = false;
        } else{
            $data_to_table['yams'] = $data->first()->plan_year;
        }
        $data = PlanBalans::where('year', '=', $date)->where('yams_yub', '=', 'yub')->get();
        if ($data->isEmpty()){
            $data_to_table['yub'] = false;
        } else{
            $data_to_table['yub'] = $data->first()->plan_year;
        }
        return $data_to_table;
    }

    public function create_record_valoviy(){    //создание записей в таблицах годового месячного и суточного валовых
        $hour = (int) date('H');
        $day = (int) date('d');
        $month =(int) date('m');
        $year =(int) date('Y');
        try {
            $hfrpok_yams = (int) YearBalans::where('config', '=', true)->
            where('yams_yub', '=', 'yams')->first()->val;
            $hfrpok_yub = (int) YearBalans::where('config', '=', true)->
            where('yams_yub', '=', 'yub')->first()->val;
            //Получим последний часовой
            $last_yams = Hour_params::orderbyDesc('id')->where('hfrpok_id', '=', $hfrpok_yams)->first()->val;
            $last_yub = Hour_params::orderbyDesc('id')->where('hfrpok_id', '=', $hfrpok_yub)->first()->val;
            //запишев в часовой
            $day_yams = DayBalans::where('hour', '=', $hour)->where('day', '=', $day)->where('month', '=', $month)->where('year', '=', $year)->where('yams_yub', '=', 'yams')->get();
            $day_yub = DayBalans::where('hour', '=', $hour)->where('day', '=', $day)->where('month', '=', $month)->where('year', '=', $year)->where('yams_yub', '=', 'yub')->get();
            if ($day_yams->isEmpty()){
                $data_to_day['hour'] = $hour;
                $data_to_day['day'] = $day;
                $data_to_day['month'] = $month;
                $data_to_day['year'] = $year;
                $data_to_day['yams_yub'] = 'yams';
                $data_to_day['val'] = $last_yams;
                DayBalans::create($data_to_day);
            } else{
                $day_yams->first()->update([$last_yams]);
            }
            if ($day_yub->isEmpty()){
                $data_to_day['hour'] = $hour;
                $data_to_day['day'] = $day;
                $data_to_day['month'] = $month;
                $data_to_day['year'] = $year;
                $data_to_day['yams_yub'] = 'yub';
                $data_to_day['val'] = $last_yub;
                DayBalans::create($data_to_day);
            } else{
                $day_yub->first()->update([$last_yams]);
            }
            //посчитаем суточный
            $month_yams = MonthBalans::where('day', '=', $day)->where('month', '=', $month)->where('year', '=', $year)->where('yams_yub', '=', 'yams')->get();
            $month_yub = MonthBalans::where('day', '=', $day)->where('month', '=', $month)->where('year', '=', $year)->where('yams_yub', '=', 'yub')->get();
            if ($month_yams->isEmpty()){
                MonthBalans::create(['day'=>$day, 'month'=>$month, 'year'=>$year, 'yams_yub'=>'yams', 'val'=>$last_yams]);
            } else{
                $month_yams->first()->update(['val'=>$month_yams->first()->val + $last_yams]);
            }
            if ($month_yub->isEmpty()){
                MonthBalans::create(['day'=>$day, 'month'=>$month, 'year'=>$year, 'yams_yub'=>'yub', 'val'=>$last_yub]);
            } else{
                $month_yub->first()->update(['val'=>$month_yub->first()->val + $last_yub]);
            }
            //Посчитаем годовой
            $year_yams = YearBalans::where('month', '=', $month)->where('year', '=', $year)->where('yams_yub', '=', 'yams')->get();
            $year_yub = YearBalans::where('month', '=', $month)->where('year', '=', $year)->where('yams_yub', '=', 'yub')->get();
            if ($year_yams->isEmpty()){
                YearBalans::create(['month'=>$month, 'year'=>$year, 'yams_yub'=>'yams', 'val'=>$last_yams]);
            } else{
                $year_yams->first()->update(['val'=>$year_yams->first()->val + $last_yams]);
            }
            if ($year_yub->isEmpty()){
                YearBalans::create(['month'=>$month, 'year'=>$year, 'yams_yub'=>'yub', 'val'=>$last_yub]);
            } else{
                $year_yub->first()->update(['val'=>$year_yub->first()->val + $last_yub]);
            }
        }catch (\Throwable $e){

        }
    }

    public function get_val($date, $type){   //получение данных для таблиц
        if ($type == 'year'){
            $year_yams = YearBalans::where('yams_yub', '=', 'yams')->where('year', '=', $date)->get();
            $year_yub = YearBalans::where('yams_yub', '=', 'yub')->where('year', '=', $date)->get();
            for ($i =1; $i<13; $i++){
                try {
                    $data_yams[$i] = $year_yams->where('month', '=', $i)->first()->val;
                    $data_yub[$i] = $year_yub->where('month', '=', $i)->first()->val;
                } catch (\Throwable $e){
                    $data_yams[$i] = '...';
                    $data_yub[$i] = '...';
                }
            }
            $data_to_table['yams'] = $data_yams;
            $data_to_table['yub'] = $data_yub;
            return $data_to_table;
        } elseif ($type == 'month'){
            $year = (int) stristr($date, '-', true);
            $month = (int) substr(stristr($date, '-'), 1, 2);
            $month_yams = MonthBalans::where('yams_yub', '=', 'yams')->where('year', '=', $year)->where('month', '=', $month)->get();
            $month_yub = MonthBalans::where('yams_yub', '=', 'yub')->where('year', '=', $year)->where('month', '=', $month)->get();
            $number_day = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            for ($i =1; $i<=$number_day; $i++){
                try {
                    $data_yams[$i] = $month_yams->where('day', '=', $i)->first()->val;
                    $data_yub[$i] = $month_yub->where('day', '=', $i)->first()->val;
                } catch (\Throwable $e){
                    $data_yams[$i] = '...';
                    $data_yub[$i] = '...';
                }
            }
            $data_to_table['yams'] = $data_yams;
            $data_to_table['yub'] = $data_yub;
            return $data_to_table;
        } else{
            $year = (int) mb_substr($date, 0, 4);
            $month = (int) mb_substr($date, 5, 2);
            $day = (int) mb_substr($date, 8, 2);
            $day_yams = DayBalans::where('yams_yub', '=', 'yams')->where('year', '=', $year)->where('month', '=', $month)->where('day', '=', $day)->get();
            $day_yub = DayBalans::where('yams_yub', '=', 'yub')->where('year', '=', $year)->where('month', '=', $month)->where('day', '=', $day)->get();
            for ($i =0; $i<24; $i++){
                try {
                    $data_yams[$i] = $day_yams->where('hour', '=', $i)->first()->val;
                    $data_yub[$i] = $day_yub->where('hour', '=', $i)->first()->val;
                } catch (\Throwable $e){
                    $data_yams[$i] = '...';
                    $data_yub[$i] = '...';
                }
            }
            $data_to_table['yams'] = $data_yams;
            $data_to_table['yub'] = $data_yub;
            return $data_to_table;
        }
    }

    public function valoviy_setting(){
        $config = YearBalans::orderbyDesc('id')->where('config', '=', true)->get();
        if(count($config) < 2){
            $data = 'false';
            $new_log  = (new MainTableController)->create_log_record('Открыл настройки балансового отчета');
            return view('web.reports.setting_valoviy', compact('data'));
        } else{
            $data = 'true';
            $new_log  = (new MainTableController)->create_log_record('Открыл настройки балансового отчета');
            return view('web.reports.setting_valoviy', compact('data'));
        }

    }

    public function get_setting_valoviy(){
        try {
            try {
                $config = YearBalans::orderbyDesc('id')->where('config', '=', true)->where('yams_yub', '=', 'yams')->first();
                $data_to_table['fact_yams'] = $config->val;
            } catch (\Throwable $exception){

            }
            try {
                $config = YearBalans::orderbyDesc('id')->where('config', '=', true)->where('yams_yub', '=', 'yub')->first();
                $data_to_table['fact_yub'] = $config->val;
            } catch (\Throwable $exception){

            }
            return $data_to_table;
        } catch (\Throwable $e){
            return $e;
        }
    }
    public function save_param_valoviy($params, $hfrpok){
        $new_log  = (new MainTableController)->create_log_record('Изменил настройки балансового отчета');
        try {
            $config = YearBalans::orderbyDesc('id')->where('config', '=', true)->where('yams_yub', '=', $params)->first()->update(['val'=>$hfrpok]);

        }catch (\Throwable $e){
            $config = YearBalans::create(['yams_yub'=>$params, 'val'=>$hfrpok, 'config'=>true]);
        }
    }

    public function print_val($date, $type){
        if ($type == 'year'){
            $new_log  = (new MainTableController)->create_log_record('Распечатал годовой балансовый отчет за '. $date);
            return view('web.pdf_form.pdf_val_year', compact( 'date'));
        } elseif($type == 'month'){
            $new_log  = (new MainTableController)->create_log_record('Распечатал месячный балансовый отчет за '. $date);
            return view('web.pdf_form.pdf_val_month', compact( 'date'));
        } else{
            $new_log  = (new MainTableController)->create_log_record('Распечатал суточный балансовый отчет за '. $date);
            return view('web.pdf_form.pdf_val_day', compact( 'date'));
        }
    }
    public function open_val_month(){    //открытие формы
        $config = YearBalans::orderbyDesc('id')->where('config', '=', true)->get();
        if(count($config) < 2){
            return redirect('/valoviy_setting');
        } else{
            $new_log  = (new MainTableController)->create_log_record('Посмотрел месячный балансовый отчет');
            return view('web.reports.open_val_month');
        }
    }
    public function open_val_day(){    //открытие формы
        $config = YearBalans::orderbyDesc('id')->where('config', '=', true)->get();
        if(count($config) < 2){
            return redirect('/valoviy_setting');
        } else{
            $new_log  = (new MainTableController)->create_log_record('Посмотрел суточный балансовый отчет');
            return view('web.reports.open_val_day');
        }
    }












    public function open_balans(){
        $new_log  = (new MainTableController)->create_log_record('Посмотрел данные от смежных систем');

        return view('web.reports.open_balans');
    }

    public function get_balans($date){
            $sum = 0;
            $gz_u = BalansReport::wherebetween('date',  [date('Y-m-01', strtotime($date)), date('Y-m-01', strtotime($date. ' +1 month'))])
                ->where('guid', '=', 'd91cb427-770e-4fe9-82bb-3c853a3532de')->orderbydesc('date')->first();
            try {
                $gz_u = $gz_u->toArray();
                $to_balans['poteri'] = $gz_u['value'];
                $sum = $sum + $gz_u['value'];

            } catch (\Throwable $e){
                $to_balans['poteri'] = '...';
            }
            $gz_uh = BalansReport::wherebetween('date',  [date('Y-m-01', strtotime($date)), date('Y-m-01', strtotime($date. ' +1 month'))])
                ->where('guid', '=', 'dd812389-45fe-4dc4-ac99-3d6cfd64730b')->orderbydesc('date')->first();
            try {
                $gz_uh = $gz_uh->toArray();
                $to_balans['rash_val'] = $gz_uh['value'];
                $sum = $sum + $gz_uh['value'];
            } catch (\Throwable $e){
                $to_balans['rash_val'] = '...';
            }
            $st_org = BalansReport::wherebetween('date',  [date('Y-m-01', strtotime($date)), date('Y-m-01', strtotime($date. ' +1 month'))])
                ->where('guid', '=', '142a3b0b-0b34-4cef-9a8b-728d6629e9e1')->orderbydesc('date')->first();
            try {
                $st_org = $st_org->toArray();
                $to_balans['rash_gaz'] = $st_org['value'];
                $sum = $sum + $st_org['value'];

            } catch (\Throwable $e){
                $to_balans['rash_gaz'] = '...';
            }
            $tov_g = BalansReport::wherebetween('date',  [date('Y-m-01', strtotime($date)), date('Y-m-01', strtotime($date. ' +1 month'))])
                ->where('guid', '=', 'fbb860e6-225d-4dd3-ac4e-02b83fb0167e')->orderbydesc('date')->first();
            try {
                $tov_g = $tov_g->toArray();
                $to_balans['rash_sobstv'] = $tov_g['value'];
                $sum = $sum + $tov_g['value'];

            } catch (\Throwable $e){
                $to_balans['rash_sobstv'] = '...';
            }

            $self = BalansReport::wherebetween('date',  [date('Y-m-01', strtotime($date)), date('Y-m-01', strtotime($date. ' +1 month'))])
                ->where('guid', '=', 'be1f7e18-c0b7-42d9-b06c-48dbedabf693')->orderbydesc('date')->first();
            try {
                $self = $self->toArray();
                $to_balans['stor'] = $self['value'];
                $sum = $sum + $self['value'];

            } catch (\Throwable $e){
                $to_balans['stor'] = '...';
            }

            $val = BalansReport::wherebetween('date',  [date('Y-m-01', strtotime($date)), date('Y-m-01', strtotime($date. ' +1 month'))])
                ->where('guid', '=', '2e0ccf1f-5ccf-493e-b5f1-c99cd243a22f')->orderbydesc('date')->first();
            try {
                $val = $val->toArray();
                $to_balans['rash_tov'] = $val['value'];
                $sum = $sum + $val['value'];

            } catch (\Throwable $e){
                $to_balans['rash_tov'] = '...';
            }
            $to_balans['sum'] = $sum;
        return $to_balans;
    }

    public function print_balans($date){
        $new_log  = (new MainTableController)->create_log_record('Распечатал данные от смежных систем за '.$date);
        return view('web.pdf_form.pdf_bal', compact( 'date'));
    }





}

?>
