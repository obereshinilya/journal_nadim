<style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px}

    .itemInfoTable th, .itemInfoTable td{
        border: 1px solid black;
        margin: 0;
        padding: 0;
        border-spacing: 0px;
        border-collapse: collapse;
    }
    table{
        border-spacing: 0px;
        border-collapse: collapse;
    }
    table th{
        background-color: darkgrey;
    }
</style>

<script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('assets/js/jquery-ui.js')}}"></script>
@stack('scripts')
@stack('styles')
<script src="{{ asset('js/app.js') }}"></script>

<p id="date" style="display: none">{{$date}}</p>

    <div style="display: inline-flex; width: 100%; margin-left: 25%">
            <h1 >Балансовый отчет Надымского НГДУ за {{$date}}</h1>

    </div>
    <style>
        .choice-period-btn {
            display: none;
        }
    </style>
    <div id="content-header"></div>


    <div id="redirect">

        <div id="content-header" style="margin-top: 2%">
            <h2>Показатели Ямсовейского ГКМ</h2>
            <input  id="plan_yams" type="number" style="display: none" placeholder="Годовой план">
        </div>
        <div id="tableDiv_yams" style="display: none; margin-top: 1%; overflow-x: auto">
            <div id="chart_yams" style="display: none; width: 100%">
                <div id="timeline-chart" style="width: 100%"></div>
            </div>
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
            <table id="itemInfoTable_yams" class="itemInfoTable" style="width: 87%; float:left; overflow-x: auto; display: block; white-space: nowrap">
                <thead>
                <tr id="thead_yams">
                    {{--                    <th  class="timeCell" style="width: 8%"><h4>Декабрь</h4></th>--}}
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

        <div id="content-header" style="padding-top: 20px">
            <h2>Показатели Юбилейного ГКМ</h2>
            <input  id="plan_yub" type="number" style="display: none" placeholder="Годовой план">
        </div>
        <div id="tableDiv_yub" style="display: none">
            <div id="chart_yub" style="display: none; width: 100%">
                <div id="timeline-chart" style="width: 100%"></div>
            </div>
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
            <table id="itemInfoTable_yub" class="itemInfoTable" style="width: 87%; float:left; overflow-x: auto; display: block; white-space: nowrap">
                <thead>
                <tr id="thead_yub">
                    {{--                <th  class="timeCell" style="width: 8%"><h4>Январь</h4></th>--}}
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
        <div style="margin-top: 30%">
        <span style="text-decoration:underline; margin-left: 60%; font-size: 20px">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; / &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</span>
        </div>
    </div>


    <style>
        .content {
            width: calc(100% - 40px);
        }
    </style>

    <script>

        $(document).ready(function () {
            get_plan()
            get_table_data();
        })

        function get_plan(){
            $.ajax({
                url: '/get_plan/'+document.getElementById('date').textContent.split('-')[0],
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
                url: '/get_val/'+document.getElementById('date').textContent+'/month',
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
                        plan = Math.round((100*plan)/(12*Object.keys(res[type]).length))/100
                        ///заполнение таблицы факт
                        var th = document.getElementById('thead_'+type)
                        var tr = document.getElementById('fakt_'+type+'_tr')
                        var tr_plan = document.getElementById('plan_'+type+'_tr')
                        var tr_otkl = document.getElementById('otkl_'+type+'_tr')
                        th.innerText = ''
                        tr.innerText = ''
                        tr_plan.innerText = ''
                        tr_otkl.innerText = ''
                        for (var j=1; j<=Object.keys(res[type]).length; j++){
                            //заполнение хедера
                            var th_day=document.createElement('th')
                            th_day.classList.add('timeCell')
                            th_day.style.width = '4%'
                            th_day.innerHTML+=`<h4>${j}</h4>`
                            th.appendChild(th_day);
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
                    document.getElementById('tableDiv_yub').style.display = 'inline'
                    document.getElementById('tableDiv_yams').style.display = 'inline'
                },
                async:false
            })
        }

        setTimeout(function() {
            window.print();
        }, 1500)
        var div = document.getElementById("redirect")
        div.onclick = function(){
            document.location.href = "/open_val_month"
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


