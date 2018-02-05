@php
   if(!isset($titulo)){
      $titulo = "Menu Principal";
   }
@endphp

<nav>
   <div class="nav-wrapper light-blue lighten-1">
      <a href="" class="brand-logo">Managers - {{ $titulo }} </a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
         <li><a href="/legajo">Legajos</a></li>
         <li><a href="">Cuentas</a></li>
         <li><a href="/cerrar">Cerrar</a></li>
      </ul>
   </div>
</nav>
