(function () {
    function escapeHtml(value) {
        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    function isDarkMode() {
        return document.documentElement.getAttribute('data-mode') === 'dark';
    }

    function attexSwal() {
        if (typeof Swal === 'undefined') {
            return null;
        }

        return Swal.mixin({
            buttonsStyling: false,
            customClass: {
                popup: 'attex-swal-popup',
                title: 'attex-swal-title',
                htmlContainer: 'attex-swal-text',
                confirmButton: 'attex-swal-confirm',
                cancelButton: 'attex-swal-cancel',
            },
            color: isDarkMode() ? '#cbd5e1' : '#475569',
            background: isDarkMode() ? '#313a46' : '#ffffff',
        });
    }

    function shouldSkipWarningPopup() {
        return /^\/inscricao\/?$/.test(window.location.pathname);
    }

    function showFlashMessages() {
        var flash = window.__dashboardFlash;
        var swal = attexSwal();

        if (!flash || !swal) {
            return;
        }

        if (flash.success) {
            swal.fire({
                icon: 'success',
                title: 'Sucesso',
                text: flash.success,
                confirmButtonText: 'OK',
            });
        }

        if (flash.warning && !shouldSkipWarningPopup()) {
            swal.fire({
                icon: 'warning',
                title: 'Atenção',
                text: flash.warning,
                confirmButtonText: 'OK',
            });
        }

        if (flash.errors && flash.errors.length) {
            swal.fire({
                icon: 'error',
                title: 'Erro',
                html: '<ul style="text-align:left;margin:0;padding-left:1.25rem;">'
                    + flash.errors.map(function (message) {
                        return '<li>' + escapeHtml(message) + '</li>';
                    }).join('')
                    + '</ul>',
                confirmButtonText: 'OK',
            });
        }
    }

    function bindDeleteConfirmations() {
        document.addEventListener('submit', function (event) {
            var form = event.target.closest('form.js-confirm-delete');
            var swal = attexSwal();

            if (!form || !swal) {
                return;
            }

            event.preventDefault();

            swal.fire({
                title: form.dataset.confirmTitle || 'Excluir registro?',
                text: form.dataset.confirmMessage || 'Esta ação não pode ser desfeita. Deseja continuar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim, excluir',
                cancelButtonText: 'Cancelar',
                reverseButtons: true,
                focusCancel: true,
                customClass: {
                    popup: 'attex-swal-popup',
                    title: 'attex-swal-title',
                    htmlContainer: 'attex-swal-text',
                    confirmButton: 'attex-swal-confirm attex-swal-confirm-danger',
                    cancelButton: 'attex-swal-cancel',
                },
            }).then(function (result) {
                if (result.isConfirmed) {
                    HTMLFormElement.prototype.submit.call(form);
                }
            });
        }, true);
    }

    document.addEventListener('DOMContentLoaded', function () {
        showFlashMessages();
        bindDeleteConfirmations();
    });
})();