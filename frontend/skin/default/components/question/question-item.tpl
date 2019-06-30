
{component_define_params params=[ 'oQuestion', 'classes' ]}

<div class="question media {$classes}">
    <img  class="mr-3 rounded-circle" src="{$oQuestion->getAuthor()->getProfileAvatar('50x50')}" alt="{$oQuestion->getAuthor()->getLogin()}">
    <div class="media-body">
        <h5 class="mt-0"><a href="{$oQuestion->getUrl()}" class="link">{$oQuestion->getTitle()}</a></h5>
        <span class="text-muted">
            <a class="text-muted" href="{$oQuestion->getAuthor()->getProfileUrl()}">{$oQuestion->getAuthor()->getName()}</a>
        </span> 
            
        <span class="mx-2">&bull;</span>
        <span class="text-muted font-italic">{$oQuestion->getDateCreateFormat()}</span>
        
        <span class="mx-2">&bull;</span>
        <span class="text-muted">
            <a href="{$oQuestion->getUrl()}" class="link {if $oQuestion->getCountAnswers()}text-success{/if}">
                {if $oQuestion->getCountAnswers()}
                    {lang name='plugin.questions.question.answer' plural=true count=$oQuestion->getCountAnswers()}
                {else}
                    {lang name='plugin.questions.question.respond' }
                {/if}
            </a>
        </span>
        
        {if $oUserCurrent and ($oUserCurrent->getId() == $oQuestion->getAuthor()->getId() or $oUserCurrent->isAdministrator())}
            <span class="mx-2">&bull;</span>
            {component "bs-button" 
                com     = "link"
                url     = {router page="questions/edit-question/{$oQuestion->getId()}"}
                text    = {component "bs-icon" icon="edit"}
                popover = [content => $aLang.common.edit] }
            
        {/if}
    </div>
</div>