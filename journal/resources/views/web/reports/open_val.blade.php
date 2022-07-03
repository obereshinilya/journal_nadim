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
            <h3 >Валовая добыча газа Надымского НГДУ</h3>
{{--            <div style="position: absolute; right: 11%">--}}
                <button  id="print" class="button button1" style="margin-left: 5%; margin-top: 1%">Печать</button>
                <input  id="plan" type="number" style="margin-left: 35%; border-radius: 6px; height: 6%; margin-top: 0.7%" placeholder="Месячный план">
                <button  id="submit" class="button button1" onclick="saveMonth()" style="margin-left: 4%">Сохранить месячный план</button>

            {{--            </div>--}}
        </div>
    @include('include.choice_month')
    <style>
        .choice-period-btn {
            display: none;
        }
    </style>
    <div id="content-header"></div>



    <div id="tableDiv" style="width: 100%">
        <table id="statickItemInfoTable" class="itemInfoTable">
            <thead>
            <tr>
                <th style="width: 14%; text-align: center">Дата</th>
                <th style="width: 14%; text-align: center">План(сут)</th>
                <th style="width: 14%; text-align: center">Факт(сут)</th>
                <th style="width: 14%; text-align: center">Откл.(сут)</th>
                <th style="width: 14%; text-align: center">План(год)</th>
                <th style="width: 14%; text-align: center">Факт(год)</th>
                <th style="width: 14%; text-align: center">Откл.(год)</th>
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
        function saveMonth(){
            $.ajax({
                url: '/save_plan_month/'+$('#table_date_start').val()+'/'+document.getElementById('plan').value,
                method: 'GET',
                success: function (res) {
                    alert('Месячный план успешно сохранен!')
                    document.location.href = '/open_val'
                },
                async:true
            })
        }

        $(document).ready(function () {
            document.getElementById('table_date_start')
            $('#table_date_start').change(function () {
                get_table_data();
            })
            get_table_data()
            // console.log($('#table_date_start').val())
            $('#print').click(function() {
                window.location.href = '/print_val/'+$('#table_date_start').val()
            });


        })

         function get_table_data() {

             $.ajax({
                 url: '/get_val/'+$('#table_date_start').val(),
                 method: 'GET',
                 success: function (res) {
                     document.getElementById('plan').value = res['plan']

                     var body = document.getElementById('time_id')
                     body.innerText = ''
                     for (var j=1; j<Object.keys(res).length; j++){

                         var tr=document.createElement('tr')
                         tr.innerHTML+=`<td style="text-align: center; padding: 0px; min-width: 20px"><p>${j}</p></td>`
                         tr.innerHTML+=`<td style="text-align: center; padding: 0px; min-width: 20px"><p>${res[j]['plan_sut']}</p></td>`
                         tr.innerHTML+=`<td style="text-align: center; padding: 0px; min-width: 20px"><p>${res[j]['fact_sut']}</p></td>`
                         tr.innerHTML+=`<td style="text-align: center; padding: 0px; min-width: 20px"><p>${res[j]['otkl_sut']}</p></td>`
                         tr.innerHTML+=`<td style="text-align: center; padding: 0px; min-width: 20px"><p>${res[j]['plan_year']}</p></td>`
                         tr.innerHTML+=`<td style="text-align: center; padding: 0px; min-width: 20px"><p>${res[j]['fact_year']}</p></td>`
                         tr.innerHTML+=`<td style="text-align: center; padding: 0px; min-width: 20px"><p>${res[j]['plan_year']}</p></td>`
                         body.appendChild(tr);

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
    </style>


@endsection
