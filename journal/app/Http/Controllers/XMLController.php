<?php

namespace App\Http\Controllers;

use App\Models\ConfigXML;
use App\Models\Day_params;
use App\Models\Events;
use App\Models\Hour_params;
use App\Models\TableObj;
use Illuminate\Http\Request;
use App\Models\GD_obj;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\NormConsumption;
use App\Models\PlanConsumption;
use App\Models\EconomyNorm;
use App\Models\EconomyPlan;
use App\Models\FactConsumption;
use PDF;
use DOMDocument;
use LibXMLError;


class XMLController extends Controller
{
    public function journal_xml(){
        $new_log  = (new MainTableController)->create_log_record('Открыл журнал отправки XML');
        return view('web.journal_xml');
    }

    public function get_journal_xml_data(){
        $data = Events::orderByDesc('id')->get();
        return $data;
    }

    public function create_xml($hours_xml) //раскоментить то, что с remove_astra
    {
        try {
            $time = date('Y-m-d H:i:s', strtotime('-1 hours')); //для часовиков начало
            $time1 = date('Y-m-d H:i:s', strtotime('-24 hours')); //для суточных начало
            $time2 = date('Y-m-d H:i:s', strtotime('-5 minutes')); //для минуток начало

            $time_zone = '+03:00';
            $hour = date("H");
            $hour = (ceil($hour / 2)-1) * 2;  //для подписи xml
            $minutes = date("i");
            $minutes = (ceil($minutes / 5)-1) * 5;
                if ($hours_xml == 1) {   //для часовика
                    $obj_data = TableObj::where('guid_masdu_hours', '!=', '')->get();     // выбираем те, что надо отправлять
                    if (count($obj_data) == 0){    //проверка на наличие записей с guid
                        $data_in_journal['event'] = 'Отправка XML PT24H';
                        $data_in_journal['option'] = 'Нет данных для отправки!';
                        $data_in_journal['timestamp'] = date('Y-m-d H:i:s');
                        $record = Events::create($data_in_journal);
                        return 'Нет данных для отправки!';
                    }
                    $hfrpok = [];
                    foreach ($obj_data as $row){
                        array_push($hfrpok, $row->hfrpok);
                    }
//                    dd($hfrpok);
                    $params = DB::table('app_info.hour_params')->whereIn('hfrpok_id', $hfrpok)->where('timestamp', '>', $time)->orderByDesc('timestamp')->get();
                    $count_in_test_table = count($hfrpok); //сколько надо отправить
                    $count_params = count($params); //сколько есть на отправку
                    if ($count_in_test_table != $count_params) {  //проверка на количество нужных и фактических
                        $check_count = 0; //если не равны
                    } else {
                        $check_count = 1; //если равны
                    }
                    $template_id = ' id="D_NDM.PT2H.RT.V1';
                    $type_xml = 'PT2H';
                    $comment = 'Сеансовые данные (2ч)';
                    foreach ($params as $row) {
                        DB::table('app_info.hour_params')->where('id', $row->id)->update(['xml_create' => 'true']); //отмечаем, что по данных отправлена xml
                    }
                } elseif ($hours_xml == 24) {
                    $obj_data = TableObj::where('guid_masdu_day', '!=', '')->get();
                    if (count($obj_data) == 0){    //проверка на наличие записей с guid
                        $data_in_journal['event'] = 'Отправка XML PT2H';
                        $data_in_journal['option'] = 'Нет данных для отправки!';
                        $data_in_journal['timestamp'] = date('Y-m-d H:i:s');
                        $record = Events::create($data_in_journal);
                        return 'Нет данных для отправки!';
                    }
                    $hfrpok = [];
                    foreach ($obj_data as $row){
                        array_push($hfrpok, $row->hfrpok);
                    }
                    $params = DB::table('app_info.sut_params')->whereIn('hfrpok_id', $hfrpok)->where('timestamp', '=', $time1)->orderByDesc('timestamp')->get();
                    $count_in_test_table = count($hfrpok);
                    $count_params = count($params);
                    if ($count_in_test_table != $count_params) {        //проверка на количество данных снизу и в базе
                        $check_count = 0;
                    } else {
                        $check_count = 1;
                    }
                    $template_id = ' id="D_NDM.PT24H.RT.V1';
                    $type_xml = 'PT24H';
                    $comment = 'Сеансовые данные (24ч)';
                    foreach ($params as $row) {
                        DB::table('app_info.sut_params')->where('id', $row->id)->update(['xml_create' => '1']);
                    }
                } else{
                    $obj_data = TableObj::where('guid_masdu_5min', '!=', '')->get();
                    if (count($obj_data) == 0){    //проверка на наличие записей с guid
                        $data_in_journal['event'] = 'Отправка XML PT5M';
                        $data_in_journal['option'] = 'Нет данных для отправки!';
                        $data_in_journal['timestamp'] = date('Y-m-d H:i:s');
                        $record = Events::create($data_in_journal);
                        return 'Нет данных для отправки!';
                    }
                    $hfrpok = [];
                    foreach ($obj_data as $row){
                        array_push($hfrpok, $row->hfrpok);
                    }
                    $params = DB::table('app_info.5min_params')->whereIn('hfrpok_id', $hfrpok)->where('timestamp', '>', $time2)->orderByDesc('timestamp')->get();
                    $count_in_test_table = count($hfrpok);
                    $count_params = count($params);
                    if ($count_in_test_table != $count_params) {        //проверка на количество данных снизу и в базе
                        $check_count = 0;
                    } else {
                        $check_count = 1;
                    }
                    $template_id = ' id="D_NDM.PT5M.RT.V1';
                    $type_xml = 'PT5M';
                    $comment = 'Сеансовые данные (Реальное время)';
                    foreach ($params as $row) {
                        DB::table('app_info.5min_params')->where('id', $row->id)->update(['xml_create' => '1']);
                    }
                }

                $time_generate = date('Y-m-d') . 'T' . date('H:i:s').'+05:00';

                $contents = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
                $contents = $contents . "<BusinessMessage>\n";
                $contents = $contents . "   <HeaderSection>\n";
                $contents = $contents . "     <Sender id=\"ГП ДБ Надым\"/>\n";
                $contents = $contents . "     <Receiver id=\"М АСДУ ЕСГ\"/>\n";    //ИУС ПТП
                $contents = $contents . "     <Generated at=\"" . $time_generate . "\"/>\n";
                $contents = $contents . "     <Comment>{$comment}</Comment>\n";
                if ($hours_xml ==1 ){
                    if ($hour<10){
                        $hour ='0'.$hour;
                    }
                    $time_generate = date('Y-m-d') . 'T' . date($hour.':00:00', strtotime('-2 hours'));
                } elseif ($hours_xml == 24){
                    $time_generate = date('Y-m-d') . 'T10:00:00';
                } else{
                    if ($minutes<10){
                        $minutes ='0'.$minutes;
                    }
                    $time_generate = date('Y-m-d') . 'T'.date('H:'. $minutes.':00', strtotime('-2 hours'));
                }
                $contents = $contents . "     <ReferenceTime time=\"" . $time_generate . $time_zone . "\"/>\n";
                $contents = $contents . "     <Scale>{$type_xml}</Scale>\n";

                $contents = $contents . "     <Template{$template_id}\"/>\n";
                if ($hours_xml == 24){
                    $contents = $contents . "     <FullName>ГД Надым</FullName>\n";
                }
                $contents = $contents . "   </HeaderSection>\n";

                foreach ($obj_data as $row) {

                    $data_param = $params->where('hfrpok_id', '=', $row->hfrpok)->first();
                    if ($data_param != '') {
                        $value = $data_param->val;


                        $contents = $contents . "   <DataSection>\n";
                        if ($hours_xml == 1) {
                            $contents = $contents . "     <Identifier type=\"ASDU_ESG\">" . $row->guid_masdu_hours . "</Identifier>\n";
                        } elseif ($hours_xml == 24) {
                            $contents = $contents . "     <Identifier type=\"ASDU_ESG\">" . $row->guid_masdu_day . "</Identifier>\n";
			            } else {
                            $contents = $contents . "     <Identifier type=\"ASDU_ESG\">" . $row->guid_masdu_5min . "</Identifier>\n";
                        }
//                        dd($row);
                        $contents = $contents . "     <Value>" . $value . "</Value>\n";
                        $contents = $contents . "     <Source>" . '0' . "</Source>\n";
//                        $contents = $contents . "     <Dimension></Dimension>\n";
                        $contents = $contents . "   </DataSection>\n";
                    }
                }
		$contents = $contents . "</BusinessMessage>\n";
                if ($hours_xml == 1) {
                    $name_xml = 'PT2H_' . date('Y_m_d_H_i_s', strtotime('+2 hours'));
                    Storage::disk('local')->put('buffer_xml/PT2H.xml', $contents, 'public');
                } elseif ($hours_xml == 24) {
                    $name_xml = 'PT24H_' . date('Y_m_d_H_i_s', strtotime('-2 hours'));
                    Storage::disk('local')->put('buffer_xml/PT24H.xml', $contents, 'public');
                } else{
                    $name_xml = 'PT5M' . date('Y_m_d_H_i_s', strtotime('-2 hours'));
                    Storage::disk('local')->put('buffer_xml/PT5M.xml', $contents, 'public');
                }
            $check_data = 1;
        } catch (\Throwable $e) {
               return $e;
            $check_data = 0;
            $data_in_journal['event'] = 'Отправка XML'.' '. $name_xml;
            $data_in_journal['option'] = 'Ошибка отправки XML!';
            $data_in_journal['timestamp'] = date('Y-m-d H:i:s');
            $record = Events::create($data_in_journal);
        }
        $path = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $path = str_replace("\\", "/", $path );
        $path = (string) $path;
        try {
            if ($hours_xml == 1) {
                $xml = new DOMDocument();
                $xml->load($path.'buffer_xml/PT2H.xml');
                if (!$xml->schemaValidate($path.'schema_xml/PT2H.xsd')) {
                } else {
                    $check_valid = 1;
                }
            } elseif ($hours_xml == 24) {
                $xml = new DOMDocument();
                $xml->load($path.'buffer_xml/PT24H.xml');
                if (!$xml->schemaValidate($path.'schema_xml/PT24H.xsd')) {
                } else {
                    $check_valid = 1;
                }
            } else{
                $xml = new DOMDocument();
                $xml->load($path.'buffer_xml/PT5M.xml');
                if (!$xml->schemaValidate($path.'schema_xml/PT5M.xsd')) {
                } else {
                    $check_valid = 1;
                }
            }

        } catch (\Throwable $e) {
            $check_valid = 0;
        }

        if ($check_count != 0){
            if ($check_data != 0){
                if ($check_valid != 0) {

                    if ($hours_xml == 1 ){
                        $name_xml = 'PT2H_' . date('Y_m_d_H_i_s',strtotime('-2 hours'));
                    } elseif($hours_xml == 24) {
                        $name_xml = 'PT24H_' . date('Y_m_d_H_i_s',strtotime('-2 hours'));
                    } else{
                        $name_xml = 'PT5M_' . date('Y_m_d_H_i_s',strtotime('-2 hours'));
                    }
                    Storage::disk('local')->put($name_xml . '.xml', $contents, 'public'); //можно дописать путь перед $name_xml
                    try {
                        Storage::disk('xml_ptp')->put($name_xml . '.xml', $contents, 'public'); //можно дописать путь перед $name_xml
                        Storage::disk('xml_disp')->put($name_xml . '.xml', $contents, 'public'); //можно дописать путь перед $name_xml
                    } catch (\Throwable $e){

                    }

                    $data_in_journal['event'] = 'Отправка XML'.' '. $name_xml;
                    $data_in_journal['option'] = 'XML успешно отправлена!';
                    $data_in_journal['timestamp'] = date('Y-m-d H:i:s');
                    $record = Events::create($data_in_journal);
                    return 'XML успешно отправлена!';

                } else {
                    if ($hours_xml == 1 ){
                        $name_xml = 'PT2H_' . date('Y_m_d_H_i_s',strtotime('-2 hours'));
                    } elseif($hours_xml == 24) {
                        $name_xml = 'PT24H_' . date('Y_m_d_H_i_s',strtotime('-2 hours'));
                    } else{
                        $name_xml = 'PT5M_' . date('Y_m_d_H_i_s',strtotime('-2 hours'));
                    }
                    $data_in_journal['event'] = 'Отправка XML'.' '. $name_xml;
                    $data_in_journal['option'] = 'Файл сеансовых данных не соответствует формату передачи сеансовых данных!';
                    $data_in_journal['timestamp'] = date('Y-m-d H:i:s');
                    $record = Events::create($data_in_journal);
                    return 'Файл сеансовых данных не соответствует формату передачи сеансовых данных!';
                }
            } else{
                if ($hours_xml == 1 ){
                    $name_xml = 'PT2H_' . date('Y_m_d_H_i_s',strtotime('-2 hours'));
                } elseif($hours_xml == 24) {
                    $name_xml = 'PT24H_' . date('Y_m_d_H_i_s',strtotime('-2 hours'));
                } else{
                    $name_xml = 'PT5M_' . date('Y_m_d_H_i_s',strtotime('-2 hours'));
                }
                $data_in_journal['event'] = 'Отправка XML'.' '. $name_xml;
                $data_in_journal['option'] = 'Ошибка записи XML!';
                $data_in_journal['timestamp'] = date('Y-m-d H:i:s');
                $record = Events::create($data_in_journal);
                return 'Ошибка записи XML!';
            }
        } else{
            if ($hours_xml == 1 ){
                $name_xml = 'PT2H_' . date('Y_m_d_H_i_s',strtotime('-2 hours'));
            } elseif($hours_xml == 24) {
                $name_xml = 'PT24H_' . date('Y_m_d_H_i_s',strtotime('-2 hours'));
            } else{
                $name_xml = 'PT5M_' . date('Y_m_d_H_i_s',strtotime('-2 hours'));
            }
            $data_in_journal['event'] = 'Отправка XML'.' '. $name_xml;
            $data_in_journal['option'] = 'Файл сеансовых данных не соответствует полноте наполнения!';
            $data_in_journal['timestamp'] = date('Y-m-d H:i:s');
            $record = Events::create($data_in_journal);
            return 'Файл сеансовых данных не соответствует полноте наполнения!';
        }
    }
}

?>
