<?php

class PluginQuestions_ModuleTalk extends ModuleORM
{
    /**
     * Инициализация
     *
     */
    
    protected $aBehaviors = array(
        // Категории
        'category' => array(
            'class'       => 'ModuleCategory_BehaviorModule',
            'target_type' => 'questions',
        ),
        'like' => [
            'class'     => 'PluginLike_ModuleLike_BehaviorModule',
            'target_type'   => 'question'
        ],
        'moderation' => 'PluginModeration_ModuleModeration_BehaviorModule',
        'media' => [
            'PluginMedia_ModuleMedia_BehaviorModule',
            'target_type' => 'media'
        ]
    );

    public function Init()
    {
        parent::Init();
    }
    
    public function CallbackEventAnswer($aUserIds, $aParams) {
        
        $aUsers = $this->User_GetUserItemsByFilter(['id in' => $aUserIds]);
        if(!$aUsers){
            return;
        }
        
        foreach ($aUsers as $oUser) {
            /*
             * Оповещение
             */
            $this->Notify_Send(
                $oUser,
                'add_answer.tpl',
                $this->Lang_Get('plugin.questions.emails.add_answer.subject'),
                [
                    'oAnswer' => $aParams['oAnswer'],
                    'oQuestion' => $aParams['oAnswer']->getQuestion(['#with_moderation' => 1])
                ], 
                'questions', 
                true
            );
        }
        
    }
    
    public function CallbackAddAnswer($aUserIds, $aParams) {
        
        $aUsers = $this->User_GetUserItemsByFilter(['id in' => $aUserIds]);
        if(!$aUsers){
            return;
        }
        
        foreach ($aUsers as $oUser) {
            /*
             * Оповещение
             */
            $this->Notify_Send(
                $oUser,
                'add_answer.tpl',
                $this->Lang_Get('plugin.questions.emails.add_answer.subject'),
                [
                    'oAnswer' => $aParams['oAnswer'],
                    'oQuestion' => $aParams['oAnswer']->getQuestion(['#with_moderation' => 1])
                ], 
                'questions', 
                true
            );
        }
        
    }
}