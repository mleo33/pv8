<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Envío de complemento de pago</title>
</head>
<body>
    <h1>Complemento {{$complemento->folio}}{{$complemento->serie}}</h1 >
    <p>
        Se ha generado complemento de pago para: {{$complemento->entidad_fiscal->model->nombre}}<br>
        Factura: 
        @foreach ($complemento->facturas as $item)
            {{$item->folio}}{{$item->serie}},
        @endforeach
        RFC: {{$complemento->entidad_fiscal->rfc}}<br>
        Razón Social: {{$complemento->entidad_fiscal->razon_social}}<br>
    </p>
</body>
</html>