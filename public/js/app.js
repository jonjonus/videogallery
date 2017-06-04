$(function () {
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN' : csrf } });
});