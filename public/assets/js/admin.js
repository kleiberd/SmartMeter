$(function() {
    $(window).bind("load resize", function() {
        topOffset = 50;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            $("#map-canvas").width($(window).width());
            topOffset = 100;
        } else {
            //$("#sidebar").height($(window).height() - $(".navbar").height());
            $("#map-canvas").width($(window).width() - $("#sidebar").width());
            $("#page-wrapper").width(($(window).width() - $("#sidebar").width()) - 50);
            $('div.navbar-collapse').removeClass('collapse');
        }

        height = (this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    })
});
