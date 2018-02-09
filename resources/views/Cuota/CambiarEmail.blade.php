@extends('layouts.app')
@section('content')

   @include('layouts.menu')

   <div class="row">
      <div class="col">

         <form method="POST" action="/cuota/{{ $legajo->CODIGO }}/cambiaremail">

            {{ csrf_field() }}
            <div class="card">

               <ul class="collection with-header">
                  <li class="collection-header">{{ $legajo->NOMBRE}}</li>
                  <li class="collection-item">{{ $legajo->LEGAJO_ESCOLAR }}</li>
               </ul>
               <div class="card-content">

                  <div class="input-field ">
                     <input type="email" class="email" name="EMAIL" value="{{ $legajo->EMAIL }}" maxlength="50" required>
                     <label for="EMAIL">Email</label>
                  </div>

               </div>
               <div class="card-action">
                  <button type="submit" class="btn btn-primary">Aceptar</button>
                  <a class="btn btn-link" href="/cuota/{{$legajo->CODIGO}}/cuenta">Cancelar</a>
               </div>

            </div>
         </form>
      </div>
   </div>


@endsection
