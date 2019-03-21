<?php
/**
 * Таблица БД
 */

//$config['$root$']['db']['table']['test_test_result'] = '___db.table.prefix___test_result';
/**
 * Роутинг
 */
$config['$root$']['router']['page']['questions'] = 'PluginQuestions_ActionQuestions';



$config['admin']['assets'] = [
    'js' => [
        //'assets/js/admin.js'
    ],
    'css' => [
//        'assets/css/admin.css'
    ]
]; 
$config['admin']['components'] = [
//    'wiki:editor'
]; 

//$config['assets']['js'][]  = 'assets/js/init.js'; 


return $config;