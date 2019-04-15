{**
 * Предложение
 *}
 
{component_define_params params=[ 'oAnswer']}

<div class="answer ml-3 d-flex flex-md-row flex-column" data-id="{$oAnswer->getId()}">
        <div class="pb-3">
            <img  class="mr-3 rounded-circle" src="{$oAnswer->getAuthor()->getProfileAvatar()}" alt="{$oAnswer->getAuthor()->getLogin()}">
        </div>
        
        <div>
            <span class="text-muted">{$oAnswer->getAuthor()->getName()}</span> 

            <span class="mx-2">&bull;</span>
            <span class="text-muted font-italic">{$oAnswer->getDateCreateFormat()}</span>



            {if $oUserCurrent and ($oUserCurrent->getId() == $oAnswer->getAuthor()->getId() or $oUserCurrent->isAdministrator())}
                <span class="mx-2">&bull;</span>
                {component "bs-button" 
                    classes = "btn-edit"
                    com     = "link"
                    url     = "#"
                    text    = {component "bs-icon" icon="edit"}
                    popover = [content => $aLang.common.edit] }

            {/if}
            <br>
            <div class="py-3 answer-text">{$oAnswer->getText()}</div>
            <div class="mt-3">
                {component "like:like" 
                    target  = $oAnswer
                    bmods = "outline-success" 
                    text= $aLang.plugin.questions.question.actions.like}
                    
                {component "bs-button" 
                    popover = $aLang.plugin.questions.question.actions.complain
                    bmods = "outline-danger"
                    icon = "ban"}
            </div>
        </div>
    </div>