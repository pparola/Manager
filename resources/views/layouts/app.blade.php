<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width,initial-scale=1">
      <title>Managers</title>
      <link rel="stylesheet" href="./css/materialize.min.css">
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
   </head>
   <body >

      <div class="mdc-typography" style="display: flex; min-height: 90vh; flex-direction: column; ">
         @yield('content')
      </div>

      @if(Auth::check())
         <footer class="page-footer" >
            © 2018 Adc Consultores
            <span class="grey-text text-lighten-4 right">{{Auth::user()->name}}-{{Auth::user()->categoria->NOMBRE}}</span>
         </footer>
      @endif
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="./js/materialize.min.js"></script>
      <script>window.mdc.autoInit();</script>
   </body>
</html>
