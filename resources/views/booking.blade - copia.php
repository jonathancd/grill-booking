<!-- https://codepen.io/jaguilera/pen/qAkGK?editors=1010 -->

<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Grill Booking</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        
        <link rel="stylesheet" href="{{url('css/styles.css')}}">

    </head>
    <body>
        
        <div class="jumbotron text-center background border-r0" style="margin-bottom:0">
            <h1 class="text-white">Grill Booking</h1>
            <!-- <p style="color: #fff;">El lugar para encontrar las barbacoas cercanas a tí.</p>  -->
        </div>


        <nav class="navbar navbar-expand-sm bg-dark navbar-dark">

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse align-flex-right" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Cerrar Sesión</a>
                    </li>

                </ul>
            </div>  

        </nav>


        <div class="container">
            
            <div class="row m-5">
                <div class="col-md-12">
                    <div id="map"></div>
                </div>
            </div>


            <div>
                
                <div>
                    <h2>Barbecues</h2>
                </div>

                <ul id="barbecue-list" class="list-group list-group-flush">
                    
                </ul>
            </div>

        </div>
        

        <footer class="bg-dark">

            <div class="text-center mt-3 text-white py-3">© 2018 Copyright:
              <a href="#"> Grill Booking </a>by Jonathan Cuotto
            </div>

        </footer>


        <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>   
        
        <script src="https://maps.googleapis.com/maps/api/js?sensor=false" type="text/javascript"></script>

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

                    console.log("La api de google maps no carga");

                }

            });

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

                                console.log("No se puede obtener info de su codigo postal");
                                // showModalSelectStoreError(must_have_a_valid_direction);

                            }

                        });
                }
                else{
                        // CODE POSTAL
                    showModalSelectStoreError("Debe ingresar un código postal valido");

                }
            }


            function createMap(lat, lon){

                map = new google.maps.Map(document.getElementById('map'), {
                    center: new google.maps.LatLng(lat, lon),
                    zoom: 13
                });
                
                infoWindow = new google.maps.InfoWindow();

                getStoresFromModule(lat, lon);

            }

            function getStoresFromModule(lat, lon){

                $.getJSON( './api/barbecues/'+lat+'/'+lon, {

                    latitude : lat,
                    longitude : lon

                })
                .done(function(data){

                    printBarbecuesInMap(data.barbecues);

                    updateBarbecueList(data.barbecues);

                })
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
                                            '<img class="img-fluid" src="./images/barbecues/'+barbecues_data[i].photo+'" alt="">'+
                                        '</div>'+

                                        '<div class="col-md-8">'+
                                            '<div class="card-info">'+
                  
                                                '<div class="p-2 bg-dark">'+
                                                    
                                                    '<div class="row">'+
                                                        
                                                        '<div class="col-10">'+
                                                            '<p class="barbecue-model text-white m-0">'+barbecues_data[i].model+'</p> '+
                                                        '</div>'+

                                                        '<div class="col-2">'+
                                                            '<span class="barbecue-price">$ 150</span>'+
                                                        '</div>'+

                                                    '</div>'+
                                                '</div>'+
                                                  
                                                '<div>'+

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

                                                '<div class="m-2 text-right">'+
                                                    '<a href="./booking/'+barbecues_data[i].id+'" class="btn bg-dark font-weight-bold px-5 text-white">Rentar</a>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+

                                '</li>';

                }

                $('#barbecue-list').append(content);

            }

            function createMarker(barbecue, location) {

                var image = new google.maps.MarkerImage("/images/icons/barbecue.png");
                console.log(image);
                var marker = new google.maps.Marker({
                    position: location, 
                    map: map,
                    icon: image,
                    title: 'Okis',
                    data: barbecue
                });


                MARKERS.push(marker);
                markerPopup(marker);     

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


        </script>

    </body>
</html>
