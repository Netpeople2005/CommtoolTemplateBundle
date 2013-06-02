(function($) {

    var helpTpl = _.template($("#section-help-tpl").html())
    var sectionTpl = _.template($("#section-element-tpl").html())

    $(".draggable-container li").draggable({
        helper: 'clone',
        cursor: "move",
        start: function() {
            $("#help").show()
        },
        stop: function() {
            $("#help").hide()
        }
    })

    if($("#html-content body").size() > 0){
        var container = "#html-content body";
    }else{
        var container = "#html-content";        
    }
    console.log(container)
    $("*:not(tr,tbody,tfoot,thead,table)", container).droppable({
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
            $('*',container).removeClass("element-hover")

            var este = $(this)
            var sectionType = ui.draggable.html().toLowerCase()

            if (este.is('.section-element')) {
                return false;
            }

            este.uniqueId().addClass('section-element ' + sectionType).attr({
                'data-section-id': este.attr('id'),
                'data-section-type': sectionType
            })

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

    $(".generate").on('click', function(event) {
        event.preventDefault()

        $("<div/>").dialog({
            width: 1000,
            modal: true
        }).html(generateTemplate());
    })

    window.generateTemplate = function() {

        //$("#html-content .ui-droppable").droppable('disable')

        var template = $($("#html-content").html())

        template.find(".ui-droppable").droppable().droppable('destroy')
        template.find(".section-element.active").removeClass('active')

        return template;
    }

})(jQuery);


