<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS traer_compras_por_mes");
        DB::unprepared("DROP PROCEDURE IF EXISTS traer_ventas_por_mes");
        DB::unprepared("DROP PROCEDURE IF EXISTS traer_vendedores");
        DB::unprepared("DROP PROCEDURE IF EXISTS trer_productos_mas_vendidos");

        DB::unprepared("
        CREATE PROCEDURE `traer_ventas_por_mes`(
            IN `pa_anio` INT
        )
        BEGIN

        SELECT 'Enero' AS 'Mes', if(SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) IS NULL, 0,SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) ) AS Total
        FROM detalle_ventas
        INNER JOIN ventas ON ventas.id = detalle_ventas.venta_id
        WHERE month(ventas.sale_invoice_date) = 01 AND year(ventas.sale_invoice_date) = pa_anio

        UNION

        SELECT 'Febrero', if(SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) IS NULL, 0,SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) ) AS total
        FROM detalle_ventas
        INNER JOIN ventas ON ventas.id = detalle_ventas.venta_id
        WHERE month(ventas.sale_invoice_date) = 02 AND year(ventas.sale_invoice_date) = pa_anio

        UNION

        SELECT 'Marzo', if(SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) IS NULL, 0,SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) ) AS total
        FROM detalle_ventas
        INNER JOIN ventas ON ventas.id = detalle_ventas.venta_id
        WHERE month(ventas.sale_invoice_date) = 03 AND year(ventas.sale_invoice_date) = pa_anio

        UNION

        SELECT 'Abril', if(SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) IS NULL, 0,SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) ) AS total
        FROM detalle_ventas
        INNER JOIN ventas ON ventas.id = detalle_ventas.venta_id
        WHERE month(ventas.sale_invoice_date) = 04 AND year(ventas.sale_invoice_date) = pa_anio

        UNION

        SELECT 'Mayo', if(SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) IS NULL, 0,SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) ) AS total
        FROM detalle_ventas
        INNER JOIN ventas ON ventas.id = detalle_ventas.venta_id
        WHERE month(ventas.sale_invoice_date) = 05 AND year(ventas.sale_invoice_date) = pa_anio

        UNION

        SELECT 'Junio', if(SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) IS NULL, 0,SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) ) AS total
        FROM detalle_ventas
        INNER JOIN ventas ON ventas.id = detalle_ventas.venta_id
        WHERE month(ventas.sale_invoice_date) = 06 AND year(ventas.sale_invoice_date) = pa_anio

        UNION

        SELECT 'Julio', if(SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) IS NULL, 0,SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) ) AS total
        FROM detalle_ventas
        INNER JOIN ventas ON ventas.id = detalle_ventas.venta_id
        WHERE month(ventas.sale_invoice_date) = 07 AND year(ventas.sale_invoice_date) = pa_anio

        UNION

        SELECT 'Agosto', if(SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) IS NULL, 0,SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) ) AS total
        FROM detalle_ventas
        INNER JOIN ventas ON ventas.id = detalle_ventas.venta_id
        WHERE month(ventas.sale_invoice_date) = 08 AND year(ventas.sale_invoice_date) = pa_anio

        UNION

        SELECT 'Septiembre', if(SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) IS NULL, 0,SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) ) AS total
        FROM detalle_ventas
        INNER JOIN ventas ON ventas.id = detalle_ventas.venta_id
        WHERE month(ventas.sale_invoice_date) = 09 AND year(ventas.sale_invoice_date) = pa_anio

        UNION

        SELECT 'Octubre', if(SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) IS NULL, 0,SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) ) AS total
        FROM detalle_ventas
        INNER JOIN ventas ON ventas.id = detalle_ventas.venta_id
        WHERE month(ventas.sale_invoice_date) = 10 AND year(ventas.sale_invoice_date) = pa_anio

        UNION

        SELECT 'Noviembre', if(SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) IS NULL, 0,SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) ) AS total
        FROM detalle_ventas
        INNER JOIN ventas ON ventas.id = detalle_ventas.venta_id
        WHERE month(ventas.sale_invoice_date) = 11 AND year(ventas.sale_invoice_date) = pa_anio

        UNION

        SELECT 'Diciembre', if(SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) IS NULL, 0,SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) ) AS total
        FROM detalle_ventas
        INNER JOIN ventas ON ventas.id = detalle_ventas.venta_id
        WHERE month(ventas.sale_invoice_date) = 12 AND year(ventas.sale_invoice_date) = pa_anio ;



        END
        ");

        DB::unprepared("
        CREATE PROCEDURE `traer_compras_por_mes`(
            IN `pa_anio` INT
        )
        BEGIN

        SELECT 'Enero' AS 'Mes', if(SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) IS NULL, 0,SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) ) AS Total
        FROM detalle_compras
        INNER JOIN compras ON compras.id = detalle_compras.compra_id
        WHERE month(compras.purchase_date) = 01 AND year(compras.purchase_date) = pa_anio

        UNION

        SELECT 'Febrero', if(SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) IS NULL, 0,SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) ) AS total
        FROM detalle_compras
        INNER JOIN compras ON compras.id = detalle_compras.compra_id
        WHERE month(compras.purchase_date) = 02 AND year(compras.purchase_date) = pa_anio

        UNION

        SELECT 'Marzo', if(SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) IS NULL, 0,SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) ) AS total
        FROM detalle_compras
        INNER JOIN compras ON compras.id = detalle_compras.compra_id
        WHERE month(compras.purchase_date) = 03 AND year(compras.purchase_date) = pa_anio

        UNION

        SELECT 'Abril', if(SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) IS NULL, 0,SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) ) AS total
        FROM detalle_compras
        INNER JOIN compras ON compras.id = detalle_compras.compra_id
        WHERE month(compras.purchase_date) = 04 AND year(compras.purchase_date) = pa_anio

        UNION

        SELECT 'Mayo', if(SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) IS NULL, 0,SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) ) AS total
        FROM detalle_compras
        INNER JOIN compras ON compras.id = detalle_compras.compra_id
        WHERE month(compras.purchase_date) = 05 AND year(compras.purchase_date) = pa_anio

        UNION

        SELECT 'Junio', if(SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) IS NULL, 0,SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) ) AS total
        FROM detalle_compras
        INNER JOIN compras ON compras.id = detalle_compras.compra_id
        WHERE month(compras.purchase_date) = 06 AND year(compras.purchase_date) = pa_anio

        UNION

        SELECT 'Julio', if(SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) IS NULL, 0,SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) ) AS total
        FROM detalle_compras
        INNER JOIN compras ON compras.id = detalle_compras.compra_id
        WHERE month(compras.purchase_date) = 07 AND year(compras.purchase_date) = pa_anio

        UNION

        SELECT 'Agosto', if(SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) IS NULL, 0,SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) ) AS total
        FROM detalle_compras
        INNER JOIN compras ON compras.id = detalle_compras.compra_id
        WHERE month(compras.purchase_date) = 08 AND year(compras.purchase_date) = pa_anio

        UNION

        SELECT 'Septiembre', if(SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) IS NULL, 0,SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) ) AS total
        FROM detalle_compras
        INNER JOIN compras ON compras.id = detalle_compras.compra_id
        WHERE month(compras.purchase_date) = 09 AND year(compras.purchase_date) = pa_anio

        UNION

        SELECT 'Octubre', if(SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) IS NULL, 0,SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) ) AS total
        FROM detalle_compras
        INNER JOIN compras ON compras.id = detalle_compras.compra_id
        WHERE month(compras.purchase_date) = 10 AND year(compras.purchase_date) = pa_anio

        UNION

        SELECT 'Noviembre', if(SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) IS NULL, 0,SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) ) AS total
        FROM detalle_compras
        INNER JOIN compras ON compras.id = detalle_compras.compra_id
        WHERE month(compras.purchase_date) = 11 AND year(compras.purchase_date) = pa_anio

        UNION

        SELECT 'Diciembre', if(SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) IS NULL, 0,SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) ) AS total
        FROM detalle_compras
        INNER JOIN compras ON compras.id = detalle_compras.compra_id
        WHERE month(compras.purchase_date) = 12 AND year(compras.purchase_date) = pa_anio;


        END
        ");


        DB::unprepared("
        CREATE PROCEDURE `traer_vendedores`(
            IN `pa_anio` INT,
            IN `pa_mes` INT
        )
        BEGIN
            SELECT users.name, sum(detalle_ventas.precio_venta * detalle_ventas.cantidad_detalle_venta) AS total
            FROM detalle_ventas
            INNER JOIN ventas ON ventas.id = detalle_ventas.venta_id
            INNER JOIN users ON users.id = ventas.user_id
            WHERE YEAR(ventas.sale_invoice_date) = pa_anio AND MONTH(ventas.sale_invoice_date) = pa_mes
            GROUP BY users.name;
        END
        ");

        DB::unprepared("
        CREATE PROCEDURE `trer_productos_mas_vendidos`()
        BEGIN
                SELECT SUM(detalle_ventas.cantidad_detalle_venta) AS 'vendidos',
                    productos.id,
                    productos.product_barcode,
                    productos.product_name,
                    productos.product_description,
                    productos.product_stock,
                    productos.product_sell_price,
                    productos.product_image
                FROM detalle_ventas
                INNER JOIN productos ON productos.id = detalle_ventas.producto_id
                GROUP BY productos.id,
                        productos.product_barcode,
                        productos.product_name,
                        productos.product_description,
                        productos.product_stock,
                        productos.product_sell_price,
                        productos.product_image
                ORDER BY SUM(detalle_ventas.cantidad_detalle_venta) DESC
                LIMIT 10;
        END
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {}
};
