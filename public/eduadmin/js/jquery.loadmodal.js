/*jshint esversion: 11 */
(function ($) {
    $.loadModal = function (options) {
        // allow a simple url to be sent as the single option
        if ($.type(options) === 'string') {
            options = {
                url: options,
            };
        }

        // set the default options
        options = $.extend(true, {
            url: null,                               // a convenience place to specify the url - this is moved into ajax.url
            id: 'jquery-load-modal-js',               // the id of the modal
            idBody: 'jquery-load-modal-js-body',      // the id of the modal-body (the dialog content)
            appendToSelector: 'body',                // the element to append the dialog <div> code to.  Normally, this should be left as the 'body' element.
            title: window.document.title || 'Dialog',// the title of the dialog
            width: '400px',                          // 20%, 400px, or other css width
            dlgClass: 'fade',                        // CSS class(es) to add to the <div class="modal"> main dialog element.  This default makes the dialog fade in.
            size: 'modal-lg',                        // CSS class(es) to specify the dialog size ('modal-lg', 'modal-sm', '').  The default creates a large dialog.  See the Bootstrap docs for more info.
            closeButton: true,                       // whether to have an 'X' button at top right to close the dialog
            buttons: {},                             // return false from the function to prevent the automatic closing of the dialog
            modal: {},                               // options sent into $().modal (see Bootstrap docs for .modal and its options)
            ajax: {                                  // options sent into $.ajax (see JQuery docs for .ajax and its options)
                url: null,                           // required (for convenience, you can specify url above instead)
            },
            beforeShow: null,                        // This method is called at the beginning of the default success method.  If this method
            bgClass: 'secondary',
            onShow: null,
            btnStyle: '',
        }, options);

        // ensure we have a url
        options.ajax.url = options.ajax.url || options.url;
        if (!options.ajax.url) {
            throw new Error('$().loadModal requires a url.');
        }

        // close any dialog with this id first
        $('#' + options.id).modal('hide');

        // create our own success responder for the ajax
        options.ajax.success = $.isArray(options.ajax.success) ? options.ajax.success : options.ajax.success ? [options.ajax.success] : [];
        options.ajax.success.unshift(function (data, status, xhr) { // unshift puts this as the first success method
            if (options.beforeShow && options.beforeShow(data, status, xhr) === false) {
                return;
            }

            // create the modal html
            const headTitle = options.title;
            const submitClass = headTitle.replace(/\s+/gi, '-').toLowerCase();
            const div = $([
                '<div id="' + options.id + '" class="modal ' + options.dlgClass + '" role="dialog" aria-labelledby="modalLabel' + options.bgClass + '">',
                '  <div class="modal-dialog ' + options.size + '" role="document">',
                '      <div class="modal-content">',
                '        <div class="modal-header border-bottom ' + options.bgClass + '" style="cursor: move;" title="click & geser modal">',
                '          <h4 class="modal-title" style="cursor: default;" id="modalLabel' + options.bgClass + '">' + options.title + '</h4>',
                options.closeButton ? '<button class="btn-close" data-bs-dismiss="modal" type="button"></button>' : '',
                '        </div>',
                '        <div id="' + options.idBody + '" class="modal-body"></div>',
                '        <div class="modal-footer">',
                '           <button class="btn btn-sm btn-secondary" data-bs-dismiss="modal"><i class="fa fa-ban"></i> Tutup</button>',
                '           <button type="button" data-for="" class="pull-right btn btn-info btn-sm submit-data btn-' + options.bgClass + ' submit-' + submitClass + '" style="' + options.btnStyle + '">' +
                '               <i class="fa fa-refresh fa-spin loading" style="display:none;"></i><i class="fa fa-save"></i> ' + options.title +
                '           </button>',
                '        </div>',
                '      </div>',
                '    </div>',
                '  </div>',
            ].join('\n'));

            // add the new modal div to the body and show it!
            $(options.appendToSelector).append(div);
            div.find('.modal-body').html(data);
            div.modal(options.modal);
            div.find('.modal-dialog').css('width', options.width);

            if (!$.isEmptyObject(options.buttons)) {
                div.find('.modal-body').append('<div class="button-panel"></div>');
                let button_class = 'btn btn-primary';
                $.each(options.buttons, function (key, func) {
                    let button = $('<button class="' + button_class + '">' + key + '</button>');
                    div.find('.button-panel').append(button);
                    button.on('click.button-panel', function (evt) {
                        let closeDialog = true; // any button closes the dialog
                        if (func && func(evt) === false) {  // run the callback
                            closeDialog = false; // an explicit false returned from the callback stops the dialog close
                        }
                        if (closeDialog) {
                            div.modal('hide');
                        }
                    });
                    button_class = 'btn btn-default';  // only the first is the primary
                });
            }

            // event to remove the content on close
            div.on('hidden.bs.modal', function () {
                div.removeData();
                div.remove();
            });

            // event to drag the modal
            $(".modal-header").on("mousedown", function (mousedownEvt) {
                let $move = $(this);
                let body = $("body");
                let x = mousedownEvt.pageX - $move.offset().left,
                    y = mousedownEvt.pageY - $move.offset().top;
                body.on("mousemove.draggable", function (mousemoveEvt) {
                    $move.closest(".modal-dialog").offset({
                        "left": mousemoveEvt.pageX - x,
                        "top": mousemoveEvt.pageY - y
                    });
                });
                body.one("mouseup", function () {
                    $("body").off("mousemove.draggable");
                });
                $move.closest(".modal").one("bs.modal.hide", function () {
                    $("body").off("mousemove.draggable");
                });
            });

            // call the onShow function if there is one
            if (options.onShow) {
                options.onShow(div);
            }
        });

        // load the content from the server
        $.ajax(options.ajax);
    };

    $.showLoading = function () {
        $.blockUI({
            message: '<div class="loading"><i class="fa fa-refresh fa-spin"></i> Loading...</div>',
            css: {
                'border': 'none',
                'padding': '15px',
                'backgroundColor': '#000',
                'color': '#fff',
                'opacity': 0.5,
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                'border-radius': '10px',
                'z-index': 9999
            }
        });
    };

    $.hideLoading = function () {
        $.unblockUI();
    };

    $.showError = function (message) {
        $.blockUI({
            message: '<div class="error">' + message + '</div>',
            css: {
                'border': 'none',
                'padding': '15px',
                'backgroundColor': '#f00',
                'color': '#fff',
                'opacity': 0.5,
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                'border-radius': '10px',
                'z-index': 9999
            }
        });
        setTimeout($.unblockUI, 2000);
    };
})(jQuery);
