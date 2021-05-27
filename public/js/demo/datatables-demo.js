// Call the dataTables jQuery plugin
$(document).ready(function() {
    reloadDataTable = $('#dataTable').DataTable({ searching: false, pageLength: 50 });
});