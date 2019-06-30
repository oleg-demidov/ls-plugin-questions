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

    protected $aDependences = [
        'like',
        'subscribe'
    ];


    public function Init()
    {
        $this->Component_Add('questions:answer');
        $this->Viewer_AppendScript(Plugin::GetTemplatePath('questions'). '/assets/js/init.js');
        
    }

    public function Activate()
    {
        $this->Category_CreateTargetType('questions', 'Вопросы', array(), true);

        if( !$this->CheckDependences() ){
            return false;
        }
        
        $this->PluginLike_Like_CreateTarget(
            'PluginQuestions_ModuleTalk_EntityQuestion',
            'Вопросы'
        );
        
        $this->PluginLike_Like_CreateTarget(
            'PluginQuestions_ModuleTalk_EntityAnswer',
            'Ответы'
        );
        
        $this->PluginSubscribe_Subscribe_CreateEvent(
            'add_answer',
            'Ответ',
            'PluginQuestions_Talk_CallbackEventAnswer'
        );
        
        return true;
    }
    
    private function CheckDependences() {
        $aPlugins = array_keys(Engine::getInstance()->GetPlugins());
        
        foreach ($this->aDependences as $sDepend) {
            if( in_array($sDepend, $aPlugins) ){
                $this->Message_AddError('Need Dependences plugin: '. strtoupper($sDepend));
                return false;
            }
        }
        
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