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
        
        {insert name='block' block='fieldCategory' params=[
            'target'      => $oQuestion,
            'entity'      => 'PluginQuestions_ModuleTalk_EntityQuestion',
            'target_type' => "questions",
            'params'      => [
                'label'    => {$aLang.plugin.questions.edit_question.form.categories.label}
                    
            ]
        ]}

        {* title *}
        {component 'bs-form' 
            validate   = [
                entity => $oQuestion
            ]
            template    = 'text' 
            name        = "title"
            value       = $oQuestion->getTitle()
            label       = $aLang.plugin.questions.edit_question.form.title.label
            placeholder = $aLang.plugin.questions.edit_question.form.title.placeholder
            }
        
        {* Текст *}
        {component 'tinymce' 
            validate   = [
                entity => $oQuestion
            ]
            name        = "text"
            value       = $oQuestion->getText()
            label       = $aLang.plugin.questions.edit_question.form.text.label
            placeholder = $aLang.plugin.questions.edit_question.form.text.placeholder
            }

        {if !$oQuestion->_isNew()}
            <input type="hidden" name="id" value="{$oQuestion->getId()}">
        {/if}

        {if $oUserCurrent}
            <input type="hidden" name="id" value="{$oUserCurrent->getId()}">
        {/if}
        
        
        {component "bs-button" 
            bmods = "primary" 
            type  = "submit" 
            text  = $aLang.common.save}

    </form>
{/block}
