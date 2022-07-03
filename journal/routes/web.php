<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use Illuminate\Support\Facades\Auth;


    //Главная
    Route::get('/', [Controllers\MenuController::class, 'index_hour'])->name('gazprom');
    Route::get('/sut', [Controllers\MenuController::class, 'index_sut']);
    Route::get('/minutes', [Controllers\MenuController::class, 'index_minut']);

    //По-новому минутные параметры
    Route::get('/minutes_param/{date}/{hour}', [Controllers\MinutesController::class, 'get_minute_param']);

    //По-новому часовые параметры
    Route::get('/hours_param/{date}', [Controllers\HoursController::class, 'get_hour_param']);

    //По-новому суточные параметры
    Route::get('/sut_param/{month}', [Controllers\SutController::class, 'get_sut_param']);

    //Для добавления в крон
    Route::get('/create_param/{params_type}', [Controllers\TestController::class, 'test']);     //создание тестовых данных
    Route::get('/create_record_rezhim_dks', [Controllers\TestController::class, 'create_record_rezhim_dks']);     //запись для отчета р\4 часа
    Route::get('/create_xml/{hours_xml}', [Controllers\XMLController::class, 'create_xml'])->name('create_xml');

    //Изменение test_table
    Route::get('/signal_settings', [Controllers\TestTableController::class, 'settings']);
    Route::post('/signal_settings_store', [Controllers\TestTableController::class, 'signal_settings_store'])->name('signal_settings_store');

    Route::get('/signal_create', [Controllers\TestTableController::class, 'create']);
    Route::post('/store_object', [Controllers\TestTableController::class, 'store_object']);
    Route::post('/store_signal', [Controllers\TestTableController::class, 'store_signal']);



//Получить дерево side_menu
    Route::get('/getsidetree', [Controllers\SidetreeController::class, 'getSideTree']);
    Route::get('/get_parent/{parentId}', [Controllers\TestController::class, 'get_parent']);   //для дерева

    //Изменить временные показатели
    Route::post('/changetimeparams/{type}', [Controllers\SidetreeController::class, 'change_time_params']);
    Route::post('/createtimeparams', [Controllers\SidetreeController::class, 'create_time_params']);
    Route::post('/changeminsparams', [Controllers\SidetreeController::class, 'change_mins_params']);
    Route::post('/createminsparams', [Controllers\SidetreeController::class, 'create_mins_params']);

    //Журнал XML
    Route::get('/get_journal_xml_data', [Controllers\XMLController::class, 'get_journal_xml_data'])->name('get_journal_xml_data');
    Route::get('/journal_xml', [Controllers\XMLController::class, 'journal_xml'])->name('journal_xml');

    //Отчеты
    Route::get('/reports', [Controllers\BalansController::class, 'reports'])->name('reports');
        //ДКС
            //Изменение режимов работы ГПА на ДКС
    Route::get('/gpa_rezhim', [Controllers\BalansController::class, 'gpa_rezhim'])->name('gpa_rezhim');
    Route::get('/get_gpa_rezhim', [Controllers\BalansController::class, 'get_gpa_rezhim'])->name('get_gpa_rezhim');
    Route::post('/post_gpa_rezhim', [Controllers\BalansController::class, 'post_gpa_rezhim'])->name('post_gpa_rezhim');
            //Отчет режимы работы турбоагрегатов
    Route::get('/get_gpa_rezhim_report/{dks}', [Controllers\BalansController::class, 'get_gpa_rezhim_report'])->name('get_gpa_rezhim_report');
    Route::get('/get_gpa_rezhim_report_data/{date}/{dks}', [Controllers\BalansController::class, 'get_gpa_rezhim_report_data'])->name('get_gpa_rezhim_report_data');
    Route::get('/print_gpa_rezhim_report/{date}/{dks}', [Controllers\BalansController::class, 'print_gpa_rezhim_report'])->name('print_gpa_rezhim_report');
        //Сводный отчет ННГДУ
    Route::get('/open_svodniy', [Controllers\BalansController::class, 'open_svodniy'])->name('open_svodniy');
    Route::get('/get_svodniy/{date}', [Controllers\BalansController::class, 'get_svodniy'])->name('get_svodniy');
    Route::get('/print_svodniy/{date}', [Controllers\BalansController::class, 'print_svodniy'])->name('print_svodniy');
        //Валовая добыча
    Route::get('/open_val', [Controllers\BalansController::class, 'open_val'])->name('open_val');
    Route::get('/get_val/{date}', [Controllers\BalansController::class, 'get_val'])->name('get_val');
    Route::get('/print_val/{date}', [Controllers\BalansController::class, 'print_val'])->name('print_val');
    Route::get('/save_plan_month/{date}/{value}', [Controllers\BalansController::class, 'save_plan_month'])->name('save_plan_month');
        //Балансовый
    Route::get('/open_balans', [Controllers\BalansController::class, 'open_balans'])->name('open_balans');
    Route::get('/get_balans/{date}', [Controllers\BalansController::class, 'get_balans'])->name('get_balans');
    Route::get('/print_balans/{date}', [Controllers\BalansController::class, 'print_balans'])->name('print_balans');


    //ГЛАВНАЯ ТАБЛИЦА
    Route::post('/add-index', [Controllers\MainTableController::class, 'add_index']);
    Route::get('/maintable', [Controllers\MainTableController::class, 'index']);
    Route::get('/getmaintable', [Controllers\MainTableController::class, 'getMainTableInfo']);
    Route::post('/changetable', [Controllers\MainTableController::class, 'changeMainTable']);
    Route::post('/delete-from-main-table', [Controllers\MainTableController::class, 'delete_row']);
    Route::get('/getfieldsnames', [Controllers\MainTableController::class, 'getFieldsName']);





