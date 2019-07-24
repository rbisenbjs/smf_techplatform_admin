var levelCount=0;
var prevSelection=['null'];
var prevLevelId=null;   
var state_id=0;
var stateHasCluster=false;
var roleLevel="";
var mirId;

var url = window.location;
$('#errorMsg').hide();
// for sidebar menu entirely but not cover treeview
$('ul.sidebar-menu a').filter(function() {
	 return this.href == url;
}).parent().addClass('active');


$(document).on('change','#org_id',function(){
    console.log(this.value)
    jQuery.ajax({
        type: "GET",
        url: "/getRoles",
        data: { selectedOrg:this.value},
         success:function(result){
            
            var obj = JSON.parse(result);
           
            $('#role_id') .find('option')
            .remove()
            .end()
            $('#role_id').append('<option value="" >Select Role</option>')
            obj.forEach(element => {
                console.log(element.name+' '+element._id)
                $('#role_id').append('<option value="'+ element._id +'">'+element.name+'</option>');
            });
         }
       
      });
  });
  
  /*$('#org_id').change(function() {
    $('#JQResult').html('');
    $('option:selected', $(this)).each(function() {
      $('#JQResult').append(
        $('<li/>').html($(this).val())
      );
    });*/

  $(document).on('click','#addLevel',function(){
       prevLevelId='#level'+(levelCount+1);
     // console.log(prevLevelId)
      
      //console.log(prevSelection)
        levelCount++;
        var levelId='#level'+levelCount.toString();
        $(levelId) .find('option')
        .remove()
        .end();
     
      $('#levels').append('<div class="row form-group" ><p class="col-md-2">  Level '+ levelCount+'</p>'+
      '<select id="level' +levelCount +'" name="levels[]" class="form-control col-md-4" > <option value="null"></option> </select>' +
      '</div>')

        console.log(prevSelection)
      jQuery.ajax({
         
        type: "GET",
        url: "/getJurisdiction",
        data: { list: prevSelection },
         success:function(result){
             console.log(result)
            var obj = JSON.parse(result);
          
            var levelId='#level'+levelCount.toString();
          //  console.log(levelId)
           
            obj.forEach(element => {
                $(levelId).append('<option value="'+ element._id +'">'+element.levelName+'</option>')
                
            });
            //console.log($(levelId))
           
            console.log(prevSelection)
         }
       
      });
     
     

  })

  $(document).on('change','select',function(){
     
    prevSelection.push($(prevLevelId).find(":selected").text());
    //console.log(prevSelection)
  })

  
$(document).on('change','#role_id',function(){
   
   jQuery.ajax({
    type: "GET",
    url: "/getLevel",
    data: { role_id:this.value},
     success:function(result){
      
      $('#state_id2').find('option')
      .remove()
      .end();
      $('#jurisdiction').find('label').remove()
      $('#jurisdiction').find('select').remove()
      $('#state_id2').append('<option value=0"> </option>');
        var obj = JSON.parse(result);
        console.log(obj[0])
        roleLevel=obj[0];
        var states=obj[1];
        states.forEach((element)=>{
          $('#state_id2').append('<option value="'+element['_id']['$oid']+'">'+element.Name+'</option>');
        })
      
     }
   
  });
  
})
 
