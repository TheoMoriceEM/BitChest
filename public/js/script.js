/**
 * Manage mobile nav
 */
$(function () {
    $("#closeNav, #toggleNav").click(function() {
        $("#sidebar").toggleClass('hidden');
    });
});
