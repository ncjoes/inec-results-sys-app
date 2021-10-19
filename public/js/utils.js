jQuery(function () {
    window.$ = jQuery;

    window.notify = function(response) {
        //Remove text-* classes
        var message, mode;
        if (typeof (response['message']) !== 'undefined') {
            message = response['message'];
            mode = (typeof (response['mode']) !== 'undefined') ? response.mode : (response['status'] === true ? 'success' : 'error');
        } else {
            message = toString(response);
            mode = 'info';
        }
        toastr[mode](message);
    }

    window.handleHttpErrors = function (xhr, form) {
        var response = null;
        try {
            response = $.parseJSON(xhr.responseText);
        } catch (e) {
            response = xhr.responseText;
        }
        if (xhr.status === 422) {
            if (typeof (response) !== 'object') {
                notify({'status': false, 'message': response});
            } else {
                handle422ErrorObject(form, response);
            }
        } else if (xhr.status >= 400 && xhr.status < 500) {
            if (typeof (response) === 'object') {
                notify(response);
            } else {
                notify({'status': false, 'message': response});
            }
        } else if (xhr.status >= 500 && xhr.status < 600) {
            notify({'status': false, 'message': 'Something snapped, please try again shortly.'});
        }
    }

    window.handle422ErrorObject = function(form, response) {
        $(form).find('.is-invalid').removeClass('is-invalid');
        var textArr = [];
        for (var field in response['errors']) {
            if (field in response['errors']) {
                $(form).find('[name="' + field + '"]').addClass('is-invalid').focus();
                var data = $(response['errors']).prop(field);
                if (!!data && data.constructor === Array) {
                    textArr.push(data.join("<br/>"));
                } else {
                    textArr.push(data);
                }
            }
        }
        var notification = {
            'message': textArr.join('<br/>'),
            'status': false
        };
        notify(notification);
    }

    /**
     * Make ajax request
     * @param {object} settings This should contain the regular JQuery.ajax settings
     * and optionally <code>onSuccess</code>, <code>onFailure</code> and <code>onComplete</code>
     * closures which are aliases for jqXHR's <code>done</code>, <code>fail</code> and
     * <code>always</code> functions respectively.<br/><br/>
     * <b>Extra configurations</b><br/>
     * ajaxCall takes extra configurations. Add <code>extraConfig</code> object to the settings.<br/>
     * <code>extraConfig</code> properties include:<br/>
     * <b>retry</b> - Set true to resend request if fails due to connectivity, else false.<br/>
     * Note: By default, onComplete will be called after the last trial, to change this,
     * set <code>extraConfig.completeAfterRetry</code> to false.<br/>
     * <b>trials</b> - Maximum number of trials. Set value to 0 for infinite trials<br/>
     * <b>retryInterval</b> - Delay before each retry<br/><br/>
     * <b>Default Values for ajaxCall</b><br/>
     * <code>dataType: 'json'</code><br/>
     * <code>extraConfig: {retry: true,trials: 1,retryInterval: 0,completeAfterRetry: true}</code><br/>
     * @example <code>
     * var jqXHR = ajaxCall({</span><br/>
     * &nbsp;url: 'http://example.com',<br/>
     * &nbsp;data: {p: 'param'},<br/>
     * &nbsp;extraData:{<br/>
     * &nbsp;&nbsp;retry: true,<br/>
     * &nbsp;&nbsp;trials: 2<br/>
     * &nbsp;},<br/>
     * &nbsp;onSuccess: function (data) {<br/>
     * &nbsp;&nbsp;//success<br/>
     * &nbsp;},<br/>
     * &nbsp;onComplete: function () {<br/>
     * &nbsp;&nbsp;//Request complete<br/>
     * &nbsp;},<br/>
     * &nbsp;onFailure: function(){<br/>
     * &nbsp;&nbsp;//Request failed<br/>
     * &nbsp;}<br/>
     *  });
     *</code>
     * @returns {jqXHR} Returns first jqXHR object created
     */
    window.ajaxCall = function (settings) {
        var ajaxSettings = {
            dataType: 'json',
            cache: true,
            headers: {
                'Cache-Control': 'max-age=200',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            onSuccess: function (response) {
                notify(response);
            },
            onFailure: function (xhr) {
                handleHttpErrors(xhr, btn);
            },
            onComplete: function (response) {
                if (typeof response['redirect'] === 'string') {
                    setTimeout(function () {
                        window.location = response['redirect'];
                    }, 1500);
                }
            }
        };
        var extraConfig = {
            retry: true,
            trials: 1,
            retryInterval: 5000,
            completeAfterRetry: true,
            trialCount: 0
        };
        extraConfig = $.extend(extraConfig, settings['extraConfig']);

        //Merge settings
        Object.keys(settings).forEach(function (key) {
                var s = [];
                s[key] = settings[key];
                ajaxSettings = $.extend(ajaxSettings, s);
        });

        var r = $.ajax(ajaxSettings);
        if (typeof (ajaxSettings['onSuccess']) === 'function') {
            r.done(ajaxSettings['onSuccess']);
        }
        if (typeof (ajaxSettings['onComplete']) === 'function') {
            (function (completeAfterRetry) {
                r.always(function (jqXHR, status, statusText) {
                    if (jqXHR['readyState'] !== 0 || !completeAfterRetry) {
                        ajaxSettings['onComplete'](jqXHR, status, statusText);
                    }
                });
            }(extraConfig.completeAfterRetry));
        }
        r.fail(function (response, status, statusText) {
            if (response['readyState'] === 0) {
                if (extraConfig['retry']) {
                    extraConfig['trialCount']++;
                    if (extraConfig['trialCount'] === extraConfig['trials']) {
                        extraConfig['retry'] = false;
                        extraConfig['completeAfterRetry'] = false;
                    }
                    //Repeat request
                    setTimeout(function () {
                        ajaxCall($.extend(ajaxSettings, {extraConfig: extraConfig}));
                    }, extraConfig['retryInterval']);
                    return;
                } else {
                    toastr.error('Connection error!');
                }
            }

            if (typeof (ajaxSettings['onFailure']) === 'function') {
                ajaxSettings['onFailure'](response, status, statusText);
            }

        });
        return r;
    }

    toastr.options.timeOut = 10 * 1000;
    window.currentUrl = window.location.href.replace(/\/$/, "");

    window.submitAjaxForm = function (settings, form) {
        var $this = form;
        var ajaxCallSettings = {
            url: $this.attr('action'),
            method: $this.attr('method').toUpperCase(),
            data: $this.serialize(),
            onSuccess: function (response) {
                notify(response);
            },
            onFailure: function (xhr) {
                handleHttpErrors(xhr, $this);
            },
            onComplete: function (response) {
                if (typeof response['redirect'] === 'string') {
                    setTimeout(function () {
                        window.location = response['redirect'];
                    }, 1500);
                } else {
                    $('button[type=submit]', $this).removeAttr('disabled');
                }
            }
        };
        $('button[type=submit]', $this).attr('disabled', true);
        ajaxCall($.extend(ajaxCallSettings, settings));
    };

    /* Ajax Form Submission */
    $('form.ajax-form').submit(function (e) {
        e.preventDefault();
        var $this = $(this);
        window.submitAjaxForm({}, $this);
    });
});