$(document).on('change','#state_id',function(){
  console.log(this.value)
  state_id=this.value;
 var levelPage=$('#levelPage').text();
  $('#levelContainer').find('div').remove().end();
 // $('#levelContainer').find('h4').remove().end();
 // $('#levelContainer').find('br').remove().end();
  jQuery.ajax({
    type: "GET",
   
    url: "/getJidandLevel",
    data: { stateId:this.value,flevel:levelPage},
     success:function(result){
         console.log(result);
        var obj = JSON.parse(result);
     
       obj.forEach((item)=>{
         if(item=='Cluster'){stateHasCluster=true; console.log('state has cluster '+stateHasCluster)}
        $('#levelContainer').append('<div class="row"><h5 class="col-md-3">'+item+'</h5><select class="form-control col-md-6" id="'+item+'" name="'+ item +'" ></select><br/><br/></div>')
        //ajax call to populate each select tag 
        var selectTagId='#'+item;
        $(selectTagId).find('option').remove().end();
        $(selectTagId).append('<option class="form-control value="0"></option>')
        jQuery.ajax({
          type: "GET",
          url: "/populateData",
          data: { item:item,state:state_id},
           success:function(result){
            var obj = JSON.parse(result);
             // console.log(obj)
             obj.forEach((item)=>{
               console.log(item['_id']['$oid'])
              $(selectTagId).append('<option class="form-control" value="'+item['_id']['$oid']+'">'+item.Name+'</option>')
             })
           }
         
        });

       })
       
     }
   
  });

})

$(document).on('change','#District',function(){
  var district=this.value;
  console.log(district)
  jQuery.ajax({
    type: "GET",
    url: "/populateData",
    data: { item:'Taluka',state:state_id, district:district},
     success:function(result){
        $('#Taluka').find('option').remove().end();
        $('#Taluka').append('<option class="form-control value="0"></option>')
        var obj = JSON.parse(result);
        console.log(obj)
        obj.forEach((item)=>{
          $('#Taluka').append('<option class="form-control" value="'+item['_id']['$oid']+'">'+item.Name+'</option>')
         })
        
     }
   
  });
})


$(document).on('change','#Taluka',function(){
  console.log('here')
  var taluka=this.value;
  console.log(taluka)
  var item='Village';
  //console.log('item:'+item+' stateID:'+state_id+' taluka: '+taluka  )
  if(stateHasCluster)item='Cluster'
  console.log('item:'+item+' stateID:'+state_id+' taluka: '+taluka  )
  jQuery.ajax({
    type: "GET",
    url: "/populateData",
    data: { item:item,state:state_id, taluka:taluka},
     success:function(result){
        itemId='#'+item
        $(itemId).find('option').remove().end();
        $(itemId).append('<option class="form-control value="0"></option>')
        var obj = JSON.parse(result);
        obj.forEach((item)=>{
          $(itemId).append('<option class="form-control" value="'+item['_id']['$oid']+'">'+item.Name+'</option>')
         })
        
     }
   
  });
})


$(document).on('change','#Cluster',function(){
  console.log('here')
  var cluster=this.value;
  console.log(cluster)
  var item='Village';
  
  console.log('item:'+item+' stateID:'+state_id+' cluster: '+cluster  )
  jQuery.ajax({
    type: "GET",
    url: "/populateData",
    data: { item:item,state:state_id, cluster:cluster},
     success:function(result){
       //console.log(result)
        itemId='#'+item
        $(itemId).find('option').remove().end();
        $(itemId).append('<option class="form-control value="0"></option>')
        var obj = JSON.parse(result);
        obj.forEach((item)=>{
          $(itemId).append('<option class="form-control" value="'+item['_id']['$oid']+'">'+item.Name+'</option>')
         })
        
     }
   
  });
})

