/*
 Alert for Bootstrap 3 by @sdcc_ken
 License: 
 */

(function () {
    "use strict";
    var $, KenJqueryBootstrapAlert;

    $ = jQuery;
    KenJqueryBootstrapAlert = function (element,options) {
        this.options = $.extend($.fn.kenJqueryBootstrapAlert.defaults, options || {});
        this.$element = $(element);
        var alert = "";
        var close = "";
        if (options.close) {
            close = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        }
        switch (options.type) {
            case "success":
                alert = '<div class="alert alert-success" role="alert">' + close + options.message + '</div>';
                break;
            case "info":
                alert = '<div class="alert alert-info" role="alert">' + close + options.message + '</div>';
                break;
            case "warning":
                alert = '<div class="alert alert-warning" role="alert">' + close + options.message + '</div>';
                break;
            case "danger":
                alert = '<div class="alert alert-danger" role="alert">' + close + options.message + '</div>';
                break;
        }
        this.$element.append(alert);
        return alert;
    };
    $.fn.kenJqueryBootstrapAlert = function (options) {
        return this.each(function () {
            var $this;
            $this = $(this);
            options = $.extend(options, $this.data());
            new KenJqueryBootstrapAlert(this, options);
            return this;
        });
    };

    $.fn.kenJqueryBootstrapAlert.defaults = {
        type: null,
        messgae: '',
        close: true,
    };
}).call(this);