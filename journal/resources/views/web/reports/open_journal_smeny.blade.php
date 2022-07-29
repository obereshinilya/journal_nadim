@extends('layouts.app')
@section('title')
    Журнал смены
@endsection
@section('side_menu')
    @include('web.reports.side_menu_reports')
@endsection
@section('content')

    @push('scripts')
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
            <h3>Сменный журнал ННГДУ за</h3>

            <div class="date-input-group" style="margin-left: 2%">
                <input type="date" id="table_date_start" class="date_input" required onkeydown="return false">
                <label for="table_date_start" class="table_date_label">Дата</label>
            </div>

                <button  id="print" class="button button1" style="margin-left: 50%; margin-top: 1%">Печать</button>
                <button  id="save_all" class="button button1" style="margin-left: 1%; margin-top: 1%">Сохранить изменения</button>
        </div>

    <div id="content-header" style="display: inline-flex; width: 100%">
    </div>

    <div id="tableDiv" style="height: auto">

        <table class="iksweb">
            <tbody>
            <tr>
                <th colspan="2" style="width: 15%">Месторождение</th>
                <th style="width: 10%">Объект</th>
                <th style="width: 10%">Оборудование</th>
                <th style="width: 10%">Статус</th>
                <th style="width: 55%">Дата/время/описание работ</th>
            </tr>
            <tr>
                <th rowspan="7">ННГДУ</th>
                <th rowspan="3">ЮНГКМ сеноман</th>
                <td id="yub_ukpg" onmouseover="this.textContent = 'Добавить запись'; this.style.background = 'green'" onmouseout="this.textContent = 'УКПГ'; this.style.background = ''" onclick="add_new_record(this.id)">УКПГ</td>
                <td id="yub_ukpg_save" onmouseover="this.style.background = 'green'" onmouseout="this.style.background = '#3CB371'" style="display: none; background: #3CB371" onclick="save_new_record(this.id)">Сохранить</td>
                <td id="yub_ukpg_obor"></td>
                <td  id="yub_ukpg_status"></td>
                <td  id="yub_ukpg_date"></td>
            </tr>
            <tr>
                <td id="yub_dks1" onmouseover="this.textContent = 'Добавить запись'; this.style.background = 'green'" onmouseout="this.textContent = 'ДКС-1'; this.style.background = ''" onclick="add_new_record(this.id)">ДКС-1</td>
                <td id="yub_dks1_save" onmouseover="this.style.background = 'green'" onmouseout="this.style.background = '#3CB371'" style="display: none; background: #3CB371" onclick="save_new_record(this.id)">Сохранить</td>
                <td id="yub_dks1_obor"></td>
                <td  id="yub_dks1_status"></td>
                <td  id="yub_dks1_date"></td>
            </tr>
            <tr>
                <td id="yub_dks2" onmouseover="this.textContent = 'Добавить запись'; this.style.background = 'green'" onmouseout="this.textContent = 'ДКС-2'; this.style.background = ''" onclick="add_new_record(this.id)">ДКС-2</td>
                <td id="yub_dks2_save" onmouseover="this.style.background = 'green'" onmouseout="this.style.background = '#3CB371'" style="display: none; background: #3CB371" onclick="save_new_record(this.id)">Сохранить</td>
                <td id="yub_dks2_obor"></td>
                <td  id="yub_dks2_status"></td>
                <td  id="yub_dks2_date"></td>
            </tr>
            <tr>
                <th colspan="2">ЮНТС</th>
                <td  id="unts_obor" contenteditable="true" style="background-color: white" ></td>
                <td id="unts_status" contenteditable="true" style="background-color: white" ></td>
                <td id="unts_date" contenteditable="true" style="background-color: white" ></td>
            </tr>
            <tr>
                <th rowspan="3">ЯНГКМ</th>
                <td id="yams_ukpg" onmouseover="this.textContent = 'Добавить запись'; this.style.background = 'green'" onmouseout="this.textContent = 'УКПГ'; this.style.background = ''" onclick="add_new_record(this.id)">УКПГ</td>
                <td id="yams_ukpg_save" onmouseover="this.style.background = 'green'" onmouseout="this.style.background = '#3CB371'" style="display: none; background: #3CB371" onclick="save_new_record(this.id)">Сохранить</td>
                <td id="yams_ukpg_obor"></td>
                <td  id="yams_ukpg_status"></td>
                <td  id="yams_ukpg_date"></td>
            </tr>
            <tr>
                <td id="yams_dks1" onmouseover="this.textContent = 'Добавить запись'; this.style.background = 'green'" onmouseout="this.textContent = 'ДКС-1'; this.style.background = ''" onclick="add_new_record(this.id)">ДКС-1</td>
                <td id="yams_dks1_save" onmouseover="this.style.background = 'green'" onmouseout="this.style.background = '#3CB371'" style="display: none; background: #3CB371" onclick="save_new_record(this.id)">Сохранить</td>
                <td id="yams_dks1_obor"></td>
                <td  id="yams_dks1_status"></td>
                <td  id="yams_dks1_date"></td>
            </tr>
            <tr>
                <td id="yams_dks2" onmouseover="this.textContent = 'Добавить запись'; this.style.background = 'green'" onmouseout="this.textContent = 'ДКС-2'; this.style.background = ''" onclick="add_new_record(this.id)">ДКС-2</td>
                <td id="yams_dks2_save" onmouseover="this.style.background = 'green'" onmouseout="this.style.background = '#3CB371'" style="display: none; background: #3CB371" onclick="save_new_record(this.id)">Сохранить</td>
                <td id="yams_dks2_obor"></td>
                <td  id="yams_dks2_status"></td>
                <td  id="yams_dks2_date"></td>
            </tr>
            <tr>
                <th colspan="3">ООО ГДН</th>
                <td id="gdn" contenteditable="true" colspan="3" style="background-color: white" </td>
            </tr>
            <tr>
                <th rowspan="2">Метео</th>
                <td style="text-align: center">19:00</td>
                <td id="meteo_19" contenteditable="true" style="background-color: white" ></td>
                <td id="meteo_date" contenteditable="true" colspan="3" rowspan="2" style="background-color: white" ></td>
            </tr>
            <tr>
                <td style="text-align: center">07:00</td>
                <td  id="meteo_7" contenteditable="true" style="background-color: white" ></td>
            </tr>
            <tr>
                <th colspan="2">ЭСН</th>
                <th>Работа</th>
                <th>Резерв</th>
                <th>Нагрузка факт/max/средняя МВт</th>
                <th>ТО/ТР</th>
            </tr>
            <tr>
                <td style="text-align: center">ЮКГМ</td>
                <td rowspan="2"  style="text-align: center; vertical-align: center">ПАЭС</td>
                <td id="yub_job" contenteditable="true"style="background-color: white" ></td>
                <td id="yub_reserv" contenteditable="true"style="background-color: white" ></td>
                <td id="yub_nagruzka" contenteditable="true"style="background-color: white" ></td>
                <td id="yub_to" contenteditable="true"style="background-color: white" ></td>

            </tr>
            <tr>
                <td style="text-align: center">ЯГКМ</td>
                <td id="yams_job" contenteditable="true"style="background-color: white" ></td>
                <td id="yams_reserv" contenteditable="true"style="background-color: white" ></td>
                <td id="yams_nagruzka" contenteditable="true"style="background-color: white" ></td>
                <td id="yams_to" contenteditable="true"style="background-color: white" ></td>

            </tr>
            </tbody>
        </table>
    </div>



    <script>

        $(document).ready(function () {
            var today = new Date();
            $('#table_date_start').val(today.toISOString().substring(0, 10))
            document.getElementById("table_date_start").setAttribute("max", today.toISOString().substring(0, 10));

            get_row('yub_ukpg')
            get_row('yub_dks1')
            get_row('yub_dks2')
            get_row('yams_ukpg')
            get_row('yams_dks1')
            get_row('yams_dks2')
            get_table_data();


            $('#table_date_start').change(function () {
                var ids_special_row = ['yub_ukpg', 'yub_dks1', 'yub_dks2', 'yams_ukpg', 'yams_dks1', 'yams_dks2']
                for (var id_special_row of ids_special_row){
                    document.getElementById(id_special_row).style.display = ''
                    document.getElementById(id_special_row+'_save').style.display = 'none'
                    document.getElementById(id_special_row+'_obor').contentEditable = false
                    document.getElementById(id_special_row+'_status').contentEditable = false
                    document.getElementById(id_special_row+'_date').contentEditable = false
                    document.getElementById(id_special_row+'_obor').style.background = ''
                    document.getElementById(id_special_row+'_status').style.background = ''
                    document.getElementById(id_special_row+'_date').style.background = ''
                    get_row(id_special_row)
                    get_table_data();
                }
            })
            $('#print').click(function() {
                window.location.href = '/print_journal_smeny/'+$('#table_date_start').val()
            });
            $('#save_all').click(function() {
                save_other_row()
            });

        })
        function add_new_record(id){
            document.getElementById(id).style.display = 'none'
            document.getElementById(id+'_save').style.display = ''
            document.getElementById(id+'_obor').contentEditable = true
            document.getElementById(id+'_status').contentEditable = true
            document.getElementById(id+'_date').contentEditable = true
            document.getElementById(id+'_obor').style.background = 'white'
            document.getElementById(id+'_status').style.background = 'white'
            document.getElementById(id+'_date').style.background = 'white'
            document.getElementById(id+'_obor').textContent = ''
            document.getElementById(id+'_status').textContent = ''
            document.getElementById(id+'_date').textContent = ''
        }

        function save_new_record(id){
            var id_mother = id.split('_')[0]+'_'+id.split('_')[1]
            var arr = new Map()
            arr.set(id_mother+'_obor', document.getElementById(id_mother+'_obor').textContent)
            arr.set(id_mother+'_status', document.getElementById(id_mother+'_status').textContent)
            arr.set(id_mother+'_date', document.getElementById(id_mother+'_date').textContent)
            var data = Object.fromEntries(arr)
            $.ajax({
                url: '/save_journal_smeny/'+$('#table_date_start').val(),
                data: data,
                method: 'POST',
                success: function (res) {
                    alert('Данные сохранены!')
                },
                async:false
            })
            document.getElementById(id_mother).style.display = ''
            document.getElementById(id).style.display = 'none'
            document.getElementById(id_mother+'_obor').contentEditable = false
            document.getElementById(id_mother+'_status').contentEditable = false
            document.getElementById(id_mother+'_date').contentEditable = false
            document.getElementById(id_mother+'_obor').style.background = ''
            document.getElementById(id_mother+'_status').style.background = ''
            document.getElementById(id_mother+'_date').style.background = ''
            get_row(id_mother)
        }

        function save_other_row(){
            var arr = new Map()
            var ids = ['unts_obor', 'unts_status', 'unts_date', 'gdn', 'meteo_19', 'meteo_7', 'meteo_date', 'yub_reserv', 'yub_nagruzka', 'yub_to', 'yams_reserv', 'yams_nagruzka', 'yams_to', 'yub_job', 'yams_job']
            for (var one_id of ids){
                arr.set(one_id, document.getElementById(one_id).textContent)
            }
            var data = Object.fromEntries(arr)
            $.ajax({
                url: '/save_other_row/'+$('#table_date_start').val(),
                data: data,
                method: 'POST',
                success: function (res) {
                    alert('Данные сохранены!')

                },
                async:true
            })
        }


        function get_row(id){
            $.ajax({
                url: '/get_row/'+$('#table_date_start').val()+'/'+id,
                method: 'GET',
                success: function (res) {
                        document.getElementById(id+'_obor').innerHTML = res[id+'_obor']
                        document.getElementById(id+'_status').innerHTML = res[id+'_status']
                        document.getElementById(id+'_date').innerHTML = res[id+'_date']
                },
                error: function(){
                    document.getElementById(id+'_obor').innerHTML = ''
                    document.getElementById(id+'_status').innerHTML = ''
                    document.getElementById(id+'_date').innerHTML = ''
                },
                async:true
            })
        }
         function get_table_data() {
             $.ajax({
                 url: '/get_row_other/'+$('#table_date_start').val(),
                 method: 'GET',
                 success: function (res) {
                     for (var j=0; j<Object.keys(res).length; j++){
                         document.getElementById(Object.keys(res)[j]).textContent = Object.values(res)[j]
                     }
                 },
                 async:true
             })
        }

    </script>
    <style>
        span{
            outline: none !important;
        }
        table.iksweb{
            width: 100%;
            border-collapse:collapse;
            border-spacing:0;
            height: auto;
        }
        table.iksweb td, table.iksweb th {
            border: 1px solid #595959;
        }
        table.iksweb td,table.iksweb th {
            min-height:35px;
            padding: 3px;
            /*width: 30px;*/
            height: 40px;
        }
        table.iksweb th {
            background: #347c99;
            color: #fff;
            font-weight: normal;
        }
        .content {
            overflow-x: hidden;
            width: 100%;
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
        .date_input{
            font-family: inherit;
            width: 100%;
            border: 0;
            border-bottom: 2px solid #9b9b9b;
            outline: 0;
            font-size: 1.3rem;
            color: black;
            padding: 7px 0;
            background: transparent;
            transition: border-color 0.2s;
        }

        .date-input-group{
            /*width: 30%;*/
            margin: 8px 5px;
            display: table-cell;
            padding-left: 5px;
            padding-right: 10px;
            float:left;
        }

        input[type=date]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            display: none;
        }
        input[type=date]::-webkit-clear-button {
            -webkit-appearance: none;
            display: none;
        }



        .date_input::placeholder {
            color: transparent;
        }
        .date_input:placeholder-shown ~ .form__label {
            font-size: 1.3rem;
            cursor: text;
            top: 20px;
        }

        .table_date_label {
            position: absolute;
            top: 0;
            display: block;
            transition: 0.2s;
            font-size: 1rem;
            color: #9b9b9b;
        }
        .date_input:focus {
            /*padding-bottom: 6px;*/
            font-weight: 700;
            /*border-width: 3px;*/
            border-image: linear-gradient(to right, black, gray);
            border-image-slice: 1;
        }
        .date_input:focus ~ .table_date_label {
            position: absolute;
            top: 0;
            display: block;
            transition: 0.2s;
            font-size: 1rem;
            color: black;
            font-weight: 700;
        }


    </style>


@endsection