$(document).on('change','#state_id2',function(){
  console.log(this.value)
  state_id=this.value;

  $('#jurisdiction').find('div').remove().end();
 // $('#levelContainer').find('h4').remove().end();
 // $('#levelContainer').find('br').remove().end();
  jQuery.ajax({
    type: "GET",
   
    url: "/getJidandLevel",
    data: { stateId:this.value,roleLevel:roleLevel},
     success:function(result){
       
        var obj = JSON.parse(result);
     console.log(obj)
       obj.forEach((item)=>{
         if(item=='Cluster'){stateHasCluster=true; console.log('state has cluster '+stateHasCluster)}
         if(item==obj[obj.length-1]) {

              $('#jurisdiction').append('<div class="row"><h5 class="col-md-3">'+item+'</h5><select multiple size=4 class="form-control col-md-6" id="'+item+'" name="'+ item +'[]" ></select><br/><br/></div>')
          }
         else
        $('#jurisdiction').append('<div class="row"><h5 class="col-md-3">'+item+'</h5><select class="form-control col-md-6" id="'+item+'" name="'+ item +'" ></select><br/><br/></div>')
        //ajax call to populate each select tag 
        var selectTagId='#'+item;
        $(selectTagId).find('option').remove().end();
        $(selectTagId).append('<option class="form-control value="0"></option>')
        jQuery.ajax({
          type: "GET",
          url: "/populateData",
          data: { item:item,state:state_id},
           success:function(result){
            var obj = JSON.parse(result);
             // console.log(obj)
             obj.forEach((item)=>{
              $(selectTagId).append('<option class="form-control" value="'+item['_id']['$oid']+'">'+item.Name+'</option>')
             })
           }
         
        });

       })
       
     }
   
  });

})

$(document).on('change','#orgid,#orgidedit',function() {
 
  var orgID = $(this).val();
  if (orgID) {
    $.ajax({
        url: '/getAjaxOrgId',
        type: "GET",
        data: {orgID : orgID},
        success:function(data) {
          var obj = JSON.parse(data); 
          $('select[name="project_id"]').empty();
          obj.forEach(element => {
            $('select[name="project_id').append('<option value="'+ element['_id']['$oid'] +'">'+element['name']+'</option>');
          });
        },
        error: function (data) {
          console.log('Error in ajax response:', data.responseText);
        }
    });
  } else {
      $('select[name="project_id"]').empty();
  }
})

// Used for creating a location
$(document).on('change','#jurisdictionType',function(){

  // Empties both div tags
  $('#jurisdictionTypeContainer').empty();
  $('#jurisdictionTypeContainer2').empty();

  // because an error occurs while fetching document.getElementById(this.value).innerText for value = 0
  if(this.value != 0)
  {
  // Obtains the value present between the option tag of the selected select option
  var result = document.getElementById(this.value).innerText;
  // Converting the string to an array of substrings using delimiter ','
  var jurisdictions = result.split(", ");

        var i = 0;

        // var item contains values such as state, district, taluka, etc.
        jurisdictions.forEach((item)=>{

        // Creates a new input tag for each item
        $('#jurisdictionTypeContainer').append('<div><h4>'+item+'</h4><input type="text" id="location'+i+'" name="level'+ 0 +'_location'+ i +'" class="form-control"></input><br/></div>')
        i = i + 1;

       });

      //  Creates a hidden input tag to pass the array of levels e.g. [state, district, taluka]
       $('#jurisdictionTypeContainer').append('<div><h5 class="col-md-3"></h5><input type="hidden" name="jurisdictionTypes" value="'+jurisdictions+'"></input><br/><br/></div><br>')

      }

})

// Used for adding another set of input tags for the selected location
  $('#addJurisdictionType').click(function(){

    // Cloning the div so as to get the same empty input tags and titles of the main div
      $('#jurisdictionTypeContainer').clone().appendTo('#jurisdictionTypeContainer2').find("input[type='text']").val("");

      $('#jurisdictionTypeContainer2').find("input[type='hidden']").remove();

      // To count number of divs contained inside the div having id = jurisdictionTypeContainer2
      var noOfTypes= $('#jurisdictionTypeContainer2').children().length;


      $('#jurisdictionTypeContainer2').append('<input type="hidden" name="noOfJurisdictionTypes" value="'+ noOfTypes +'" class="form-control"></input>')

      var i = 0;

      // For each input tag of the last div with id = jurisdictionTypeContainer we change the value of name to
      // store values like level0_location0, level0_location1, etc.
      $('#jurisdictionTypeContainer2 #jurisdictionTypeContainer:last').find('input').each(function(){
        $(this).attr('name', 'level'+ (noOfTypes) + '_location' + i);
        i++;

     });

})

