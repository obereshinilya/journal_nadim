@extends('layouts.app')
@section('title')
    Временные показатели
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


    @include('include.choice_date')
    <style>
        .choice-period-btn {
            display: none;
        }
    </style>
    <div id="content-header"></div>



    <div id="tableDiv">
        <table id="statickItemInfoTable" class="itemInfoTable" style="width: 25%; float:left; direction:rtl; table-layout: fixed">
            <thead>
            <tr>
                <th class="objCell" style="width: 2%; padding-left: 0px; padding-right: 0px; text-align: center"><h4>Ед. изм</h4></th>
                <th class="objCell" ><h4>Наименование параметра</h4></th>
            </tr>
            <tbody>

            </tbody>
        </table>
        <table id="itemInfoTable" class="itemInfoTable" style="width: 74%; float:left">
            <thead>
                <tr>
                    <th  class="timeCell" onclick="goToHour(this.textContent)" style="width: 4%" data-time="10:00" data-time-id="1"><h4>10:00</h4></th>
                    <th  class="timeCell" onclick="goToHour(this.textContent)"  style="width: 4%" data-time="11:00" data-time-id="2"><h4>11:00</h4></th>
                    <th  class="timeCell" onclick="goToHour(this.textContent)"  style="width: 4%" data-time="12:00" data-time-id="3"><h4>12:00</h4></th>
                    <th  class="timeCell" onclick="goToHour(this.textContent)"  style="width: 4%" data-time="13:00" data-time-id="4"><h4>13:00</h4></th>
                    <th  class="timeCell" onclick="goToHour(this.textContent)"  style="width: 4%" data-time="14:00" data-time-id="5"><h4>14:00</h4></th>
                    <th  class="timeCell" onclick="goToHour(this.textContent)"  style="width: 4%" data-time="15:00" data-time-id="6"><h4>15:00</h4></th>
                    <th  class="timeCell" onclick="goToHour(this.textContent)"  style="width: 4%" data-time="16:00" data-time-id="7"><h4>16:00</h4></th>
                    <th  class="timeCell" onclick="goToHour(this.textContent)"  style="width: 4%" data-time="17:00" data-time-id="8"><h4>17:00</h4></th>
                    <th  class="timeCell" onclick="goToHour(this.textContent)"  style="width: 4%" data-time="18:00" data-time-id="9"><h4>18:00</h4></th>
                    <th  class="timeCell" onclick="goToHour(this.textContent)"  style="width: 4%" data-time="19:00" data-time-id="10"><h4>19:00</h4></th>
                    <th  class="timeCell" onclick="goToHour(this.textContent)"  style="width: 4%" data-time="20:00" data-time-id="11"><h4>20:00</h4></th>
                    <th  class="timeCell" onclick="goToHour(this.textContent)"  style="width: 4%" data-time="21:00" data-time-id="12"><h4>21:00</h4></th>

                    <th  class="timeCell" onclick="goToHour(this.textContent)"  style="width: 4%" data-time="22:00" data-time-id="13"><h4>22:00</h4></th>
                    <th  class="timeCell" onclick="goToHour(this.textContent)"  style="width: 4%" data-time="23:00" data-time-id="14"><h4>23:00</h4></th>
                    <th  class="timeCell" onclick="goToHour(this.textContent)"  style="width: 4%" data-time="00:00" data-time-id="15"><h4>00:00</h4></th>
                    <th  class="timeCell" onclick="goToHour(this.textContent)"  style="width: 4%" data-time="01:00" data-time-id="16"><h4>01:00</h4></th>
                    <th  class="timeCell" onclick="goToHour(this.textContent)"  style="width: 4%" data-time="02:00" data-time-id="17"><h4>02:00</h4></th>
                    <th  class="timeCell" onclick="goToHour(this.textContent)"  style="width: 4%" data-time="03:00" data-time-id="18"><h4>03:00</h4></th>
                    <th  class="timeCell" onclick="goToHour(this.textContent)"  style="width: 4%" data-time="04:00" data-time-id="19"><h4>04:00</h4></th>
                    <th  class="timeCell" onclick="goToHour(this.textContent)"  style="width: 4%" data-time="05:00" data-time-id="20"><h4>05:00</h4></th>
                    <th  class="timeCell" onclick="goToHour(this.textContent)"  style="width: 4%" data-time="06:00" data-time-id="21"><h4>06:00</h4></th>
                    <th  class="timeCell" onclick="goToHour(this.textContent)"  style="width: 4%" data-time="07:00" data-time-id="22"><h4>07:00</h4></th>
                    <th  class="timeCell" onclick="goToHour(this.textContent)"  style="width: 4%" data-time="08:00" data-time-id="23"><h4>08:00</h4></th>
                    <th  class="timeCell" onclick="goToHour(this.textContent)"  style="width: 4%" data-time="09:00" data-time-id="24"><h4>09:00</h4></th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>


    <style>
        .content {
            width: calc(100% - 40px);
        }

    </style>

    <script>
        var header_content = 'Часовые показатели.  ';
        var datatable = null;
        $(document).ready(function () {

/////Объединяем скролы двух таблиц
            $("#itemInfoTable").scroll(function() {
                $('#statickItemInfoTable').scrollTop($("#itemInfoTable").scrollTop());
            });
            $("#statickItemInfoTable").scroll(function() {
                $('#itemInfoTable').scrollTop($("#statickItemInfoTable").scrollTop());
            });
/////Выбор диспетчерских суток
            var today = new Date();
            if (today.getHours() < 10){
                today.setDate(today.getDate() -1)
                $('#table_date_start').val(today.toISOString().substring(0, 10))
            } else {
                $('#table_date_start').val(today.toISOString().substring(0, 10))
            }
/////Проверяем заходим ли мы по ссылке
            if (localStorage.getItem('day')){
                $('#table_date_start').val(localStorage.getItem('year') + '-' + localStorage.getItem('month') + '-' +localStorage.getItem('day'))
                localStorage.clear()
            } else {

            }
            click_side_menu_func = get_table_data;
            document.getElementById("table_date_start").setAttribute("max", today.toISOString().substring(0, 10));
            $('#table_date_start').change(function () {
                var choiced = $('.choiced')[0]
                click_side_menu_func(choiced.getAttribute('data-id'));
            })

        })
