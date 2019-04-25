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
    
    <div class="d-flex"> 
        <div class="pt-1 pr-2">
            Сортировать по:
        </div>

        {component "bs-nav" 
            activeItem = $_aRequest['order']
            bmods = "pills sm"
            items = [
                [
                    classes => "py-1 px-3",
                    name => "#count_like",
                    text => $aLang.plugin.questions.question.order.rating,
                    url  => "{$aPaging['sBaseUrl']}?{if $_aRequest.q}q={$_aRequest.q}{/if}&order=%23count_like"
                ],
                [
                    classes => "py-1 px-3",
                    name => "date_create",
                    text => $aLang.plugin.questions.question.order.date,
                    url  => "{$aPaging['sBaseUrl']}?{if $_aRequest.q}q={$_aRequest.q}{/if}&order=date_create"
                ]
            ]}
    </div>

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