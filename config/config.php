<?php
/**
 * Таблица БД
 */

$config['$root$']['db']['table']['questions_talk_question'] = '___db.table.prefix___questions_question';
$config['$root$']['db']['table']['questions_talk_answer'] = '___db.table.prefix___questions_answer';
/**
 * Роутинг
 */
$config['$root$']['router']['page']['questions'] = 'PluginQuestions_ActionQuestions';

$config['question'] = [
    'per_page' => 10,
    'count_pages' => 5
];

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
            ), 
            'categories' => array(
                'priority' => 98,
                'params' => array(
                    'plugin' => 'questions'
                )
            )
        ),
        'clear'  => false,
    )
);

$config['$root$']['block']['question'] = array(
    'action' => array(
        'questions' => [
             '{question}'
        ]
    ),
    'blocks' => array(
        'left' => array(
            'categories' => array(
                'priority' => 98,
                'params' => array(
                    'plugin' => 'questions'
                )
            )
        ),
        'clear'  => false,
    )
);

return $config;