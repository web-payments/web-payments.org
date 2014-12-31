!function ($) {

    $(function() {

        $( ".column" ).sortable({
            connectWith: ".column",
            handle: ".panel-heading",
            cancel: ".portlet-toggle",
            placeholder: "portlet-placeholder ui-corner-all",
            forcePlaceholderSize: true
        });

        var body = $('body');
        body.on('click', '.portlet > .panel > .panel-heading > .panel-options > .panel-collapse, .portlet > .panel > .panel-heading > .panel-options > .panel-expand', function (evt) {
            evt.preventDefault();
            var el = $(this).closest(".portlet").find(".panel-body");
            if ($(this).hasClass("panel-collapse")) {
                $(this).removeClass("panel-collapse").addClass("panel-expand");
                $(this).find('i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
                el.slideUp(200);
            } else {
                $(this).removeClass("panel-expand").addClass("panel-collapse");
                $(this).find('i').removeClass('fa-chevron-down').addClass('fa-chevron-up');
                el.slideDown(200);
            }
        });

        body.on('click', '.portlet > .panel > .panel-heading > .panel-options > .panel-remove', function (evt) {
            evt.preventDefault();
            var el = $(this).closest(".portlet");
            el.fadeOut("normal", function() {
                $(this).remove();
            });
        });

    });
}(window.jQuery);