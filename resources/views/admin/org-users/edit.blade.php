@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
<div class="container">
<div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">		
            <div class="panel panel-default" style="padding-left:50px;padding-top:40px;padding-bottom:75px;">

				<div class="panel-body">

						@if (session('msg'))
                        <div class="alert alert-danger">
                            {{ session('msg') }}
                        </div>
						@endif
						
						@if (session('msg'))
						<div class="alert-success">
							{{ session('msg') }}
						</div> @endif 
						
						<form action="{{url('editUserData')}}" name="userData" method="post" class="form-horizontal">
                        
                        {{csrf_field()}} 
                        <legend></legend>
						
							 <div class="form-group">
                                <div>
                                <input onclick="addValidate();" type="checkbox" id="is_admin" name="is_admin" @if($user->is_admin) checked @endif />
                                <label for="is_admin" class="col-md-4 col-form-label "><b>Is Org Admin</b></label>
                                </div>
                            </div>
												
						
                             <div class="form-group">
                                 <label for="name">Name</label>
                                 <input type="text" name="name" placeholder="name"class="form-control"value="{{$user->name}}"/>
								@if ($errors->has('name'))
                                <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
							 </div>
                            <!--  <div class="form-group">
                                    <label for="email">email</label>
                                    <input type="email" name="email" placeholder="email"class="form-control" value="{{$user->email}}"/>
                            </div> -->


							<div class="form-group row">
								<label id="phoneLabel" class="col-md-3"  for="phone">{{ __('Phone Number') }}</label>
								
								<input id="phone" type="text" value="{{$user->phone}}" max="10" class="form-control form-control-user" name="phone" value="{{ old('phone') }}" required placeholder="Phone Number">
								  {{-- @if ($errors->has('phone'))
								  <span class="invalid-feedback" role="alert">
									  <strong>{{ $errors->first('phone') }}</strong>
								  </span>
								  @endif --}}
									@if ($errors->has('phone'))
										<b style="color:red">{{$errors->first('phone')}}</b>
									@endif
								 
							</div>	
							
							<div class="form-group row date" data-provide="datepicker">
                
							<label for="dob" class="col-md-3 col-form-label">{{ __('Date Of Birth') }}</label>
							<div class="col-sm-6 mb-3 mb-sm-0">
								<input  name="dob" class="form-control form-control-user" value="{{ Carbon\Carbon::createFromTimestamp($user->dob)->format('d-m-Y') }}
								" placeholder="Date Of Birth">
								
								<div class="input-group-addon">
								  <span class="glyphicon glyphicon-th"></span>
								</div>
								@if ($errors->has('dob'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('dob') }}</strong>
								</span>
								@endif
							  </div>
						</div>
						
						<div class="form-group row">
						 <label for="gender" class="col-md-3 col-form-label">{{ __('Gender') }}</label>
						 <div class="col-sm-6 mb-3 mb-sm-0">
							<select name="gender" class="form-control" type="select" id="navbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							  <option {{ $user->gender == "male" ? 'selected="selected"' : '' }} value="male">Male</option>
							  <option {{ $user->gender == "female" ? 'selected="selected"' : '' }} value="female">Female</option>
							  <option {{ $user->gender == "other" ? 'selected="selected"' : '' }} value="other">Other</option>
							</select>
							</div>
							@if ($errors->has('gender'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('gender') }}</strong>
								</span>
							@endif
						</div>                           

                        <div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
							<label for="role_id" class="col-md-4 col-form-label ">Role</label>					  
							<div>
								<select id="role_id"  class="form-control" name="role_id" required>
									<option value="">Select Role</option>
									
									@if ($role)										
										@foreach($roles as $role)
											<option {{ $orgDetails['role_id'] == $role->id ? 'selected="selected"' : '' }} value={{$role['_id']}}>{{ $role['display_name']}}</option>
										@endforeach
									@endif

									@if ($roleId == '')										
										@foreach($roles as $role)
											<option  value={{$role['_id']}}>{{ $role['display_name']}}</option>
										@endforeach
									@endif


								</select>

								@if ($errors->has('role_id'))
									<span class="help-block">
										<strong>{{ $errors->first('role_id') }}</strong>
									</span>
								@endif
							</div>
                        </div>
                            
						<div class="form-group row">
							<label class="col-md-3 col-form-label required" id="addLabel">Address</label>
							
							<div class="col-sm-6 mb-3 mb-sm-0">
							@if ($errors->has('userAddress'))
                                <span class="help-block">
                                <strong>{{ $errors->first('userAddress') }}</strong>
                                </span>
                                @endif
								<input id="searchMapInput" class="mapControls" type="text" placeholder="Enter a location">
								<div id="map" style="width:100%;height:400px"></div>
							
							</div>
						</div>
						
						<div class="form-group">
							<div>
							@if($user->approve_status == 'approved')
							<input type="checkbox" name="approved"  checked disabled/>
							@else
							<input type="checkbox" name="approved" />
							@endif
							<label for="userActive" class="col-md-4 col-form-label ">Is Approved</label>
							</div>
						</div> 

							<input type="hidden" name="latval" id="latval" value="{{$orgDetails['lat']}}">
							<input type="hidden" name="longval" id="longval" value="{{$orgDetails['long']}}">
							<input type="hidden" name="userAddress" id="userAddress" value="{{$orgDetails['address']}}">
							<input type="hidden" name="id" id="id" value="{{$user->_id}}">

                            <input type="submit" value="Save" class="btn btn-primary btn-user btn-block"/>
                       
                    
                        </form> 
                        
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</div>
@endsection

