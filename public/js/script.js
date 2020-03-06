$(function () {
    // Manage mobile nav
    $("#closeNav, #toggleNav").click(function() {
        $("#sidebar").toggleClass('hidden');
    });

    // DataTable
    $('.datatable:not(.custom)').DataTable({
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
        }
    });

    // Buying form
    $('.buying_options').change(function() {
        const input = $(this).val();
        $(`.buying-inputs#${input}`).show();
        $(`.buying-inputs#${input} input[type="number"]`).attr('required', 'required');
        $(`.buying-inputs:not(#${input})`).hide();
        $(`.buying-inputs:not(#${input}) input[type="number"]`).removeAttr('required');
    });

    // Trigger tooltips
    $('[data-toggle="tooltip"]').tooltip();
});
