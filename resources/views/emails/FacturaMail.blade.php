<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Envio de Factura</title>
</head>
<body>
    <h1>Factura #@paddy($factura->id)</h1>
    <p>
        Se ha generado factura para: {{$factura->entidad_fiscal->model->nombre}}<br>
        RFC: {{$factura->entidad_fiscal->rfc}}<br>
        Razón Social: {{$factura->entidad_fiscal->razon_social}}<br>
    </p>
</body>
</html>