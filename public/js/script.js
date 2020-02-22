$(function () {
    // Manage mobile nav
    $("#closeNav, #toggleNav").click(function() {
        $("#sidebar").toggleClass('hidden');
    });

    // DataTable
    $('.datatable').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
        }
    });
});
