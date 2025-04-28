<head>
    <title>Factura cliente final {{ $venta->sale_invoice_number }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=LXGW+WenKai+TC&display=swap" rel="stylesheet">
    <style>
        .lxgw-wenkai-tc-regular {
            font-family: "LXGW WenKai TC", serif;
        }

        body {
            font-family: "LXGW WenKai TC", serif;
            background-color: #f4f4f9;
            color: #333;
            padding: 10px;
            padding-top: 10mm;
            padding-bottom: 10mm;
        }

        .factura {
            background: #fff;
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            border-radius: 10px;
        }

        .factura .encabezado {
            margin-bottom: 20px;
        }

        .factura .invoice-info {
            text-align: left;
            vertical-align: top;
            /* Alinea el contenido arriba */
        }

        .factura .logo-container {
            text-align: right;
            vertical-align: top;
            /* Alinea el contenido arriba */
        }

        .factura .cliente {
            margin-bottom: 20px;
        }

        .factura table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .factura table th {
            font-size: 8pt;
        }

        .factura table th,
        .factura table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .factura table th {
            background-color: #f8e1e8;
        }

        .factura .terminos {
            font-size: 8.5pt;
            color: #666;
            background: #f8e1e8;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="factura">
        <table class="encabezado" style="width: 100%;">
            <tr>
                <td class="invoice-info">
                    <span style="text-align: left; font-size: 28pt; margin: 5px; letter-spacing: 0.25em; word-spacing: 0.25em;">FACTURA</span><br>
                    <span style="font-size: 8.5pt; border: 2px solid #f8e1e8; padding: 5px; margin-right: 10px">Nº FACT. {{ $venta->sale_invoice_number }}</span><br>
                    <span style="font-size: 8.5pt; border: 2px solid #f8e1e8; background-color: #f8e1e8; padding: 5px;">{{ $venta->sale_invoice_date }}</span>
                </td>
                <td class="logo-container">
                    @php
                    $settings = App\Models\Settings::first();
                    @endphp

                    <img src="{{ $image_logo }}" style="position: relative; top: 0; right: 10; opacity: 0.8; width: 64px; height: 64px"><br>
                    <span style="font-size: 8.5pt;">{{ $settings->company_phone ?? 'N/A' }}</span><br>
                    <span style="font-size: 8.5pt;">


                        {{ $settings->company_address ?? 'N/A' }}
                    </span>
                </td>
            </tr>
        </table>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>DESCRIPCIÓN DEL PRODUCTO / SERVICIO</th>
                    <th>CANTIDAD</th>
                    <th>PRECIO</th>
                    <th>SUBTOTAL</th>
                </tr>
            </thead>
            <tbody>
                @php
                $total = 0;
                $counter = 0; // Inicializamos el contador
                @endphp

                @foreach ($venta->detalle_venta as $detalle)
                @php
                $counter++; // Incrementamos el contador en cada iteración
                @endphp
                <tr style="font-size: 9pt">
                    <td>{{ $counter }}</td>
                    <td>{{ $detalle->producto->product_name }}</td>
                    <td>{{ $detalle->cantidad_detalle_venta }}</td>
                    <td>L. {{ number_format($detalle->precio_venta, 2, ".", ",") }}</td>
                    <td>L. {{ number_format($detalle->precio_venta * $detalle->cantidad_detalle_venta, 2, ".", ",") }}</td>
                </tr>
                @php
                $total += $detalle->precio_venta * $detalle->cantidad_detalle_venta;
                @endphp
                @endforeach
            </tbody>
        </table>

        <div style="display: flex; width: 100%;">
            <div style="flex: 2;">
                <!-- Contenido que ocupará el 66.66%, en este caso un espacio -->
            </div>
            <div style="flex: 1; text-align: right;">
                <!-- Contenido que ocupará el 33.33% y se alineará a la derecha -->
                <div style="border: 2px solid #f8e1e8; padding: 10px; display: inline-block;">
                    <span style="font-size: 8.5pt;">Impuestos: (Incluidos)</span><br>
                    <span style="font-size: 8.5pt;">Subtotal: L. {{ number_format($total,2) }}</span><br>
                    <span style="font-size: 12pt; font-weight: 400;">Total: L. {{ number_format($total,2) }}</span>
                </div>
            </div>
        </div>

        <div class="terminos">
            TÉRMINOS Y CONDICIONES
            <ul>
                <li>Los servicios serán realizados por profesionales capacitados en el Salón de Belleza.</li>
                <li>El cliente es responsable de proporcionar cualquier información relevante sobre alergias o condiciones médicas.</li>
            </ul>
        </div>
        <footer style="font-size: 8pt; color: lightgray; text-align: right;">
            {{ $venta->sale_invoice_number }}
        </footer>
    </div>
</body>