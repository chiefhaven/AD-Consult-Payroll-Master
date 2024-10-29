import './bootstrap';
import $ from 'jquery'; // Import jQuery
import 'datatables.net-dt'; // This imports both the DataTables JS and the default CSS.
import 'datatables.net-dt/css/jquery.dataTables.css'; // Include DataTables CSS

$(document).ready(function() {
    // Initialize DataTables for all tables with the class 'datatable'
    $('.datatable').DataTable({
        pageLength: 10,
        language: {
            search: "Search records:",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty: "No entries available",
            infoFiltered: "(filtered from _MAX_ total entries)",
            paginate: {
                next: "Next",
                previous: "Previous"
            }
        }
    });
});

