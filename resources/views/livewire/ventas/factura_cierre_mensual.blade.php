<?php
$meses = array(
    "Enero",
    "Febrero",
    "Marzo",
    "Abril",
    "Mayo",
    "Junio",
    "Julio",
    "Agosto",
    "Septiembre",
    "Octubre",
    "Noviembre",
    "Diciembre"
);
?>

<title>Ventas (Cierre mensual) - <?php echo $meses[$mesSeleccionado - 1]; ?> - {{ \Carbon\Carbon::now()->format('Y') }} </title>

<body>
    <div id="page_pdf">
        <header style="background-color: rgba(0, 89, 255, 0.64); display: flex; justify-content: space-between; align-items: center; border: 2px solid #ddd; border-radius: 10px; padding: 10px; margin-bottom: 20px; margin-top: 5px; overflow: hidden;">
            <div style="text-align: right; margin-top: 10px; margin-bottom: 10px; padding: 20px;">
                <div style="float: left;">
                    <img src="{{ $image_logo }}" alt="Logo" style="width: 370px; height: 405px; margin-left: -80px; margin-top: -130px">
                </div>
                <h1 style="font-size: 20pt; text-decoration: underline; font-style: italic; margin: 0; font-weight: bold; color: rgba(255,255,255,0.3);">VENTAS - CIERRE MENSUAL</h1>
                <h1 style="font-size: 15pt; margin: 10px 0 0 0; font-weight: bold; color: white">{{ config('app.name') }}</h1>
                <p style="margin: 5px 0; font-size: 9pt; color: white"><strong>Mes:</strong> <?php echo $meses[$mesSeleccionado - 1]; ?> - {{ \Carbon\Carbon::now()->format('Y') }}</p>
                <p style="margin: 5px 0; font-size: 9pt; color: white"><strong>Fecha actual:</strong>&nbsp;&nbsp;{{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>
                <p style="margin: 5px 0; font-size: 9pt; color: white"><strong>Hora actual:</strong>&nbsp;&nbsp;{{ \Carbon\Carbon::now()->format('h:i A') }}</p>
            </div>
        </header>

        <h4 style="text-align: right;">LISTADO DE PRODUCTOS VENDIDOS EN EL MES (<?php echo $meses[$mesSeleccionado - 1]; ?> - {{ \Carbon\Carbon::now()->format('Y') }})</h4>


        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead style="font-size: 0.7rem; color: #fff; background-color: rgba(0, 89, 255, 0.64);">
                <tr>
                    <th style="text-align: center">Nº</th>
                    <th style="text-align: center">EMPLEADO</th>
                    <th style="text-align: center">FECHA/HORA</th>
                    <th style="text-align: center">PRODUCTO</th>
                    <th style="text-align: center">CANTIDAD</th>
                    <th style="text-align: center; width: 70px">PRECIO</th>
                    <th style="text-align: center; width: 90px">SUBTOTAL</th>
                </tr>
            </thead>
            <tbody style="font-size: 0.7rem;">
                @php
                $total=0;
                @endphp
                @if(count($ventas) > 0)
                @foreach ($ventas as $i => $venta)
                @foreach ($venta->detalle_venta as $detalle)
                <tr>
                    <td style="text-align: center; width: 45px; font-size: 7pt">{{++$i}}</td>
                    <td style="text-align: center; color: gray; text-transform: uppercase; font-size: 7pt">{{ $venta->user->name }}</td>
                    <td style="text-align: center; font-size: 7pt; max-width: 20px">{{ $detalle->created_at->format('d-m-Y h:i:s A') }}</td>
                    <td style="text-align: center; font-size: 7.7pt; max-width: 50px; word-wrap: break-word;">{{ $detalle->producto->product_name }}</td>
                    <td style="text-align: center">{{ $detalle->cantidad_detalle_venta }}</td>
                    <td style="text-align: center">L. {{ number_format($detalle->precio_venta, 2, ".", ",") }}</td>
                    <td style="text-align: center">L. {{ number_format($detalle->precio_venta * $detalle->cantidad_detalle_venta, 2, ".", ",") }}</td>
                </tr>
                @php
                $total+=$detalle->precio_venta*$detalle->cantidad_detalle_venta;
                @endphp
                @endforeach
                @endforeach
                @else
                <tr>
                    <td colspan="7" style="text-align: center;">
                        No existen ventas registradas este mes para ser mostradas.
                    </td>
                </tr>
                @endif
            </tbody>
            <tfoot id="detalle_totales">
                <tr>
                    <th></th>
                    <th style="text-align: center;">
                        <h4>TOTAL VENTAS</h4>
                    </th>
                    <th colspan="4"></th>
                    <th style="text-align: center;">
                        <h4>L. {{ number_format($total, 2, ".", ",") }}</h4>
                    </th>
                </tr>
            </tfoot>
        </table>
    </div>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            padding-top: 10mm;
            padding-bottom: 10mm;
            margin: 0;
        }

        #page_pdf {
            width: 95%;
            margin: auto;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: rgba(0, 89, 255, 0.64);
            color: white;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</body>