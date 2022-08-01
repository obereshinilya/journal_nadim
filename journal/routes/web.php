<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

    //Главная
    Route::get('/', [Controllers\MenuController::class, 'index_hour'])->name('gazprom');
    Route::get('/sut', [Controllers\MenuController::class, 'index_sut']);
    Route::get('/minutes', [Controllers\MenuController::class, 'index_minut']);

    //Журнал действий оператора
    Route::get('/open_user_log', [Controllers\MenuController::class, 'open_user_log']);
    Route::get('/get_user_log', [Controllers\MenuController::class, 'get_user_log']);

    //По-новому минутные параметры
    Route::get('/minutes_param/{date}/{hour}', [Controllers\MinutesController::class, 'get_minute_param']);

    //По-новому часовые параметры
    Route::get('/hours_param/{date}', [Controllers\HoursController::class, 'get_hour_param']);

    //По-новому суточные параметры
    Route::get('/sut_param/{month}', [Controllers\SutController::class, 'get_sut_param']);

    //Для добавления в крон
    Route::get('/create_param/{params_type}', [Controllers\TestController::class, 'test']);     //создание тестовых данных
    Route::get('/create_record_rezhim_dks', [Controllers\TestController::class, 'create_record_rezhim_dks']);     //запись для отчета р\4 часа
    Route::get('/create_xml/{hours_xml}', [Controllers\XMLController::class, 'create_xml'])->name('create_xml'); //отправка xml
    Route::get('/create_record_svodniy', [Controllers\BalansController::class, 'create_record_svodniy'])->name('create_record_svodniy'); //Создание строк в сводном отчете каждый час в конце часа
    Route::get('/create_record_valoviy', [Controllers\BalansController::class, 'create_record_valoviy'])->name('create_record_valoviy'); //Создание строк в валовом отчете каждый час в конце часа
    Route::get('/update_guid', [Controllers\TestController::class, 'update_guid']);        ///Обновление GUID



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
    Route::get('/open_svodniy', [Controllers\BalansController::class, 'open_svodniy'])->name('open_svodniy');   //Открывает главную
    Route::get('/get_svodniy/{date}', [Controllers\BalansController::class, 'get_svodniy'])->name('get_svodniy');   //Получаем инфу в таблицу
    Route::get('/print_svodniy/{date}', [Controllers\BalansController::class, 'print_svodniy'])->name('print_svodniy');  //Отправляем на печать
    Route::get('/svodniy_setting', [Controllers\BalansController::class, 'svodniy_setting'])->name('svodniy_setting');  //Переход на страницу настройки
    Route::get('/get_all_params', [Controllers\MainTableController::class, 'get_all_params'])->name('get_all_params');   //Получаем все параметры (без объектов)
    Route::get('/save_param_svodniy/{params}/{hfrpok}', [Controllers\BalansController::class, 'save_param_svodniy'])->name('save_param_svodniy');  //Сохраняем настройки
    Route::get('/get_setting_svodniy', [Controllers\BalansController::class, 'get_setting_svodniy'])->name('get_setting_svodniy');  //Для получения настроек
        //Валовая добыча
    Route::get('/open_val_year', [Controllers\BalansController::class, 'open_val'])->name('open_val');   //открытие формы
    Route::get('/get_val/{date}/{type}', [Controllers\BalansController::class, 'get_val'])->name('get_val');  //получение данных для таблиц
    Route::get('/print_val/{date}/{type}', [Controllers\BalansController::class, 'print_val'])->name('print_val'); //печать
    Route::get('/save_plan_month/{date}/{value}/{mestorozhdeniye}', [Controllers\BalansController::class, 'save_plan_month'])->name('save_plan_month');   //сохранение годового плана
    Route::get('/get_plan/{date}', [Controllers\BalansController::class, 'get_plan'])->name('get_plan'); //получение планов на год по месторождениям
    Route::get('/valoviy_setting', [Controllers\BalansController::class, 'valoviy_setting'])->name('valoviy_setting');  //Переход на страницу настройки
    Route::get('/get_setting_valoviy', [Controllers\BalansController::class, 'get_setting_valoviy'])->name('get_setting_valoviy');  //Для получения настроек
    Route::get('/save_param_valoviy/{params}/{hfrpok}', [Controllers\BalansController::class, 'save_param_valoviy'])->name('save_param_valoviy');  //Сохраняем настройки

    Route::get('/open_val_month', [Controllers\BalansController::class, 'open_val_month'])->name('open_val_month');   //открытие формы
    Route::get('/open_val_day', [Controllers\BalansController::class, 'open_val_day'])->name('open_val_day');   //открытие формы

        //Балансовый
    Route::get('/open_balans', [Controllers\BalansController::class, 'open_balans'])->name('open_balans');
    Route::get('/get_balans/{date}', [Controllers\BalansController::class, 'get_balans'])->name('get_balans');
    Route::get('/print_balans/{date}', [Controllers\BalansController::class, 'print_balans'])->name('print_balans');

/////Суточный журнал смены
    Route::get('/open_journal_smeny', [Controllers\SutJournalController::class, 'open_journal_smeny'])->name('open_journal_smeny');
    Route::post('/save_journal_smeny/{date}', [Controllers\SutJournalController::class, 'save_journal_smeny'])->name('save_journal_smeny');   //сохранение строки
    Route::get('/get_row/{date}/{id_mother}', [Controllers\SutJournalController::class, 'get_row'])->name('get_row');   //получить строку по id
    Route::post('/save_other_row/{date}', [Controllers\SutJournalController::class, 'save_other_row'])->name('save_other_row');   //сохранение остальных строк
    Route::get('/get_row_other/{date}', [Controllers\SutJournalController::class, 'get_row_other'])->name('get_row_other');   //получить строку по id
    Route::get('/print_journal_smeny/{date}', [Controllers\SutJournalController::class, 'print_journal_smeny'])->name('print_journal_smeny');
    Route::get('/remove_last_row/{id_last_row}', [Controllers\SutJournalController::class, 'remove_last_row'])->name('remove_last_row');

////ТЭР
    Route::get('/open_ter/{yams_yub}', [Controllers\TerController::class, 'open_ter'])->name('open_ter');
    Route::get('/get_ter/{date}/{type}/{yams_yub}', [Controllers\TerController::class, 'get_ter'])->name('get_ter');
    Route::post('/save_ter/{yams_yub}', [Controllers\TerController::class, 'save_ter'])->name('save_ter');
    Route::get('/print_ter/{date}/{type}/{yams_yub}', [Controllers\TerController::class, 'print_ter'])->name('print_ter');





//ГЛАВНАЯ ТАБЛИЦА
    Route::post('/add-index', [Controllers\MainTableController::class, 'add_index']);
    Route::get('/maintable', [Controllers\MainTableController::class, 'index']);
    Route::get('/getmaintable', [Controllers\MainTableController::class, 'getMainTableInfo']);
    Route::post('/changetable', [Controllers\MainTableController::class, 'changeMainTable']);
    Route::post('/delete-from-main-table', [Controllers\MainTableController::class, 'delete_row']);
    Route::get('/getfieldsnames', [Controllers\MainTableController::class, 'getFieldsName']);





