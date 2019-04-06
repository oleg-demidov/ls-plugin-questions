<?php

/**
 * Description of ActionProfile_EventSettings
 *
 * @author oleg
 */
class PluginQuestions_ActionQuestions_EventAnswer extends Event {
    
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
     
    public function EventEditAjax() {
        
        $this->Viewer_SetResponseAjax('json');
        
        if(!$oAnswer = $this->PluginQuestions_Talk_GetAnswerById( getRequest('id'))){
            $oAnswer = Engine::GetEntity('PluginQuestions_Talk_Answer');
            $oAnswer->setState('moderate');
            $oAnswer->_setValidateScenario('create');
            
        }else{
            if (!($this->oUserCurrent and $this->oUserCurrent->getId() == $oAnswer->getUserId()) and !$this->CheckUserAccess()) {
                $this->Message_AddError($this->Lang_Get('common.error.error'));
                return;
            }
            $oAnswer->_setValidateScenario('edit');
        }
        
        $oAnswer->_setDataSafe($_REQUEST);
        $oAnswer->setUserId($this->oUserCurrent->getId());
        $oAnswer->setText($this->Text_Parser($oAnswer->getText()));
        
        if($oAnswer->_Validate()){
            if($oAnswer->Save()){
                /*
                 * На модерацию
                 */
                if($oAnswer->getState() == 'moderate'){
//                    $this->Notify_Send(
//                        $oAnswer->getUser(),
//                        'response_new.tpl',
//                        $this->Lang_Get('emails.response_new.subject'),
//                        ['oResponse' => $oAnswer], null, true
//                    );
                }

                $this->Hook_Run('add_answer', array('oAnswer' => 'kk'));
                
                if(getRequest('photos')){
                    $this->Media_AttachMedia(getRequest('photos'), 'question', $oAnswer->getId());
                }else{
                    $this->Media_RemoveTargetByTypeAndId('question', $oAnswer->getId());
                }
                
                $this->Viewer_AssignAjax('sUrlRedirect', $oAnswer->getQuestion()->getUrl());
                
                $this->Message_AddNotice($this->Lang_Get('common.success.save'));
            }else{
                $this->Message_AddError($this->Lang_Get('common.error.error'));
            }
        }else{
            foreach ($oAnswer->_getValidateErrors() as $aError) {
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
