<?php

namespace App\Http\Controllers;

use App\Models\Hour_params;
use App\Models\Min_params;
use App\Models\Sut_params;
use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use App\Models\TableObj;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SidetreeController extends Controller
{

    private function treeFormed($dom, $dict, $element, $level){
        $parent=$dom->createElement('ul');
        if ($level>1){
            $parent->setAttribute('hidden','true');
        }
        try{
            foreach ($dict['children'] as $value){
                    $element_li=$dom->createElement('li');
                    $a_node=$dom->createElement('a');
                    $a_node->textContent=$value['namepar1'];
                    $a_node->setAttribute('data-id', $value['id']);
                    $a_node->setAttribute('class', 'tableItem');
                    if (array_key_exists('children', $value)){
                        $plus_icon=$dom->createElement('img');
                        $plus_icon->setAttribute('class', 'treePlusIcon');
                        $plus_icon->setAttribute('src', asset('assets/images/icons/plus.png'));
                        $a_node->appendChild($plus_icon);
                    }

                    $element_li->appendChild($a_node);
                    $this->treeFormed($dom, $value, $element_li, $level+1);
                    $parent->appendChild($element_li);

            }
            $element->appendChild($parent);
        }
        catch (\Exception $err){

        }
    }


    public function getSideTree(){
        $arr=TableObj::getTree();
        $dom=new \DOMDocument('1.0');
        $testTree=$dom->createElement('div');
        $testTree->setAttribute('style', 'margin-right: 10px');
        $level=1;
        $this->treeFormed($dom, $arr[0], $testTree, $level);

        return $dom->saveHTML($testTree);
    }

    public function change_time_params(Request $request, $type){
        try{
            if ($type == 'sutki'){
                Sut_params::where('id', '=', $request->id)
                ->update([
                    'manual'=>true,
                    'val'=>$request->value
                ]);
                return [true];
            } else{
                DB::table('app_info.hour_params')->where('id', $request->id)->
                update([$request->column=>$request->value, 'manual'=>true]);
                return [true];
            }
        }
        catch (\Exception $err){
            return [false, $err];
        }
    }

    public function create_time_params(Request $request){
        $timestamp = date('Y-m-d H:i:s', strtotime("$request->day -1 hours"));
        $timestamp = date('Y-m-d H:i:s', strtotime("$timestamp +$request->number_column hours 1 minutes"));

        try{
            if ($request->type != 'hour'){
                $create = Sut_params::
                create([
                    'val'=>$request->value,
                    'manual'=>true,
                    'hfrpok_id'=>$request->hfrpok,
                    'xml_create'=>false,
                    'change_by'=>-1,
                    'timestamp'=>$request->date,
                ]);
                return true;
            } else{
                $create = Hour_params::
                create([
                    'val'=>$request->value,
                    'manual'=>true,
                    'hfrpok_id'=>$request->hfrpok,
                    'xml_create'=>false,
                    'change_by'=>-1,
                    'timestamp'=>$timestamp,
                ]);
                return true;
            }
        }
        catch (\Exception $err){
            return [false, $err];
        }
    }

    public function change_mins_params(Request $request){
        try{
            DB::table('app_info.5min_params')->where('id', $request->id)->
            update([$request->column=>$request->value, 'manual'=>true]);
            return [true];
        }
        catch (\Exception $err){
            return [false, $err];
        }
    }




}

?>
