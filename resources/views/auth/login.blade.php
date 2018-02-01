@extends('layouts.app')

@section('content')
   <div class="row">
      <div class="col s12">
         <form method="POST" action="{{ route('login') }}">
            <div class="card">

               <div class="card-content">
                  <nav class="light-blue lighten-1">
                     <div class="nav-wrapper">
                        <span class="brand-logo center">Ingreso</span>
                     </div>
                  </nav>
                  <br/>
                  {{ csrf_field() }}

                  <div class="input-field ">
                     <input type="email" class="validate" name="email" value="{{ old('email') }}" required autofocus>
                     <label for="email">Direccion de Email</label>
                  </div>

                  <div class="input-field">
                     <input type="password" class="validate" name="password" required>
                     <label for="password">Password</label>
                  </div>

                  <div class="input-field">
                     <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                     <label for="remember">Recuerdame</label>
                  </div>

               </div>
               <div class="card-action">
                  <button type="submit" class="btn btn-primary">Ingrese</button>
                  <a class="btn btn-link" href="{{ route('password.request') }}">
                     Olvido su Password?
                  </a>
               </div>
            </div>
         </form>
      </div>
   </div>
@endsection
