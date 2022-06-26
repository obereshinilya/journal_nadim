@extends('layouts.app')
@section('title')
    Реальное время
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
    <p id="date_start" style="display: none;">{{$date_start}}</p>
    <p id="date_stop" style="display: none;">{{$date_stop}}</p>
    <div style="display: inline-block; width: 100%">
        <div id="content-header" style="width: 40%"></div>
        <a class="choice-period-btn" id="submit_button">Изменить период</a>
    </div>


    <div id="tableDiv" style="margin-top: 2%">
        <table id="statickItemInfoTable" class="itemInfoTable" style="width: 25%; float:left; direction:rtl; table-layout: fixed">
            <thead>
            <tr>
                <th class="objCell" style="width: 5%; text-align: center"><h4>Ед. измерения</h4></th>
                <th class="objCell" style="width: 10%; text-align: center"><h4>Наименование параметра</h4></th>
            </tr>
            <tbody>
                @for($i=0; $i<count($result); $i++)
                    <tr data-id="{{$result[$i]['hfrpok']}}">
                        <td style="text-align: center">{{$result[$i]['shortname']}}</td>
                        <td >{{$result[$i]['namepar1']}}</td>
                    </tr>
                @endfor
            </tbody>
        </table>
        <table id="itemInfoTable" class="itemInfoTable" style="width: 75%; float:left">
            <thead>
            <tr>
                <th  class="timeCell"  style="width: 4%; text-align: center"><h4>{{$hour}}:00</h4></th>
                <th  class="timeCell"  style="width: 4%; text-align: center"><h4>{{$hour}}:05</h4></th>
                <th  class="timeCell"  style="width: 4%; text-align: center"><h4>{{$hour}}:10</h4></th>
                <th  class="timeCell"  style="width: 4%; text-align: center"><h4>{{$hour}}:15</h4></th>
                <th  class="timeCell"  style="width: 4%; text-align: center"><h4>{{$hour}}:20</h4></th>
                <th  class="timeCell"  style="width: 4%; text-align: center"><h4>{{$hour}}:25</h4></th>
                <th  class="timeCell"  style="width: 4%; text-align: center"><h4>{{$hour}}:30</h4></th>
                <th  class="timeCell"  style="width: 4%; text-align: center"><h4>{{$hour}}:35</h4></th>
                <th  class="timeCell"  style="width: 4%; text-align: center"><h4>{{$hour}}:40</h4></th>
                <th  class="timeCell"  style="width: 4%; text-align: center"><h4>{{$hour}}:45</h4></th>
                <th  class="timeCell"  style="width: 4%; text-align: center"><h4>{{$hour}}:50</h4></th>
                <th  class="timeCell"  style="width: 4%; text-align: center"><h4>{{$hour}}:55</h4></th>
            </tr>
            </thead>
            <tbody>
                @for($i=0; $i<count($result); $i++)
                    <tr data-id="{{$result[$i]['hfrpok']}}" name-param="{{$result[$i]['namepar1']}}">
                        @for($j=0; $j<12; $j++)
                            @if($result[$i]['min_params'][$j] != [])
                                <td style="text-align: center" time-param="{{$j*5}}" class="data{{'-'.$i.'-'.$j}}">{{$result[$i]['min_params'][$j]['val']}}</td>
                            @else
                                <td style="text-align: center" time-param="{{$j*5}}" class="data{{'-'.$i.'-'.$j}}">...</td>
                            @endif
                        @endfor
                    </tr>
                @endfor
            </tbody>
        </table>
{{--        <div id="chart_div" style="position: absolute; width: 50%; height: 50%; display: none"></div>--}}
    </div>


    <script>
        var start_date = document.getElementById('date_start').textContent
        var stop_date = document.getElementById('date_stop').textContent.slice(11)
        var header_content = 'Временные показатели за '+start_date+'-'+stop_date+'. ';
        $(document).ready(function () {
            $("#itemInfoTable").scroll(function() {
                $('#statickItemInfoTable').scrollTop($("#itemInfoTable").scrollTop());
            });
            $("#statickItemInfoTable").scroll(function() {
                $('#itemInfoTable').scrollTop($("#statickItemInfoTable").scrollTop());
            });
            click_side_menu_func = show_hide;

            $('#submit_button').click(function () {
                document.location.href = '/mins'
            })

        })

        function show_hide(data_id) {
        }

        // $("#itemInfoTable tr").click(function() {   //попытка сделать график
        //     $('.tableItemInfoChart').remove();
        //     var hfrpok = this.getAttribute('data-id')
        //     var name = this.getAttribute('name-param')
        //     var child = this.querySelectorAll('td')
        //     var data = new Array()
        //     var time = new Array()
        //     var buff = ''
        //     var check_empty = false
        //     for(var j of child){
        //         time.push(Number(j.getAttribute('time-param')))
        //         buff = j.textContent
        //         if (buff === '...'){
        //             buff = 0
        //         } else {
        //             check_empty = true
        //         }
        //         data.push(Number(buff))
        //     }
        //
        //     if (check_empty){
        //         jQuery('<div>', {
        //             id: `chart-${hfrpok}`,
        //             class: 'tableItemInfoChart',
        //         }).appendTo('body');
        //
        //         var options = {
        //             series: [{
        //                 name: name,
        //                 data: data
        //             }],
        //             xaxis: {
        //                 categories: time
        //             },
        //             chart: {
        //                 type: 'line',
        //                 height: 350,
        //             },
        //             stroke: {
        //                 curve: 'smooth',
        //             },
        //             dataLabels: {
        //                 enabled: false
        //             },
        //             title: {
        //                 text: `Динамика измемнения ${name}`,
        //                 align: 'left'
        //             },
        //             markers: {
        //                 hover: {
        //                     sizeOffset: 4
        //                 }
        //             },
        //             tooltip: {
        //                 custom: function ({series, seriesIndex, dataPointIndex, w}) {
        //                     return (
        //                         '<div class="arrow_box">' +
        //                         "<span>" +
        //                         w.globals.seriesNames[seriesIndex] +
        //                         ": " +
        //                         series[seriesIndex][dataPointIndex] +
        //                         "</span>" +
        //                         "</div>"
        //                     );
        //                 }
        //             }
        //         };
        //
        //         var chart = new ApexCharts(document.getElementById(`chart-${hfrpok}`), options);
        //
        //         chart.render();
        //
        //
        //         tippy.createSingleton(tippy(`.data-1-1`, {
        //             content: document.getElementById(`chart-${hfrpok}`),
        //
        //         }), {
        //             placement: 'left',
        //             maxWidth: 650,
        //             width:650,
        //             delay: 100, // ms
        //             moveTransition: 'transform 0.2s ease-out',
        //             allowHTML: true,
        //             interactive: true,
        //         });
        //
        //
        //
        //     }
        // })



    </script>

    <style>
        .content {
            width: calc(100% - 40px);
        }
        table tbody tr{
            height: 40px;
        }
        .choice-period-btn{
            /*box-sizing: border-box;*/
            /*display: inline-block;*/
            min-width: 1.5em;
            padding: .5em 1em;
            text-align: center;
            text-decoration: none !important;
            cursor: pointer;
            color: #fff;
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: #0079c2;
            width: 110px;
        }

    </style>

@endsection
