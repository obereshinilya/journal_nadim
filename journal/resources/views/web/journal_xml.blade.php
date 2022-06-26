@extends('layouts.app')
@section('title')
    Журнал отправки XML
@endsection


@section('content')
    @push('scripts')
        <script src="{{asset('assets/js/moment-with-locales.min.js')}}"></script>
        <script src="{{asset('assets/libs/changeable_td.js')}}"></script>
        <script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('assets/libs/modal-windows/modal_windows.js')}}"></script>
    @endpush

    @push('styles')
        <link rel="stylesheet" href="{{asset('assets/css/table.css')}}">
        <link rel="stylesheet" href="{{asset('assets/libs/modal-windows/modal_windows.css')}}">
    @endpush



    <div id="content-header"><h3>Журнал событий по отправке XML</h3></div>

    <style>
        .content{
            width: calc(100% - 40px);
        }

    </style>

    <div id="tableDiv">
        <table id="itemInfoTable" class="itemInfoTable">
            <thead>
                <tr>
                    <th style="text-align: center; width: 10%">Дата (местн)</th>
                    <th style="text-align: center">Событие</th>
                    <th style="text-align: center">Статус</th>
                </tr>

            </thead>
            <tbody>

            </tbody>
        </table>
{{--        <a class="paginate_button first disabled" aria-controls="itemInfoTable" style="float: right" data-dt-idx="0" tabindex="-1" id="to_print">Печать</a>--}}
    </div>

    <script>

        $(document).ready(function (){

            getTableData();
            // var button_print = document.getElementById('to_print'); //кнопка отправки на печать
            // button_print.href = `/create_pdf_ter/economy_norm/${start_date}`;


            $('#itemInfoTable').DataTable({
                "pagingType": "full_numbers",
                destroy: true

            });

            // $('.objCell').removeAttr('style')
        });

        function getTableData(type=null, data=null) {
            document.body.className = '';



            $.ajax({
                url:'/get_journal_xml_data',
                data: 1,
                type:'GET',
                success:(res)=>{
                    if ($.fn.dataTable.isDataTable('#itemInfoTable')) {
                        $('#itemInfoTable').DataTable().destroy();
                    }
                    var result = Object.keys(res);
                    // var result = Object.keys(res).map((key) => res[key]);
//
// console.log(res)
                    var table_body=document.getElementById('itemInfoTable').getElementsByTagName('tbody')[0]
                    table_body.innerText=''
                    for (var i = 0; i<res.length; i++){
                        var tr=document.createElement('tr')
                        tr.innerHTML+=`<td><span data-type="text" style="text-align: center">${res[i]['timestamp']}</span></td>`
                        tr.innerHTML+=`<td><span data-type="text" style="text-align: center">${res[i]['event']}</span></td>`
                        tr.innerHTML+=`<td><span data-type="text" style="text-align: center">${res[i]['option']}</span></td>`


                        table_body.appendChild(tr);
                    }



                    $('#itemInfoTable').DataTable({
                        "pagingType": "full_numbers",
                        destroy: true
                    });
                    // $('.objCell').removeAttr('style')

                    window.setTimeout(function () {
                        document.body.classList.add('loaded');
                        document.body.classList.remove('loaded_hiding');
                    }, 500);
                }
            })
        }

    </script>


@endsection


