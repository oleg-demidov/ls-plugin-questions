{**
 * Жалоба
 *}

{extends 'Component@email.email'}

{block 'content'}ssssssssdsdsdsdsd
    {lang name='plugin.questions.emails.add_answer.text' params=[
        'question'         => $oQuestion->getTitle()
    ]}
{/block}