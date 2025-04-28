<div class="modal fade" id="cierreCajaModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="cierreCajaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger" style="color: white; font-size: clamp(0.7rem, 3vw, 1rem);">
                <p class="modal-title fw-bold" id="cierreCajaModalLabel">Cierre de caja - ventas</p>
            </div>
            <div class="modal-body" style="font-size: clamp(0.7rem, 3vw, 0.9rem);">
                <div class="form-group row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <strong><i class="fas fa-calendar-check"></i> Cierre de caja (Hoy)</strong>
                            </div>

                            <div class="card-body">
                                <input style="font-size: clamp(0.8rem, 3vw, 0.9rem);" type="date" class="form-control" id="fechaCierre" name="fechaCierre" max="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">
                            </div>

                            <div class="card-footer">
                                <button style="display: flex; margin: auto; font-size: clamp(0.8rem, 3vw, 0.9rem);" type="button" class="btn btn-sm btn-danger fw-bold" id="cierre_diario_btn" data-toggle="modal" data-target="#cierre_diario_modal">
                                    Exportar cierre diario
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card">
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

                            <div class="card-header">
                                <strong><i class="fas fa-calendar-alt"></i> Cierre de caja (Mensual)</strong>
                            </div>

                            <div class="card-body">
                                <select style="font-size: clamp(0.8rem, 3vw, 0.9rem);" class="form-control" id="fechaCierreMensual" name="fechaCierreMensual">
                                    <?php
                                    $currentMonth = date('n'); // Obtiene el mes actual (1-12)
                                    foreach ($meses as $index => $mes) {
                                        $monthValue = $index + 1; // Valor del mes (1-12)
                                        $selected = ($monthValue == $currentMonth) ? 'selected' : '';
                                        $disabled = ($monthValue > $currentMonth) ? 'disabled' : ''; // Deshabilita los meses futuros
                                        echo "<option value='$monthValue' $selected $disabled>$mes</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="card-footer">
                                <button style="display: flex; margin: auto; font-size: clamp(0.8rem, 3vw, 0.9rem);" type="button" class="btn btn-sm btn-danger fw-bold" id="cerrarCajaMensualBtn" onclick="exportarPDF()">
                                    Exportar cierre mensual
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>