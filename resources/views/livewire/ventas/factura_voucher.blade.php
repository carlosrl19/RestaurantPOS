<head>
    <title>Factura cliente final {{ $venta->sale_invoice_number }}</title>
    <style>
        @page {
            size: 40mm auto;
            margin: 0mm;
            padding: 0mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            width: 52mm;
            margin: 5mm !important;
            padding: 1mm !important;
        }

        * {
            box-sizing: border-box;
        }

        .header {
            text-align: center;
            margin-bottom: 2mm;
        }

        .title {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 1mm;
        }

        .company-info {
            font-size: 9px;
            margin-bottom: 3mm;
            text-align: center;
            text-transform: uppercase;
        }

        .divider {
            border-top: 1px dashed #000;
            margin: 3mm 0;
        }

        .item-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1mm;
        }

        .item-name {
            flex: 2;
            font-size: 9px;
        }

        .item-price {
            flex: 1;
            text-align: right;
        }

        .total-section {
            margin-top: 3mm;
            text-align: right;
            font-weight: bold;
        }

        .footer {
            font-size: 8px;
            text-align: center;
            margin-top: 5mm;
        }
    </style>

    <script>
        // Imprimir automáticamente al cargar
        window.onload = function() {
            setTimeout(function() {
                window.print();

                // Opcional: cerrar después de imprimir
                window.onafterprint = function() {
                    window.close();
                };
            }, 300);
        };

        // Manejar caso donde el usuario cancela
        window.onbeforeunload = function() {
            return '¿Está seguro que desea salir sin imprimir el recibo?';
        };
    </script>
</head>

<body>
    @php
    $settings = App\Models\Settings::first();
    @endphp

    <div class="header">
        <div class="title">FACTURA</div>
        <div class="company-info">
            {{ $settings->company_name ?? 'Nombre de empresa' }}<br>
            {{ $settings->company_address ?? 'Dirección' }}<br>
            Tel: {{ $settings->company_phone ?? 'Teléfono' }}
        </div>
    </div>

    <div class="divider"></div>

    <div>
        Nº FACT. {{ $venta->sale_invoice_number }}<br>
        Fecha: {{ Carbon\Carbon::parse($venta->created_at)->format('d-m-Y') }} <span style="float: right;">{{ Carbon\Carbon::parse($venta->created_at)->format('H:i') }}</span>
    </div>

    <div class="divider"></div>

    @php
    $total = 0;
    @endphp
    <div style="font-weight: bold; margin-bottom: 2mm;">Descripción <span style="float: right;">Subtotal</span></div>

    @foreach ($venta->detalle_venta as $detalle)
    @php
    $subtotal = $detalle->precio_venta * $detalle->cantidad_detalle_venta;
    $total += $subtotal;
    @endphp
    <div class="item-row">
        <div class="item-name">{{ $detalle->producto->product_name }} <span style="float: right;">{{ number_format($subtotal, 2) }}</span></div>
    </div>
    @endforeach

    <div class="divider"></div>

    <div class="total-section">
        <div><span style="float: left; font-size: 12px">TOTAL</span> {{ number_format($total, 2) }}</div>
    </div>

    <div class="divider"></div>

    <div class="footer">
        ¡Gracias por su compra!<br>
        CAI: {{ $settings->company_cai ?? 'CAI de empresa' }}<br>
    </div>

    <!-- Margen para cortar papel (comando específico para XP76IIH) -->
    <div style="text-align: center; margin-top: 20px">
        ____
    </div>
</body>