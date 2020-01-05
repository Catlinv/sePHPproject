$('document').ready(function() {
    const table = $('#categoryDT').DataTable({
        hideEmptyCols: true,
        "ajax": "/category"
    });

    $('#categoryDT tbody').on('click', 'tr', function () {
        const data = table.row( $(this) ).data();
        window.location.replace("/categories/"+data[0]);
    } );

    const table2 = $('#productsDT').DataTable({
        hideEmptyCols: true,
        "ajax": "/product"
    });

    $('#productsDT tbody').on('click', 'tr', function () {
        const data = table2.row( $(this) ).data();
        window.location.replace("/products/"+data[0]);
    } );

    const table3 = $('#ordersDT').DataTable({
        hideEmptyCols: true,
        "ajax": "/order"
    });

    // console.log(table3);

    $('#ordersDT tbody').on('click', 'tr', function () {
        const data = table3.row( $(this) ).data();
        window.location.replace("/orders/"+data[0]);
    } );

    const table4 = $('#orderHistoryDT').DataTable({
        hideEmptyCols: true,
        "ajax": "/order/history"
    });

    // console.log(table3);

    $('#orderHistoryDT tbody').on('click', 'tr', function () {
        const data = table4.row( $(this) ).data();
        window.location.replace("/orders/"+data[0]);
    } );

});