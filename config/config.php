<?php
/**
 * Таблица БД
 */

$config['$root$']['db']['table']['questions_talk_question'] = '___db.table.prefix___question';
$config['$root$']['db']['table']['questions_talk_answer'] = '___db.table.prefix___answer';
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

$config['$root$']['block']['questions'] = array(
    'action' => array(
         'questions' => [
             '{list}'
         ]
    ),
    'blocks' => array(
        'left' => array(
            'component@questions:questions.block-actions' => array(
                'priority' => 99,
                'params' => array(
                )
            )
        ),
        'clear'  => false,
    )
);

return $config;