<?php
/*
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
 * @author Oleg Demidov 
 *
 */

/**
 * Экшен обработки ajax запросов
 * Ответ отдает в JSON фомате
 *
 * @package actions
 * @since 1.0
 */
class PluginQuestions_ActionQuestions extends ActionPlugin
{
    /**
     * Инициализация
     */
    public function Init()
    {
        
        
    }

    /**
     * Регистрация евентов
     */
    protected function RegisterEvent()
    {        
        
        $this->RegisterEventExternal('Answer', 'PluginQuestions_ActionQuestions_EventAnswer');
        $this->AddEventPreg('/^(add|edit)-answer-ajax$/i', 'Answer::EventEditAjax');
        $this->AddEventPreg('/^ajax-answer-best/i', 'Answer::EventAjaxBest');
        
        $this->RegisterEventExternal('Question', 'PluginQuestions_ActionQuestions_EventQuestion');
        $this->AddEventPreg('/^(add|edit)-question$/i', '/^([1-9]\d{0,10})?$/i', ['Question::EventEdit', 'edit_question']);
        $this->AddEventPreg('/^(add|edit)-question-ajax$/i', 'Question::EventEditAjax');
        $this->AddEventPreg('/^([\w\-\_]+)\.html$/i', ['Question::EventView', 'question']);
        $this->AddEventPreg('/^[\w\-\_]+\$/i', ['Question::EventView', 'question']);
        $this->AddEventPreg(
            '/^(page(\d))?([\w\-\_]+)?$/i',
            '/^(page(\d))?([\w\-\_]+)?$/i',
            '/^(page(\d))?([\w\-\_]+)?$/i', 
            ['Question::EventList', 'list']
        );
        
        
    }

    
    
}