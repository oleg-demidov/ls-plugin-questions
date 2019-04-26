{extends "component@bs-button"}

{block 'button_options'}
    {component_define_params params=[ 'oAnswer' ]}
    
    {$icon = [icon => "heart", display => 's', classes => 'mr-1']}
    
    {if $target}
        {$state = $oAnswer->isBest()}
        {$target_id = $oAnswer->getId()}
    {/if}
        
    {$attributes['data-btn'] = true}
    {$attributes['data-best-btn'] = true}
    {$attributes['data-param-state'] = {$state|default:0}}
    {$attributes['data-param-id'] = $oAnswer->getId()}
    {$attributes['data-url'] = {router page="questions/ajax-answer-best"}}
    
    {if $state}
        {$classes = "active"}
    {/if}
    
    {$text = $aLang.plugin.questions.answer.best_btn.text}
    
    {$bmods = "outline-primary"}
    
{/block}