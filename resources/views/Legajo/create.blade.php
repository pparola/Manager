@extends('layouts.app')
@section('content')

   @include('layouts.menu')

   <div class="row">
      <div class="col">
         <form method="POST" action="/legajo/create">

            {{ csrf_field() }}
            <div class="card">

               <div class="card-content">
                  {{ csrf_field() }}

                  <div class="input-field ">
                     <input type="text" class="validate" name="NOMBRE" value="{{ old('NOMBRE') }}" maxlength="32" required autofocus>
                     <label for="NOMBRE">Nombre</label>
                  </div>

                  <div class="input-field ">
                     <input type="text" class="validate" name="LEGAJO_ESCOLAR" value="{{ old('LEGAJO_ESCOLAR') }}" maxlength="12" required>
                     <label for="LEGAJO_ESCOLAR">Apodo</label>
                  </div>

                  <div class="input-field ">
                     <input type="email" class="email" name="EMAIL" value="{{ old('EMAIL') }}" maxlength="50" required>
                     <label for="EMAIL">Email</label>
                  </div>

                  <div class="input-field ">
                     <input type="number" class="validate" step="any" name="DEREXA" value="{{ old('DEREXA') }}" maxlength="12" required>
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
