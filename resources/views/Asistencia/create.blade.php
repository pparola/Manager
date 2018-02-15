@extends('layouts.app')
@section('content')

   @include('layouts.menu')

   <div class="row">
      <div class="col">
         <form method="POST" action="/asistencia/create">

            {{ csrf_field() }}
            <div class="card">

               <div class="card-content">

                  <div class="input-field ">
                     <input type="text" class="datepicker" name="FECHA" value="{{ old('FECHA') }}" >
                     <label for="FECHA">Fecha</label>
                  </div>

                  <div class="input-field ">
                     <input type="text" class="validate" name="OBSERVA" value="{{ old('OBSERVA') }}" maxlength="32" required>
                     <label for="OBSERVA">Observación</label>
                  </div>

               </div>
               <div class="card-action">
                  <button type="submit" class="btn btn-primary">Aceptar</button>
                  <a class="btn btn-link" href="/asistencia">Cancelar</a>
               </div>

            </div>
         </form>
      </div>
   </div>



@endsection
