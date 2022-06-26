@extends('layouts.app')
@section('title')
    Реальное время
@endsection

@section('content')
<h2>Укажите интервал для отображения данных реального времени</h2>
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
    <div id="content-header"></div>
    @include('include.choice_date_time')


    <script>
        $(document).ready(function () {
            var today = new Date();
            $('#table_date_start').val(today.toISOString().substring(0, 10))
            document.getElementById("table_date_start").setAttribute("max", today.toISOString().substring(0, 10));
            var optionList  = document.getElementById("select_interval").getElementsByTagName('option');
            if ($('#table_date_start').val() === today.toISOString().substring(0, 10)){
                for (var i of optionList){
                    if (i.value > today.getHours()){
                        i.setAttribute('style', 'display:none')
                    }
                }
            }
            $('#table_date_start').change(function() {
                if ($('#table_date_start').val() === today.toISOString().substring(0, 10)) {
                    for (var i of optionList){
                        if (i.value >= today.getHours()){
                            i.setAttribute('style', 'display:none')
                        }
                    }
                } else {
                    for (var i of optionList){
                        i.setAttribute('style', 'display:block')
                    }
                }
            });
            $('#submit_button').click(function () {
                document.getElementById('submit_button').style.display = 'none'
                document.getElementById('wait_button').style.display = ''
                document.location.href = '/mins_param/'+$('#table_date_start').val()+'/'+document.getElementById("select_interval").value
            })
        })


    </script>

    <style>
        .content {
            width: calc(100% - 40px);
        }

    </style>

@endsection
