<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Orden #{{ $order->id }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script>
        window.onload = () => window.print();
    </script>
</head>
<body class="p-6 text-sm font-sans">
    <h2 class="text-xl font-bold mb-4">Orden #{{ $order->id }}</h2>
    <p><strong>Cliente:</strong> {{ $order->customer_name }}</p>
    <p><strong>Teléfono:</strong> {{ $order->customer_phone }}</p>
    <p><strong>Fecha:</strong> {{ $order->order_datetime }}</p>
    <p><strong>Método de pago:</strong> {{ $order->payment_method }}</p>
    <hr class="my-4">

    <h3 class="font-semibold">Servicios:</h3>
    <ul class="list-disc list-inside mb-4">
        @foreach ($order->services as $service)
            <li>{{ $service->service }} — S/. {{ $service->rate }}</li>
        @endforeach
    </ul>

    <h3 class="font-semibold">Productos:</h3>
    <ul class="list-disc list-inside mb-4">
        @foreach ($order->items as $item)
            <li>{{ $item->inventory->description ?? '-' }} x {{ $item->quantity }} — S/. {{ $item->subtotal }}</li>
        @endforeach
    </ul>

    <p class="mt-4"><strong>Total:</strong> S/. {{ $order->total }}</p>
</body>
</html>