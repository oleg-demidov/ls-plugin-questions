<?php

/**
 * Description of ActionProfile_EventSettings
 *
 * @author oleg
 */
class PluginQuestions_ActionQuestions_EventQuestion extends Event {
    
    public $oUserCurrent;


    public function Init() {
        $this->oUserCurrent = $this->User_GetUserCurrent();
    }
    
    /**
     * Проверка корректности профиля
     */
    protected function CheckUserAccess()
    {
        /**
         * Проверяем есть ли такой юзер
         */
        if (!$this->oUserCurrent = $this->User_GetUserCurrent()) {
            return false;
        }        
        
        if($this->oUserCurrent->isAdministrator()){
            return true;
        } 
                
        if(! $this->Rbac_IsAllow('moderation')){
            return false;
        }
        
        return true;
    }
    
    public function EventEdit() {
        if(!$oQuestion = $this->PluginQuestions_Talk_GetQuestionById($this->GetParam(0))){
            $oQuestion = Engine::GetEntity('PluginQuestions_Talk_Question');
        }

        $this->Viewer_Assign('oQuestion', $oQuestion);
        $this->SetTemplateAction('question-edit');
    }
    
    
    public function EventList()
    {
        $aQuestions = $this->PluginQuestions_Talk_GetQuestionAll();
        
        $this->Viewer_Assign('aQuestions', $aQuestions);
        $this->SetTemplateAction('question-list');
    }
    
    public function EventView() {
        $oQuestion = $this->PluginQuestions_Talk_GetQuestionByFilter([
            '#where' => ['t.id = ?d OR t.url = ?' => [$this->sCurrentEvent, $this->sCurrentEvent]]
        ]);
        
        $this->Viewer_Assign('oQuestion', $oQuestion);
        $this->SetTemplateAction('question');
    }
        
    public function EventEditAjax() {
        
        $this->Viewer_SetResponseAjax('json');
        
        if(!$oQuestion = $this->PluginQuestions_Talk_GetQuestionById( getRequest('id'))){
            $oQuestion = Engine::GetEntity('PluginQuestions_Talk_Question');
            $oQuestion->setState('moderate');
            $oQuestion->_setValidateScenario('create');
            
        }else{
            if (!($this->oUserCurrent and $this->oUserCurrent->getId() == $oQuestion->getUserId()) and !$this->CheckUserAccess()) {
                $this->Message_AddError($this->Lang_Get('common.error.error'));
                return;
            }
            
        }
        
        $oQuestion->_setDataSafe($_REQUEST);
        $oQuestion->setUserId($this->oUserCurrent->getId());
        
        if($oQuestion->_Validate()){
            if($oQuestion->Save()){
                /*
                 * На модерацию
                 */
                if($oQuestion->getState() == 'moderate'){
//                    $this->Notify_Send(
//                        $oQuestion->getUser(),
//                        'response_new.tpl',
//                        $this->Lang_Get('emails.response_new.subject'),
//                        ['oResponse' => $oQuestion], null, true
//                    );
                }
                
                if(getRequest('photos')){
                    $this->Media_AttachMedia(getRequest('photos'), 'question', $oQuestion->getId());
                }else{
                    $this->Media_RemoveTargetByTypeAndId('question', $oQuestion->getId());
                }
                
                $this->Viewer_AssignAjax('sUrlRedirect', $oQuestion->getUrl());
                
                $this->Message_AddNotice($this->Lang_Get('common.success.save'));
            }else{
                $this->Message_AddError($this->Lang_Get('common.error.error'));
            }
        }else{
            foreach ($oQuestion->_getValidateErrors() as $aError) {
                $this->Message_AddError(array_shift($aError));
            }
        }
    }
    
    
    
    public function EventDelete() {
        if(!$oMessage = $this->Talk_GetMessageById(getRequest('id'))){
            $this->Message_AddError($this->Lang_Get('common.error.error'));
            return;
        }
        
        if(!$oUserCurrent = $this->User_GetUserCurrent()){
            $this->Message_AddError($this->Lang_Get('common.error.error'));
            return;
        }
        
        if($oMessage->getUser()->getId() != $oUserCurrent->getId() and !$oUserCurrent->isAdministrator()){
            $this->Message_AddError($this->Lang_Get('common.error.error'));
            return;
        }
        
        if($oMessage->Delete()){
            $this->Message_AddNotice($this->Lang_Get('talk.answer.notice.success_remove'));
            $this->Viewer_AssignAjax('sUrlRedirect', getRequest('redirect'));
        }
        
    }   
    

}
