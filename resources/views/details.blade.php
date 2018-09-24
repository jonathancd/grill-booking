@extends('template.template')

@section('title')
    <title>Grill Booking - Renter {{$barbecue->model}} - {{$renter->id}}</title>
@stop


@section('content')

	@if(!empty(Session::get('status')) )
		<div class="alert alert-success alert-dismissible fade show mt-3 font-weight-bold" role="alert">
		  	
		  	{{Session::get('status')}}
		  	
		  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    	<span aria-hidden="true">&times;</span>
		  	</button>
		</div>
	@endif

	<div class="barbecue font-weight-bold">
	  	<div class="row mt-5">

	        <div class="col-md-6 text-center">
	        	<div class="card-info">

	                <div class="p-2 bg-dark">
	                    
	                    <div class="row">
	                        
	                        <div class="col-12 text-left">
	                            <p class="barbecue-model text-white m-0">{{$barbecue->model}} ({{$barbecue->year}})</p> 
	                        </div>

	                        <div class="col-3">
	                            <span class="barbecue-price"></span>
	                        </div>

	                    </div>
	                </div>
	                  
	                <br>
	                  
	            </div>

	            <img class="" src="{{url('/images/barbecues/')}}/{{$barbecue->photo}}" alt="">
	        </div>

	        <div class="col-md-6">
				<div>
					<h4 class="text-center font-weight-bold">Detalles de la renta</h4>
				</div>

				<div class="content">
                    <p>
                      {{$barbecue->description}}
                    </p>

                    <div class="barbecue-specifics">
                    	<p><b>Monto: </b> ${{$renter->amount}}</p>
                        <p><b>Desde:</b> {{$renter->date_from}}</p>
                        <p><b>Hasta:</b> {{$renter->date_to}}</p>

                        @if($renter->address)
                        <p><b>Dirección:</b> {{$renter->address}}</p>
                        @endif

						<h4 class="mt-2">Detalles del vendedor:</h4>
						<p><b>Nombre: </b> {{$barbecue->seller->name}}</p>
                        <p><b>Email:</b> {{$barbecue->seller->email}}</p>

                    </div>
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

	</div>
@stop
