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

    <div style="display: inline-flex; width: 100%; margin-left: 33%">
            <h3 >Сводный отчет Надымского НГДУ за {{$date}}</h3>

    </div>
    <style>
        .choice-period-btn {
            display: none;
        }
    </style>
    <div id="content-header"></div>


    <div id="redirect">

    <div id="tableDiv" style="width: 40%; margin-left: 30%">
        <table id="statickItemInfoTable" class="itemInfoTable" style="">
            <thead>
            <tr>
                <th rowspan="2" style="width: 10%; text-align: center">Час</th>
                <th colspan="2" style="width: 20%; text-align: center">Ямсовей (сеноман)</th>
                <th rowspan="2" style="width: 10%; text-align: center">Q ННГДУ</th>
            </tr>
            <tr>
                <th style="width: 10%; text-align: center">P вых</th>
                <th style="width: 10%; text-align: center">Q</th>
            </tr>
            </thead>
            <tbody id="time_id">

            </tbody>
        </table>

    </div>
    <div style="margin-top: 25%">
        <span style="text-decoration:underline; margin-left: 45%; font-size: 20px">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; / &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</span>
    </div>
    </div>


    <style>
        .content {
            width: calc(100% - 40px);
        }
    </style>

    <script>

        $(document).ready(function () {
            get_table_data();
        })

         function get_table_data() {

             $.ajax({
                 url: '/get_svodniy/'+document.getElementById('date').textContent,
                 method: 'GET',
                 success: function (res) {
                     var time_id = ''
                     for (var j of res){

                         var body = document.getElementById('time_id')
                         body.innerText = ''
                             for (var i=0; i<24; i++) {
                                 var tr=document.createElement('tr')
                                 tr.innerHTML+=`<td style="text-align: center; padding: 0px; min-width: 20px"><p>${i+':00'}</p></td>`
                                 tr.innerHTML+=`<td style="text-align: center; padding: 0px; min-width: 20px"><p>${res[i]['p']}</p></td>`
                                 tr.innerHTML+=`<td style="text-align: center; padding: 0px; min-width: 20px"><p>${res[i]['q']}</p></td>`
                                 tr.innerHTML+=`<td style="text-align: center; padding: 0px; min-width: 20px"><p>${res[i]['q']}</p></td>`
                                 body.appendChild(tr);
                             }

                     }

                 },
                 async:true
             })
        }

        setTimeout(function() {
            window.print();
        }, 1500)
        var div = document.getElementById("redirect")
        div.onclick = function(){
            document.location.href = "/open_svodniy"
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


