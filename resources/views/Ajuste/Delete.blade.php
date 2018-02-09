@extends('layouts.app')
@section('content')

   @include('layouts.menu')


   <div class="row">
      <div class="col">
         <form method="POST" action="/ajuste/{{$pago->CODIGO}}/delete">

            {{ csrf_field() }}
            <div class="card">

               <ul class="collection with-header">
                  <li class="collection-header">Codigo {{$pago->CODIGO}}</li>
                  <li class="collection-item">{{$pago->cuota->legajo->NOMBRE}}</li>
                  <li class="collection-item">{{$pago->cuota->legajo->LEGAJO_ESCOLAR}}</li>
                  <li class="collection-item">email: {{$pago->cuota->legajo->EMAIL}}</li>
                  <li class="collection-item">Concepto: {{$pago->cuota->liquidacion->concepto->NOMBRE}}</li>
                  <li class="collection-item">Fecha: ${{ $pago->FECHA->format('d/m/Y') }}</li>
                  <li class="collection-item">Importe: ${{ number_format( $pago->IMPORTE,2 )}}</li>
                  <li class="collection-item">usuario: {{ $pago->usuario->name }}</li>
               </ul>
               <div class="card-action">
                  @if($pago->USUARIO == Auth::user()->id)
                     <button type="submit" class="btn btn-primary">Aceptar</button>
                  @endif
                  <a class="btn btn-link" href="/ajuste }}">Cancelar</a>
               </div>
            </div>
         </form>
      </div>
   </div>

@endsection
