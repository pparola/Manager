@extends('layouts.app')
@section('content')

   @include('layouts.menu')

   <div class="row">
      <div class="col">
         <form method="POST" action="/cuota/{{$legajo->CODIGO}}/create">


            {{ csrf_field() }}
            <div class="card">

               <ul class="collection with-header">
                  <li class="collection-header">{{ $legajo->NOMBRE}}</li>
                  <li class="collection-item">{{ $legajo->LEGAJO_ESCOLAR }}</li>
                  <li class="collection-item">email: {{ $legajo->EMAIL}}</li>
               </ul>

               <div class="card-content">

                  <div class="input-field ">
                     <select name="CONCEPTO" value="{{old('CONCEPTO')}}" >
                        <option disabled selected>Seleccione un Concepto</option>
                        @foreach($conceptos as $concepto)
                           <option value="{{$concepto->CODIGO}}"> {{$concepto->NOMBRE}} </option>
                        @endforeach
                     </select>
                     <label for="CONCEPTO">Concepto</label>
                  </div>

                  <div class="input-field ">
                     <input type="text" class="datepicker" name="FECHA_1" value="{{ old('FECHA_1') }}" >
                     <label for="FECHA_1">Fecha</label>
                  </div>

                  <div class="input-field ">
                     <input type="number" class="validate" step="any" name="IMPORTE_1" value="{{ old('IMPORTE_1') }}" maxlength="12" required>
                     <label for="IMPORTE_1">Importe</label>
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
