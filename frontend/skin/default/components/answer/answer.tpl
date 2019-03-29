{**
 * Предложение
 *}
 
{component_define_params params=[ 'oAnswer']}

<div class="ml-3 d-flex flex-md-row flex-column">
        <div class="pb-3">
            <img  class="mr-3 rounded-circle" src="{$oAnswer->getAuthor()->getProfileAvatar()}" alt="{$oAnswer->getAuthor()->getLogin()}">
        </div>
        
        <div>
            <span class="text-muted">{$oAnswer->getAuthor()->getName()}</span> 

            <span class="mx-2">&bull;</span>
            <span class="text-muted font-italic">{$oAnswer->getDateCreateFormat()}</span>



            {if $oUserCurrent and $oUserCurrent->getId() == $oAnswer->getAuthor()->getId() or $oUserCurrent->isAdministrator()}
                <span class="mx-2">&bull;</span>
                {component "bs-button" 
                    com     = "link"
                    url     = {router page="questions/edit-question/{$oAnswer->getId()}"}
                    text    = {component "bs-icon" icon="edit"}
                    popover = [content => $aLang.common.edit] }

            {/if}
            <br>
            <div class="py-3">
                {$oAnswer->getText()}
            </div>
            <div class="mt-3">
                {component "bs-button" 
                    bmods = "outline-success"
                    icon = [icon => "thumbs-up", display => 'r', classes => 'mr-1']
                    text = $aLang.plugin.questions.question.actions.like}
                    
                {component "bs-button" 
                    bmods = "outline-primary"
                    text = $aLang.plugin.questions.question.actions.subscribe}
                
                {component "bs-button" 
                    popover = $aLang.plugin.questions.question.actions.complain
                    bmods = "outline-danger"
                    icon = "ban"}
            </div>
        </div>
    </div>