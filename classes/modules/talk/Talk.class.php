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
        'moderation' => 'PluginModeration_ModuleModeration_BehaviorModule'
    );

    public function Init()
    {
        parent::Init();
    }
    
    public function SubscribeEventAnswer($aUserIds, $aParams) {
        $this->Logger_Notice("SubscribeEventAnswer " . print_r($aParams, true). print_r($aUserIds, true));
    }
}