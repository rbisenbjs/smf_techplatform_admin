@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
<!-- Begin Page Content -->
<div class="container-fluid">

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h3>Location</h3><br/>
                    
                    <form action="locations" method="post">
                    {{csrf_field()}}     
                    
                        <div id="locationIndex">
                          <div style="float:left;">
                          <div style="text-align:left;">
                            <div style="border:0px solid red;float:left;padding-top:10px;margin-right:15px;" class="text">
                            <span style="font-size:1.3rem;">Jurisdiction Type</span>
                            </div>
                            <div style="border:0px solid blue;float:right;">
                              <select id="jurisdictionType" style="max-width:100%;" name="jurisdiction_type_id" class="form-control">
                                    <option value=""></option>

                                      @foreach($jurisdictions as $jurisdiction)
                                        {{ $jurisdictionLevels = "" }}
                                        {{ $i = true }}
                                        {{ $first = $loop->first }}

                                        @foreach($jurisdiction->jurisdictions as $type)
                                        
                                            @if($i != true)
                                            {{ $jurisdictionLevels = $jurisdictionLevels.", ".$type }}
                                            @else
                                            {{ $jurisdictionLevels = $type }}
                                            {{ $i = false }}
                                            @endif
                                        @endforeach
                                        <option id={{$jurisdiction->id}} value={{$jurisdiction->id}} {{ $first ? 'selected="selected"' : '' }}> {{ $jurisdictionLevels }}</option>
                                      @endforeach
                              </select>
                            </div>
                            <div style="clear:both;">&nbsp;</div>
                          </div>
                          <!-- <div style="clear:both;">&nbsp;</div> -->
                          </div>
                          <div style="clear:both;"></div>
                          <div style="clear:both;"></div>
                          <div style="float:left;">
                          <input type="hidden" name="created_by" value="{{Auth::user()->id}}">
                    
                        <!--<input type="submit" class="btn btn-primary btn-icon-split" value="Delete Selected Row" id="deleteRow"> -->

                        <button type="button" class="btn btn-primary btn-icon-split" id="deleteRow">
                          <span class="icon text-white-50">
                          <i class="fas fa-trash"></i>
                          </span>
                          <span class="text">Delete Selected Row</span>
                        </button>
                        <button type="button" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#editModal" id="editRow">
                          <span class="icon text-white-50">
                            <i class="fas fa-pen"></i>
                          </span>
                          <span class="text">Edit Selected Row</span>
                        </button>
                        <button type="button" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#addModal" id="addRow">
                          <span class="icon text-white-50"><i class="fas fa-plus"></i></span>
                          <span class="text">Add New Row</span>
                        </button>

                          
                          </div>
                          <div style="clear:both;"></div>
                        </div>
                        <div>&nbsp;</div>
                        
                        <table id="location" class="display" cellspacing="0" width="100%">
                        </table>


                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="editModalLabel">Update Row</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body" id="editModalBody">
                                  
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  <input type="submit" class="btn btn-success" id="update" value="Update">
                                </div>
                              </div>
                            </div>
                          </div>

{{-- What is returned back after editing 
    {"_token":"8sC6JxZc6L0l5HWaz58nFDriTW3YEW3DwTiM1OIC","createdBy":"5c1cb0ce48b67128f4002ea7","jurisdictionTypeId":"5c418fe948b671040c000e36","location_length":"10","stateEdit":"5c66989ec7982d31cc6b86c3","districtEdit":"5c669d72c7982d31cc6b86cf","talukaEdit":"5c66a53cd42f283b440013fa","villageEdit":"5c66a589d42f283b44001ff3","id":"5c6d21fb48b6713730005114"}
--}}

                          <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="addModalLabel">Add New Row</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body" id="addModalBody">
                                      
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                      <input type="submit" class="btn btn-success" id="add" value="Add">
                                    </div>
                                  </div>
                                </div>
                              </div>

{{-- What is returned back after editing 
    {"_token":"8sC6JxZc6L0l5HWaz58nFDriTW3YEW3DwTiM1OIC","createdBy":"5c1cb0ce48b67128f4002ea7","jurisdictionTypeId":"5c418fe948b671040c000e36","location_length":"10","stateAdd":"5c66989ec7982d31cc6b86c3","districtAdd":"5c669d13c7982d31cc6b86cd","talukaAdd":"5c66a53cd42f283b440013f8","villageAdd":"5c66a588d42f283b4400141a"}
--}}
                            </form>

                </div>
            </div>
			@include('layouts.footers.auth')
        </div>
    
		
</div>
<!-- /.container-fluid -->
@endsection

@push('css')
<!--    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.4/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.7/css/select.dataTables.min.css">-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.7/css/select.dataTables.min.css">

@endpush

@push('scripts')
{{-- Newly added --}}
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
{{-- previously commented --}}
   <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
   <script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>
    {{-- <script src="https://cdn.datatables.net/buttons/1.5.4/js/dataTables.buttons.min.js"></script> --}} 
    <script src="http://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('js/location.js') }}"></script>

@endpush
