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
    <h3 >Сменный журнал ННГДУ за {{$date}} </h3>

</div>
<style>
    .choice-period-btn {
        display: none;
    }
</style>
<div id="content-header"></div>


<div id="redirect">

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
                <td id="yub_ukpg">УКПГ</td>
                <td id="yub_ukpg_obor"></td>
                <td  id="yub_ukpg_status"></td>
                <td  id="yub_ukpg_date"></td>
            </tr>
            <tr>
                <td id="yub_dks1">ДКС-1</td>
                <td id="yub_dks1_obor"></td>
                <td  id="yub_dks1_status"></td>
                <td  id="yub_dks1_date"></td>
            </tr>
            <tr>
                <td id="yub_dks2">ДКС-2</td>
                <td id="yub_dks2_obor"></td>
                <td  id="yub_dks2_status"></td>
                <td  id="yub_dks2_date"></td>
            </tr>
            <tr>
                <th colspan="2">ЮНТС</th>
                <td  id="unts_obor"  style="background-color: white" ></td>
                <td id="unts_status"  style="background-color: white" ></td>
                <td id="unts_date"  style="background-color: white" ></td>
            </tr>
            <tr>
                <th rowspan="3">ЯНГКМ</th>
                <td id="yams_ukpg">УКПГ</td>
                <td id="yams_ukpg_obor"></td>
                <td  id="yams_ukpg_status"></td>
                <td  id="yams_ukpg_date"></td>
            </tr>
            <tr>
                <td id="yams_dks1">ДКС-1</td>
                <td id="yams_dks1_obor"></td>
                <td  id="yams_dks1_status"></td>
                <td  id="yams_dks1_date"></td>
            </tr>
            <tr>
                <td id="yams_dks2">ДКС-2</td>
                <td id="yams_dks2_obor"></td>
                <td  id="yams_dks2_status"></td>
                <td  id="yams_dks2_date"></td>
            </tr>
            <tr>
                <th colspan="3">ООО ГДН</th>
                <td id="gdn"  colspan="3" style="background-color: white" </td>
            </tr>
            <tr>
                <th rowspan="2">Метео</th>
                <td style="text-align: center">19:00</td>
                <td id="meteo_19"  style="background-color: white" ></td>
                <td id="meteo_date"  colspan="3" rowspan="2" style="background-color: white" ></td>
            </tr>
            <tr>
                <td style="text-align: center">07:00</td>
                <td  id="meteo_7"  style="background-color: white" ></td>
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
                <td id="yub_job" style="background-color: white" ></td>
                <td id="yub_reserv" style="background-color: white" ></td>
                <td id="yub_nagruzka" style="background-color: white" ></td>
                <td id="yub_to" style="background-color: white" ></td>

            </tr>
            <tr>
                <td style="text-align: center">ЯГКМ</td>
                <td id="yams_job" style="background-color: white" ></td>
                <td id="yams_reserv" style="background-color: white" ></td>
                <td id="yams_nagruzka" style="background-color: white" ></td>
                <td id="yams_to" style="background-color: white" ></td>

            </tr>
            </tbody>
        </table>
    </div>
    <div style="margin-top: 10%">
        <span style="text-decoration:underline; margin-left: 70%; font-size: 20px">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; / &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</span>
    </div>
</div>


<style>
    .content {
        width: calc(100% - 40px);
    }
</style>

<script>

    $(document).ready(function () {
        get_row('yub_ukpg')
        get_row('yub_dks1')
        get_row('yub_dks2')
        get_row('yams_ukpg')
        get_row('yams_dks1')
        get_row('yams_dks2')
        get_table_data();
    })

    function get_row(id){
        $.ajax({
            url: '/get_row/'+document.getElementById('date').textContent+'/'+id,
            method: 'GET',
            success: function (res) {
                document.getElementById(id+'_obor').innerHTML = res[id+'_obor']
                document.getElementById(id+'_status').innerHTML = res[id+'_status']
                document.getElementById(id+'_date').innerHTML = res[id+'_date']
            },
            async:true
        })
    }
    function get_table_data() {
        $.ajax({
            url: '/get_row_other/'+document.getElementById('date').textContent,
            method: 'GET',
            success: function (res) {
                for (var j=0; j<Object.keys(res).length; j++){
                    document.getElementById(Object.keys(res)[j]).textContent = Object.values(res)[j]
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
        document.location.href = "/open_journal_smeny"
    }






</script>
<style>
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
</style>
