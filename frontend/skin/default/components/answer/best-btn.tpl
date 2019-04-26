{extends "component@bs-button"}

{block 'button_options' }
    {component_define_params params=[ 'oAnswer', 'static' ]}
    
    {$icon = [icon => "heart", display => 's', classes => 'mr-1']}
    
    {if $oAnswer}
        {$state = $oAnswer->isBest()}
        {$target_id = $oAnswer->getId()}
    {/if}
    
    {if !$static}
        {$attributes['data-btn'] = true}
        {$attributes['data-best-btn'] = true}
    {/if}

    {$attributes['data-param-state'] = {$state|default:0}}
    {$attributes['data-param-id'] = $oAnswer->getId()}
    {$attributes['data-url'] = {router page="questions/ajax-answer-best"}}
    
    {if $state OR $static}
        {$classes = "active"}
    {/if}
    
    {if !$state}
        {$attributes['style'] = "display: none;"}
    {/if}
    
    {$text = $aLang.plugin.questions.answer.best_btn.text}
    
    {$bmods = "outline-primary"}
    
{/block}