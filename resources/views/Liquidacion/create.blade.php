@extends('layouts.app')
@section('content')

   @include('layouts.menu')

   <div class="row">
      <div class="col">
         <form method="POST" action="/liquidacion/create">

            {{ csrf_field() }}
            <div class="card">

               <div class="card-content">

                  <div class="input-field ">
                     <input type="text" class="datepicker" name="VENCIMIENTO_1" value="{{ old('VENCIMIENTO_1') }}" >
                     <label for="VENCIMIENTO_1">Fecha</label>
                  </div>

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
                     <input type="number" class="validate" step="any" name="SUMA_FIJA_1" value="{{ old('SUMA_FIJA_1') }}" maxlength="12" required>
                     <label for="SUMA_FIJA_1">Importe</label>
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
