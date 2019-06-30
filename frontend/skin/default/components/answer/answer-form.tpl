{**
 * Текст
 *
 * @param string  $readonly          Список классов основного блока (через пробел)
 * 
 *}
 
{component_define_params params=[ 'oAnswer', 'question_id',  'redirect']}

<form action="" class="answer-form" data-form-ajax data-form-validate novalidate data-url="{router page='questions/edit-answer-ajax'}">
     
    {$oAnswer->_setValidateScenario('create')}
    
    {* Текст *}
    {component 'tinymce' 
        validate   = [
            entity => $oAnswer
        ]
        id          = "answerEdit"
        name        = "text"
        value       = $oAnswer->getText()
        label       = $aLang.plugin.questions.answer.form.text.label
        placeholder = $aLang.plugin.questions.answer.form.text.placeholder
    }
        
    <input type="hidden" name="question_id" value="{$question_id}">
    <input type="hidden" name="id" value="0">
    <input type="hidden" name="redirect" value="{$redirect}">
    
    {component "bs-button" text=$aLang.plugin.questions.answer.form.submit.text type="submit" bmods="primary"}
</form>

