(function($) {
    var module = angular.module('commtool.config', ['commtool.config.service'])

    module.config(function($routeProvider) {

    })

    module.controller('MainCtrl', function($scope, $compile, ReadSections) {

        $scope.sections = ReadSections($('#html-content'))

        $scope.enter = function(el) {
            $('[data-id=' + el.id + ']').addClass('active')
        }

        $scope.leave = function(el) {
            $('[data-id=' + el.id + ']').removeClass('active')
        }

        $scope.show = function(el) {
            $.get(urls.getSection + el.type).done(function(res) {
                content = $(res)
                var scope = $("#dialog-edit").scope();
                $compile(content)(scope)
                scope.section = el
                scope.$digest()
                var section = $('#html-content').find('[data-id=' + el.id + ']').clone().addClass('active')
                $("#dialog-edit").dialog({
                    modal: true,
                    width: 1000,
                    resizable: false
                }).html(content).find('.section-content').html(section);
            })
        }

        $scope.save = function() {
            $.post(urls.save, {
                sections: $scope.sections
            })
        }

    })

    module.controller("DialogCtrl", function($scope) {
        
        $scope.change = function(){
            $scope.section.config = $scope.options
        }
    })

})(jQuery)