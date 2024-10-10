<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>@yield('title')</title>
  <link rel="stylesheet" href="css/custom_pdf.css">
  <link rel="stylesheet" href="css/custom_page.css">
</head>

<body>
  @include('pdf.layout.footer')

  @yield('content')  

</body>

</html>
