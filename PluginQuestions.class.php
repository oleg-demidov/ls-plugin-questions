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
        $this->Component_Add('questions:answer');
        $this->Viewer_AppendScript(Plugin::GetTemplatePath('questions'). '/assets/js/init.js');

    }

    public function Activate()
    {
        $this->Category_CreateTargetType('questions', 'Вопросы', array(), true);

        if( in_array('like', array_keys(Engine::getInstance()->GetPlugins())) ){
            $this->Message_AddError('Need depenccies PluginLike');
            return false;
        }
        
        $this->PluginLike_Like_CreateTarget(
            'question',
            'Вопросы'
        );
        
        $this->PluginLike_Like_CreateTarget(
            'answer',
            'Ответы'
        );
        
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