@extends('layouts.app')
@section('title')
    Режим работы ГПА
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
        <h3 >Режим работы ГПА</h3>
    <style>
        .choice-period-btn {
            display: none;
        }
    </style>
    <div id="content-header"></div>



    <div id="tableDiv" style="width: 70%">
        <table id="statickItemInfoTable" class="itemInfoTable" style="">
            <thead>
            <tr>
                <th style="width: 16%; text-align: center"><h4>ГПА 11</h4></th>
                <th style="width: 16%; text-align: center"><h4>ГПА 12</h4></th>
                <th style="width: 16%; text-align: center"><h4>ГПА 13</h4></th>
                <th style="width: 16%; text-align: center"><h4>ГПА 14</h4></th>
                <th style="width: 16%; text-align: center"><h4>ГПА 15</h4></th>
                <th style="width: 16%; text-align: center"><h4>ГПА 16</h4></th>
            </tr>
            </thead>
            <tbody>

            <tr>
                <td style="width: 16%; text-align: center"><select id="gpa11"><option value="ТО">ТО</option><option value="Работа">Работа</option><option value="Резерв">Резерв</option></select></td>
                <td style="width: 16%; text-align: center"><select id="gpa12"><option value="ТО">ТО</option><option value="Работа">Работа</option><option value="Резерв">Резерв</option></select></td>
                <td style="width: 16%; text-align: center"><select id="gpa13"><option value="ТО">ТО</option><option value="Работа">Работа</option><option value="Резерв">Резерв</option></select></td>
                <td style="width: 16%; text-align: center"><select id="gpa14"><option value="ТО">ТО</option><option value="Работа">Работа</option><option value="Резерв">Резерв</option></select></td>
                <td style="width: 16%; text-align: center"><select id="gpa15"><option value="ТО">ТО</option><option value="Работа">Работа</option><option value="Резерв">Резерв</option></select></td>
                <td style="width: 16%; text-align: center"><select id="gpa16"><option value="ТО">ТО</option><option value="Работа">Работа</option><option value="Резерв">Резерв</option></select></td>
            </tr>
            </tbody>
            <thead>
            <tr>
                <th style="width: 16%; text-align: center"><h4>ГПА 21</h4></th>
                <th style="width: 16%; text-align: center"><h4>ГПА 22</h4></th>
                <th style="width: 16%; text-align: center"><h4>ГПА 23</h4></th>
                <th style="width: 16%; text-align: center"><h4>ГПА 24</h4></th>
                <th style="width: 16%; text-align: center"><h4>ГПА 25</h4></th>
                <th style="width: 16%; text-align: center"><h4>ГПА 26</h4></th>
            </tr>
            </thead>
            <tbody>

            <tr>
                <td style="width: 16%; text-align: center"><select id="gpa21"><option value="ТО">ТО</option><option value="Работа">Работа</option><option value="Резерв">Резерв</option></select></td>
                <td style="width: 16%; text-align: center"><select id="gpa22"><option value="ТО">ТО</option><option value="Работа">Работа</option><option value="Резерв">Резерв</option></select></td>
                <td style="width: 16%; text-align: center"><select id="gpa23"><option value="ТО">ТО</option><option value="Работа">Работа</option><option value="Резерв">Резерв</option></select></td>
                <td style="width: 16%; text-align: center"><select id="gpa24"><option value="ТО">ТО</option><option value="Работа">Работа</option><option value="Резерв">Резерв</option></select></td>
                <td style="width: 16%; text-align: center"><select id="gpa25"><option value="ТО">ТО</option><option value="Работа">Работа</option><option value="Резерв">Резерв</option></select></td>
                <td style="width: 16%; text-align: center"><select id="gpa26"><option value="ТО">ТО</option><option value="Работа">Работа</option><option value="Резерв">Резерв</option></select></td>
            </tr>
            </tbody>
        </table>
        <button  id="solve" class="button button1" style="margin-left: 20%">Сохранить</button>
    </div>



    <style>
        .content {
            width: calc(100% - 40px);
        }
    </style>

    <script>

        var datatable = null;
        $(document).ready(function () {
            get_table_data()

            $('#solve').click(function() {
                post_table_data();
            });

        })

         function get_table_data() {

             $.ajax({
                url: '/get_gpa_rezhim/',
                method: 'GET',
                success: function (res) {
                    for (var i = 11; i<27; i++){
                        if (res[i]){
                            var select = document.getElementById('gpa'+res[i]['number_gpa'])
                            select.value = res[i]['rezhim']
                        }
                    }
                },
                async:true
            })
        }

        function post_table_data() {
            var arr = new Map()
            for (var i = 11; i<27; i++){
                if (document.getElementById('gpa'+i)){
                    arr.set('gpa'+i, document.getElementById('gpa'+i).value)
                }
            }
            var data = Object.fromEntries(arr)
            $.ajax({
                url: '/post_gpa_rezhim',
                data: data,
                method: 'POST',
                success: function (res) {
                    alert('Данные успешно сохранены!')
                },
                async:true
            })
            get_table_data()
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
    </style>


@endsection