// To remove a set of input tags for the selected location
$('#removeJurisdictionType').click(function(){

  // If div with id = jurisdictionTypeContainer2 has no child divs with id = jurisdictionTypeContainer
  // we empty the main div having id = jurisdictionTypeContainer
  if($('#jurisdictionTypeContainer2').find('#jurisdictionTypeContainer').length == 0)
      $('#jurisdictionTypeContainer').empty();
  else {
    // will remove the last child having id = jurisdictionTypeContainer of parent div with id = jurisdictionTypeContainer2 
    $('#jurisdictionTypeContainer2 #jurisdictionTypeContainer:last').remove();

    // Will return the number of children
    var noOfTypes= $('#jurisdictionTypeContainer2').children().length;

    // A hidden input tag that will help obtain in the controller the total number of enteries made
    $('#jurisdictionTypeContainer2').find("input[type='hidden']").val(noOfTypes-1); 
  }
})

// Used for editing a location
$(document).on('change','#editJurisdictionType',function(){

  // Empties both div tags
  $('#jurisdictionTypes').empty();
  $('#jurisdictionTypeContainer2').empty();

  // because an error occurs while fetching document.getElementById(this.value).innerText for value = 0
  if(this.value != 0)
  {
  // Obtains the value present between the option tag of the selected select option
  var result = document.getElementById(this.value).innerText;
  // Converting the string to an array of substrings using delimiter ','
  var jurisdictions = result.split(", ");
      
        var i = 0;

        // Since emptying div with id = jurisdictionTypes removes the div with id = jurisdictionTypeContainer
        // we append it again
        $('#jurisdictionTypes').append('<div id="jurisdictionTypeContainer"></div>');

        // var item contains values such as state, district, taluka, etc.
        jurisdictions.forEach((item)=>{
        
        // Creates a new input tag for each item
        $('#jurisdictionTypes #jurisdictionTypeContainer').append('<div><h4>'+item+'</h4><input type="text" id="location'+i+'" name="level'+ 0 +'_location'+ i +'" class="form-control"></input><br/></div>')
        i = i + 1;

       });

      // A hidden input tag that will keep a track of the number of enteries made
      $('#jurisdictionTypeContainer2').append('<input type="hidden" name="noOfJurisdictionTypes" value="'+ 1 +'" class="form-control"></input>');

       //  Creates a hidden input tag to pass the array of levels e.g. [state, district, taluka]
       $('#jurisdictionTypes').append('<input type="hidden" name="jurisdictionTypes" value="'+jurisdictions+'" class="form-control"></input>')
       
      }
})

