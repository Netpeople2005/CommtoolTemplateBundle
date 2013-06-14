(function($) {
    var commtoolConfig = angular.module('commtool.config', ['commtool.config.service'])

    var helpTpl = _.template($("#section-help-tpl").html())
    var sectionTpl = _.template($("#section-element-tpl").html())

    commtoolConfig.controller('MainCtrl', function($scope, $element, setAttrs) {
        $scope.save = function() {
            $.post(urls.save, {
                content: $element.find('#html-content').html()
            })
        }
//        $(".generate").on('click', function(event) {
//            event.preventDefault()
//
//            $("<div/>").dialog({
//                width: 1000,
//                modal: true
//            }).html(generateTemplate());
//        })
//
//        window.generateTemplate = function() {
//
//            //$("#html-content .ui-droppable").droppable('disable')
//
//            var template = $($("#html-content").html())
//
//            template.find(".ui-droppable").droppable().droppable('destroy')
//            template.find(".section-element.active").removeClass('active')
//
//            return template;
//        }
    })

    commtoolConfig.controller('HtmlCtrl', function($scope, $element, setAttrs) {


        if ($element.find("body").size() > 0) {
            var container = $element.find("body");
        } else {
            var container = $element;
        }
        
        container.find("*:not(tr,tbody,tfoot,thead,table,.commtool_section)").droppable({
            greedy: true,
            over: function() {
                $(this).addClass("element-hover")
                var este = $(this)
                $("#help").html(helpTpl({
                    tag: este.prop('tagName').toLowerCase()
                }))
            },
            out: function() {
                $(this).removeClass("element-hover")
            },
            drop: function(event, ui) {

                container.find('*').removeClass("element-hover")

                var este = $(this)
                var sectionType = ui.draggable.html().toLowerCase()

                if (este.is('.commtool_section')) {
                    return false;
                }

                var numSections = $('.' + sectionType).filter(function() {
                    return $(this).parents('.commtool_section').size() == 0;
                }).size()

                este.addClass('section-element commtool_section ' + sectionType).attr({
                    'data-id': numSections,
                    'data-type': sectionType,
                })

                setAttrs(este)

                var el = $(sectionTpl({
                    type: sectionType,
                    tag: este.prop('tagName').toLowerCase()
                }))

                el.data('section', este)

                $("#sections-template").append(el)

            }
        })

        $("#html-content *").on("click", function(event) {
            event.preventDefault()
        })

        $("#html-content").on("click", ".section-element", function(event) {
            event.preventDefault()

            var section = $(this).clone().addClass('active')

            $.post(urls.section_properties + section.data('section-type'), {
                id: section.data('section-id')
            }).done(function(html) {
                $("#html-content .ui-droppable").droppable('disable')
                $("#dialog-edit").dialog({
                    modal: true,
                    width: 1000,
                    resizable: false,
                    close: function() {
                        $("#html-content .ui-droppable").droppable('enable')
                    }
                }).html(html).find('.section-content').html(section);
            })
        })

        $("#sections-template").on("click", 'a', function(event) {
            event.preventDefault()
            var div = $(this).parent()
            div.data('section').removeClass('section-element')
            div.remove();
        }).on("mouseenter", 'li', function(event) {
            $(this).data('section').addClass('active')
        }).on("mouseleave", 'li', function(event) {
            $(this).data('section').removeClass('active')
        }).on("click", 'li', function(event) {
            $(this).data('section').trigger('click')
        })
    })

    commtoolConfig.controller('SectionsCtrl', function($scope, $element) {

        $scope.showHelp = false;

        $element.find("li").draggable({
            helper: 'clone',
            cursor: "move",
            start: function() {
                $scope.$apply(function() {
                    $scope.showHelp = true
                });
            },
            stop: function() {
                $scope.$apply(function() {
                    $scope.showHelp = false
                });
            }
        })
    })

})(jQuery)