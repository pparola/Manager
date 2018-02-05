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
                  <th>Codigo</th>
                  <th>Apodo</th>
                  <th>Nombre</th>
                  <th></th>

               </tr>
            </thead>

            <tbody>

               @foreach($legajos as $legajo)

                  <tr>
                     <td>{{ $legajo->CODIGO }}</td>
                     <td>{{ $legajo->LEGAJO_ESCOLAR }}</td>
                     <td>{{ $legajo->NOMBRE }}</td>

                     <td>
                        <a class="btn-floating yellow darken-1" href="/legajo/{{ $legajo->CODIGO }}/edit">
                           <i class="small material-icons">edit</i>
                        </a>
                        <a class="btn-floating red" href="/legajo/{{ $legajo->CODIGO }}/delete">
                           <i class="small material-icons">delete</i>
                        </a>
                     </td>

                  </tr>

               @endforeach


            </tbody>
         </table>
      </div>
   </div>

@endsection
