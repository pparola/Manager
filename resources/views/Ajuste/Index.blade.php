@extends('layouts.app')
@section('content')

   @include('layouts.menu')


   <div class="container">

      <div class="card">

         <ul class="collection with-header">
            <li class="collection-header"><h3>Ajustado por {{ Auth::user()->name}}</h3></li>
         </ul>

         <table class="responsive-table highlight">
            <thead>
               <tr>
                  <th>Apodo</th>
                  <th>Nombre</th>
                  <th>Concepto</th>
                  <th>Fecha</th>
                  <th>Importe</th>
                  <th></th>

               </tr>
            </thead>

            <tbody>

               @foreach($pagos as $pago)


                  <tr>
                     <td>{{ $pago->cuota->legajo->LEGAJO_ESCOLAR }}</td>
                     <td>{{ $pago->cuota->legajo->NOMBRE }}</td>
                     <td>{{ $pago->cuota->liquidacion->concepto->NOMBRE }}</td>
                     <td>{{ $pago->FECHA->format('d/m/Y') }}</td>
                     <td>{{ number_format( $pago->IMPORTE,2) }}</td>
                     <td>
                        <a class="btn-floating red" href="/ajuste/{{$pago->CODIGO}}/delete">
                           <i class="small material-icons">delete</i>
                        </a>
                     </td>

                  </tr>

               @endforeach


            </tbody>
         </table>

         <ul class="collection with-header">
            <li class="collection-header center"><strong> Importe Ajustado {{number_format( $pagos->sum('IMPORTE'),2)}} </strong></li>
         </ul>

      </div>
   </div>

@endsection
