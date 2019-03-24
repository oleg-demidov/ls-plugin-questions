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
class PluginQuestions_ActionAjax extends ActionPlugin
{
    /**
     * Инициализация
     */
    public function Init()
    {
        /**
         * Устанавливаем формат ответа
         */
        if (getRequest('is_iframe')) {
            $this->Viewer_SetResponseAjax('jsonIframe', false);
        } else {
            $this->Viewer_SetResponseAjax('json');
        }
        
    }

    /**
     * Регистрация евентов
     */
    protected function RegisterEvent()
    {
        
        
        
//        $this->RegisterEventExternal('Talk', 'PluginQuestions_ActionAjax_EventTalk');
//        $this->AddEventPreg('/^talk$/i', '/^edit-response$/', '/^$/', 'Talk::EventAjaxResponseEdit');
//        $this->AddEventPreg('/^talk$/i', '/^create-proposal$/', '/^$/', 'Talk::EventAjaxProposalCreate');
//        $this->AddEventPreg('/^talk$/i', '/^create-answer$/', '/^$/', 'Talk::EventAjaxAnswerCreate');
//        $this->AddEventPreg('/^talk$/i', '/^create-arbitrage$/', '/^$/', 'Talk::EventAjaxArbitrageCreate');
//        $this->AddEventPreg('/^talk$/i', '/^message-delete$/', '/^$/', 'Talk::EventAjaxMessageDelete');
//        $this->AddEventPreg('/^talk$/i', '/^create-arbitrage-chat$/', '/^$/', 'Talk::EventAjaxArbitrageChat');
//        
        $this->RegisterEventExternal('Question', 'PluginQuestions_ActionAjax_EventQuestion');
        $this->AddEventPreg('/^(add|edit)\-question$/i', 'Question::EventEdit');
        
    }


    
}