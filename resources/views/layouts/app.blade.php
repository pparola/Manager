<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width,initial-scale=1">
      <title>Managers</title>
      <link rel="stylesheet" href={{URL::asset("/css/materialize.min.css")}}>
      <link rel="stylesheet" href={{URL::asset("/css/toastr.min.css")}}>
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
   </head>
   <body >
      <div class="mdc-typography" style="display: flex; min-height: 90vh; flex-direction: column; ">
         @yield('content')
      </div>

      @if(Auth::check())
         <footer class="page-footer" >
            {{Auth::user()->name}}-{{Auth::user()->categoria->NOMBRE}}
         </footer>
      @endif
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src={{URL::asset("/js/materialize.min.js")}}></script>
      <script src={{URL::asset("/js/toastr.min.js")}}></script>
      <script>window.mdc.autoInit();</script>


      <script>
         @if(Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}";
            switch(type){
               case 'info':
               toastr.info("{{ Session::get('message') }}");
               break;

               case 'warning':
               toastr.warning("{{ Session::get('message') }}");
               break;

               case 'success':
               toastr.success("{{ Session::get('message') }}");
               break;

               case 'error':
               toastr.error("{{ Session::get('message') }}");
               break;
            }
         @endif

         $('.datepicker').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 40, // Creates a dropdown of 15 years to control year,
            today: 'Hoy',
            clear: 'Limpiar',
            close: 'Selecciona',
            closeOnSelect: true, // Close upon selecting a date,
            format: 'dd/mm/yyyy'
         });
         $('select').material_select();
      </script>
   </body>
</html>
