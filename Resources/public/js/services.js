(function($) {
    var service = angular.module('commtool.config.service', []);
    
    service.factory('setAttrs', function() {

        return function(el) {
            console.log(el.is('img'))
            if (el.is('img')) {
                el.attr({
                    'ng-src': '{{' + el.data('type') + '[' + el.data('id') + ']}}',
                })
            }else if(el.is('a')){
                el.attr({
                    'ng-href': '{{' + el.data('type') + '[' + el.data('id') + ']}}',
                })                
            }else{
                el.attr({
                    'ng-bind': el.data('type') + '[' + el.data('id') + ']',
                })                
            }

        }
    });
})(jQuery);


