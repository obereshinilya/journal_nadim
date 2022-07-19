@extends('layouts.app')
@section('title')
    Редактирование сигналов ОЖД
@endsection
@section('side_menu')
    @include('include.side_menu')
@endsection
@section('content')
    @push('scripts')
        <script src="{{asset('assets/js/moment-with-locales.min.js')}}"></script>
        <script src="{{asset('assets/libs/changeable_td.js')}}"></script>
        <script src="{{asset('assets/libs/tooltip/popper.min.js')}}"></script>
        <script src="{{asset('assets/libs/tooltip/tippy-bundle.umd.min.js')}}"></script>

        <script src="{{asset('assets/libs/apexcharts.js')}}"></script>
        <script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>

    @endpush

    @push('styles')
        <link rel="stylesheet" href="{{asset('assets/css/table.css')}}">
        <link rel="stylesheet" href="{{asset('assets/libs/tooltip/tooltip.css')}}">
    @endpush
    <div>
        <div id="content-header" style="display:inline-block;width: 92%"></div>
        <div style="display:none">
                <button class="button button1" id="save_all">Сохранить</button>
        </div>

    </div>


    <div id="tableDiv" style="margin-top: 2%">

        <table id="itemInfoTable" class="itemInfoTable" style="width: 100%; float:left">
            <thead>
            <tr s>
                <th  class="timeCell"  style="width: 10%; text-align: center; padding-bottom: 0px; padding-top: 0px"><h4>Наименование</h4></th>
                <th  class="timeCell"  style="width: 10%; text-align: center; padding-bottom: 0px; padding-top: 0px"><h4>Ед.изм</h4></th>
                <th  class="timeCell"  style="width: 10%; text-align: center; padding-bottom: 0px; padding-top: 0px"><h4>ИУС ПТП <br>(РВ)</h4></th>
                <th  class="timeCell"  style="width: 10%; text-align: center; padding-bottom: 0px; padding-top: 0px"><h4>ИУС ПТП <br>(2 часа)</h4></th>
                <th  class="timeCell"  style="width: 10%; text-align: center; padding-bottom: 0px; padding-top: 0px"><h4>ИУС ПТП <br>(сут)</h4></th>
                <th  class="timeCell"  style="width: 10%; text-align: center; padding-bottom: 0px; padding-top: 0px"><h4>Отображение в ОЖД<br>(РВ)</h4></th>
                <th  class="timeCell"  style="width: 10%; text-align: center; padding-bottom: 0px; padding-top: 0px"><h4>Отображение в ОЖД<br>(час)</h4></th>
                <th  class="timeCell"  style="width: 10%; text-align: center; padding-bottom: 0px; padding-top: 0px"><h4>Отображение в ОЖД<br>(сут)</h4></th>
                <th  class="timeCell"  style="width: 10%; text-align: center; padding-bottom: 0px; padding-top: 0px"><h4>Имя тега</h4></th>
                <th  class="timeCell"  style="width: 10%; text-align: center; padding-bottom: 0px; padding-top: 0px"><h4></h4></th>
            </tr>
            </thead>
            <tbody>
            @for($i=0; $i<count($data); $i++)
                <tr data-id="{{$data[$i]['hfrpok']}}">
                    <td class="row" style="text-align: center"><textarea class="namepar1">{{$data[$i]['namepar1']}}</textarea></td>
                    <td class="row" style="text-align: center"><input class="shortname" type="text" value="{{$data[$i]['shortname']}}"></td>

                    <td class="row" style="text-align: center">
                        @if ($data[$i]['guid_masdu_5min']) <input class="guid_masdu_5min_{{$data[$i]['hfrpok']}}" type="checkbox" checked onclick="showMe(this)"> @else <input class="guid_masdu_5min_{{$data[$i]['hfrpok']}}" type="checkbox" onclick="showMe(this)"> @endif
                        <textarea style="display: none; margin-left: 4%" id="guid_masdu_5min_{{$data[$i]['hfrpok']}}">{{$data[$i]['guid_masdu_5min']}}</textarea>
                    </td>
                    <td class="row" style="text-align: center">
                        @if ($data[$i]['guid_masdu_hours']) <input class="guid_masdu_hours_{{$data[$i]['hfrpok']}}" type="checkbox" checked onclick="showMe(this)"> @else <input class="guid_masdu_hours_{{$data[$i]['hfrpok']}}" type="checkbox" onclick="showMe(this)"> @endif
                        <textarea style="display: none; margin-left: 4%" id="guid_masdu_hours_{{$data[$i]['hfrpok']}}">{{$data[$i]['guid_masdu_hours']}}</textarea>
                    </td>
                    <td class="row" style="text-align: center">
                        @if ($data[$i]['guid_masdu_day']) <input class="guid_masdu_day_{{$data[$i]['hfrpok']}}" type="checkbox" checked onclick="showMe(this)"> @else <input class="guid_masdu_day_{{$data[$i]['hfrpok']}}" type="checkbox" onclick="showMe(this)"> @endif
                        <textarea style="display: none; margin-left: 4%" id="guid_masdu_day_{{$data[$i]['hfrpok']}}" >{{$data[$i]['guid_masdu_day']}}</textarea>
                    </td>

                    <td class="row" style="text-align: center">@if ($data[$i]['min_param']) <input id="min_param_{{$data[$i]['hfrpok']}}" type="checkbox" checked> @else <input type="checkbox" id="min_param_{{$data[$i]['hfrpok']}}"> @endif</td>
                    <td class="row" style="text-align: center">@if ($data[$i]['hour_param']) <input id="hour_param_{{$data[$i]['hfrpok']}}" type="checkbox" checked> @else <input type="checkbox" id="hour_param_{{$data[$i]['hfrpok']}}"> @endif</td>
                    <td class="row" style="text-align: center">@if ($data[$i]['sut_param']) <input id="sut_param_{{$data[$i]['hfrpok']}}" type="checkbox" checked> @else <input type="checkbox" id="sut_param_{{$data[$i]['hfrpok']}}"> @endif</td>
                    <td class="row" style="text-align: center"><textarea class="tag_name">{{$data[$i]['tag_name']}}</textarea></td>

                    <td class="row" style="text-align: center; "><button id="id_button_{{$data[$i]['hfrpok']}}" class="button button1">Сохранить</button></td>
                </tr>
            @endfor
            </tbody>
        </table>
    </div>


    <script>
        var header_content = 'Параметры ОЖД. ';
        function showMe(box){
            var vis = (box.checked) ? "block" : "none";
            document.getElementById(box.classList[0]).style.display = vis;
        }
        $(document).ready(function () {
            click_side_menu_func = show_hide;
            var save_all_row = false
            $('#save_all').click(function () {
                var all_button = document.querySelectorAll('button')
                for (var i=1; i<all_button.length; i++){
                    all_button[i].click()
                }
                alert('Все данные обновлены!')
            })
            $('button').click(function (){
                if (this.id !== 'save_all'){
                    var tr = this.parentElement.parentElement
                    var hfrpok = tr.getAttribute('data-id')
                    var namepar1 = tr.getElementsByClassName('namepar1')[0].value
                    var shortname = tr.getElementsByClassName('shortname')[0].value
                    var tag_name = tr.getElementsByClassName('tag_name')[0].value
                    if (document.getElementById('min_param_'+hfrpok).checked){
                        var min_param = true
                    } else {
                        var min_param = false
                    }
                    if (document.getElementById('hour_param_'+hfrpok).checked){
                        var hour_param = true
                    } else {
                        var hour_param = false
                    }
                    if (document.getElementById('sut_param_'+hfrpok).checked){
                        var sut_param = true
                    } else {
                        var sut_param = false
                    }
                    if (document.getElementsByClassName('guid_masdu_5min_'+hfrpok)[0].checked){
                        var guid_masdu_5min = document.getElementById('guid_masdu_5min_'+hfrpok).value
                    } else {
                        var guid_masdu_5min = ''
                    }
                    if (document.getElementsByClassName('guid_masdu_hours_'+hfrpok)[0].checked){
                        var guid_masdu_hours = document.getElementById('guid_masdu_hours_'+hfrpok).value
                    } else {
                        var guid_masdu_hours = ''
                    }
                    if (document.getElementsByClassName('guid_masdu_day_'+hfrpok)[0].checked){
                        var guid_masdu_day = document.getElementById('guid_masdu_day_'+hfrpok).value
                    } else {
                        var guid_masdu_day = ''
                    }

                    var data = {hfrpok: hfrpok, namepar1: namepar1, shortname: shortname, tag_name: tag_name,
                        min_param: min_param, hour_param: hour_param, sut_param: sut_param, guid_masdu_5min: guid_masdu_5min,
                        guid_masdu_hours: guid_masdu_hours, guid_masdu_day: guid_masdu_day}

                    $.ajax({
                        url:'/signal_settings_store',
                        type:'POST',
                        data: data,
                        success:(res)=>{
                            var i = 0
                                $(tr).children().each(function (){
                                    $($(tr).children()[i]).css("background", "rgba(0, 0, 0, 0)")
                                    i++
                                })
                                alert('Данные успешно обновлены!')
                        },
                        async: true
                    });
                }
            })

            //Обработка измененной строки
            $( ".namepar1" ).change(function() {
                $($(this).parent()[0]).css("background", "#fc6262")
            });
            $( ".tag_name" ).change(function() {
                $($(this).parent()[0]).css("background", "#fc6262")
            });
            $( ".shortname" ).change(function() {
                $($(this).parent()[0]).css("background", "#fc6262")
            });
            $( ":checkbox" ).change(function() {
                $($(this).parent()[0]).css("background", "#fc6262")
            });

        })

        function show_hide() {
        }

    </script>

    <style>
        .text{
            text-overflow: ellipsis
        }
        .row{
            padding-top: 10px;
            padding-bottom: 10px;

        }
        .create_td{
            background-color: white;
        }
        .button {
            background-color: #4CAF50;
            border: none;
            border-radius: 6px;
            color: white;
            height: 5%;
            padding: 6px 12px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 13px;
            margin: 4px 2px;
            -webkit-transition-duration: 0.4s; /* Safari */
            transition-duration: 0.4s;
            cursor: pointer;
        }

        .button1 {
            background-color: white;
            color: black;
            border: 2px solid #008CBA;
        }

        .button1:hover {
            background-color: #008CBA;
            color: white;
        }

        textarea { font-family: HeliosCond; }
        input[type=text] { font-family: HeliosCond; }

    </style>

@endsection
