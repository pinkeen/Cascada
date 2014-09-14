(function($) {
    'use strict';

    $.fn.confirmize = function(options) {
        var settings = $.extend({
            title: '<i class="fa fa-exclamation-triangle text-danger"></i> Confirm Action',
            message: 'Are you sure?'
        }, options);

        return $(this).each(function() {
            if($(this).data('confirmize')) {
                return;
            }

            $(this).data('confirmize', true);

            $(this).click(function(e) {
                var $this = $(this),
                    title = $this.data('title') || $this.attr('title') || settings.title,
                    href = $this.data('href') || $this.attr('href') || settings.href,
                    message = $this.data('message') || settings.message;

                if($this.data('confirmize-confirmed')) {
                    return true;
                }

                e.preventDefault();

                if($.isFunction(message)) {
                    message = message($this);
                }

                message = '<span>' + message + '</span>';

                if($this.attr('type') === 'submit') {
                    bootbox.confirm({
                        title: title,
                        message: message,
                        callback: function(confirmed) {
                            if(confirmed) {
                                //$this.closest('form').submit();
                                $this.data('confirmize-confirmed', true);
                                $this.click();
                            }
                        }
                    });

                } else {
                    bootbox.confirm({
                        title: title,
                        message: message,
                        callback: function(confirmed) {
                            if(confirmed) {
                                window.location.href = href;
                            }
                        }
                    });
                }

                return false;
            });
        });
    };
})(jQuery);