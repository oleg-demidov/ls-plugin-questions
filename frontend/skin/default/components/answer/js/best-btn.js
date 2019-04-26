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

    $.widget( "livestreet.lsBestButton", $.livestreet.lsComponent,{
        /**
         * Дефолтные опции
         */
        options: {
            selectors:{
                bestButtons:"@[data-best-btn]"
            },
            urls:{
                load:aRouter.questions + "ajax-answer-best"
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
            
            this._on(this.element, {click: "onClick"})

            
        },
        onClick:function(){
            this.element.bsButton('loading');
            
            if(this.element.hasClass('active')){
                this.option('params.state', 1);
            }

            this._load("load", {}, function(response){ 
                this.option('params.state', response.state);
                if(response.state){
                    this.element.bsButton('active');
                    this.elements.bestButtons.not(this.element).bsButton('deactive').hide();
                }else{
                    this.element.bsButton('deactive');
                    this.elements.bestButtons.show();
                }
                this.element.bsButton('setCount', response.count);
            }.bind(this), {
                showProgress:false, 
                onComplete: function(response){
                    this.element.bsButton('loaded');
                }.bind(this)
            });
        }
        
    });
})(jQuery);