<?php

namespace App\Http\Controllers;


use App\Models\Hour_params;
use App\Models\TableObj;
use Faker\Core\Number;
use Illuminate\Http\Request;use Illuminate\Support\Facades\DB;

class TestTableController extends Controller
{
    public function settings(){
        $data = TableObj::where('inout', '!=', '!')->orderby('id')->get();
        return view('web.signal_settings', compact('data'));
    }
    public function signal_settings_store(Request $request){
        $data = $request->all();
        TableObj::where('hfrpok', '=', $data['hfrpok'])->first()
            ->update($data);
    }

    public function create(){
        return view('web.signal_create');
    }

    public function store_object(Request $request){
        $data = $request->all();
        $level = TableObj::where('id', '=', $data['parentId'])->select('level')->first();
        $level = $level['level'] +1;
        TableObj::create(['parentId'=>$data['parentId'],'namepar1'=>$data['namepar1'],'inout'=>'!', 'level'=>$level ]);
        return 'ok';
    }

    public function store_signal(Request $request){
        try {
            $data = $request->all();
            $level = TableObj::where('id', '=', $data['parentId'])->select('level')->first();
            $level = $level['level'] +1;
            $to_table = ['parentId'=>$data['parentId'], 'namepar1'=>$data['name_new_obj'], 'level'=>$level,
                'inout'=>'ВХОД', 'name_str'=>$data['shortname'], 'shortname'=>$data['shortname'], 'min_param'=>$data['ojd_rv'],
                'hour_param'=>$data['ojd_hour'], 'sut_param'=>$data['ojd_day'], 'tag_name'=>$data['tagname'],
                'guid_masdu_day'=>$data['masdu_day'], 'guid_masdu_hours'=>$data['masdu_hour'], 'guid_masdu_5min'=>$data['masdu_rv'],
            ];
            TableObj::create($to_table);
            $id = TableObj::orderbydesc('id')->select('id')->first();
            TableObj::where('id', '=', $id['id'])->first()->update(['hfrpok'=>$id['id']]);
            return 'ok';
        } catch (\Throwable $e){
            return $e;
        }
    }
}

?>
