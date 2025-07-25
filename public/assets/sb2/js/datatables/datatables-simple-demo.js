
    let table, tableData = {};

    window.addEventListener('DOMContentLoaded', (event) => {
        // DataTable for #datatablesSimple
        const datatablesSimple = document.getElementById('datatablesSimple');
        if (datatablesSimple) {
            table = new DataTable(datatablesSimple, configration || {});
        }

        // DataTable for #simpleDatatable (if it's a different table)
        const simpleDatatable = document.getElementById('simpleDatatable');
        if (simpleDatatable) {
             new simpleDatatables.DataTable(simpleDatatable);
        }
    });