// Used for adding a set of input tags when editing a location
$('#addJurisdictionTypeForEdit').click(function(){

  // If div with id = jurisdictionTypeContainer2 has no child divs with id = jurisdictionTypeContainer
  if (!$('#jurisdictionTypes').find('#jurisdictionTypeContainer').length){
   
    // To obtain the value of the option selected
    var result = $('#editJurisdictionType').find(":selected").text();
     // Converting the string to an array of substrings using delimiter ','
    var jurisdictions = result.split(", ");
      
        var i = 0;

        // Since div with id = jurisdictionTypes is empty
        $('#jurisdictionTypes').append('<div id="jurisdictionTypeContainer"></div>');

        // var item contains values such as state, district, taluka, etc.
        jurisdictions.forEach((item)=>{
        
        // Creates a new input tag for each item
        $('#jurisdictionTypes #jurisdictionTypeContainer').append('<div><h4>'+item+'</h4><input type="text" id="location'+i+'" name="level'+ 0 +'_location'+ i +'" class="form-control"></input><br/></div>')
        i = i + 1;
       });

      // A hidden input tag that will keep a track of the number of enteries made       
      $('#jurisdictionTypeContainer2').append('<input type="hidden" name="noOfJurisdictionTypes" value="'+ 1 +'" class="form-control"></input>');

      //  Creates a hidden input tag to pass the array of levels e.g. [state, district, taluka]
      $('#jurisdictionTypes').append('<input type="hidden" name="jurisdictionTypes" value="'+jurisdictions+'" class="form-control"></input>')
  } else {  // There are child divs present and so we append a new div to div with id = jurisdictionTypeContainer2
  $('#jurisdictionTypeContainer').clone().appendTo('#jurisdictionTypeContainer2').find("input[type='text']").val("");

  $('#jurisdictionTypeContainer2').find("input[type='hidden']").remove();

  // Obtains total number of child tags for divs with ids jurisdictionTypes & jurisdictionTypeContainer2
  var noOfTypes = $('#jurisdictionTypes').children('#jurisdictionTypeContainer').length + $('#jurisdictionTypeContainer2').children('#jurisdictionTypeContainer').length;

  $('#jurisdictionTypeContainer2').append('<input type="hidden" name="noOfJurisdictionTypes" value="'+noOfTypes+'" class="form-control"></input>')

  var i = 0;
  // For each input tag of the last div with id = jurisdictionTypeContainer we change the value of name to
  // store values like level0_location0, level0_location1, etc.
  $('#jurisdictionTypeContainer2 #jurisdictionTypeContainer:last').find('input').each(function(){
    $(this).attr('name', 'level'+ (noOfTypes - 1) + '_location' + i);
    i++;
 });
  }
})

// Used for removing a set of input tags when editing a location
$('#removeJurisdictionTypeForEdit').click(function(){

    // If div with id = jurisdictionTypeContainer2 has child divs with id = jurisdictionTypeContainer
    // we remove the last child div
    if ($('#jurisdictionTypeContainer2').find('#jurisdictionTypeContainer').length){

            $('#jurisdictionTypeContainer2 #jurisdictionTypeContainer:last').remove();

            // Obtains the total count of children present in both the divs
            var noOfTypes = $('#jurisdictionTypes').children('#jurisdictionTypeContainer').length + $('#jurisdictionTypeContainer2').children().length;

            // Changing the value of the hidden input tag of div jurisdictionTypeContainer2
            $('#jurisdictionTypeContainer2').find("input[type='hidden']").val(noOfTypes-1);
    }            
    else{      //If no children are present, we remove the last child div of parent div jurisdictionTypes
            $('#jurisdictionTypes').find('div').last().remove();

            // Obtaining the number of child div with id = jurisdictionTypeContainer present in parent 
            // div with id = jurisdictionTypes
            var oldTypes = $('#jurisdictionTypes').children('#jurisdictionTypeContainer').length;
            
            // Helps to obtain the value in the controller
            $('#jurisdictionTypeContainer2').append('<input type="hidden" name="noOfJurisdictionTypes" value="'+ oldTypes +'" class="form-control"></input>');
    }
})

/* to pop a warning message on delete of Jurisdiction if
** the Jurisdiction is associated with Jurisdiction Type
*/

$(document).on('click', '#edit-jusrisdiction,#delete-jusrisdiction', function() {

    var delJurisId = $(this).attr('value');
    var elemt_id = $(this).attr('id');
    var href_url = $(this).attr('href');
   
    
    $.ajax({
      url: '/checkJurisdictionTypeExist',
      type: "GET",
      data: {delJurisId : delJurisId},
      dataType: 'json',
      success: function (data) {
          //console.log(data.success);
          if (data.success === true) {
            $('#myModal').modal('show');
            return false;
          } else {
            if (elemt_id == 'delete-jusrisdiction') {
              $('#delete-jusrisdiction-form').attr('action', '/jurisdictions/'+delJurisId).submit();
            } else {
              window.location.href = href_url;
            }
        } 
      },
      error: function (data) {
          console.log('Error:', data);
      }
    });
    return false;
})

