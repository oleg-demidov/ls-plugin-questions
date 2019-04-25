<?php


/**
 * Description of EntityVote
 *
 * @author oleg
 */
class PluginQuestions_ModuleTalk_EntityQuestion extends EntityORM{
    
    protected $aValidateRules = [];
    
    protected $aBehaviors = array(
        // Категории
        'category' => array(
            'class'       => 'ModuleCategory_BehaviorEntity',
            'target_type' => 'questions',
            'form_field'  => 'category',
            'validate_require'               => true,
        ),
        'like' => array(
            'class'       => 'PluginLike_ModuleLike_BehaviorEntity',
            'target_type' => 'question',
            'title_field' => 'title',
        ),
        'moderation' => [
            'class' => 'PluginModeration_ModuleModeration_BehaviorEntity',
            'moderation_fields' => [
                'title', 'url', 'text'
            ],
            'title_field' => 'title',
            'label' => 'Вопрос'
        ]
    );

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
            'on' => [ 'create', 'edit']
        );
        
        $this->aValidateRules[] =    array(
            'title', 
            'title', 
            'on' => [ 'create', 'edit']
        );
        
        $this->aValidateRules[] =    array(
            'text', 
            'string', 
            'max' => 2000, 
            'min' => 10, 
            'allowEmpty' => false,
            'msg' => $this->Lang_Get('plugin.questions.edit_question.form.text.error_validate', ['min' => 10, 'max' => 2000]),
            'on' => [ 'create', 'edit']
        );
        $this->aValidateRules[] =    array(
            'text', 
            'double_text',
            'on' => ['create'],
        );
        
        
        
    }
    
    
    protected $aRelations = array(
        'author' => array(self::RELATION_TYPE_BELONGS_TO, 'ModuleUser_EntityUser', 'user_id'),
        'answers' => array(self::RELATION_TYPE_HAS_MANY, 'PluginQuestions_ModuleTalk_EntityAnswer', 'question_id')
    );
    
    public function ValidateDoubleText($sValue) {
        $sParseText = $this->Text_Parser($sValue);
        
        if($this->_isNew() and $this->PluginQuestions_Talk_GetQuestionByFilter([
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
        
        if($this->_isNew()){
            if($oQuestion = $this->PluginQuestions_Talk_GetQuestionByTitle($sValue)){
                 return "double title";
            }
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
            return Router::GetPathRootWeb() .'/questions/'.$this->getId().'.html';
        }
        return Router::GetPathRootWeb() .'/questions/'.parent::getUrl().'.html';
    }

    public function getCountAnswers() {
        return count($this->getAnswers());
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
