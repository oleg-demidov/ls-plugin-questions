<?php


/**
 * Description of EntityVote
 *
 * @author oleg
 */
class PluginQuestions_ModuleTalk_EntityAnswer extends EntityORM{
    
    protected $aValidateRules = [];
   
    protected $aBehaviors = array(
        
        'like' => array(
            'class'       => 'PluginLike_ModuleLike_BehaviorEntity',
            'target_type' => 'answer'
        ),
        'moderation' => [
            'class' => 'PluginModeration_ModuleModeration_BehaviorEntity',
            'moderation_fields' => [
                'text'
            ]
        ]
    );

    public function __construct($aParam = false)
    {
        parent::__construct($aParam);
        
        
        $this->aValidateRules[] =   array(
            'user_id', 
            'exist_user',
            'on' => [ 'edit', 'create']
        );
        $this->aValidateRules[] = array(
            'question_id', 
            'exist_question',
            'on' => [ 'edit', 'create']            
        );
        $this->aValidateRules[] =    array(
            'text', 
            'string', 
            'max' => 200, 
            'min' => 10, 
            'allowEmpty' => false,
            'msg' => $this->Lang_Get('talk.response.form.text.error_validate', ['min' => 10, 'max' => 200]),
            'on' => [ 'edit', 'create']
        );
        $this->aValidateRules[] =    array(
            'text', 
            'double_text',
            'on' => [ 'edit', 'create']
        );
        
        
    }
    
    
    protected $aRelations = array(
        'author' => array(self::RELATION_TYPE_BELONGS_TO, 'ModuleUser_EntityUser', 'user_id'),
        'question' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginQuestions_ModuleTalk_EntityQuestion', 'question_id')
    );
    
    public function ValidateDoubleText($sValue) {
        $sParseText = $this->Text_Parser($sValue);
        
        if( $this->PluginQuestions_Talk_GetAnswerByFilter([
            '#where' => ['t.id != ?' => [($this->getId() !== null)?$this->getId():0] ],
            'text'  => $sParseText,
            'user_id' => $this->getUserId(),
            'question_id' => $this->getQuestionId()
        ])){
            return $this->Lang_Get('plugin.questions.answer.notice.error_double_text');
        }
        
        return true;
    }
    
    public function ValidateExistUser($sValue) {
        if((int)$sValue === 0 ){
            return true;
        }
        if(!$this->User_GetUserById($sValue)){
            return $this->Lang_Get('common.error.error').' user not found';
        }
        return true;
    }
    
    public function ValidateExistQuestion($sValue) {
        if(!$this->PluginQuestions_Talk_GetQuestionById($sValue) ){
            return $this->Lang_Get('common.error.error').' Question not found';
        }
       
        return true;
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
        $this->Media_RemoveTargetByTypeAndId('answer', $this->getId());
       
    }
    
    
}
