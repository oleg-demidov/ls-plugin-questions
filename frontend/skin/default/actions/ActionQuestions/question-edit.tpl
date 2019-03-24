{**
 * Страница вывода ошибок
 *}

{extends "layouts/layout.base.tpl"}


{block 'layout_page_title'}
    {if $oQuestion->_isNew()}
        {$aLang.plugin.questions.edit_question.title_add}
    {else}
        {$aLang.plugin.questions.edit_question.title_edit}
    {/if}

    
{/block}

{block 'layout_content'}
    <form action="" data-form-ajax data-form-validate novalidate data-url="{router page='questions/edit-question-ajax'}">
    
        {$oQuestion->_setValidateScenario('create')}

        {* Текст *}
        {component 'bs-form' 
            validate   = [
                entity => $oQuestion
            ]
            template    = 'text' 
            name        = "title"
            label       = $aLang.plugin.questions.edit_question.form.title.label
            placeholder = $aLang.plugin.questions.edit_question.form.title.placeholder
            }
        
        {* Текст *}
        {component 'editor' 
            validate   = [
                entity => $oQuestion
            ]
            type        = 'visual' 
            inputClasses     = 'js-editor-default'
            name        = "text"
            label       = $aLang.plugin.questions.edit_question.form.text.label
            placeholder = $aLang.plugin.questions.edit_question.form.text.placeholder
            }
        {if $oUserCurrent}
            {component "bs-media.field" 
                validate   = [
                    entity => $oQuestion
                ]
                multiple = true
                name    = 'photos'
                label   = $aLang.plugin.questions.edit_question.form.photo.label 
                text    = $aLang.plugin.questions.edit_question.form.photo.text }
        {/if}

        {if $oUserCurrent}
            {component "field.hidden" name="user_id" value="{$oUserCurrent->getId()}"}
        {/if}
        
        {component "bs-button" 
            bmods = "primary" 
            type  = "submit" 
            text  = $aLang.common.save}

    </form>
{/block}