/* to populate jurisdiction types as per projects selected
** for roles authorization configuration
*/

$("#assigned_projects").change(function() {
    
    var projectId = $(this).val();
    $.ajax({
      url: "/getJurisdictionTypesByProjectId",
      type: "GET",
      data: {projectId : projectId},
      success: function (data) {

        var obj = JSON.parse(data); 
        if (obj.length !== 0) {
          $jurisTypeId = obj._id;
          
          $("#jurisdiction_type_id").val(JSON.stringify(obj.jurisdictions));
          $("#jurisdiction_id").append('<input type="hidden" name="jurisdictionId" value="'+ obj._id +'" class="form-control"></input>');

              var selectedValue = $("#levelNames").attr("value");
              
              $('#levelNames').empty();
              $('#levelNames').append('<option value=""></option>');

              obj.jurisdictions.forEach((value)=>{

                    if(value == selectedValue) {  
                      $('#levelNames').append('<option value="'+ value +'" selected="selected">'+value+'</option>');
                    } else {
                      $('#levelNames').append('<option value="'+ value +'">'+value+'</option>');
                    }
              })

        }
      },
      error: function (data) {
        console.log('Error in ajax response:', data.responseText);
      }
    });
}).change();

$("#organisationOfUser").change(function() {
    
  var org_id = $(this).val();
  $.ajax({
    url: "/getUsersOfOrganisation",
    type: "GET",
    data: {organisationId : org_id},
    success: function (data) {
      var obj = JSON.parse(data); 
      if (obj.length !== 0) {

            $('#userTable').empty();

            csrfValue = $('meta[name="csrf-token"]').attr('content');

            obj.forEach((user)=>{

                    $('#userTable').append('<tr>');
                    $('#userTable').append('<td>'+user.name+'</td>');
                    $('#userTable').append('<td>'+user.email+'</td>');
                    $('#userTable').append('<td>'+user.phone+'</td>');
                    $('#userTable').append('<td><div class="actions"><div style="float:left !important;padding-left:5px;"><a class="btn btn-primary btn-circle btn-sm" href="users/'+user._id+'/edit"><i class="fas fa-pen"></i></a></div><div style="float:left !important;padding-left:5px;"><form action="user/'+user._id+'" method="POST"><input type="hidden" name="_token" value="'+csrfValue+'"><input type="hidden" name="_method" value="DELETE"><button type="submit" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></button></form></div><div style="clear:both !important;"></div></div></td>');
                    // $('#userTable').append('<form action="user/'+user._id+'" method="POST">{{ csrf_field() }}{{ method_field("DELETE") }}');
                    $('#userTable').append('</tr>');
            })

      }
    },
    error: function (data) {
      console.log('Error in ajax response:', data.responseText);
    }
  });
})

$("#organisationRoles").change(function() {
    
  var org_id = $(this).val();
  $.ajax({
    url: "/getRolesOfOrganisation",
    type: "GET",
    data: {organisationId : org_id},
    success: function (data) {
      var obj = JSON.parse(data); 
      if (obj.length !== 0) {

            $('#roleTable').empty();

            csrfValue = $('meta[name="csrf-token"]').attr('content');

            obj.forEach((role)=>{
              console.log(role);

                    $('#roleTable').append('<tr>');
                    $('#roleTable').append('<td>'+role.display_name+'</td>');
                    $('#roleTable').append('<td>'+role.description+'</td>');
                    $('#roleTable').append(' <td><div class="actions"><div style="float:left !important;padding-left:5px;"><a class="btn btn-primary btn-circle btn-sm" href="role/'+role._id+'/edit"><i class="fas fa-pen"></i></a></div><div style="float:left !important;padding-left:5px;"><form action="role/'+role._id+'" method="POST"><input type="hidden" name="_token" value="'+csrfValue+'"><input type="hidden" name="_method" value="DELETE"><button type="submit" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></button></form></div><div style="clear:both !important;"></div></div></td>');
                    // $('#roleTable').append('<form action="user/'+user._id+'" method="POST">{{ csrf_field() }}{{ method_field("DELETE") }}<button type="submit" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></button></form></div>');
                    $('#roleTable').append('</tr>');
            })

      }
    },
    error: function (data) {
      console.log('Error in ajax response:', data.responseText);
    }
  });
})


