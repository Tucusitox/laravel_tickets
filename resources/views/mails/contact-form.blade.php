<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MorianSoft Computación</title>
</head>

<body style="margin: 0; padding: 0; box-sizing: border-box; overflow: hidden; display: flex; justify-content: center; align-items: center; min-height: 100vh; font-family: 'Poppins', sans-serif;">
    {{-- ESTRUCTURA DEL CORREO DE CODIGO DE RECUPERACION --}}
    @if ($codigo)
        <section style="margin: 20px; background: linear-gradient(45deg, #007bff 40%, #198754 70%); width: 100%; height: 300px; text-align: center; border: 3px solid black; border-radius: 10px; padding: 20px;">
            <h1 style="font-size: 30px; color:black;">MorianSoft Computación</h1>
            <p style="font-size: 30px; color:black;">{{ $mensaje }}</p>
            <p><b style="font-size: 40px; color: aqua;">{{ $codigo }}</b></p>
        </section>
    @endif
    {{-- ESTRUCTURA DEL CORREO DE MENSAJES AL CLIENTE SEAN SEGUIMIENTOS O SOLUCIONES --}}
    @if ($cliente)
        <section style="margin: 20px; background: linear-gradient(45deg, #007bff 40%, #198754 70%); width: 100%; height: 300px; text-align: center; border: 3px solid black; border-radius: 10px; padding: 20px;">
            <h1 style="color:black;">MorianSoft Computación</h1>
            <p style="font-size: 30px; color:black;">{{ $mensaje }}</p>
        </section>
    @endif

</body>

</html>
