<?php
/**
 * LiveStreet CMS
 * Copyright © 2013 OOO "ЛС-СОФТ"
 *
 * ------------------------------------------------------
 *
 * Official site: www.livestreetcms.com
 * Contact e-mail: office@livestreetcms.com
 *
 * GNU General Public License, version 2:
 * http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * ------------------------------------------------------
 *
 * @link http://www.livestreetcms.com
 * @copyright 2013 OOO "ЛС-СОФТ"
 *
 */

/**
 * Русский языковой файл
 */

return array(
    'index' => [
        'title' => 'Вопросы и ответы'
    ],
    'menu_item' => [
        'title' => 'Ответы'
    ],
    'question' => [
        'search_form' => [
            'q' => [
                'placeholder' => "Введите для поиска по тексту"
            ]
        ],
        'order' => [
            'date' => 'Дате',
            'rating' => 'Рейтингу'
        ],
        'actions' => [
            'subscribe' => 'Подписаться',
            'like' => 'Нравится',
            'complain' => 'Пожаловаться'
        ],
        'answer' => "%%count%% ответ;%%count%% ответа;%%count%% ответов;",
        'respond' => 'Ответить',
        'blankslate' => [
            'text' => 'Вoпросов нет'
        ]
    ],
    
    'edit_question' => [
        'title_edit' => 'Редактировать вопрос',
        'title_add' => 'Добавить вопрос',
        'form' => [
            'categories' => [
                'label'       => 'Выберете категорию:'
            ],
            'title' => [
                'label' => 'Короткий заголовок:',
                'placeholder' => 'Вопрос по ПДД',
                'error_validate' => 'Введите текст от %%min%% до %%max%% символов'
            ],
            'text' => [
                'label' => 'Опишите свой вопрос:',
                'placeholder' => 'Текст вопроса',
                'error_validate' => 'Введите текст от %%min%% до %%max%% символов'
            ],
            'photo' => [
                'label' => 'Вставьте изображение:',
                'text' => 'Вставить'
            ]
        ]
    ],
    'answer' => [
        'blankslate' => [
            'text' => 'Ответов нет'
        ],
        'answers' => 'Ответы',
        'answered' => 'Ответить',
        'form' => [
            'text' => [
                'label' => 'Введите ответ',
                'placeholder' => ''
            ],
            'submit' => [
                'text' => 'Ответить'
            ]
        ],
        'notice' => [
            'error_question_closed' => 'Вы больше не можете оставлять ответы на этот вопрос',
            'select_best_answer' => 'Вы отметили ответ как лучший',
            'delete_best_answer' => 'Ответ убран из лучших',
            'error_double_text' => 'Ответ с таким текстом уже существует',
            'error_not_found' => 'Ответ не найден'
        ],
        'best_btn' => [
            'text' => 'Лучший ответ'
        ]
    ],
    'emails' => [
        'add_answer' => [
            'subject' => 'Новый ответ',
            'text' => 'Новый ответ на вопрос %%question%%'
        ]
    ]
);

?>