/**
 * Datepicker script for user DOB
 */
/*$.fn.datepicker.defaults.format = "dd-mm-yyyy";
 $(function() {
   $(".datepicker").datepicker({
   format: 'dd-mm-yyyy',
   });
 });
 */
 
 window.setTimeout(function() {
    $(".alert-success").slideUp(1000, function(){
        $(this).remove(); 
    });
}, 4000);

 window.setTimeout(function() {
    $(".alert-danger").slideUp(1000, function(){
        $(this).hide(); 
    });
}, 4000);


function editFormData(orgId,surveyId) {
	
		console.log(orgId);
		jQuery.ajax({
        type: "POST",
        url: "http://localhost/smf_techplatform_php_new/public/editFormData",
		dataType: "json",
        data: { 
                orgId:orgId,
                surveyId:surveyId
				},
        success:function(res) {			
			if (res.code == 400) {
			  jQuery('.alert-danger').show();	
			  jQuery('.alert-danger').html(res.msg);			 
			} else {
			// jQuery('#editForm').modal('show');
			 jQuery('#editForm').modal('show')
			//jQuery('#editForm').modal('show');
			 //jQuery.getScript('edit_survey.js');
			 
			 
			 var script = document.getElementById("id");  // create a script DOM node
			//  script.src = 'http://localhost/smf_techplatform_php_new/public/js/edit_survey.js';  // set its src to the provided URL
			//script.id = 'id'; 
			script.surveyID =res.data.surveyID;
			script.value = res.data.surveyJson;
			//  document.head.appendChild(script);  //			 
				
			}
        }
      });	
	}

