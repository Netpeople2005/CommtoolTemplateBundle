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

    $("#html-content *:not(img,tr,tbody,tfoot,thead,table)").droppable({
        greedy: true,
        over: function() {
            $(this).addClass("element-hover")
            var este = $(this)
            $("#help").html(helpTpl({
                tag: este.prop('tagName'),
                id: este.attr('id'),
                classes: este.attr('class')
            }))
        },
        out: function() {
            $(this).removeClass("element-hover")
        },
        drop: function(event, ui) {
            $('#html-content *').removeClass("element-hover")

            var este = $(this)
            var sectionType = ui.draggable.html().toLowerCase()

            if (este.is('.section-element')) {
                return false;
            }

            este.addClass('section-element ' + sectionType).attr('data-section-id', "holaaa")

            $('<div class="edit">Edit</div>').appendTo(este)

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

    $("#html-content").on("click", ".edit", function(event) {
        event.preventDefault()

        var section = $(this).closest('.section-element').clone()

        section.find('.edit').remove()

        $("#html-content .ui-droppable").droppable('disable')

        $("#dialog-edit").dialog({
            modal: true,
            width: 1000,
            resizable: false,
            close: function() {
                $("#html-content .ui-droppable").droppable('enable')
            }
        }).find('.section-element1').html(section);
    })

    $("#sections-template").on("click", 'a', function(event) {
        event.preventDefault()
        var div = $(this).parent()
        div.data('section').removeClass('section-element').find('.edit').remove()
        div.remove();
    }).on("mouseenter", 'li', function(event) {
        $(this).data('section').addClass('active')
    }).on("mouseleave", 'li', function(event) {
        $(this).data('section').removeClass('active')
    }).on("click", 'li', function(event) {
        $(this).data('section').find('.edit').trigger('click')
    })

})(jQuery);


