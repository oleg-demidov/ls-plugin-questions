{**
 * Страница вывода ошибок
 *}

{extends "layouts/layout.base.tpl"}


{block 'layout_page_title'}
    {$aLang.plugin.questions.index.title}
{/block}

{block 'layout_content'}
    <div class="mt-4">
        {foreach $aQuestions as $oQuestion}
            {component "questions:question.item" 
                classes     = "mt-2"
                oQuestion   = $oQuestion}
            <hr>
        {/foreach}
    </div>
{/block}