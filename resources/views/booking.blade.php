<!-- https://codepen.io/jaguilera/pen/qAkGK?editors=1010 -->
@extends('template.template')

@section('title')
    <title>Grill Booking</title>
@stop

@section('content')
    <div class="row m-5">
        <div class="col-md-12">
            <div id="map"></div>
        </div>
    </div>


    <div>
        
        <div>
            <h2>Barbecoas</h2>
        </div>

        <ul id="barbecue-list" class="list-group list-group-flush">
            
        </ul>
    </div>
@stop


@section('scripts')

        
        <script>    
            var USER = {!! json_encode($user) !!};
            var MAP;
            var MARKERS = [];
            var PREV_INFOWINDOW =false; 


            $(document).ready(function(){

                if(typeof google !== 'undefined'){

                    getZipcodeCoordinates();

                }
                else
                {
                    $('#map').css('height', 'auto');
                    showMapMessageError("En este momento no se puede hacer uso de google maps.");

                }

            });

            


            function createMap(lat, lon){

                map = new google.maps.Map(document.getElementById('map'), {
                    center: new google.maps.LatLng(lat, lon),
                    zoom: 13
                });
                
                infoWindow = new google.maps.InfoWindow();

                getStoresFromModule(lat, lon);

            }

            function createMarker(barbecue, location) {

                var image = new google.maps.MarkerImage("/images/icons/barbecue.png");
                console.log(image);
                var marker = new google.maps.Marker({
                    position: location, 
                    map: map,
                    icon: image,
                    title: barbecue.model,
                    data: barbecue
                });


                MARKERS.push(marker);
                markerPopup(marker);     

            }


            function getBarbecueOfferTransport(barbecue){
                var content = '';

                if(barbecue.transport == 1){
                    content += '<div class="text-center mt-2">'+
                                    '<span><i>El dueño de esta barbacoa ofrece transporte</i></span>'+
                                '</div>';
                }

                return content;
            }


            function getStoresFromModule(lat, lon){

                $.getJSON( '../api/barbecues/'+lat+'/'+lon, {

                    latitude : lat,
                    longitude : lon

                })
                .done(function(data){

                    if(data.barbecues.length > 0){
                        printBarbecuesInMap(data.barbecues);
                        updateBarbecueList(data.barbecues);
                    }else{
                        $('#barbecue-list').append('<li class="list-group-item"><h4>No se encuentran Barbocas cercanas</h4></li>');
                    }

                });
            }


            function getZipcodeCoordinates(){

                if( USER.zipcode != null && USER.country != null){

                    var url_geocoder = "https://nominatim.openstreetmap.org/search?postalcode="+USER.zipcode+"&country="+USER.country+"&format=json";

                    $.getJSON( url_geocoder, {})
                        .done(function(user_coords){

                            var lat=0,lon=0;

                            if( user_coords.length>0 ){

                                lat = user_coords[0].lat;
                                lon = user_coords[0].lon;


                                createMap(lat, lon);

                            }else{

                                showMapMessageError("Debido a que no se consiguen coordenadas para su código postal, en este momento no podemos ofrecerle una lista de las Barbacoas cercanas a su dirección")
                                // showModalSelectStoreError(must_have_a_valid_direction);

                            }

                        });
                }
                else{
                        // CODE POSTAL
                    showMapMessageError("Debido a que no se consiguen coordenadas para su código postal, en este momento no podemos ofrecerle una lista de las Barbacoas cercanas a su dirección")

                }
            }


            function markerPopup(marker){

                var content = '<div id="content">'+
                                    '<div>'+
                                        '<h3 id="firstHeading" class="firstHeading">'+marker.data.model+'</h3>'+
                                        '<div class="marker-popup-image">'+
                                            '<img src="./images/barbecues/'+marker.data.photo+'">'+
                                        '</div>'+

                                        '<div>'+
                                            '<a href="#barbecue-'+marker.data.id+'" class="btn btn-primary w-100">Ver más</a>'+
                                        '<div>'+

                                    '</div>';
                                '</div>';

                marker.infowindow = new google.maps.InfoWindow({
                    content: content
                });

                marker.addListener('click', function() {
                    
                    if( PREV_INFOWINDOW ) {
                       PREV_INFOWINDOW.close();
                    }

                    PREV_INFOWINDOW = marker.infowindow;

                    marker.infowindow.open(map, marker);

                });
            }


            function printBarbecuesInMap(barbecues_data){

                for(var i=0;i<barbecues_data.length; i++){
                    
                    if(typeof barbecues_data[i].latitude !== 'undefined' && typeof barbecues_data[i].longitude !== 'undefined'){

                        var latlng = new google.maps.LatLng(barbecues_data[i].latitude, barbecues_data[i].longitude);

                        createMarker(barbecues_data[i], latlng);

                    }
                }

            }


            function updateBarbecueList(barbecues_data)
            {   
                var content = '';

                for (var i=0; i < barbecues_data.length; i++){

                    content += '<li id="barbecue-'+barbecues_data[i].id+'" class="list-group-item">'+
                            
                                    '<div class="row">'+

                                        '<div class="col-md-4 text-center">'+
                                            '<img class="img-fluid" src="../images/barbecues/'+barbecues_data[i].photo+'" alt="">'+
                                        '</div>'+

                                        '<div class="col-md-8">'+
                                            '<div class="card-info">'+
                  
                                                '<div class="p-2 bg-dark">'+
                                                    
                                                    '<div class="row">'+
                                                        
                                                        '<div class="col-10">'+
                                                            '<p class="barbecue-model text-white m-0">'+barbecues_data[i].model+' ('+barbecues_data[i].year+')</p> '+
                                                        '</div>'+

                                                        '<div class="col-2">'+
                                                            '<span class="barbecue-price">$'+barbecues_data[i].price+'</span>'+
                                                        '</div>'+

                                                    '</div>'+
                                                '</div>'+
                                                  
                                                  // '<hr>'+
                                                  '<br>'+

                                                  
                                                '<div class="content">'+
                                                    '<p>'+
                                                      barbecues_data[i].description+
                                                    '</p>'+
                                                    '<div class="barbecue-specifics">'+
                                                        '<p><b>Area de cocina:</b> '+barbecues_data[i].cooking_area+'</p>'+
                                                        '<p><b>Materiales:</b> '+barbecues_data[i].materials+'</p>'+
                                                        '<p><b>Dimensiones:</b> '+barbecues_data[i].dimensions+'</p>'+
                                                        '<p><b>Combustible:</b> '+barbecues_data[i].fuel+'</p>'+
                                                        '<p><b>Ideal para:</b> '+barbecues_data[i].ideal_for+'</p>'+
                                                    '</div>'+
                                                '</div>'+

                                                getBarbecueOfferTransport(barbecues_data[i])+

                                                '<div class="m-2 text-right">'+
                                                    '<a href="../booking/'+barbecues_data[i].id+'" class="btn bg-dark font-weight-bold px-5 text-white">Rentar</a>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+

                                '</li>';

                }

                $('#barbecue-list').append(content);

            }

            

            function showMapMessageError(msg){
                
                // $('#map').css('min-height', '250px');
                $('#map').css('height', '250px');

                 var content = '<div class="alert alert-success alert-dismissible fade show mt-3 font-weight-bold" role="alert">'+
                            
                                    msg+
                                    
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                                        '<span aria-hidden="true">&times;</span>'+
                                    '</button>'+
                                '</div>';

                $('#map').append(content);
            }

        </script>
@stop
