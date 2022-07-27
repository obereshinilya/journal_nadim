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


    @include('include.choice_month')
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
        var header_content = 'Суточные показатели.  ';
        var datatable = null;
        $(document).ready(function () {
/////Объединяем скролы двух таблиц
            $("#itemInfoTable").scroll(function() {
                $('#statickItemInfoTable').scrollTop($("#itemInfoTable").scrollTop());
            });
            $("#statickItemInfoTable").scroll(function() {
                $('#itemInfoTable').scrollTop($("#statickItemInfoTable").scrollTop());
            });
/////
            click_side_menu_func = get_table_data;

            $('#table_date_start').change(function () {
                var choiced = $('.choiced')[0]
                click_side_menu_func(choiced.getAttribute('data-id'));
            })

        })

        function goToDay(day) {
            if (day < 10){
                day = '0' + day
            }
            localStorage.setItem('day', day)
            localStorage.setItem('month', $('#table_date_start').val().split('-')[1])
            localStorage.setItem('year', $('#table_date_start').val().split('-')[0])
            document.location.href = '/'
        }

        function get_table_data(data_id) {

            $('.tableItemInfoChart').remove();

            var data = {
                'id': data_id,
                'type': $('#date-type').val()
            }

            data['date'] = $('#table_date_start').val();

            $.ajax({
                url: '/sut_param/'+$('#table_date_start').val(),
                method: 'GET',
                data: data,
                success: function (res) {
                    var static_table_body=document.getElementById('statickItemInfoTable').getElementsByTagName('tbody')[0]
                    var table_body = document.getElementById('itemInfoTable').getElementsByTagName('tbody')[0]
                    var table_thead = document.getElementById('itemInfoTable').getElementsByTagName('thead')[0]
                    table_body.innerText = ''
                    table_thead.innerText = ''
                    static_table_body.innerHTML=''
                    var charts = {}
                    var index_thead = false
                    var tr_thead = document.createElement('tr')
                    for (var row of res) {
                        var tr = document.createElement('tr')
                        var static_tr=document.createElement('tr')
                        tr.setAttribute('data-id', row['hfrpok'])
                        static_tr.setAttribute('data-id', row['hfrpok'])
                        static_tr.innerHTML += `<td ><span style="background-color: rgba(0, 0, 0, 0); text-align: center">${row['shortname']}</span></td>`
                        static_tr.innerHTML += `<td data-name="namepar1">${row['namepar1']}</td>`

                        var data = [];
                        var xaxis = [];

                        // console.log(row[0]['timestamp'])
                        for (var id = 1; id <= Object.keys(row).length -4; id++) {
                            if (!index_thead){
                                tr_thead.innerHTML += `<th  class="timeCell" onclick="goToDay(${id})" style="width: 2%; text-align: center" data-time-id="1"><h4>${id}</h4></th>`
                            }
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
                        index_thead = true
                        static_table_body.appendChild(static_tr);
                        table_body.appendChild(tr);
                        table_thead.appendChild(tr_thead);
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

                    link_to_changeable('/changetimeparams/sutki');
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
