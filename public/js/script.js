$(function () {
    // Manage mobile nav
    $("#closeNav, #toggleNav").click(function() {
        $("#sidebar").toggleClass('hidden');
    });

    // DataTable
    $('.datatable').DataTable({
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
        }
    });

    // Buying form
    $('.buying_options').change(function() {
        const input = $(this).val();
        $(`.buying-inputs#${input}`).show();
        $(`.buying-inputs:not(#${input})`).hide();
    });

    // Trigger tooltips
    $('[data-toggle="tooltip"]').tooltip()
});
