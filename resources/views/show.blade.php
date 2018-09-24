@extends('template.template')

@section('title')
    <title>Grill Booking - {{$barbecue->model}}</title>
@stop


@section('content')
	<div class="barbecue font-weight-bold">
	  	<div class="row mt-5">

	        <div class="col-md-6 text-center">
	        	<div class="card-info">

	                <div class="p-2 bg-dark">
	                    
	                    <div class="row">
	                        
	                        <div class="col-9 text-left">
	                            <p class="barbecue-model text-white m-0">{{$barbecue->model}} ({{$barbecue->year}})</p> 
	                        </div>

	                        <div class="col-3">
	                            <span class="barbecue-price">${{$barbecue->price}}</span>
	                        </div>

	                    </div>
	                </div>
	                  
	                <br>
	                  
	            </div>

	            <img class="" src="{{url('/images/barbecues/')}}/{{$barbecue->photo}}" alt="">
	        </div>

	        <div class="col-md-6">
				
				<div>
					<h4 class="text-center font-weight-bold">Renta esta Barbacoa</h4>
					<p>Indica las fechas de recibo y entrega de la Barbacoa</p>
				</div>

				<div>

					<form action="{{url('/booking')}}" method="POST">	
						{{ csrf_field() }}

						<div class="form-group">
					    	<label for="date-from">Desde:</label>
					    	<input id="date-from" class="date form-control" type="text" name="date_from" required >
					    	<span class="text-danger" style="font-size: 13px;">{{ $errors->first('date_from') }}</span>
					  	</div>

					  	<div class="form-group">
					    	<label for="date-to">Hasta:</label>
					    	<input id="date-to" class="date form-control" type="text" name="date_to" required disabled>
					    	<span class="text-danger" style="font-size: 13px;">{{ $errors->first('date_to') }}</span>
					  	</div>
						
						@if($barbecue->transport == 1)
					  	<div class="form-group form-check">
						    <input type="checkbox" class="form-check-input" id="check-transport" name="transport" data-toggle="collapse" href="#collapse-address" value="1">
						    <label class="form-check-label" for="check-transport">Pagar transporte</label>

						    <div class="collapse" id="collapse-address">
							  	<div class="card card-body">
							    	<div class="form-group">
								    	<label for="address">Dirección de domicilio:</label>
								    	<input id="address" class="form-control" type="text" name="address" value="{{ old('address') }}">

								    	<span class="text-danger" style="font-size: 13px;">{{ $errors->first('address') }}</span>

								  	</div>
							  	</div>
							</div>

						</div>
						@endif

						<div>
							<input type="hidden" name="barbecue" value="{{$barbecue->id}}">
						</div>


					  	<button type="submit" class="btn bg-dark text-white w-100">Rentar</button>
					</form>

				</div>

	            <div>
	            	
	            </div>
	        </div>
			
	    </div>
		

		<div class="row">
			<div class="col-12">
				<div>
					<h4 class="font-weight-bold">Caracteristicas</h4>
				</div>
				<div>
			    	<ul class="list-group list-group-flush">
					  	<li class="list-group-item">
					  		<p>
					  			<b class="barbecue-feature">Area de cocina:</b>
					  			{{$barbecue->cooking_area}}
					  	</li>
					  	<li class="list-group-item">
					  		<p>
					  			<b class="barbecue-feature">Materiales:</b> 
					  			{{$barbecue->materials}}
					  		</p>
					  	</li>
					  	<li class="list-group-item">
					  		<p>
					  			<b class="barbecue-feature">Dimensiones:</b>
					  			 {{$barbecue->dimensions}}
					  		</p>
					  	</li>
					  	<li class="list-group-item">
					  		<p>
					  			<b class="barbecue-feature">Combustible:</b>
					  			 {{$barbecue->fuel}}
					  		</p>
					  	</li>
					  	<li class="list-group-item">
					  		<p>
					  			<b class="barbecue-feature">Ideal para:</b>
					  			 {{$barbecue->ideal_for}}
					  		</p>
					  	</li>
					</ul>

				</div>
			</div>
		</div>
		

		<div class="row m-5">
			<div>
				<h4>Ubicación de la Barbacoa</h4>
			</div>
	        <div class="col-md-12">
	            <div id="map"></div>
	        </div>
	    </div>

	</div>
@stop




@section('scripts')
<script src="{{url('/js/selectDates.js')}}"></script>


<script>
	var BARBECUE = {!! json_encode($barbecue) !!};
    var MAP;
    var MARKERS = [];

    $(document).ready(function(){

        if(typeof google !== 'undefined'){

            createMap();

        }
        else
        {

            console.log("La api de google maps no carga");

        }

    });

	function createMap(){

        map = new google.maps.Map(document.getElementById('map'), {
            center: new google.maps.LatLng(BARBECUE.latitude, BARBECUE.longitude),
            zoom: 13
        });

        createBarbecueMarker();

    }

    function createBarbecueMarker(barbecue, location) {

    	var location = new google.maps.LatLng(BARBECUE.latitude, BARBECUE.longitude);

        var image = new google.maps.MarkerImage("/images/icons/barbecue.png");
        
        var marker = new google.maps.Marker({
            position: location, 
            map: map,
            icon: image,
            title: BARBECUE.model
        });


        MARKERS.push(marker);   

    }

</script>

@stop