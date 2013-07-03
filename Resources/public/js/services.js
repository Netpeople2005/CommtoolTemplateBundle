(function($) {
    var service = angular.module('commtool.config.service', []);

    service.factory('ReadSections', function() {

        var read = function(container) {
            var sections = [];
            container.find('.commtool_section').filter(function() {
                return $(this).parents('.commtool_section:first').not(container).size() === 0;
            }).each(function() {
                var current = $(this)
                sections.push({
                    type: current.data('type'),
                    name: current.data('name'),
                    id: current.data('id'),
                    tag: current.prop('tagName').toLowerCase(),
                    children: read(current),
                    config: configs[current.data('type')]
                })
            })
            return sections;
        }

        return read;
    })
    
})(jQuery);


