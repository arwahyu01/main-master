/* jshint esversion: 11 */
(function ($) {
    $.loadModal = function (options) {
        // Allow a simple URL to be passed as the single option
        if (typeof options === 'string') {
            options = {url: options};
        }

        // Set default options
        options = $.extend(true, {
            url: null,                               // Convenience URL setting
            id: 'jquery-load-modal-js',              // Modal ID
            idBody: 'jquery-load-modal-js-body',     // Modal body ID
            appendToSelector: 'body',                // Element to append the modal to
            title: window.document.title || 'Dialog',// Modal title
            width: '400px',                          // Modal width (CSS value)
            dlgClass: 'fade',                        // Additional CSS class for the modal
            size: 'modal-lg',                        // Modal size class
            closeButton: true,                       // Show close button (X)
            buttons: {},                             // Custom buttons with callback functions
            modal: {},                               // Options passed to Bootstrap modal
            ajax: {                                  // Options for AJAX request
                url: null,                           // Required (can also be set via `url` above)
            },
            beforeShow: null,                        // Callback before showing the modal
            bgClass: 'secondary',                    // Background class for header/footer
            onShow: null,                            // Callback when modal is shown
            btnStyle: '',                            // Custom style for buttons
        }, options);

        // Ensure a URL is provided
        options.ajax.url = options.ajax.url || options.url;
        if (!options.ajax.url) {
            throw new Error('$().loadModal requires a URL.');
        }

        // Close any existing modal with the same ID
        $('#' + options.id).modal('hide');

        // Create AJAX success responder
        options.ajax.success = [].concat(options.ajax.success || []);
        options.ajax.success.unshift(function (data, status, xhr) {
            if (options.beforeShow && options.beforeShow(data, status, xhr) === false) {
                return;
            }

            // Build modal HTML
            const headTitle = options.title;
            const submitClass = headTitle.replace(/\s+/g, '-').toLowerCase();
            const modalHtml = `
                <div id="${options.id}" class="modal ${options.dlgClass}" role="dialog" aria-labelledby="modalLabel${options.bgClass}">
                    <div class="modal-dialog ${options.size}" role="document">
                        <div class="modal-content">
                            <div class="modal-header border-bottom ${options.bgClass}" style="cursor: move;" title="Click & drag modal">
                                <h4 class="modal-title" style="cursor: default;" id="modalLabel${options.bgClass}">${options.title}</h4>
                                ${options.closeButton ? '<button class="btn-close" data-bs-dismiss="modal" type="button"></button>' : ''}
                            </div>
                            <div id="${options.idBody}" class="modal-body"></div>
                            <div class="modal-footer">
                                <button class="btn btn-sm btn-secondary" data-bs-dismiss="modal"><i class="fa fa-ban"></i> Batal</button>
                                <button type="button" class="pull-right btn btn-sm btn-primary submit-data btn-${options.bgClass} submit-${submitClass}" style="${options.btnStyle}">
                                    <i class="fa fa-refresh fa-spin loading" style="display:none;"></i><i class="fa fa-save"></i> ${options.title}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>`;

            // Append and show modal
            const $modal = $(modalHtml).appendTo(options.appendToSelector);
            $modal.find('.modal-body').html(data);
            $modal.modal(options.modal);
            $modal.find('.modal-dialog').css('width', options.width);

            // Add custom buttons
            if (!$.isEmptyObject(options.buttons)) {
                const $buttonPanel = $('<div class="button-panel"></div>').appendTo($modal.find('.modal-body'));
                let buttonClass = 'btn btn-primary';
                $.each(options.buttons, (key, callback) => {
                    const $button = $(`<button class="${buttonClass}">${key}</button>`).appendTo($buttonPanel);
                    $button.on('click', function (evt) {
                        if (callback && callback(evt) === false) {
                            return;
                        }
                        $modal.modal('hide');
                    });
                    buttonClass = 'btn btn-default';
                });
            }

            // Cleanup on close
            $modal.on('hidden.bs.modal', () => $modal.remove());

            // Enable dragging
            $modal.find('.modal-header').on('mousedown', function (mousedownEvt) {
                const $dialog = $(this).closest('.modal-dialog');
                const offset = $dialog.offset();
                const startX = mousedownEvt.pageX - offset.left;
                const startY = mousedownEvt.pageY - offset.top;

                $(document).on('mousemove.draggable', (mousemoveEvt) => {
                    $dialog.offset({
                        left: mousemoveEvt.pageX - startX,
                        top: mousemoveEvt.pageY - startY,
                    });
                }).one('mouseup', () => $(document).off('mousemove.draggable'));
            });

            // Call onShow callback
            if (options.onShow) {
                options.onShow($modal);
            }
        });

        // Execute AJAX request
        $.ajax(options.ajax);
    };

    $.showLoading = function () {
        $.blockUI({
            message: '<div class="loading"><i class="fa fa-refresh fa-spin"></i> Loading...</div>',
            css: {
                border: 'none',
                padding: '15px',
                backgroundColor: '#000',
                color: '#fff',
                opacity: 0.5,
                borderRadius: '10px',
                zIndex: 9999,
            },
        });
    };

    $.hideLoading = function () {
        $.unblockUI();
    };

    $.showError = function (message) {
        $.blockUI({
            message: `<div class="error">${message}</div>`,
            css: {
                border: 'none',
                padding: '15px',
                backgroundColor: '#f00',
                color: '#fff',
                opacity: 0.5,
                borderRadius: '10px',
                zIndex: 9999,
            },
        });
        setTimeout($.unblockUI, 2000);
    };
})(jQuery);
