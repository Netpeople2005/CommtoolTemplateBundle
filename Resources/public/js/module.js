(function($) {
    var module = angular.module('commtool.config', ['commtool.config.service'])

    module.config(function($routeProvider){
        
    })

    module.controller('MainCtrl', function($scope, $element) {
        $scope.help = {tag: ''}
        $scope.dialog = {}
        
        $scope.save = function() {
            $.post(urls.save, {
                content: $element.find('#html-content').html()
            })
        }
    })

    module.controller('HtmlCtrl', function($scope, $element, SectionAttributes, TemplateSections) {

        if ($element.find("body").size() > 0) {
            var container = $element.find("body");
        } else {
            var container = $element;
        }

        container.find("*:not(tr,tbody,tfoot,thead,table,.commtool_section)").droppable({
            greedy: true, //solo el elemento mas interno recibe la sección
            hoverClass: "element-hover", //clase que se coloca en el hover de un droppable
            tolerance: 'pointer', //estamos en un elemento cuando el mouse esté dentro de este
            accept: function(drag) {
                //definimos cuando un droppable acepta un draggable
                var este = $(this)
                return este.is(drag.data('validElements'))
                        && !este.is('.commtool_section')
                        && este.find('.commtool_section').size() === 0
                        && este.parents('.commtool_section').size() === 0
            },
            over: function(event, ui) {
                //cuando estemos encima de un droppable mostramos el tag en el helper
                var este = $(this)
                $scope.$apply(function() {
                    $scope.help.tag = este.prop('tagName').toLowerCase()
                })
            },
            drop: function(event, ui) {
                //cuando sea soltado un drag en un drop, creamos la sección en el elemento del 
                //template y lo agregamos al listado de secciones creadas.
                container.find('.element-hover').removeClass('element-hover')

                var este = $(this)
                //desabil
//                este.droppable('option', 'disabled', true)

                var sectionType = ui.draggable.data('type')

                var numSections = container.find('.' + sectionType).filter(function() {
                    return $(this).parents('.commtool_section').size() === 0;
                }).size()

                este.addClass('commtool_section ' + sectionType).attr({
                    'data-id': numSections,
                    'data-type': sectionType
                })

                SectionAttributes(este)

                TemplateSections.add({
                    id: numSections,
                    section: este,
                    type: sectionType,
                    tag: este.prop('tagName').toLowerCase()
                })
            }
        })

        container.find('*').on("click", function(event) {
            event.preventDefault()
        })

//        container.on("click", ".commtool_section", function(event) {
//            event.preventDefault()
//
//            var section = $(this).clone().addClass('active')
//
//            $.post(urls.section_properties + section.data('section-type'), {
//                id: section.data('id')
//            }).done(function(html) {
//                container.find(".ui-droppable").droppable('disable')
//                $("#dialog-edit").dialog({
//                    modal: true,
//                    width: 1000,
//                    resizable: false,
//                    close: function() {
//                        container.find(".ui-droppable").droppable('enable')
//                    }
//                }).html(html).find('.commtool_section').html(section);
//            })
//        })

    })

    module.controller('SectionsCtrl', function($scope, $element) {

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

    module.controller('TemplateSectionsCtrl', function($scope, $http, $compile, TemplateSections) {
        $scope.sections = TemplateSections.items;

        $scope.remove = function(el) {
            el.section.removeClass('commtool_section active')
            TemplateSections.remove(el)
        }

        $scope.enter = function(el) {
            el.section.addClass('active')
        }

        $scope.leave = function(el) {
            el.section.removeClass('active')
        }

        $scope.show = function(el) {
            $.get(urls.getSection + el.type).done(function(res) {
                $compile(res)($("#dialog-edit").scope())
                var section = el.section.clone().addClass('active')
                $("#dialog-edit").dialog({
                    modal: true,
                    width: 1000,
                    resizable: false,
                    create: function() {
                        $("#html-content .ui-droppable").droppable('option','disabled', true)
                    },
                    close: function() {
                        $("#html-content .ui-droppable").droppable('option','disabled', false)
                    },
                }).html(res).find('.section-content').html(section);
            })
        }
    })
    
    module.controller("DialogCtrl", function($scope){
        //$scope.dialog;
    })

})(jQuery)