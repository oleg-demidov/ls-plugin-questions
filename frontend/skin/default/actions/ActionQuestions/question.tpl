{**
 * Страница вывода ошибок
 *}

{extends "layouts/layout.base.tpl"}


{block 'layout_page_title'}
    {$oQuestion->getTitle()}
{/block}

{block 'layout_content'}
    <div class="{$classes}">
        {$oQuestion->getText()}
    </div>

{/block}