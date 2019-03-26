/**
 * LiveStreet
 *
 * @license   GNU General Public License, version 2
 * @copyright 2013 OOO "ЛС-СОФТ" {@link http://livestreetcms.com}
 * @author    Denis Shakhov <denis.shakhov@gmail.com>
 */


tinymce.PluginManager.add('questions', function(editor, url) {
   
    // Ссылка на пользователя
    editor.addButton('wiki', {
        icon: 'numlist',
        tooltip: 'Вставить пункт',
        onclick: function() {
            // Open window
            editor.windowManager.open({
                title: 'Добавить пункт',
                body: [
                    { type: 'textbox', name: 'number', label: 'Номер' }
                ],
                onsubmit: function(e) {
                    editor.insertContent('<wiki punkt="' + e.data.number + '">');
                }
            });
        }
    });

});