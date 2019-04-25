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
        $aFilter = [];
        $aGetParamsList = [];
        
        if(getRequest('order')){
            $aGetParamsList['order'] = getRequest('order');
        }
                
        if(getRequest('q')){
            $aGetParamsList['q'] = getRequest('q');
        }
        
        $aFilter['#order'] = [getRequest('order', '#count_like') => 'desc'];
        
        $aCategoryUrl = [];
        
        $iPage = $this->GetPage($aCategoryUrl);
        
        $oCategory = $this->Category_GetCategoryByUrlFull( join('/', $aCategoryUrl) );
        
        $iCount = 0;
        
        if($oCategory){
            $aQuestionIds = $this->Category_GetTargetIdsByCategoriesId(
                [$oCategory->getId()], 
                'questions', 
                $iPage, 
                Config::Get('plugin.questions.question.per_page')
            );
            $iCount = $this->Category_GetCountFromTargetByFilter([
                'category_id'    => $oCategory->getId(),
                'target_type'    => 'questions']);
            
            $aFilter['id in'] = array_merge([0],$aQuestionIds);
            
        }else{
            $aFilter['#page'] = [$iPage, Config::Get('plugin.questions.question.per_page')];
        }
        
        if(getRequest('q')){
            $aFilter['#where'] = [
                '(t.text LIKE ? OR t.title LIKE ?)' => [
                    '%'.getRequest('q').'%',
                    '%'.getRequest('q').'%'                    
                ]
            ];
        }

        $aQuestions = $this->PluginQuestions_Talk_GetQuestionItemsByFilter($aFilter); 
        
        if(!$oCategory){
            $iCount = $aQuestions['count'];
            $aQuestions = $aQuestions['collection'];
        } 
        
        $aPaging = $this->Viewer_MakePaging(
            $iCount, 
            $iPage, 
            Config::Get('plugin.questions.question.per_page'), 
            Config::Get('plugin.questions.question.count_pages'), 
            Router::GetPath($this->sCurrentAction. '/' .join('/', $aCategoryUrl)),
            $aGetParamsList
        );
                
        $this->Viewer_Assign('aQuestions', $aQuestions);
        $this->Viewer_Assign('aPaging', $aPaging);
        $this->SetTemplateAction('question-list');
    }
    
    protected function GetPage( &$aUrlWithoutPage ) {
        if($iPage = $this->GetEventMatch(2)){
            return $iPage;
        }
        $aUrlWithoutPage[] = $this->sCurrentEvent;
        
        if($iPage = $this->GetParamEventMatch(0, 2)){
            return $iPage;
        }
        if($this->GetParam(0)){
            $aUrlWithoutPage[] = $this->GetParam(0);
        }
        
        if($iPage = $this->GetParamEventMatch(1, 2)){
            return $iPage;
        }
        if($this->GetParam(1)){
            $aUrlWithoutPage[] = $this->GetParam(1);
        }
        return 1;
    }
    
    public function EventView() {
        $this->SetTemplateAction('question');
        
        $oQuestion = $this->PluginQuestions_Talk_GetQuestionByFilter([
            '#where' => ['t.id = ?d OR t.url = ?' => [$this->GetEventMatch(1), $this->GetEventMatch(1)]]
        ]);
        
//        if(!$oQuestion->moderation->isModerated()){
//            $this->SetTemplateAction('question-moderation');
//            $this->Viewer_ClearBlocksAll();
//        }
        
        $this->Viewer_Assign('oQuestion', $oQuestion);
        $this->Viewer_Assign('oAnswerEntity', Engine::GetEntity('PluginQuestions_Talk_Answer'));
        
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
            $oQuestion->_setValidateScenario('edit');
        }
        
        $oQuestion->_setDataSafe($_REQUEST);
        $oQuestion->setUserId($this->oUserCurrent->getId());
        $oQuestion->setText($this->Text_Parser($oQuestion->getText()));
        $oQuestion->setCategory(getRequest('category'));
        
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
