@extends('layouts.app')
@section('content')

   @include('layouts.menu')

   <div class="row">
      <div class="col">

         <form method="POST" action="/legajo/{{ $legajo->CODIGO }}/edit">

            {{ csrf_field() }}
            <div class="card">

               <div class="card-content">

                  <div class="input-field ">
                     <input type="text" class="validate" name="NOMBRE" value="{{ $legajo->NOMBRE }}" maxlength="32" required autofocus>
                     <label for="NOMBRE">Nombre</label>
                  </div>

                  <div class="input-field ">
                     <input type="text" class="validate" name="LEGAJO_ESCOLAR" value="{{ $legajo->LEGAJO_ESCOLAR }}" maxlength="12" required>
                     <label for="LEGAJO_ESCOLAR">Apodo</label>
                  </div>

                  <div class="input-field ">
                     <input type="email" class="email" name="EMAIL" value="{{ $legajo->EMAIL }}" maxlength="50" required>
                     <label for="EMAIL">Email</label>
                  </div>

                  <div class="input-field ">
                     <input type="number" class="validate" name="DNI" value="{{ $legajo->DNI }}" maxlength="32" >
                     <label for="DNI">D.N.I.</label>
                  </div>

                  <div class="input-field ">
                     <input type="text" class="validate" name="TELEFONO" value="{{ $legajo->TELEFONO }}" maxlength="32" >
                     <label for="TELEFONO">Telefono</label>
                  </div>

                  <div class="input-field ">
                     <input type="text" class="validate" name="TELEFONO1" value="{{ $legajo->TELEFONO1 }}" maxlength="32" >
                     <label for="TELEFONO1">Telefono Padre</label>
                  </div>




                  <div class="input-field ">
                     <input type="text" class="datepicker" name="BAJA" value="{{ $legajo->BAJA }}" >
                     <label for="BAJA">F.Baja</label>
                  </div>

                  <div class="input-field ">
                     <input type="number" class="validate" step="any" name="DEREXA" value="{{ $legajo->DEREXA }}" maxlength="12" >
                     <label for="DEREXA">Beca</label>
                  </div>

               </div>
               <div class="card-action">
                  <button type="submit" class="btn btn-primary">Aceptar</button>
                  <a class="btn btn-link" href="/legajo">Cancelar</a>
               </div>

            </div>
         </form>
      </div>
   </div>


@endsection
