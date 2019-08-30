<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>

        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Noesis</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
         <script src="{{ secure_asset('js/app.js') }}"></script>
          <link href="{{ secure_asset('css/main.css') }}" rel="stylesheet">
        <script src="{{ secure_asset('js/main.js') }}"></script>

    </head>
    <body>
        
        @yield('main')
        
        
    </body>
    <footer>
        <link href="https://fonts.googleapis.com/css?family=Lato:400,900&display=swap" rel="stylesheet">
         <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
         <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/additional-methods.min.js"></script>
    </footer>
</html>
