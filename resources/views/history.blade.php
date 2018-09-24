@extends('template.template')

@section('title')
    <title>Grill Booking - Mi historial</title>
@stop


@section('content')
	<div id="history" class="mt-3">
        
        <div>
            <h2>Rentas</h2>
        </div>

        <ul id="barbecue-list" class="list-group list-group-flush">
            @if(count($renters) > 0)
            	@foreach($renters as $renter)
					<li id="barbecue-{{$renter->barbecue->id}}" class="list-group-item">
                            
                        <div class="row">

                            <div class="col-md-4 text-center">
                                <img class="img-fluid" src="{{url('/images/barbecues')}}/{{$renter->barbecue->photo}}" alt="">
                            </div>

                            <div class="col-md-8">
                                <div class="card-info">
      
                                    <div class="p-2 bg-dark">
                                        
                                        <div class="row">
                                            
                                            <div class="col-10">
                                                <p class="barbecue-model text-white m-0">{{$renter->barbecue->model}} ({{$renter->barbecue->year}})</p>
                                            </div>

                                            <div class="col-2">
                                                <span class="barbecue-price">$ {{$renter->amount}}</span>
                                            </div>

                                        </div>
                                    </div>
                                      

                                     <br>

                                      
                                    <div class="content">
                                        <p>
                                          {{$renter->barbecue->description}}
                                        </p>
                                        <div class="barbecue-specifics">
                                            <h4 class="mt-2">Detalles del vendedor:</h4>
											<p><b>Nombre: </b> {{$renter->seller->name}}</p>
					                        <p><b>Email:</b> {{$renter->seller->email}}</p>
                                        </div>
                                    </div>
									
									<div class="m-2 text-right">
                                        <a href="{{url('/booking')}}/{{$renter->id}}/details" class="btn bg-dark font-weight-bold px-5 text-white">Ver detalles</a>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </li>
            	@endforeach
            @else
                <li>
                    Aun no ha rentado alguna Barbacoa
                </li>
            @endif
        </ul>

    </div>
	
@stop
