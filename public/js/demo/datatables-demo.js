// Call the dataTables jQuery plugin
$(document).ready(function() {
 // $('#dataTable').DataTable();
  
   $('#dataTable').DataTable( {
        //"pagingType": "full_numbers",
		"language": {
		"paginate": {
			"next": '<i class="ni ni-bold-right"></i>',
			"previous": '<i class="ni ni-bold-left"></i>'
		}
  },
    } );
});
