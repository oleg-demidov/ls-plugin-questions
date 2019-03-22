<?php

/**
 * Description of 
 *
 * @author oleg
 */
class PluginQuestions_ActionQuestions_EventQuestions extends Event {
      

    public function EventList()
    {
        
        
        $this->SetTemplateAction('index');
    }

    
    public function EventEdit() {
        $this->SetTemplateAction('edit');
    }

}
