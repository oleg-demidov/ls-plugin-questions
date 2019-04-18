{**
 * Страница вывода ошибок
 *}

{extends "layouts/layout.base.tpl"}


{block 'layout_content'}
    <div class="ml-3 d-flex flex-md-row flex-column">
        <div class="pb-3">
            <img  class="mr-3 rounded-circle" src="{$oQuestion->getAuthor()->getProfileAvatar()}" alt="{$oQuestion->getAuthor()->getLogin()}">
        </div>
        
        <div>
            <h1 class="mt-0">{$oQuestion->getTitle()}</h1>
            <span class="text-muted">{$oQuestion->getAuthor()->getName()}</span> 

            <span class="mx-2">&bull;</span>
            <span class="text-muted font-italic">{$oQuestion->getDateCreateFormat()}</span>



            {if $oUserCurrent and ($oUserCurrent->getId() == $oQuestion->getAuthor()->getId() or $oUserCurrent->isAdministrator())}
                <span class="mx-2">&bull;</span>
                {component "bs-button" 
                    com     = "link"
                    url     = {router page="questions/edit-question/{$oQuestion->getId()}"}
                    text    = {component "bs-icon" icon="edit"}
                    popover = [content => $aLang.common.edit] }

            {/if}
            <br>
            <div class="py-3">
                {$oQuestion->getText()}
            </div>
            <div class="mt-3">
                
                {component "like:like" 
                    target  = $oQuestion
                    bmods = "outline-success" 
                    text= $aLang.plugin.questions.question.actions.like}
                
               
                {insert name='block' block='subscribe' params=[ 
                    plugin  => 'subscribe',
                    event   => 'add_answer',
                    target_id => $oQuestion->getId()
                ]}
                
                {*{component "bs-button" 
                    popover = $aLang.plugin.questions.question.actions.complain
                    bmods = "outline-danger"
                    icon = "ban"}*}
            </div>
        </div>
    </div>
            
   
    
    {$itemsTabs = []}
    
    {capture name="answers"}
        {foreach $oQuestion->getAnswers() as $oAnswer}
            {component 'questions:answer' oAnswer=$oAnswer}
        {/foreach}
        {if !$oQuestion->getCountAnswers()}
            {component "blankslate" 
                text    = $aLang.plugin.questions.answer.blankslate.text 
                }
        {/if}
    {/capture}
    
    {$itemsTabs[] = [ 
        text => $aLang.plugin.questions.answer.answers , 
        content => $smarty.capture.answers, 
        name => 'answers',
        badge => $oQuestion->getCountAnswers()
    ]}
    
    {if $oUserCurrent}
        {capture name="form_answer"}
            <div class="d-flex flex-md-row flex-column ml-3"> 
                <div class="pr-3 pb-3" >
                    <img class="rounded-circle" src="{$oUserCurrent->getProfileAvatar()}" alt="{$oUserCurrent->getLogin()}">
                </div>
                <div class="flex-fill">
                    {component "questions:answer.form"
                        question_id = $oQuestion->getId()
                        oAnswer     = $oAnswerEntity}
                </div>
            </div>
        {/capture}
        
        {$itemsTabs[] = [ 
            text => $aLang.plugin.questions.question.respond , 
            content => $smarty.capture.form_answer, 
            name => 'form_answer'
        ]}
    {/if}

    
    
    {component "bs-tabs" bmods="tabs" classes="mt-5" contentClasses="mt-4" activeItem="answers" items = $itemsTabs}
    
    

    

    
    
{*
    {component "bs-card" classes = "bg-light  border-0" content = [
        [
            type => 'body',
            content => $smarty.capture.form_answer
        ]
    ]}*}
    
{/block}