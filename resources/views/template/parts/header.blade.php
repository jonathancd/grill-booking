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
                <a class="nav-link text-white" href="{{url('/booking')}}">Inicio /</a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link text-white" href="{{url('/booking/renter/history')}}">Mis Rentas /</a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white" href="{{url('/logout')}}">Cerrar Sesión</a>
            </li>

        </ul>
    </div>  

</nav>