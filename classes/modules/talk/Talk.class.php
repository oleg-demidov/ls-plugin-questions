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
        )
    );

    public function Init()
    {
        parent::Init();
    }
    
}