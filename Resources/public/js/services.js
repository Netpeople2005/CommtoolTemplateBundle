(function($) {
    var service = angular.module('commtool.config.service', []);

    service.factory('ReadSections', function() {

        var read = function(container) {
            var sections = [];
            container.find('.commtool_section').each(function() {
                var current = $(this)
                if (current.parents('.commtool_section').not(container).size() === 0) {
                    sections.push({
                        type: current.data('type'),
                        id: current.data('id'),
                        tag: current.prop('tagName').toLowerCase(),
                        children: read(current)
                    })
                }
            })
            return sections;
        }

        return read;
    })

})(jQuery);


