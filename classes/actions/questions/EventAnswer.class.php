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
            if($oAnswer->_isNew() and $oAnswer->getQuestion()->isClosed()){
            $this->Message_AddError($this->Lang_Get('plugin.questions.answer.error_question_closed'));
            return;
        }
            
            if($oAnswer->Save()){
                
                $this->Viewer_AssignAjax('sUrlRedirect', $oAnswer->getQuestion()->getUrl());
                
                if(!$oAnswer->moderation->isModerated()){
                    $this->Message_AddNotice($this->Lang_Get('common.success.save'));
                }else{
                    $this->Message_AddNotice($this->Lang_Get('common.success.save'));
                }
            }else{
                $this->Message_AddError($this->Lang_Get('common.error.error'));
            }
        }else{
            foreach ($oAnswer->_getValidateErrors() as $aError) {
                $this->Message_AddError(array_shift($aError));
            }
        }
    }
    
    public function EventAjaxBest() {
        $this->Viewer_SetResponseAjax('json');
        if(!$oAnswer = $this->PluginQuestions_Talk_GetAnswerById( getRequest('id'))){
            $this->Message_AddError($this->Lang_Get('plugin.questions.answer.notice.error_not_found'));
            return;
        }
        
        $oQuestion = $oAnswer->getQuestion();
        
        if(!getRequest('state')){
            $oAnswer->setBest();
            
            $oQuestion->setState(PluginQuestions_ModuleTalk_EntityQuestion::STATE_CLOSE);
            $oQuestion->Save();
            
            $aAnswers = $oQuestion->getAnswers(['state' => PluginQuestions_ModuleTalk_EntityAnswer::STATE_BEST]);
            foreach ($aAnswers as $oAns){
                $oAns->setState(0);
                $oAns->Save();
            }
            $this->Message_AddNotice($this->Lang_Get('plugin.questions.answer.notice.select_best_answer'));
        }else{
            $oAnswer->setState(0);
            
            $oQuestion->setState(PluginQuestions_ModuleTalk_EntityQuestion::STATE_OPEN);
            $oQuestion->Save();
            
            $this->Message_AddNotice($this->Lang_Get('plugin.questions.answer.notice.delete_best_answer'));
        }
        
        $oAnswer->Save();
        
        $this->Viewer_AssignAjax('state', $oAnswer->isBest());
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
