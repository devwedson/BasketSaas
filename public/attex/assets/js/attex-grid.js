window.AttexGrid = {
    render: function (elementId, config) {
        var target = document.getElementById(elementId);

        if (!target || typeof gridjs === 'undefined') {
            return;
        }

        var columns = (config.columns || []).map(function (column) {
            if (typeof column === 'string') {
                return column;
            }

            var definition = {
                name: column.name,
                sort: column.sort !== false,
            };

            if (column.width) {
                definition.width = column.width;
            }

            if (column.html) {
                definition.formatter = function (cell) {
                    return gridjs.html(cell || '');
                };
            }

            return definition;
        });

        return new gridjs.Grid({
            columns: columns,
            data: config.data || [],
            className: {
                container: 'w-full',
                table: 'w-full',
            },
            pagination: {
                limit: config.pageSize || 10,
            },
            search: config.search !== false,
            sort: config.sort !== false,
            language: {
                search: {
                    placeholder: 'Buscar...',
                },
                pagination: {
                    previous: 'Anterior',
                    next: 'Próximo',
                    showing: 'Exibindo',
                    of: 'de',
                    to: 'a',
                    results: 'registros',
                },
                loading: 'Carregando...',
                noRecordsFound: 'Nenhum registro encontrado',
                error: 'Erro ao carregar os dados',
            },
        }).render(target);
    },

    initAll: function () {
        document.querySelectorAll('[data-attex-grid]').forEach(function (element) {
            var config = {};

            try {
                config = JSON.parse(element.dataset.attexGrid || '{}');
            } catch (error) {
                return;
            }

            window.AttexGrid.render(element.id, config);
        });
    },
};

document.addEventListener('DOMContentLoaded', function () {
    window.AttexGrid.initAll();
});