///Для перехода к пятиминуткам
        function goToHour(hour) {
            hour = hour.split(':')[0]

            if (hour[0] === '0'){
                localStorage.setItem('hour', hour[1])
                var date = new Date($('#table_date_start').val())
                date = new Date(date.setDate(date.getDate() + 1))
                localStorage.setItem('full_date', date.toISOString().substring(0, 10))
            } else {
                localStorage.setItem('hour', hour)
                localStorage.setItem('full_date', $('#table_date_start').val())
            }
            document.location.href = '/minutes'
        }

        function get_table_data(data_id) {

            $('.tableItemInfoChart').remove();

            var data = {
                'id': data_id,
                'type': $('#date-type').val()
            }

            data['date'] = $('#table_date_start').val();

            $.ajax({
                url: '/hours_param/'+$('#table_date_start').val(),
                method: 'GET',
                data: data,
                success: function (res) {
                    var static_table_body=document.getElementById('statickItemInfoTable').getElementsByTagName('tbody')[0]
                    var table_body = document.getElementById('itemInfoTable').getElementsByTagName('tbody')[0]
                    table_body.innerText = ''
                    static_table_body.innerHTML=''
                    var charts = {}
                    for (var row of res) {
                        var tr = document.createElement('tr')
                        var static_tr=document.createElement('tr')
                        tr.setAttribute('data-id', row['hfrpok'])
                        static_tr.setAttribute('data-id', row['hfrpok'])
                        static_tr.innerHTML += `<td ><span style="background-color: rgba(0, 0, 0, 0); text-align: center">${row['shortname']}</span></td>`
                        static_tr.innerHTML += `<td data-name="namepar1">${row['namepar1']}</td>`

                        var data = [];
                        var xaxis = [];


                        for (var id = 1; id <= 24; id++) {
                            if (row[id]['id']) {
                                chart_print = true
                                if (Boolean(row[id]['xml_create']===true)){
                                    tr.innerHTML += `<td data-time-id="${id}" class="hour-value-${row['hfrpok']}" data-time="${row[id]['timestamp']}" style="background-color: #1ab585"><span xml-create="true" numbercolumn="${id}">${row[id]['val']}</span></td>`
                                } else{
                                    if (Boolean(row[id]['manual'])===true){
                                        tr.innerHTML += `<td data-time-id="${id}" class="hour-value-${row['hfrpok']}" data-time="${row[id]['timestamp']}" style="background-color: indianred" ><span class="changeable_td" numbercolumn="${id}" style="background-color: indianred" oncopy="return false" oncut="return false" onpaste="return false" data-column="val" data-row-id="${row[id]['id']}"  spellcheck="false" data-type="float" val="${row[id]['val']}" name="${row[id]['change_by']}" onmouseover="this.textContent = 'Изменил: ' + this.getAttribute('name')" onmouseout="this.textContent = this.getAttribute('val')">${row[id]['val']}</span></td>`
                                    }
                                    else{
                                        tr.innerHTML += `<td data-time-id="${id}" class="hour-value-${row['hfrpok']}" data-time="${row[id]['timestamp']}"><span class="changeable_td" contenteditable="true" style="background-color: white" oncopy="return false" numbercolumn="${id}" oncut="return false" onpaste="return false" data-column="val" data-row-id="${row[id]['id']}"  spellcheck="false" data-type="float">${row[id]['val']}</span></td>`
                                    }
                                }
                                xaxis.push(moment(row[id]['timestamp']).format('HH:mm'))
                                data.push(parseFloat(row[id]['val']))
                            }else {
                                tr.innerHTML += `<td data-time-id="${id}" class="hour-value-${row['hfrpok']}" ><span class="create_td" style="background-color: rgba(0, 0, 0, 0)" oncopy="return false" oncut="return false" onpaste="return false" data-column="val"   numbercolumn="${id}" hfrpok="${row['hfrpok']}" spellcheck="false" data-type="float">...</span></td>`
                            }
                        }

                        static_table_body.appendChild(static_tr);
                        table_body.appendChild(tr);
                        if (row['charts'] === true){
                            jQuery('<div>', {
                                id: `chart${row['id']}`,
                                class: 'tableItemInfoChart',
                            }).appendTo('body');
                            var options = {
                                series: [{
                                    name: row['namepar1'],
                                    data: data
                                }],
                                xaxis: {
                                    categories: xaxis
                                },
                                chart: {
                                    type: 'line',
                                    height: 350,
                                },
                                stroke: {
                                    curve: 'smooth',
                                },
                                dataLabels: {
                                    enabled: false
                                },
                                title: {
                                    text: `${row['namepar1']}`,
                                    align: 'left'
                                },
                                markers: {
                                    hover: {
                                        sizeOffset: 4
                                    }
                                },
                                tooltip: {
                                    custom: function ({series, seriesIndex, dataPointIndex, w}) {
                                        return (
                                            '<div class="arrow_box">' +
                                            "<span>" +
                                            w.globals.seriesNames[seriesIndex] +
                                            ": " +
                                            series[seriesIndex][dataPointIndex] +
                                            "</span>" +
                                            "</div>"
                                        );
                                    }
                                }
                            };

                            var chart = new ApexCharts(document.getElementById(`chart${row['id']}`), options);

                            chart.render();

                            tippy.createSingleton(tippy(`.hour-value-${row['hfrpok']}`, {
                                content: document.getElementById(`chart${row['id']}`),

                            }), {
                                placement: 'left',
                                maxWidth: 650,
                                width:650,
                                delay: 100, // ms
                                moveTransition: 'transform 0.2s ease-out',
                                allowHTML: true,
                                interactive: true,
                            });


                        }
                    }

                    link_to_changeable('/changetimeparams/hour');
                    link_to_create('/createtimeparams');

                },
                async:false

            })

            $('#main_content').width($(document.body).width()-$('#side_menu').width()-50);
        }



    </script>
<style>
    .create_td{
        background-color: white;
    }
</style>


@endsection
