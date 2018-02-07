@extends('layouts.app')
@section('content')

   @include('layouts.menu')

   <div class="container">


      <div class="fixed-action-btn">
         <a class="btn-floating btn-large blue" href="/legajo/create">
            <i class="large material-icons">add</i>
         </a>
      </div>


      <div class="card">

         <table class="responsive-table highlight">
            <thead>
               <tr>
                  <th>Apodo</th>
                  <th>Nombre</th>
                  <th>Saldo</th>
                  <th>U.Pago</th>
                  <th></th>

               </tr>
            </thead>

            <tbody>

               @foreach($legajos as $legajo)

                  <tr>
                     <td>{{ $legajo->LEGAJO_ESCOLAR }}</td>
                     <td>{{ $legajo->NOMBRE }}</td>
                     <td>{{ number_format( $legajo->saldo,2) }}</td>
                     @if(is_null( $legajo->ultimopago))
                        <td></td>
                     @else
                        <td>{{ $legajo->ultimopago->format('d/m/Y') }}</td>
                     @endif
                     <td>
                        <a class="btn-floating yellow darken-1" href="/legajo/{{ $legajo->CODIGO }}/edit">
                           <i class="small material-icons">edit</i>
                        </a>
                        <a class="btn-floating red" href="/legajo/{{ $legajo->CODIGO }}/delete">
                           <i class="small material-icons">delete</i>
                        </a>
                        <a class="btn-floating green" href="/cuota/{{ $legajo->CODIGO }}/cuenta">
                           <i class="small material-icons">attach_money</i>
                        </a>
                     </td>

                  </tr>

               @endforeach


            </tbody>
         </table>
      </div>
   </div>

@endsection
