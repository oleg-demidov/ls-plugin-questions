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
        ]
    );

    public function Init()
    {
        parent::Init();
    }
    
}