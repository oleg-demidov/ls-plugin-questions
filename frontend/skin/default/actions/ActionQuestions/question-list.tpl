{**
 * Страница вывода ошибок
 *}

{extends "layouts/layout.base.tpl"}


{block 'layout_page_title'}
    {$aLang.plugin.questions.index.title}
{/block}

{block 'layout_content'}
    <form action="{$aPaging['sBaseUrl']}">
        {component "bs-form.text" 
            value = $_aRequest.q
            name="q" 
            placeholder=$aLang.plugin.questions.question.search_form.q.placeholder}
    </form>

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
        {component 'bs-pagination' 
            total   = $aPaging['iCountPage'] 
            padding = 2
            showPager=true
            classes = "mt-3"
            current= $aPaging['iCurrentPage']  
            url="{$aPaging['sBaseUrl']}/page__page__" }
{/block}