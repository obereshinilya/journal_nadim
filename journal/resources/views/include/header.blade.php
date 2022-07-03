
<div class="header">
    <div class="header_container">
            <ul class="header_menu">
                <li><a href="/" style="padding-right: 37px;">Часовые показатели</a></li>
                <li><a href="/sut" style="padding-right: 37px;">Суточные показатели</a></li>
                <li><a href="/minutes" style="padding-right: 37px;">Реальное время</a></li>
                <li><a href="/journal_xml" style="padding-right: 37px;">Журнал XML<i class="fa fa-angle-down"></i></a></li>
{{--                    <ul class="submenu_ul">--}}
{{--                        <div>--}}
{{--                            <li class="submenu_li"><a href="/journal_xml" class="submenu_a level1">Журнал XML</a></li>--}}
{{--                        </div>--}}
{{--                        <div>--}}
{{--                            <li class="submenu_li" ><a href="#" class="submenu_a  level1">Отправка</a></li>--}}
{{--                            <div class="level2">--}}
{{--                                <li class="submenu_li" style="background-color: rgb(58,146,229)" ><a id="xml_hour">Часовые</a></li>--}}
{{--                                <li class="submenu_li" style="background-color: rgb(58,146,229)"><a id="xml_sut">Суточные</a></li>--}}
{{--                                <li class="submenu_li" style="background-color: rgb(58,146,229)"><a id="xml_mins">Реальное время</a></li>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </ul>--}}
{{--                </li>--}}
                <li><a href="/reports" style="padding-right: 37px;">Отчеты<i class="fa fa-angle-down"></i></a>
                <li><a href="#" style="padding-right: 37px;">Настройка параметров ОЖД<i class="fa fa-angle-down"></i></a>
                    <ul class="submenu_ul">
                        <div>
                            <li class="submenu_li"><a href="/signal_settings" class="submenu_a level1">Редактирование</a></li>
                        </div>
                        <div>
                            <li class="submenu_li"><a href="/signal_create" class="submenu_a level1">Добавление</a></li>
                        </div>
                    </ul>
                </li>
                </li>

            </ul>
        <h3 style="margin-top: 7px; float: right">Оперативный журнал диспетчера</h3>
    </div>
</div>

<style>

    .header_menu li ul {
        visibility: hidden;
        opacity: 0;
        min-width: 5rem;
        position: absolute;
        padding-top: 1rem;
        left: 0;
        display: none;
        background:#0079c2;
        padding-left: 0px;
        border-radius: 5px;
    }

    .header_menu li ul li a{
        margin-bottom: 10px;
        margin-top: 10px;
        width: 200px;
    }

    .header_menu li:hover > ul,
    .header_menu li ul:hover {
        visibility: visible;
        opacity: 1;
        display: block;
    }

    .header_menu li ul li {
        clear: both;
        width: 100%;
        border-bottom: 1px solid rgba(255,255,255,.3);
    }

    .header_menu li  {
        display: block;
        float: left;
        position: relative;
        text-decoration: none;
        transition-duration: 0.5s;
    }

    .header_menu li li:hover ul {
        display:block; /* shows sub-sublist on hover */
        margin-left:200px; /* this should be the same width as the parent list item */
        margin-top:-35px; /* aligns top of sub menu with top of list item */
    }

</style>

<script>


    $('#xml_sut').click(function(){
        $.ajax({
            url:'/create_xml/24',
            type:'GET',
            success:(res)=>{
                alert(res)
            }
        })
    })
    $('#xml_hour').click(function(){
        $.ajax({
            url:'/create_xml/1',
            type:'GET',
            success:(res)=>{
                alert(res)
            }
        })
    })
    $('#xml_mins').click(function(){
        $.ajax({
            url:'/create_xml/5',
            type:'GET',
            success:(res)=>{
                alert(res)
            }
        })
    })





    $(document).ready(function(){
        $('.level2').hide()

        $('.level1').mouseenter(function(event){
            $(event.currentTarget.parentNode).next().show()
        });

        $('.level1').parent().mouseleave(function(event){
            if ($(event.currentTarget).next().is(':hover') === false){
                $(event.currentTarget).next().hide()
            }
        })
    })


    function Show_child_first() {
        var first_list = document.querySelectorAll("#first_list");
        if (first_list[0].style.display == ""){
            for(var i = 0; i < first_list.length; i++){
                first_list[i].style.display = "none";
                var icon = document.getElementById('icon_first');
                icon.querySelector('b').textContent = "+";
            }
        } else {
            for(var i = 0; i < first_list.length; i++){
                first_list[i].style.background = 'rgb(58,146,229)';
                first_list[i].style.display = "";
                var icon = document.getElementById('icon_first');
                icon.querySelector('b').textContent = "-";
                Close_child(1);
            }
        }
    }

    function Show_child_second() {
        var second_list = document.querySelectorAll("#second_list");
        if (second_list[0].style.display == ""){
            for(var i = 0; i < second_list.length; i++){
                second_list[i].style.display = "none";
                var icon = document.getElementById('icon_second');
                icon.querySelector('b').textContent = "+";
            }
        } else {
            for (var i = 0; i < second_list.length; i++) {
                second_list[i].style.background = 'rgb(58,146,229)';
                second_list[i].style.display = "";
                var icon = document.getElementById('icon_second');
                icon.querySelector('b').textContent = "-";
                Close_child();
            }
        }
    }

    function Close_child(a) {
        if(a){
            var icon = document.getElementById('icon_second');
            icon.querySelector('b').textContent = "+";
            var list = document.querySelectorAll("#second_list");
        } else {
            var icon = document.getElementById('icon_first');
            icon.querySelector('b').textContent = "+";
            var list = document.querySelectorAll("#first_list");

        }
        for(var i = 0; i < list.length; i++){
            list[i].style.display = "none";
        }
    }

</script>

