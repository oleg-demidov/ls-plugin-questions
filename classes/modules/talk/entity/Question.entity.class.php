<?php


/**
 * Description of EntityVote
 *
 * @author oleg
 */
class PluginQuestions_ModuleTalk_EntityQuestion extends EntityORM{
    
    protected $aValidateRules = [];
    

    public function __construct($aParam = false)
    {
        parent::__construct($aParam);
        
        
        $this->aValidateRules[] =   array(
            'user_id', 
            'exist_user',
            'on' => [ 'create']
        );
        
        $this->aValidateRules[] =    array(
            'title', 
            'string', 
            'max' => 200, 
            'min' => 10, 
            'allowEmpty' => false,
            'msg' => $this->Lang_Get('plugin.questions.edit_question.form.title.error_validate', ['min' => 10, 'max' => 200]),
            'on' => [ 'create']
        );
        
        $this->aValidateRules[] =    array(
            'title', 
            'title', 
            'on' => [ 'create']
        );
        
        $this->aValidateRules[] =    array(
            'text', 
            'string', 
            'max' => 2000, 
            'min' => 10, 
            'allowEmpty' => false,
            'msg' => $this->Lang_Get('plugin.questions.edit_question.form.text.error_validate', ['min' => 10, 'max' => 2000]),
            'on' => [ 'create']
        );
        $this->aValidateRules[] =    array(
            'text', 
            'double_text',
            'on' => ['create'],
        );
        
        $this->aValidateRules[] = [   
            'photos_count', 
            'number',
            'max' => 1,
            'on' => array( 'create')
        ];
        
        
    }
    
    
    protected $aRelations = array(
        'author' => array(self::RELATION_TYPE_BELONGS_TO, 'ModuleUser_EntityUser', 'user_id'),
        'answers' => array(self::RELATION_TYPE_HAS_MANY, 'PluginQuestions_ModuleTalk_EntityAnswer', 'question_id')
    );
    
    public function ValidateDoubleText($sValue) {
        $sParseText = $this->Text_Parser($sValue);
        
        if($this->PluginQuestions_Talk_GetQuestionByFilter([
            'text'  => $sParseText,
            'user_id' => $this->getUserId()
        ])){
            return $this->Lang_Get('talk.'.$this->getType().'.notice.error_double_text');
        }
        $this->setText( $sParseText );
        
        return true;
    }
    
    public function ValidateTitle($sValue) {
        $sUrl = $this->Text_Transliteration($sValue);
        
        $oQuestion = $this->PluginQuestions_Talk_GetQuestionByFilter([
            '#where' => ['t.id = ?d OR t.url = ?' => [$this->sCurrentEvent, $this->sCurrentEvent]]
        ]);
        
        if($oQuestion){
            return "double url";
        }
        
        $this->setUrl($sUrl);
        
        return true;
    }
    
    public function ValidateExistUser($sValue) {
        if(!$this->User_GetUserById($sValue)){
            return $this->Lang_Get('common.error.error').' user not found';
        }
        return true;
    }
    
    public function getUrl() {
        if(!parent::getUrl()){
            return Router::GetPath('questions/'.$this->getId());
        }
        return Router::GetPath('questions/'.parent::getUrl());
    }


    public function getDateCreateFormat() {
        $date = new DateTime($this->getDateCreate());
        return $date->format('d.m.y');
    }
    
    public function getMedia() {
        if(is_array(parent::getMedia()) and count(parent::getMedia())){
            return parent::getMedia();
        }
        
        return $this->Media_GetMediaByTarget($this->getType(), $this->getId());
    }
    
    public function isPublish() {
        return in_array($this->getState(), [
            'publish',
        ]);
    }
    
    public function afterDelete() {
        /*
         * Удалить потомков
         */
        
        
        /*
         * Удалить медиа
         */        
        $this->Media_RemoveTargetByTypeAndId('question', $this->getId());
       
    }
    
    
}
