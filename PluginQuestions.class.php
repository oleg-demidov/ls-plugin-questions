<?php
/**
 * 
 * @author Oleg Demidov
 *
 */

/**
 * Запрещаем напрямую через браузер обращение к этому файлу.
 */
if (!class_exists('Plugin')) {
    die('Hacking attempt!');
}

class PluginQuestions extends Plugin
{

    
    public function Init()
    {
        $this->Component_Add('media');
        //$this->Viewer_AppendScript(Plugin::GetTemplatePath('questions'). '/assets/js/init.js');
    }

    public function Activate()
    {
        $this->Category_CreateTargetType('questions', 'Вопросы', array(), true);

        
        return true;
    }

    public function Deactivate()
    {
        
        return true;
    }
    
    public function Remove()
    {
        
        $this->Category_RemoveTargetType('questions');
        return true;
    }
}