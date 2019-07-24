$(document).ready(function () {
    var table = null;  
      var locationNames = $('#locationIndex').find(":selected").text();
      var jurisdictions = locationNames.split(", ");
      var tableHeaders;
      tableHeaders += "<th></th><th>"+ 'id' +"</th>";
      var columnData = [];
      var locationData;
      
      columnData.push({
        data: null,
        defaultContent: '',
        className: 'select-checkbox',
        orderable: false
        });
      columnData.push({ 'data':'_id' });
        var i = [1] ;
        var j = 1;

      jurisdictions.forEach((jurisdiction)=>{
          jurisdiction = jurisdiction.trim();
          tableHeaders += "<th>"+ jurisdiction +"</th>";
          columnData.push({ 'data' : jurisdiction.toLowerCase()+'.name'});
          columnData.push({ 'data' : jurisdiction.toLowerCase()+'._id'});
          tableHeaders += "<th>"+ jurisdiction.toLowerCase()+'_id' +"</th>";
          j = j + 2;
          i.push(j);
      });      

      $("#location").empty();    
      $("#location").append('<thead><tr>' + tableHeaders + '</tr></thead>');                
      
      table = $('#location').DataTable({
          "ajax": {
              "url": "http://localhost/smf_techplatform_php_new/public/getLocations",
              "data": {
                  "locationNames": locationNames,
                  "jurisdictionTypeId":$('#locationIndex').find(":selected").val()
              },
            },
      "ordering": false,
      "columns": columnData,
      "columnDefs":[
          {"targets": i, "visible": false, "defaultContent": '',"searchable": false},
          {"targets":0, "orderable": false, "className": 'select-checkbox'}
      ],
      select: {
          style:    'os',
          selector: 'td:first-child'
      },
  });

$(document).on('change','#jurisdictionType',function(){
            
            $("#location").dataTable().fnDestroy()
      var locationNames = $('#locationIndex').find(":selected").text();
      var jurisdictions = locationNames.split(", ");
      var tableHeaders;
      tableHeaders += "<th></th><th>"+ 'id' +"</th>";
      var columnData = [];
      var locationData;
      
      columnData.push({
        data: null,
        defaultContent: '',
        className: 'select-checkbox',
        orderable: false
        });
      columnData.push({ 'data':'_id' });
        var i = [1] ;
        var j = 1;

      jurisdictions.forEach((jurisdiction)=>{
          jurisdiction = jurisdiction.trim();
          tableHeaders += "<th>"+ jurisdiction +"</th>";
          columnData.push({ 'data' : jurisdiction.toLowerCase()+'.name'});
          columnData.push({ 'data' : jurisdiction.toLowerCase()+'._id'});
          tableHeaders += "<th>"+ jurisdiction.toLowerCase()+'_id' +"</th>";
          j = j + 2;
          i.push(j);
      });      

      $("#location").empty();    
      $("#location").append('<thead><tr>' + tableHeaders + '</tr></thead>');                
      
      table = $('#location').DataTable({
          "ajax": {
              "url": "http://localhost/smf_techplatform_php_new/public/getLocations",
              "data": {
                  "locationNames": locationNames,
                  "jurisdictionTypeId":this.value
              },
            },
      "ordering": false,
      "columns": columnData,
      "columnDefs":[
          {"targets": i, "visible": false, "defaultContent": '',"searchable": false},
          {"targets":0, "orderable": false, "className": 'select-checkbox'}
      ],
      select: {
          style:    'os',
          selector: 'td:first-child'
      },
  });
    });
  $('#location tbody').on( 'click', 'tr', function () {

      if ( $(this).hasClass('selected') ) {
          $(this).removeClass('selected');
      }
      else {
          table.$('tr.selected').removeClass('selected');
          $(this).addClass('selected');
      }
  } );

  $('#editRow').click( function () {
      
      var locationNames = $('#locationIndex').find(":selected").text();
      locations = locationNames.toLowerCase();
      
      var jurisdictions = locations.split(", ");

      var rowData = table.row( '.selected' ).data();
      $('#editModalBody').empty();

      $.ajax({
          url: "/getDetailedLocation",
          type: "GET",
          data:{locationNames:locationNames},
          success: function (data) {
              var obj = JSON.parse(data); 

              jurisdictions.forEach((jurisdiction) => {

                  jurisdiction = jurisdiction.trim();
      
      $('#editModalBody').append(jurisdiction+': <select id="'+jurisdiction+'" name="'+jurisdiction+'_id" class="form-control">');
          obj[jurisdiction].forEach((element) => {
              if(element._id.$oid == rowData[jurisdiction]._id)
                  $('#'+jurisdiction).append('<option value="'+element._id.$oid+'" class="form-control" selected="selected">'+element.name+'</option>');             
              else
                  $('#'+jurisdiction).append('<option value="'+element._id.$oid+'" class="form-control">'+element.name+'</option>');             
          });
      $('#editModalBody').append('</select></br>');

      $('#editModalBody').append('<input type="hidden" name="_id" value="'+rowData._id+'">');
      });
  }
  });

  } );

  $('#addRow').click( function () {
      $('#addModalBody').empty();

      var locationNames = $('#locationIndex').find(":selected").text();
      locations = locationNames.toLowerCase();

      var jurisdictions = locations.split(", ");

      $.ajax({
          url: "/getDetailedLocation",
          type: "GET",
          data:{locationNames:locationNames},
          success: function (data) {
              var obj = JSON.parse(data); 

              jurisdictions.forEach((jurisdiction) => {
                  
                jurisdiction = jurisdiction.trim();

                  $('#addModalBody').append(jurisdiction+': <select id="'+jurisdiction+'" name="'+jurisdiction+'_id" class="form-control">');
                  $('#'+jurisdiction).append('<option value="" class="form-control"></option>');             
                      obj[jurisdiction].forEach((element) => {
                  $('#'+jurisdiction).append('<option value="'+element._id.$oid+'" class="form-control">'+element.name+'</option>');             
                  });
                  $('#addModalBody').append('</select></br>');
                  });
      }
  });

  } );

  $('#deleteRow').click( function (e) {
	  e.preventDefault();
      var rowData = table.row( '.selected' ).data();
	  if (typeof rowData === 'undefined') {
		  return false;
	  }

		$.ajaxSetup({
		   headers: {
			   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		   }
	   });
      $.ajax({
		  type: "POST",
		  url: "/deleteLocation",
		  data: {'id': rowData._id},
		  success: function(data) {
			  var response = JSON.parse(data);
			  if (response.status === 'success') {
				  table.row('.selected').remove().draw( false );
			  }
		  },
		  error: function(jqXHR, textStatus, errorThrown) {
			  console.log(errorThrown);
		  }
	  });
  } );
});