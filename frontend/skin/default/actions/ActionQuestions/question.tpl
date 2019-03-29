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



            {if $oUserCurrent and $oUserCurrent->getId() == $oQuestion->getAuthor()->getId() or $oUserCurrent->isAdministrator()}
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
    
    {capture name="answers"}
        {foreach $oQuestion->getAnswers() as $oAnswer}
            {component 'questions:answer' oAnswer=$oAnswer}
        {/foreach}
    {/capture}
    
    {component "bs-tabs" bmods="tabs" classes="mt-4" contentClasses="mt-3" activeItem="answers" items = [
        [ text => $aLang.plugin.questions.answer.answers , content => $smarty.capture.answers, name => 'answers'],
        [ text => $aLang.plugin.questions.answer.answered , content => $smarty.capture.form_answer, name => 'form']
    ]}
    
    

    

    
    
{*
    {component "bs-card" classes = "bg-light  border-0" content = [
        [
            type => 'body',
            content => $smarty.capture.form_answer
        ]
    ]}*}
    
{/block}