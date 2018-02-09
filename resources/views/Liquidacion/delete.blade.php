@extends('layouts.app')
@section('content')

   @include('layouts.menu')


   <div class="row">
      <div class="col">
         <form method="POST" action="/liquidacion/{{$liquidacion->CODIGO}}/delete">

            {{ csrf_field() }}
            <div class="card">

               <ul class="collection with-header">
                  <li class="collection-header"><h3>Codigo {{$liquidacion->CODIGO}}</h3></li>
                  <li class="collection-item">Fecha: {{$liquidacion->VENCIMIENTO_1->format('d/m/Y')}}</li>
                  <li class="collection-item">Concepto: {{$liquidacion->concepto->NOMBRE }}</li>
                  <li class="collection-item">Importe: {{ number_format( $liquidacion->SUMA_FIJA_1,2) }}</li>
               </ul>
               <div class="card-action">
                  @if($liquidacion->ESCUELA == Auth::user()->CATEGORIA)
                     <button type="submit" class="btn btn-primary">Aceptar</button>
                  @endif
                  <a class="btn btn-link" href="/liquidacion">Cancelar</a>
               </div>
            </div>
         </form>
      </div>
   </div>

@endsection
