
{component_define_params params=[ 'oQuestion', 'classes' ]}

<div class="question media {$classes}">
    <img  class="mr-3 rounded-circle" src="{$oQuestion->getAuthor()->getProfileAvatar()}" alt="{$oQuestion->getAuthor()->getLogin()}">
    <div class="media-body">
        <h5 class="mt-0"><a href="{$oQuestion->getUrl()}" class="link">{$oQuestion->getTitle()}</a></h5>
        <span class="text-muted">{$oQuestion->getAuthor()->getName()}</span> 
        <span class="mx-2">&bull;</span>
        <span class="text-muted font-italic">{$oQuestion->getDateCreateFormat()}</span>
        {if $oUserCurrent and $oUserCurrent->getId() == $oQuestion->getAuthor()->getId()}
            <span class="mx-2">&bull;</span>
            <a href="{router page="questions/edit-question/{$oQuestion->getId()}"}" class="link">{$aLang.common.edit}</a>
        {/if}

    </div>
</div>