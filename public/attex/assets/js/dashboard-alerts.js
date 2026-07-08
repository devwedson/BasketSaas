(function () {
    function escapeHtml(value) {
        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    function showFlashMessages() {
        var flash = window.__dashboardFlash;

        if (!flash || typeof Swal === 'undefined') {
            return;
        }

        if (flash.success) {
            Swal.fire({
                icon: 'success',
                title: 'Sucesso',
                text: flash.success,
                confirmButtonText: 'OK',
                confirmButtonColor: '#3e60d5',
            });
        }

        if (flash.warning) {
            Swal.fire({
                icon: 'warning',
                title: 'Atenção',
                text: flash.warning,
                confirmButtonText: 'OK',
                confirmButtonColor: '#3e60d5',
            });
        }

        if (flash.errors && flash.errors.length) {
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                html: '<ul style="text-align:left;margin:0;padding-left:1.25rem;">'
                    + flash.errors.map(function (message) {
                        return '<li>' + escapeHtml(message) + '</li>';
                    }).join('')
                    + '</ul>',
                confirmButtonText: 'OK',
                confirmButtonColor: '#3e60d5',
            });
        }
    }

    function bindDeleteConfirmations() {
        document.addEventListener('submit', function (event) {
            var form = event.target.closest('form.js-confirm-delete');

            if (!form) {
                return;
            }

            event.preventDefault();

            Swal.fire({
                title: form.dataset.confirmTitle || 'Excluir registro?',
                text: form.dataset.confirmMessage || 'Esta ação não pode ser desfeita. Deseja continuar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sim, excluir',
                cancelButtonText: 'Cancelar',
                reverseButtons: true,
                focusCancel: true,
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