<?php

namespace App\Http\Controllers;


use App\Models\Ter;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Expression;

class TerController extends Controller
{
    public function open_ter($yams_yub){
        if ($yams_yub == 'yams'){
            $norm_name = 'Ямсковейского ГКМ';
        } else{
            $norm_name = 'Юбилейного ГКМ';
        }
//        $new_log  = (new MainTableController)->create_log_record('Открыл журнал смены');
        return view('web.reports.open_ter', compact('yams_yub', 'norm_name'));
    }

    public function get_ter($date, $type, $yams_yub){
        if ($type == 'day'){
            $data_to_table = Ter::where('timestamp', '>=', date('Y-m-d 00:00:00', strtotime($date)))->where('timestamp', '<=', date('Y-m-d 23:59:00', strtotime($date)))
                ->where('yams_yub', '=', $yams_yub)->orderbyDesc('timestamp')->get();
        } elseif($type == 'month'){
            $year = (int) stristr($date, '-', true);
            $month = (int) substr(stristr($date, '-'), 1, 2);
            $number_day = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            for ($i = 1; $i<=$number_day; $i++){
                $data = Ter::where('timestamp', '>=', date('Y-m-'.$i.' 00:00:00', strtotime($date)))->where('timestamp', '<=', date('Y-m-'.$i.' 23:59:00', strtotime($date)))
                    ->where('yams_yub', '=', $yams_yub)->orderbyDesc('timestamp');
                $data_to_table[$i-1]['timestamp'] = $i;
                try {
                    $data_to_table[$i-1]['metanol_rashod'] = 0;
                    $data_to_table[$i-1]['metanol_prihod']= 0;
                    $data_to_table[$i-1]['teg_rashod']= 0;
                    $data_to_table[$i-1]['teg_prihod']= 0;
                    $all_data = $data->get();
                    foreach ($all_data as $row){
                        $data_to_table[$i-1]['metanol_rashod']+= (float) $row->metanol_rashod;
                        $data_to_table[$i-1]['metanol_prihod']+= (float) $row->metanol_prihod;
                        $data_to_table[$i-1]['teg_rashod']+= (float) $row->teg_rashod;
                        $data_to_table[$i-1]['teg_prihod']+= (float) $row->teg_prihod;
                    }
                    $data_to_table[$i-1]['metanol_zapas']= $data->first()->metanol_zapas;
                    $data_to_table[$i-1]['teg_zapas']= $data->first()->teg_zapas;
                } catch (\Throwable $e){
                    $data_to_table[$i-1]['metanol_rashod']= '';
                    $data_to_table[$i-1]['metanol_prihod']= '';
                    $data_to_table[$i-1]['teg_rashod']= '';
                    $data_to_table[$i-1]['teg_prihod']= '';
                    $data_to_table[$i-1]['metanol_zapas']= '';
                    $data_to_table[$i-1]['teg_zapas'] = '';
                }
            }
        }else{
            $month = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
            for ($i = 1; $i<=12; $i++){
                $data = Ter::where('timestamp', '>=', date($date.'-'.$i.'-1 00:00:00'))->where('timestamp', '<=', date($date.'-'.$i.'-31 23:59:00'))
                    ->where('yams_yub', '=', $yams_yub)->orderbyDesc('timestamp');
                $data_to_table[$i-1]['timestamp'] = $month[$i-1];
                try {
                    $data_to_table[$i-1]['metanol_rashod'] = 0;
                    $data_to_table[$i-1]['metanol_prihod']= 0;
                    $data_to_table[$i-1]['teg_rashod']= 0;
                    $data_to_table[$i-1]['teg_prihod']= 0;
                    $all_data = $data->get();
                    foreach ($all_data as $row){
                        $data_to_table[$i-1]['metanol_rashod']+= (float) $row->metanol_rashod;
                        $data_to_table[$i-1]['metanol_prihod']+= (float) $row->metanol_prihod;
                        $data_to_table[$i-1]['teg_rashod']+= (float) $row->teg_rashod;
                        $data_to_table[$i-1]['teg_prihod']+= (float) $row->teg_prihod;
                    }
                    $data_to_table[$i-1]['metanol_zapas']= $data->first()->metanol_zapas;
                    $data_to_table[$i-1]['teg_zapas']= $data->first()->teg_zapas;
                } catch (\Throwable $e){
                    $data_to_table[$i-1]['metanol_rashod']= '';
                    $data_to_table[$i-1]['metanol_prihod']= '';
                    $data_to_table[$i-1]['teg_rashod']= '';
                    $data_to_table[$i-1]['teg_prihod']= '';
                    $data_to_table[$i-1]['metanol_zapas']= '';
                    $data_to_table[$i-1]['teg_zapas'] = '';
                }
            }
        }
        return $data_to_table;
    }

    public function save_ter(Request $request, $yams_yub){
        $data = $request->all();
        try {
            foreach ($data as $key => $item) {
                $data_to_table[$key] = $item;
            }
            try {
                $data_to_table['teg_zapas'] = Ter::orderbydesc('id')->where('yams_yub', '=', $yams_yub)->first()->teg_zapas + $data_to_table['teg_prihod'] - $data_to_table['teg_rashod'];
            } catch (\Throwable $e){
                $data_to_table['teg_zapas'] = $data_to_table['teg_prihod'] - $data_to_table['teg_rashod'] ;
            }
            try {
                $data_to_table['metanol_zapas'] = Ter::orderbydesc('id')->where('yams_yub', '=', $yams_yub)->first()->metanol_zapas + $data_to_table['metanol_prihod'] - $data_to_table['metanol_rashod'];
            } catch (\Throwable $e){
                $data_to_table['metanol_zapas'] = $data_to_table['metanol_prihod'] - $data_to_table['metanol_rashod'];
            }
            $data_to_table['yams_yub'] = $yams_yub;
            Ter::create($data_to_table);
        } catch (\Throwable $e){
            return $e;
        }

    }

    public function print_ter($date, $type, $yams_yub){
        if ($yams_yub == 'yams'){
            $norm_name = 'Ямсковейского ГКМ';
        } else{
            $norm_name = 'Юбилейного ГКМ';
        }
//        $new_log  = (new MainTableController)->create_log_record('Открыл журнал смены');
        return view('web.pdf_form.pdf_ter', compact('date', 'type', 'yams_yub', 'norm_name'));
    }




}

?>
