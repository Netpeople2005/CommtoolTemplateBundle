(function($) {
    var service = angular.module('commtool.config.service', []);

    service.factory('SectionAttributes', function() {

        return function(el) {
            if (el.is('img')) {
                el.attr({
                    'ng-src': '{{' + el.data('type') + '[' + el.data('id') + ']}}',
                })
            } else if (el.is('a')) {
                el.attr({
                    'ng-href': '{{' + el.data('type') + '[' + el.data('id') + ']}}',
                })
            } else {
                el.attr({
                    'ng-bind': el.data('type') + '[' + el.data('id') + ']',
                })
            }

        }
    });

    service.factory('TemplateSections', function() {
        var sections = {
            items: []
        }

        sections.add = function(s) {
            this.items.push(s)
        }

        sections.remove = function(s) {
            this.items.splice(this.items.indexOf(s), 1)
        }
        
        return sections;
    })

})(jQuery);


