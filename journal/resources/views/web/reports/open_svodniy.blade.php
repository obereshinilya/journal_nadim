@extends('layouts.app')
@section('title')
    Потери на ГПА
@endsection
@section('side_menu')
    @include('web.reports.side_menu_reports')
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
        <div style="display: inline-flex; width: 100%">
            <h3 >Сводный отчет Надымского НГДУ</h3>
            <div style="position: absolute; right: 11%">
                <button  id="print" class="button button1">Печать</button>
                <button  id="setting" class="button button1">Настройка</button>
            </div>
        </div>
    @include('include.choice_date')
    <style>
        .choice-period-btn {
            display: none;
        }
    </style>
    <div id="content-header"></div>



    <div id="tableDiv" style="width: 50%">
        <table id="statickItemInfoTable" class="itemInfoTable">
            <thead>
            <tr>
                <th rowspan="2" style="width: 10%; text-align: center">Час</th>
                <th colspan="2" style="width: 20%; text-align: center">Ямсовейское НГКМ</th>
                <th colspan="2" style="width: 20%; text-align: center">Юбилейное  НГКМ</th>
                <th rowspan="2" style="width: 10%; text-align: center">Q ННГДУ</th>
            </tr>
            <tr>
                <th style="width: 10%; text-align: center">P вых</th>
                <th style="width: 10%; text-align: center">Q</th>
                <th style="width: 10%; text-align: center">P вых</th>
                <th style="width: 10%; text-align: center">Q</th>
            </tr>
            </thead>
            <tbody id="time_id">

            </tbody>
        </table>

    </div>


    <style>
        .content {
            width: calc(100% - 40px);
        }
    </style>

    <script>

        $(document).ready(function () {
            $('#table_date_start').val(today.toISOString().substring(0, 10))
            get_table_data()
            document.getElementById('table_date_start')
            $('#table_date_start').change(function () {
                get_table_data();
            })

            $('#print').click(function() {
                window.location.href = '/print_svodniy/'+$('#table_date_start').val()
            });

            $('#setting').click(function() {
                window.location.href = '/svodniy_setting'
            });
        })

         function get_table_data() {

             $.ajax({
                 url: '/get_svodniy/'+$('#table_date_start').val(),
                 method: 'GET',
                 success: function (res) {
                     for (var j of res){
                         var body = document.getElementById('time_id')
                         body.innerText = ''
                             for (var i=0; i<24; i++) {
                                 var tr=document.createElement('tr')
                                 tr.innerHTML+=`<td style="text-align: center; padding: 0px; min-width: 20px"><p>${i+':00'}</p></td>`
                                 tr.innerHTML+=`<td style="text-align: center; padding: 0px; min-width: 20px"><p>${res[i]['p_yams']}</p></td>`
                                 tr.innerHTML+=`<td style="text-align: center; padding: 0px; min-width: 20px"><p>${res[i]['q_yams']}</p></td>`
                                 tr.innerHTML+=`<td style="text-align: center; padding: 0px; min-width: 20px"><p>${res[i]['p_yub']}</p></td>`
                                 tr.innerHTML+=`<td style="text-align: center; padding: 0px; min-width: 20px"><p>${res[i]['q_yub']}</p></td>`
                                 tr.innerHTML+=`<td style="text-align: center; padding: 0px; min-width: 20px"><p>${res[i]['q']}</p></td>`
                                 body.appendChild(tr);
                             }
                     }

                 },
                 async:true
             })
        }




    </script>
    <style>
        .create_td{
            background-color: white;
        }
        .button {
            background-color: #4CAF50;
            border: none;
            border-radius: 6px;
            color: white;
            height: 3%;
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

        input{

        }

        thead th {
            position: sticky;
        }
    </style>


@endsection
