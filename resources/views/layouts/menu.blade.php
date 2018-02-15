@php
   if(!isset($titulo)){
      $titulo = "Menu Principal";
   }
@endphp

<ul id="dropdown1" class="dropdown-content">

   <li><a href="/legajo">Legajos</a></li>
   <li><a href="/liquidacion">Liquidaciones</a></li>
   <li><a href="/pago">Pagos</a></li>
   <li><a href="/ajuste">Ajustes</a></li>
   <li class="divider"></li>
   <li><a href="/asistencia">Asistencia</a></li>
   <li class="divider"></li>
   <li><a href="/cerrar">Cerrar</a></li>

</ul>

<nav>
   <div class="nav-wrapper light-blue lighten-1">
      <a href="" class="brand-logo"> {{ $titulo }} </a>
      <ul id="nav-mobile" class="right ">

         <li>
            <a class="dropdown-button" href="#!" data-activates="dropdown1">
               <i class="material-icons">menu</i>
            </a>
         </li>



      </ul>
   </div>
</nav>

@if ($errors->any())

   <ul class="collapsible" data-collapsible="accordion">
      <li>
         <div class="collapsible-header">
            <i class="material-icons">error_outline</i>
               Errores en Ingreso de datos
            <span class="new badge red" data-badge-caption="Error(es)" >{{$errors->count()}}</span></div>
            <div class="collapsible-body">
               @foreach ($errors->all() as $error)
                   <p>{{ $error }}</p>
               @endforeach
            </div>
         </li>
   </ul>

@endif
