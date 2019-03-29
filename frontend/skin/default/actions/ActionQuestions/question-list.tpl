{**
 * Страница вывода ошибок
 *}

{extends "layouts/layout.base.tpl"}


{block 'layout_page_title'}
    {$aLang.plugin.questions.index.title}
{/block}

{block 'layout_content'}
    <div class="mt-4">
        {foreach name="questions" from=$aQuestions  item='oQuestion'}
            {component "questions:question.item" 
                classes     = "mt-2"
                oQuestion   = $oQuestion}
            {if !$smarty.foreach.questions.last}
                <hr>
            {/if}
            
        {/foreach}
        {if !count($aQuestions)}
            {component "blankslate" 
                text    = $aLang.plugin.questions.question.blankslate.text 
                }
        {/if}

    </div>
{/block}