<script type="text/javascript">
    var orgDetails = {!! json_encode($orgDetails) !!};
	console.log(orgDetails.address);
	
	
	function initMap() {
  // The location of Uluru
  var uluru = {lat:  parseFloat(orgDetails.lat), lng:  parseFloat(orgDetails.long)};
  // The map, centered at Uluru
  var map = new google.maps.Map(
	document.getElementById('map'), {zoom: 4, center: uluru});
  // The marker, positioned at Uluru
  var marker = new google.maps.Marker({position: uluru, map: map,  draggable: true});
  var infowindow = new google.maps.InfoWindow();

   infowindow.setContent('<div><strong>' + orgDetails.address + '</strong><br>' );
        infowindow.open(map, marker);
       
      var input = document.getElementById('searchMapInput');
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
   
    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);
  
    	
	
	    autocomplete.addListener('place_changed', function() { console.log('fdsfdsf');       
		//infowindow.close();
        // marker.setVisible(false);
        var place = autocomplete.getPlace();    
        /* If the place has a geometry, then present it on a map. */
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }
        marker.setIcon(({
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(35, 35)
        }));
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);
      
        var address = '';
        if (place.address_components) {
            address = [
              (place.address_components[0] && place.address_components[0].short_name || ''),
              (place.address_components[1] && place.address_components[1].short_name || ''),
              (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
        }
      
        infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
        infowindow.open(map, marker);
        
        /* Location details */
        //document.getElementById('location-snap').innerHTML = place.formatted_address;
        //document.getElementById('lat-span').innerHTML = place.geometry.location.lat();
        //document.getElementById('lon-span').innerHTML = place.geometry.location.lng();
		
		////document.getElementById('latval').value =  place.geometry.location.lat();
		//document.getElementById('longval').value = place.geometry.location.lng();
		//document.getElementById('userAddress').value =   place.name + ' , ' + address;
		
    });
	
	
	
	google.maps.event.addListener(marker, 'dragend', function(evt){
		//document.getElementById('current').innerHTML = '<p>Marker dropped: Current Lat: ' + evt.latLng.lat().toFixed(3) + ' Current Lng: ' + evt.latLng.lng().toFixed(3) + '</p>';
		//infowindow.setContent('<p>Marker dropped: Current Lat: ' + evt.latLng.lat().toFixed(3) + ' Current Lng: ' + evt.latLng.lng().toFixed(3) + '</p>');

		var latlng = {lat: parseFloat(evt.latLng.lat()), lng: parseFloat(evt.latLng.lng())};


		var geocoder= new google.maps.Geocoder();
		geocoder.geocode({'location': latlng}, function(results, status) {
			if (status === 'OK') {
				if (results[0]) {				
					map.setZoom(11);            
					infowindow.setContent(results[0].formatted_address);
					infowindow.open(map, marker);					
					
					document.getElementById('latval').value = parseFloat(evt.latLng.lat())
					document.getElementById('longval').value = parseFloat(evt.latLng.lng());
					document.getElementById('userAddress').value =  results[0].formatted_address;
					document.getElementById('searchMapInput').value =  results[0].formatted_address;
					
					
				} else {
				  window.alert('No results found');
				}
			} else {
				window.alert('Geocoder failed due to: ' + status);
			}
		});
	});


}

	
/*	function initMap() {
		
	//	console.log('hhhhhhhhhhhhhhh');
    var map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: parseFloat(orgDetails.lat), lng: parseFloat(orgDetails.long)},
        zoom: 20,
		mapTypeId: google.maps.MapTypeId.ROADMAP
    });
	
document.getElementById('searchMapInput').value =  orgDetails.address;
		
    var input = document.getElementById('searchMapInput');
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
   
    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);
  
    var infowindow = new google.maps.InfoWindow();
	
    
	
	// var directionsService = new google.maps.DirectionsService;
	
    var marker = new google.maps.Marker({
		 draggable: true,
        map: map,
        anchorPoint: new google.maps.Point(0, -29)
    });
	
		//infowindow.setContent('<div><strong>' + orgDetails.address + '</strong>');
    //infowindow.open(map, marker);
	
	
	
	
	
	
	
	
	var latlng = {lat: parseFloat(orgDetails.lat), lng: parseFloat(orgDetails.long)};
	var geocoder= new google.maps.Geocoder();
		geocoder.geocode({'location': latlng}, function(results, status) {
			if (status === 'OK') {
				console.log('hhhhhhhhhhhhhhhhhhhhh');
				if (results[0]) {

console.log('------------');					
					map.setZoom(11);      

 marker.setVisible(true);					
					infowindow.setContent(results[0].formatted_address);
					infowindow.open(map, marker);					
					
					////document.getElementById('latval').value = parseFloat(evt.latLng.lat())
					//document.getElementById('longval').value = parseFloat(evt.latLng.lng());
					////document.getElementById('userAddress').value =  results[0].formatted_address;
					document.getElementById('searchMapInput').value =  results[0].formatted_address;
					
					
				} else {
				  window.alert('No results found');
				}
			} else {
				window.alert('Geocoder failed due to: ' + status);
			}
		});
	
	
	
	
	
	
	
    
	
	google.maps.event.addListener(marker, 'dragend', function(evt){
		//document.getElementById('current').innerHTML = '<p>Marker dropped: Current Lat: ' + evt.latLng.lat().toFixed(3) + ' Current Lng: ' + evt.latLng.lng().toFixed(3) + '</p>';
		//infowindow.setContent('<p>Marker dropped: Current Lat: ' + evt.latLng.lat().toFixed(3) + ' Current Lng: ' + evt.latLng.lng().toFixed(3) + '</p>');

		var latlng = {lat: parseFloat(evt.latLng.lat()), lng: parseFloat(evt.latLng.lng())};


		var geocoder= new google.maps.Geocoder();
		geocoder.geocode({'location': latlng}, function(results, status) {
			if (status === 'OK') {
				if (results[0]) {				
					map.setZoom(11);            
					infowindow.setContent(results[0].formatted_address);
					infowindow.open(map, marker);					
					
					document.getElementById('latval').value = parseFloat(evt.latLng.lat())
					document.getElementById('longval').value = parseFloat(evt.latLng.lng());
					document.getElementById('userAddress').value =  results[0].formatted_address;
					document.getElementById('searchMapInput').value =  results[0].formatted_address;
					
					
				} else {
				  window.alert('No results found');
				}
			} else {
				window.alert('Geocoder failed due to: ' + status);
			}
		});
	});

	google.maps.event.addListener(marker, 'dragstart', function(evt){
		//  document.getElementById('current').innerHTML = '<p>Currently dragging marker...</p>';
  
  
	});
	map.setCenter(marker.position);
	marker.setMap(map); 
  
    autocomplete.addListener('place_changed', function() { console.log('fdsfdsf');       
		//infowindow.close();
        // marker.setVisible(false);
        var place = autocomplete.getPlace();    
        /* If the place has a geometry, then present it on a map. */
   /*     if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }
        marker.setIcon(({
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(35, 35)
        }));
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);
      
        var address = '';
        if (place.address_components) {
            address = [
              (place.address_components[0] && place.address_components[0].short_name || ''),
              (place.address_components[1] && place.address_components[1].short_name || ''),
              (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
        }
      
        infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
        infowindow.open(map, marker);
        
        /* Location details */
        //document.getElementById('location-snap').innerHTML = place.formatted_address;
        //document.getElementById('lat-span').innerHTML = place.geometry.location.lat();
        //document.getElementById('lon-span').innerHTML = place.geometry.location.lng();
		
	/*	document.getElementById('latval').value =  place.geometry.location.lat();
		document.getElementById('longval').value = place.geometry.location.lng();
		document.getElementById('userAddress').value =   place.name + ' , ' + address;
		
    });
}*/

</script>