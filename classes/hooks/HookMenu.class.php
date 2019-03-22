<?php


class PluginQuestions_HookMenu extends Hook{
    public function RegisterHook()
    {
        $this->AddHook('engine_init_complete', 'NavMain');        
    }

    /**
     * Добавляем в главное меню 
     */
    public function NavMain($aParams)
    {
        $aWiki = $this->PluginWiki_Wiki_GetWikiItemsAll();
        
        $oMenu = $this->Menu_Get('main');
        
        $oMenu->appendChild(Engine::GetEntity("ModuleMenu_EntityItem", [
            'name' => 'questions',
            'title' => "plugin.questions.menu_item.title",
            'url' => 'questions'
        ]));
        
    }

}
