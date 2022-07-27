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
            <h3 >Валовая добыча газа Надымского НГДУ (за сутки)</h3>
                <button  id="print" class="button button1" style="margin-left: 60%; margin-top: 1%">Печать</button>
        </div>
    @include('include.choice_date')
    <style>
        .choice-period-btn {
            display: none;
        }
    </style>
<p id="plan_yams" style="display: none"></p>
<p id="plan_yub" style="display: none"></p>
    <div id="content-header" style="display: inline-flex; width: 100%">
        <h4 style="width: 30%">Показатели Ямсовейского ГКМ</h4>
        <button  id="graph_yams" class="button button1" style="margin-left: 40%">Графический вид</button>
        <button  id="table_yams" class="button button1"  disabled="true" style="background-color: rgb(26, 181, 133)">Табличный вид</button>
    </div>
    <div id="chart_yams" style="display: none; width: 100%">
        <div id="timeline-chart" style="width: 100%"></div>
    </div>
    <div id="tableDiv_yams" style="display: none; margin-top: 1%; overflow-x: auto">

        <table id="statickItemInfoTable_yams" class="itemInfoTable" style="width: auto; float:left; table-layout: fixed; display: block; overflow-x: auto; white-space: nowrap">
            <thead>
                <tr>
                    <th class="objCell" ><h4>Параметр</h4></th>
                </tr>
            <tbody>
            <tr><td><span style="text-align: left">Факт</span></td></tr>
            <tr><td><span style="text-align: left">План</span></td></tr>
            <tr><td><span style="text-align: left">Отклонение</span></td></tr>
            </tbody>
        </table>
        <table id="itemInfoTable_yams" class="itemInfoTable" style="width: 65%; float:left; overflow-x: auto; display: block; white-space: nowrap">
            <thead>
                <tr id="thead_yams">
                    <th  class="timeCell" style="width: 4%"><h4>00:00</h4></th>
                    <th  class="timeCell" style="width: 4%"><h4>01:00</h4></th>
                    <th  class="timeCell" style="width: 4%"><h4>02:00</h4></th>
                    <th  class="timeCell" style="width: 4%"><h4>03:00</h4></th>
                    <th  class="timeCell" style="width: 4%"><h4>04:00</h4></th>
                    <th  class="timeCell" style="width: 4%"><h4>05:00</h4></th>
                    <th  class="timeCell" style="width: 4%"><h4>06:00</h4></th>
                    <th  class="timeCell" style="width: 4%"><h4>07:00</h4></th>
                    <th  class="timeCell" style="width: 4%"><h4>08:00</h4></th>
                    <th  class="timeCell" style="width: 4%"><h4>09:00</h4></th>
                    <th  class="timeCell" style="width: 4%"><h4>10:00</h4></th>
                    <th  class="timeCell" style="width: 4%"><h4>11:00</h4></th>
                    <th  class="timeCell" style="width: 4%"><h4>12:00</h4></th>
                    <th  class="timeCell" style="width: 4%"><h4>13:00</h4></th>
                    <th  class="timeCell" style="width: 4%"><h4>14:00</h4></th>
                    <th  class="timeCell" style="width: 4%"><h4>15:00</h4></th>
                    <th  class="timeCell" style="width: 4%"><h4>16:00</h4></th>
                    <th  class="timeCell" style="width: 4%"><h4>17:00</h4></th>
                    <th  class="timeCell" style="width: 4%"><h4>18:00</h4></th>
                    <th  class="timeCell" style="width: 4%"><h4>19:00</h4></th>
                    <th  class="timeCell" style="width: 4%"><h4>20:00</h4></th>
                    <th  class="timeCell" style="width: 4%"><h4>21:00</h4></th>
                    <th  class="timeCell" style="width: 4%"><h4>22:00</h4></th>
                    <th  class="timeCell" style="width: 4%"><h4>23:00</h4></th>
                </tr>
            </thead>
            <tbody>
                <tr id="fakt_yams_tr">

                </tr>
                <tr id="plan_yams_tr">

                </tr>
                <tr id="otkl_yams_tr">

                </tr>
            </tbody>
        </table>
    </div>


    <div id="content-header" style="display: inline-flex; width: 100%">
        <h4 style="width: 30%">Показатели Юбилейного ГКМ</h4>
        <button  id="graph_yub" class="button button1" style="margin-left: 40%">Графический вид</button>
        <button  id="table_yub" class="button button1"  disabled="true" style="background-color: rgb(26, 181, 133)">Табличный вид</button>
    </div>
    <div id="chart_yub" style="display: none; width: 100%">
        <div id="timeline-chart" style="width: 100%"></div>
    </div>
    <div id="tableDiv_yub" style="display: none">
        <table id="statickItemInfoTable_yub" class="itemInfoTable" style="width: auto; float:left; table-layout: fixed; display: block; overflow-x: auto; white-space: nowrap">
            <thead>
            <tr>
                <th class="objCell" ><h4>Параметр</h4></th>
            </tr>
            <tbody>
            <tr><td><span style="text-align: left">Факт</span></td></tr>
            <tr><td><span style="text-align: left">План</span></td></tr>
            <tr><td><span style="text-align: left">Отклонение</span></td></tr>
            </tbody>
        </table>
        <table id="itemInfoTable_yub" class="itemInfoTable" style="width: 65%; float:left; overflow-x: auto; display: block; white-space: nowrap">
            <thead>
            <tr id="thead_yub">
                <th  class="timeCell" style="width: 2%"><h4>00:00</h4></th>
                <th  class="timeCell" style="width: 2%"><h4>01:00</h4></th>
                <th  class="timeCell" style="width: 2%"><h4>02:00</h4></th>
                <th  class="timeCell" style="width: 2%"><h4>03:00</h4></th>
                <th  class="timeCell" style="width: 2%"><h4>04:00</h4></th>
                <th  class="timeCell" style="width: 2%"><h4>05:00</h4></th>
                <th  class="timeCell" style="width: 2%"><h4>06:00</h4></th>
                <th  class="timeCell" style="width: 2%"><h4>07:00</h4></th>
                <th  class="timeCell" style="width: 2%"><h4>08:00</h4></th>
                <th  class="timeCell" style="width: 2%"><h4>09:00</h4></th>
                <th  class="timeCell" style="width: 2%"><h4>10:00</h4></th>
                <th  class="timeCell" style="width: 2%"><h4>11:00</h4></th>
                <th  class="timeCell" style="width: 2%"><h4>12:00</h4></th>
                <th  class="timeCell" style="width: 2%"><h4>13:00</h4></th>
                <th  class="timeCell" style="width: 2%"><h4>14:00</h4></th>
                <th  class="timeCell" style="width: 2%"><h4>15:00</h4></th>
                <th  class="timeCell" style="width: 2%"><h4>16:00</h4></th>
                <th  class="timeCell" style="width: 2%"><h4>17:00</h4></th>
                <th  class="timeCell" style="width: 2%"><h4>18:00</h4></th>
                <th  class="timeCell" style="width: 2%"><h4>19:00</h4></th>
                <th  class="timeCell" style="width: 2%"><h4>20:00</h4></th>
                <th  class="timeCell" style="width: 2%"><h4>21:00</h4></th>
                <th  class="timeCell" style="width: 2%"><h4>22:00</h4></th>
                <th  class="timeCell" style="width: 2%"><h4>23:00</h4></th>
            </tr>
            </thead>
            <tbody>
                <tr id="fakt_yub_tr">

                </tr>
                <tr id="plan_yub_tr">

                </tr>
                <tr id="otkl_yub_tr">

                </tr>
            </tbody>
        </table>
    </div>


    <style>
        .content {
            overflow-x: hidden;
            width: 100%;
        }

    </style>

    <script>

        $(document).ready(function () {
            $('#table_date_start').val(today.toISOString().substring(0, 10))
            $('#table_date_start').change(function () {
                get_plan()
                get_table_data();
                $('#table_yams').trigger('click')
                $('#table_yub').trigger('click')
                // remove_chart()
            })
            get_plan()
            get_table_data();
            $('#print').click(function() {
                window.location.href = '/print_val/'+$('#table_date_start').val()+ '/day'
            });

            $('#graph_yams').click(function() {
                document.getElementById('table_yams').style.background = 'white'
                document.getElementById('graph_yams').style.background = 'rgb(26, 181, 133)'
                document.getElementById('graph_yams').setAttribute('disabled', 'true')
                document.getElementById('table_yams').removeAttribute('disabled')

                document.getElementById('statickItemInfoTable_yams').style.display = 'none'
                document.getElementById('itemInfoTable_yams').style.display = 'none'
                document.getElementById('chart_yams').style.display = ''
                document.getElementById('chart_yams').style.maxWidth = '100%'
                document.getElementById('chart_yams').style.minHeight = '10%'
                create_chart('yams')
            });
            $('#table_yams').click(function() {
                document.getElementById('graph_yams').style.background = 'white'
                document.getElementById('table_yams').style.background = 'rgb(26, 181, 133)'
                document.getElementById('table_yams').setAttribute('disabled', 'true')
                document.getElementById('graph_yams').removeAttribute('disabled')

                document.getElementById('statickItemInfoTable_yams').style.display = 'block'
                document.getElementById('itemInfoTable_yams').style.display = 'block'
                document.getElementById('chart_yams').style.display = 'none'
                remove_chart('yams')
            });
            $('#graph_yub').click(function() {
                document.getElementById('table_yub').style.background = 'white'
                document.getElementById('graph_yub').style.background = 'rgb(26, 181, 133)'
                document.getElementById('graph_yub').setAttribute('disabled', 'true')
                document.getElementById('table_yub').removeAttribute('disabled')

                document.getElementById('statickItemInfoTable_yub').style.display = 'none'
                document.getElementById('itemInfoTable_yub').style.display = 'none'
                document.getElementById('chart_yub').style.display = ''
                document.getElementById('chart_yub').style.maxWidth = '100%'
                document.getElementById('chart_yub').style.minHeight = '10%'
                create_chart('yub')
            });
            $('#table_yub').click(function() {
                document.getElementById('graph_yub').style.background = 'white'
                document.getElementById('table_yub').style.background = 'rgb(26, 181, 133)'
                document.getElementById('table_yub').setAttribute('disabled', 'true')
                document.getElementById('graph_yub').removeAttribute('disabled')

                document.getElementById('statickItemInfoTable_yub').style.display = 'block'
                document.getElementById('itemInfoTable_yub').style.display = 'block'
                document.getElementById('chart_yub').style.display = 'none'
                remove_chart('yub')
            });
        })
        function get_plan(){
            $.ajax({
                url: '/get_plan/'+$('#table_date_start').val().split('-')[0],
                method: 'GET',
                success: function (res) {
                    document.getElementById('plan_yams').textContent = Number (res['yams'])
                    document.getElementById('plan_yub').textContent = Number (res['yub'])
                },
                async:false
            })
        }
         function get_table_data() {

             $.ajax({
                 url: '/get_val/'+$('#table_date_start').val()+'/day',
                 method: 'GET',
                 success: function (res) {
                    var type = ''
                    for (var i=0; i<2; i++){
                        if (i === 0){
                            type = 'yams'
                        } else {
                            type = 'yub'
                        }
                        var plan = Number (document.getElementById('plan_'+type).textContent)
                        plan = Math.round((100*plan)/(12*30*24))/100
                        ///заполнение таблицы факт
                        var tr = document.getElementById('fakt_'+type+'_tr')
                        var tr_plan = document.getElementById('plan_'+type+'_tr')
                        var tr_otkl = document.getElementById('otkl_'+type+'_tr')
                        tr.innerText = ''
                        tr_plan.innerText = ''
                        tr_otkl.innerText = ''
                        for (var j=0; j<24; j++){
                            //заполнение факта
                            var td=document.createElement('td')
                            td.innerHTML+=`<span>${res[type][j]}</span>`
                            tr.appendChild(td);
                            //заполнение плана
                            var td_plan=document.createElement('td')
                            td_plan.innerHTML+=`<span>${plan}</span>`
                            tr_plan.appendChild(td_plan);

                            var td_otkl=document.createElement('td')
                            if (res[type][j] === '...'){
                                td_otkl.innerHTML+=`<span>...</span>`
                            } else {
                                td_otkl.innerHTML+=`<span>${Number (res[type][j]) - plan}</span>`
                            }
                            tr_otkl.appendChild(td_otkl);
                        }
                    }
                    document.getElementById('tableDiv_yub').style.display = 'inline-block'
                    document.getElementById('tableDiv_yams').style.display = 'inline-block'
                 },
                 async:false
             })
        }
        function remove_chart(type) {
            if (type === 'yams'){
                try {
                    chart_yams.destroy()
                } catch (e) {
                }
            }else {
                try {
                    chart_yub.destroy()
                } catch (e) {

                }
            }
        }

        function create_chart(mesto) {

            var data_fact = []
            var tr_fakt = document.getElementById('fakt_'+mesto+'_tr').getElementsByTagName('span')
            for (var i=0; i<tr_fakt.length; i++){
                if (tr_fakt[i].textContent === '...'){
                    data_fact.push('0')
                }else {
                    data_fact.push(tr_fakt[i].textContent)
                }
            }
            var data_plan = []
            var tr_plan = document.getElementById('plan_'+mesto+'_tr').getElementsByTagName('span')
            for (var i=0; i<tr_fakt.length; i++){
                if (tr_plan[i].textContent === '...'){
                    data_plan.push('0')
                }else {
                    data_plan.push(tr_plan[i].textContent)
                }
            }
            var x_axix = []
            var th_table = document.getElementById('itemInfoTable_'+mesto).getElementsByTagName('th')
            for (var i=0; i<th_table.length; i++){
                x_axix.push(th_table[i].textContent)
            }

            var options = {
                series: [{
                    name: 'Факт',
                    data: data_fact
                }, {
                    name: 'План',
                    data: data_plan
                }],
                chart: {
                    height: 215,
                    type: 'area'
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                xaxis: {
                    type: 'string',
                    categories: x_axix
                },
            };
            if (mesto === 'yams'){
                chart_yams = new ApexCharts(document.querySelector("#chart_"+mesto), options);
                chart_yams.render();
            } else {
                chart_yub = new ApexCharts(document.querySelector("#chart_"+mesto), options);
                chart_yub.render();
            }

            // document.getElementById('chart').style.margin = ''
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
        #chart {
            max-width: 760px;
            margin: 35px auto;
            opacity: 0.9;
        }

        #timeline-chart .apexcharts-toolbar {
            opacity: 1;
            border: 0;
        }
    </style>


@endsection
