{**
 * Страница вывода ошибок
 *}

{extends "layouts/layout.base.tpl"}


{block 'layout_content'}
    
    {component "bs-jumbotron" 
        classes   = "bg-success text-white"
        content = {lang "plugin.questions.question.modertion.text" title=$oQuestion->getTitle()}}
    
{/block}