/**
*
*
*
**/
function setProject(projectId) {

	if (projectId != '') {
		
		jQuery.ajax({
        type: "POST",
        url: "http://localhost/smf_techplatform_php_new/public/setProject",
		dataType: "json",
        data: {  projectId:projectId },
        success:function(res) {		
				 
			if (res.code == 400) {
			  jQuery('.alert-danger').show();	
			  jQuery('.alert-danger').html(res.msg);			 
			} else {
					 
				location.reload(true);
			}
        }
      });		
	}
	console.log(projectId);
}

	
	$( '#create_mroservice_form' ).submit( function(event){
		event.preventDefault();		
		var data = new FormData( $( 'form#create_mroservice_form' )[ 0 ] );
	    $.ajax({
		  processData: false,
		  contentType: false,
		  data: data,
		  dataType: 'json',
		  type: 'POST',
		  url: 'http://localhost/smf_techplatform_php_new/public/createMicroservice',
		  success: function( res ){			  
			if (res.code == 400) {
			  jQuery('.alert-danger').show();	
			  jQuery('.alert-danger').html(res.msg);			 
			} else {					 
			//	location.reload(true);
			}
		  }
		});			
	 });
	 
	 
	 function editEntity(entyId) {
		 
		var _token = $("input[name='_token']").val();			
		jQuery.ajax({
        type: "POST",
        url: "http://localhost/smf_techplatform_php_new/public/editEntity",
		//dataType: "json",
        data: { entyId:entyId, _token:_token},
        success:function(res) {
			jQuery('#editForm').modal('show');
			jQuery('.alert-danger').hide();			
            jQuery('#editMcrs').html(res);			
        }
      });		 
	 } 
	 
	 jQuery( '#microservice-edit-form' ).submit( function(event){
		
		event.preventDefault();		
		var data = new FormData( $( 'form#microservice-edit-form' )[ 0 ] );
	    jQuery.ajax({
		  processData: false,
		  contentType: false,
		  data: data,
		  dataType: 'json',
		  type: 'POST',
		  url: 'http://localhost/smf_techplatform_php_new/public/updateMicroservice',
		  success: function( res ){			  
			if (res.code == 400) {
			  jQuery('.alert-danger').show();	
			  jQuery('.alert-danger').html(res.msg);			 
			} else {					 
			//	location.reload(true);
			}
		  }
		});			
	 });
	 
	jQuery( '#create_entity_form' ).submit( function(event){
		event.preventDefault();		
		var formData = new FormData( $( 'form#create_entity_form' )[ 0 ] );
		//alert('ggggggggggggggg');
	    jQuery.ajax({
		  processData: false,
		  contentType: false,
		  data: formData,
		  dataType: 'json',
		  type: 'POST',
		  url: 'http://localhost/smf_techplatform_php_new/public/createEntity',
		  success: function( res ){			  
			if (res.code == 400) {
			  jQuery('#errorMsg').show();
			  jQuery('.alert-danger').show();	
			  jQuery('.alert-danger').html(res.msg);			 
			} else {					 
				location.reload(true);
			}
		  }
		});			
	 });
	 
	 
	 jQuery( '#entity-edit-form' ).submit( function(event){
		
		event.preventDefault();		
		var data = new FormData( $( 'form#entity-edit-form' )[ 0 ] );
	    jQuery.ajax({
		  processData: false,
		  contentType: false,
		  data: data,
		  dataType: 'json',
		  type: 'POST',
		  url: 'http://localhost/smf_techplatform_php_new/public/updateEntity',
		  success: function( res ){			  
			if (res.code == 400) {
			  jQuery('.alert-danger').show();	
			  jQuery('.alert-danger').html(res.msg);			 
			} else {					 
				location.reload(true);
			}
		  }
		});			
	 });
	 
	 
	 function closeModel(id) {
		
		$('#'+id).modal('hide');	 
		 
	 }

	function deleteMicroservicesConfirmation(micrId) {
		
		mirId = micrId;		
		$('#deleteModel').modal('show');
			
	}


	function deleteMicroservices() {		
		
		var _token = $("input[name='_token']").val();	
		jQuery.ajax({		  
		  data: {micrId:mirId, _token:_token},
		  dataType: 'json',
		  type: 'POST',
		  url: 'http://localhost/smf_techplatform_php_new/public/deleteMicroservice',
		  success: function( res ){			  
			if (res.code == 400) {
			  jQuery('.alert-danger').show();	
			  jQuery('.alert-danger').html(res.msg);			 
			} else {
				$('#deleteModel').modal('hide');				
				location.reload(true);
			}
		  }
		});		
			
	}



function addValidate() {
	
	var checkBox = document.getElementById("is_admin");

	// If the checkbox is checked, display the output text
	if (checkBox.checked == true){
		//var element = document.getElementById("emailLadel");
		 $("#emailLadel").addClass("required");
		 document.getElementById("email").required = true;
		 document.getElementById("phone").required = false;
		 $("#phoneLabel").removeClass("required");
		 $("#addLabel").removeClass("required");
		
	} else {
		 $("#emailLadel").removeClass("required");
		 document.getElementById("email").required = false;
		 document.getElementById("phone").required = true;
		 $("#phoneLabel").addClass("required");
		 $("#addLabel").addClass("required");
	}

}

function validateForm() {
	
	
	if ( $("#addLabel").hasClass('required')) {
		if (document.getElementById('latval').value != '' 
		&& document.getElementById('longval').value != "" 
		&& document.getElementById('userAddress').value != "") {
			$('#addressId').html('');
			return true;
		} else {
			$('#addressId').show();
			$('#addressId').html('Please select/enter address');
			return false;
		}
	}
	return true;	
	
}

	 

		