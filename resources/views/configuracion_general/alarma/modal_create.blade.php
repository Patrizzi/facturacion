<!-- modal - alarma -->
<div id="modal-alarma" class="modal fade" style="display: none;" aria-modal="true" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel5">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="staticBackdropLabel8">Alarma</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data" id="form_alarma">
                    @csrf
                    <input type="hidden" value="" name="alarma_edit_id" id="id_alarma_edit">
                    <div class="row">
                        <div class="col-sm-4">
                            <select class="form-control" name="select_tipo_alarma" id="select_tipo_alarma" autocomplete="off" required>
                                <option value="">Seleccione tipo</option>
                                <option value="Boleta">Boleta</option>
                                <option value="Factura">Factura</option>
                                <option value="Nota de Credito">Nota de Credito</option>
                                <option value="Personalizado">Personalizado</option>
                            </select>
                        </div>

                        <div class="col-sm-4" id="container_select_alarma" style="display: none;">
                            <select class="form-control" name="select_alarma" id="select_alarma" autocomplete="off" required>
                                <option value="Boleta">Boleta</option>
                                <option value="Factura">Factura</option>
                                <option value="Nota de Credito">Nota de Credito</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Descripción" class="form-control" name="descripcion_alarma" id="descripcion_alarma_edit" autocomplete="off" required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-4">
                            <select class="form-control" name="select_fecha" id="select_fecha" autocomplete="off" required>
                                <option value="Diario">Diario</option>
                                <option value="Semanal">Semanal</option>
                                <option value="Mensual">Mensual</option>
                                <option value="Anual">Anual</option>
                            </select>
                        </div>
                        <div class="col-sm-4" id="extra_selects">
                        </div>
                        <div class="col-sm-4" style="text-align: center">
                            <button class="btn btn-success" type="button" id="add_new_alarma" style="width: 49%">
                                <i class="fa fa-plus"></i> Guardar
                            </button>
                            <button class="btn btn-success" type="button" id="update_alarma" style="display: none; width: 49%">
                                <i class="fa fa-pencil"></i> Actualizar
                            </button>
                            <button class="btn btn-danger" type="button" id="cancel_alarma" style="width: 49%">
                                <i class="fa fa-times"></i> Cancelar
                            </button>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="input-group row">
                    <label class="col-sm-2 col-form-label text-center">Buscar:</label>
                    <input class="form-control col-sm-10" type="text" name="" id="search_alarma">
                </div>
                <br>
                <div class="table-responsive">
                    <!--Tabla-->
                    <table class="table table-striped table-bordered dataTables-alarma">
                        <thead>
                            <tr>
                                <th style="width: 20%;">Código / Descripción</th>
                                <th style="width: 20%;">Tipo</th>
                                <th style="width: 20%;">Alarma</th>
                                <th style="width: 20%;">Estado</th>
                                <th style="width: 20%;">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById("select_tipo_alarma").addEventListener("change", function () {
        const valorSeleccionado = this.value;
        const contenedor = document.getElementById("container_select_alarma");

        if (valorSeleccionado) {
            contenedor.style.display = "block";
        } else {
            contenedor.style.display = "none";
        }
    });

    document.getElementById("select_fecha").addEventListener("change", function () {
        const selected = this.value;
        const container = document.getElementById("extra_selects");
        container.innerHTML = ""; // Limpiar el contenedor

        if (selected === "Semanal") {
            const days = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"];
            const select = document.createElement("select");
            select.id = "select_dia_semanal";
            select.className = "form-control";
            days.forEach(day => {
                const option = document.createElement("option");
                option.value = day;
                option.textContent = day;
                select.appendChild(option);
            });
            container.appendChild(select);

        } else if (selected === "Mensual") {
            const select = document.createElement("select");
            select.id = "select_dia_mensual";
            select.className = "form-control";
            for (let i = 1; i <= 31; i++) {
                const option = document.createElement("option");
                option.value = i;
                option.textContent = i;
                select.appendChild(option);
            }
            container.appendChild(select);

        } else if (selected === "Anual") {
            // Día
            const selectDia = document.createElement("select");
            selectDia.id = "select_dia_anual";
            selectDia.className = "form-control";
            for (let i = 1; i <= 31; i++) {
                const option = document.createElement("option");
                option.value = i;
                option.textContent = i;
                selectDia.appendChild(option);
            }

            // Año
            const selectAnio = document.createElement("select");
            selectAnio.id = "select_anio_anual";
            selectAnio.className = "form-control";
            for (let i = 2020; i <= 2030; i++) {
                const option = document.createElement("option");
                option.value = i;
                option.textContent = i;
                selectAnio.appendChild(option);
            }

            // Crear contenedor para el año
            const divAnio = document.createElement("div");
            divAnio.style.marginTop = "20px";
            divAnio.appendChild(selectAnio);

            // Insertar select del día
            container.appendChild(selectDia);

            // Insertar el contenedor del año debajo del día
            container.appendChild(divAnio);

            // Insertar select del mes al final de la primera columna (después de #select_fecha)
            const fechaContainer = document.getElementById("select_fecha").parentElement;
            const selectMes = document.createElement("select");
            selectMes.id = "select_mes_anual";
            selectMes.className = "form-control";
            const meses = [
                "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
                "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
            ];
            meses.forEach((mes, index) => {
                const option = document.createElement("option");
                option.value = index + 1;
                option.textContent = mes;
                selectMes.appendChild(option);
            });

            // Crear contenedor y meterlo justo después del select_fecha
            const divMes = document.createElement("div");
            divMes.style.marginTop = "20px";
            divMes.appendChild(selectMes);

            // Insertar justo debajo del select de frecuencia
            fechaContainer.appendChild(divMes);
        }
    });
</script>
