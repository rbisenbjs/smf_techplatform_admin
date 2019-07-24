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
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                        <h3>Create User</h3>
                    <form id="createUserForm" onsubmit="return validateForm()" name="createUserForm" action="{{url('store')}}" method="post" class="form-horizontal">
                           {{csrf_field()}}

						<div class="form-group row">
							<label class="col-md-3 col-form-label"><b>Is Org Admin</b></label>
							<div class="col-sm-6 mb-3 mb-sm-0">
							<input onclick="addValidate();" type="checkbox" name="is_admin" checked id="is_admin" />
							</div>
						</div>

						   
                        <div class="form-group row">
                            <label  class="col-md-3 required" for="name"  >Name</label>
                            <div class="col-sm-3">
                                <input id="name" type="text" class="form-control form-control-user" placeholder="Name" name="name" value="{{ old('name') }}" required autofocus>
                                @if ($errors->has('name'))
                                <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>							 
                        </div>
						
						<!-- </div> -->
						<div class="form-group row">
							<label id="emailLadel" for="email" class="col-md-3 required" >Email</label>
							<div class="col-sm-6 mb-3 mb-sm-0">
							  <input id="email" type="email" class="form-control form-control-user" name="email" value="{{ old('email') }}" required placeholder="E-Mail Address">
								@if ($errors->has('email'))
									<span class="help-block">
										<strong>{{ $errors->first('email') }}</strong>
									</span>
								@endif
							</div>
						</div>
                <div class="form-group row">
                <label for="password" class="col-md-3 required">Password</label>
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input id="password" type="password" class="form-control form-control-user" name="password" required placeholder="Password">
                      @if ($errors->has('password'))
                          <span class="help-block">
                              <strong>{{ $errors->first('password') }}</strong>
                          </span>
                      @endif
                  </div>
                 
                </div>
                <div class="form-group row">
                <label id="phoneLabel" class="col-md-3"  for="phone">{{ __('Phone Number') }}</label>
                <div class="col-sm-6 mb-3 mb-sm-0 required">
                <input id="phone" type="text" class="form-control form-control-user" name="phone" value="{{ old('phone') }}" required placeholder="Phone Number">
                  {{-- @if ($errors->has('phone'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('phone') }}</strong>
                  </span>
                  @endif --}}
                    @if ($errors->has('phone'))
                        <b style="color:red">{{$errors->first('phone')}}</b>
                    @endif
                  </div>
                </div>
                <div class="form-group row date" data-provide="datepicker">
                
                <label for="dob" class="col-md-3 col-form-label">{{ __('Date Of Birth') }}</label>
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <input  name="dob" class="form-control form-control-user" placeholder="Date Of Birth">
                    
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
                      <option value="male">Male</option>
                      <option value="female">Female</option>
                      <option value="other">Other</option>
                    </select>
                    </div>
                    @if ($errors->has('gender'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('gender') }}</strong>
                        </span>
                    @endif
                </div>
              
                <div class="form-group row">
				
					<label for="role_id" class="col-md-3 col-form-label required">Role</label>
					<div class="col-sm-6 mb-3 mb-sm-0">
					
						<select id="role_id"  class="form-control" name="role_id" required>
							@foreach($roles as $role)
								<option value={{$role['_id']}}>{{ $role['display_name']}}</option>
							@endforeach
						</select>
						{{-- @if ($errors->has('role_id'))
						  <span class="help-block">
							  <strong>{{ $errors->first('role_id') }}</strong>
						  </span>
						@endif   --}}
						@if ($errors->has('role_id'))   
						<b style="color:red">{{$errors->first('role_id')}}</b>
						@endif						
					</div>
                </div>
				
				<div class="form-group row">
                    <label class="col-md-3 col-form-label required" id="addLabel">Address</label>
					
                    <div class="col-sm-6 mb-3 mb-sm-0">
						<input id="searchMapInput" class="mapControls" type="text" placeholder="Enter a location">
						<div id="map" style="width:100%;height:400px"></div>
					
                    </div>
                </div>
				
				<input type="hidden" name="latval" id="latval">
				<input type="hidden" name="longval" id="longval">
				<input type="hidden" name="userAddress" id="userAddress">

				<div id="addressId"  class="alert alert-danger"></div>				
                <button type="submit" value="Save" class="btn btn-primary btn-user">Save</button>                
                </form>
                        
                </div>
            </div>
			

        </div>
     
    </div>
    </div>
    </div>
</div>
@endsection

<script>

function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: 22.3038945, lng: 70.80215989999999},
        zoom: 20,
		mapTypeId: google.maps.MapTypeId.ROADMAP
    });
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
  
    autocomplete.addListener('place_changed', function() {        
		infowindow.close();
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
		
		document.getElementById('latval').value =  place.geometry.location.lat();
		document.getElementById('longval').value = place.geometry.location.lng();
		document.getElementById('userAddress').value =   place.name + ' , ' + address;
    });
}

</script>
