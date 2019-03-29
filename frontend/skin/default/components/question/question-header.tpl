
{component_define_params params=[ 'oQuestion', 'classes' ]}

<div class="question media {$classes}">
    <img  class="mr-3 rounded-circle" src="{$oQuestion->getAuthor()->getProfileAvatar()}" alt="{$oQuestion->getAuthor()->getLogin()}">
    <div class="media-body">
        <h1 class="mt-0">{$oQuestion->getTitle()}</h1>
        <span class="text-muted">{$oQuestion->getAuthor()->getName()}</span> 
            
        <span class="mx-2">&bull;</span>
        <span class="text-muted font-italic">{$oQuestion->getDateCreateFormat()}</span>
        
       
        
        {if $oUserCurrent and $oUserCurrent->getId() == $oQuestion->getAuthor()->getId() or $oUserCurrent->isAdministrator()}
            <span class="mx-2">&bull;</span>
            {component "bs-button" 
                com     = "link"
                url     = {router page="questions/edit-question/{$oQuestion->getId()}"}
                text    = {component "bs-icon" icon="edit"}
                popover = [content => $aLang.common.edit] }
            
        {/if}
    </div>
</div>