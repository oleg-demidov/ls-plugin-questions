/**
 * Visual editor
 *
 * @module ls/editor/visual
 *
 * @license   GNU General Public License, version 2
 * @copyright 2013 OOO "ЛС-СОФТ" {@link http://livestreetcms.com}
 * @author    Denis Shakhov <denis.shakhov@gmail.com>
 */

(function($) {
    "use strict";

    $.widget( "livestreet.lsAnswer", $.livestreet.lsComponent,{
        /**
         * Дефолтные опции
         */
        options: {
            selectors:{
                tabForm:    "@[data-tab-answer-form]",
                answerForm: "@.answer-form",
                btnEdit:    ".btn-edit",
                answerText: ".answer-text"
            },
            urls:{
                answer:aRouter.questions + "edit-answer-ajax"
            }
        },

        /**
         * Конструктор
         *
         * @constructor
         * @private
         */
        _create: function () {
            this._super();
            this._on(this.elements.btnEdit, {click:"edit"});
            
        },

        edit:function(e){
            this.elements.tabForm.tab('show');
            if(window.tinymce === undefined){
                return;
            }
            window.tinymce.get('answerEdit').setContent(this.elements.answerText.html())
            this.elements.answerForm.find('[name="id"]').val(this.element.data('id'));
            e.preventDefault();
        }
        
    });
})(jQuery);