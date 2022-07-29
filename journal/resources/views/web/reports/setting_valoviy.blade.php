@extends('layouts.app')
@section('title')
    Настройка валового отчета
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
    <p style="display: none" id="alarm">{{$data}}</p>
    <div>
            <h3>Выбор сигнала-источника данных</h3>
        <div id="content-header" style="display: none"></div>
        <div style="display:inline-block">
            <button class="button button1" id="fact_yams">Факт Ямсовейского ГКМ</button>
            <button class="button button1" id="fact_yub">Факт Юбилейного ГКМ</button>
            <button class="button button1" id="redirect" style="background-color: #d8d8d8">Вернуться к отчету</button>

        </div>

    </div>

    <div id="tableDiv" style="margin-top: 20px">
        <table id="statickItemInfoTable" class="itemInfoTable" style="width: 40%; float:left; direction:rtl; table-layout: fixed">
            <thead>
            <tr>
                <th class="objCell" style="width: 10px"><h4></h4></th>
                <th class="objCell" ><h4>Наименование параметра</h4></th>
            </tr>
            <tbody>

            </tbody>
        </table>
    </div>

    <button class="button button1" id="submit_signal" style="display: none; margin-left: 46%">Сохранить</button>


    <script>
        var header_content = 'Настройка';

        $(document).ready(function () {
            if (document.getElementById('alarm').textContent === 'false'){
                alert('Выберите все сигналы!')
            }
            click_side_menu_func = show_hide;
            $.ajax({
                url: '/get_all_params',
                method: 'GET',
                success: function (res) {
                    var static_table_body=document.getElementById('statickItemInfoTable').getElementsByTagName('tbody')[0]
                    static_table_body.innerHTML=''
                    for (var row of res) {
                        var static_tr = document.createElement('tr')
                        static_tr.setAttribute('data-id', row['hfrpok'])
                        static_tr.innerHTML += `<td data-name="namepar1" style="text-align: center"><button class="button button1" select-hfrpok="${row['hfrpok']}">Выбрать</button></td>`
                        static_tr.innerHTML += `<td data-name="namepar1">${row['namepar1']}</td>`
                        static_table_body.appendChild(static_tr);
                    }
                },
                async:false
            })

            var check_param = ''


            $('#fact_yams').click(function () {
                check_param = 'fact_yams'
                mark_checked_params('fact_yams')
                document.getElementById('fact_yams').style.background = '#1ab585'
                document.getElementById('fact_yub').style.background = 'white'
            })

            $('#fact_yub').click(function () {
                check_param = 'fact_yub'
                mark_checked_params('fact_yub')
                document.getElementById('fact_yub').style.background = '#1ab585'
                document.getElementById('fact_yams').style.background = 'white'
            })
            $('#redirect').click(function () {
                window.location.href = '/open_val_year'
            })

            $('.button').click(function () {
                if (!check_param){
                    if (this.id !== 'redirect')
                        alert('Не выбран параметр!')
                }
                if (this.getAttribute('select-hfrpok')){
                    var type = check_param.split('_')[1]
                    $.ajax({
                        url: '/save_param_valoviy/'+ type + '/'+ this.getAttribute('select-hfrpok'),
                        method: 'GET',
                        success: function (res) {
                            mark_checked_params(check_param)
                            alert('Параметр обновлен!')
                        },
                        async:false
                    })
                }
            })
        })

        function mark_checked_params(param_name){
            $.ajax({
                url: '/get_setting_valoviy',
                method: 'GET',
                success: function (res) {
                    var btn = ''
                    if (res[param_name] === undefined){
                        var table = document.getElementById('statickItemInfoTable')
                        var rows = table.getElementsByTagName('tr')
                        for (var row of rows){
                            btn = row.getElementsByTagName('button')[0]
                            try {
                                btn.removeAttribute('disabled')
                                btn.innerText = 'Выбрать'
                                btn.style.background = 'white'
                            } catch (e){
                            }
                        }
                    } else {
                        var hfrpok = res[param_name].split('.')[0]
                        var table = document.getElementById('statickItemInfoTable')
                        var rows = table.getElementsByTagName('tr')
                        for (var row of rows){
                            if (row.getAttribute('data-id') === hfrpok){
                                btn = row.getElementsByTagName('button')[0]
                                btn.setAttribute('disabled', true)
                                btn.innerText = 'Выбрано'
                                btn.style.background = '#d8d8d8'
                            } else {
                                btn = row.getElementsByTagName('button')[0]
                                if (btn !== undefined){
                                    btn.removeAttribute('disabled')
                                    btn.innerText = 'Выбрать'
                                    btn.style.background = 'white'

                                }
                            }
                        }
                    }
                },
                async:false
            })
        }

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
