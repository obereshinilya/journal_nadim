<?php

namespace App\Http\Controllers;


use App\Models\JournalSmeny;
use Illuminate\Http\Request;
use function Livewire\str;

class SutJournalController extends Controller
{
    public function open_journal_smeny(){
        $new_log  = (new MainTableController)->create_log_record('Открыл журнал смены');
        return view('web.reports.open_journal_smeny');
    }

    public function save_journal_smeny(Request $request, $date){   //сохранение только отдельных строк
        $new_log  = (new MainTableController)->create_log_record('Скорректировал журнал смены за '.$date);

        $data = $request->all();
        foreach ($data as $key => $item) {
            JournalSmeny::create(['id_record'=>$key, 'val'=>$item, 'date'=>$date]);
        }
    }

    public function get_row($date, $id_mother){   //получение только отдельных строк
        $from_base = JournalSmeny::orderby('id')->where('date', '=', $date)->where('id_record', 'like', $id_mother.'%')->get();
        foreach ($from_base as $row) {
            try {
                $data_to_table[$row->id_record][count($data_to_table[$row->id_record])] = count($data_to_table[$row->id_record])+1 .') '.$row->val.'<br>';
            } catch (\Throwable $e){
                $data_to_table[$row->id_record][0] = '1) '.$row->val.'<br>';
            }
        }
        foreach ($data_to_table as $key => $item) {
            $data[$key]='';
            for ($i=0; $i<count($data_to_table[$key]); $i++){
                $data[$key]=$data[$key].$data_to_table[$key][$i];
            }
        }
        return $data;
    }

    public function save_other_row(Request $request, $date){   //сохранение остальных строк строк
        $new_log  = (new MainTableController)->create_log_record('Скорректировал журнал смены за '.$date);
        $data = $request->all();
        foreach ($data as $key => $item) {
            $today = JournalSmeny::where('date', '=', $date)->where('id_record', '=', $key)->first();
            if ($today){
                $today->update(['val'=>$item]);
            } else{
                JournalSmeny::create(['id_record'=>$key, 'val'=>$item, 'date'=>$date]);
            }
        }
    }

    public function get_row_other($date){   //получение остальных строк
        $ids = ['unts_obor', 'unts_status', 'unts_date', 'gdn', 'meteo_19', 'meteo_7', 'meteo_date', 'yub_reserv', 'yub_nagruzka', 'yub_to', 'yams_reserv', 'yams_nagruzka', 'yams_to', 'yub_job', 'yams_job'];
        for ($i=0; $i<count($ids); $i++){
            try {
                $to_table[$ids[$i]] = JournalSmeny::where('date', '=', $date)->where('id_record', '=', $ids[$i])->first()->val;
            }catch (\Throwable $e){
                $to_table[$ids[$i]] = '';

            }
        }
        return $to_table;

    }

    public function print_journal_smeny($date){   //печать
        $new_log  = (new MainTableController)->create_log_record('Распечатал журнал смены за '.$date);
        return view('web.pdf_form.pdf_journal_smeny', compact('date'));
    }


}

?>
