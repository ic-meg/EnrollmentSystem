(function() {
    'use strict';
    
    if ($.fn.DataTable.isDataTable('#dataTables-example')) {
        $('#dataTables-example').DataTable().destroy();
    }
    
    $('#dataTables-example').DataTable({
        responsive: true,
        pageLength: 7, 
        lengthChange: false,
        searching: true,
        ordering: false
    });
})();
