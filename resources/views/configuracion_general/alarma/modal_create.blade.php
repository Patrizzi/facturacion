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
                        <div class="col-sm-4"  style="text-align: center">
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
                </form>
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
    container.innerHTML = ""; // Limpiar el contenedor central

    // Limpiar también los selects adicionales que se agregan al primer
    const fechaContainer = document.getElementById("select_fecha").parentElement;
    const extraChildren = fechaContainer.querySelectorAll("div");
    extraChildren.forEach(child => child.remove());

    // Restaurar botón Cancelar a su posición original
    const cancelBtn = document.getElementById("cancel_alarma");
    cancelBtn.style.display = "inline-block"; // o el valor que uses por defecto
    cancelBtn.style.marginTop = ""; // remover margen adicional en caso lo tuviera

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
            const selectDia = document.createElement("select");
            selectDia.id = "select_dia_anual";
            selectDia.className = "form-control";
            for (let i = 1; i <= 31; i++) {
                const option = document.createElement("option");
                option.value = i;
                option.textContent = i;
                selectDia.appendChild(option);
            }

            const selectAnio = document.createElement("select");
            selectAnio.id = "select_anio_anual";
            selectAnio.className = "form-control";
            for (let i = 2020; i <= 2030; i++) {
                const option = document.createElement("option");
                option.value = i;
                option.textContent = i;
                selectAnio.appendChild(option);
            }

            const divAnio = document.createElement("div");
            divAnio.style.marginTop = "20px";
            divAnio.appendChild(selectAnio);

            container.appendChild(selectDia);
            container.appendChild(divAnio);

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

            const divMes = document.createElement("div");
            divMes.style.marginTop = "20px";
            divMes.appendChild(selectMes);
            fechaContainer.appendChild(divMes);

            //  Mover botón Cancelar debajo de Guardar
            const colBotones = document.querySelector("#add_new_alarma").parentElement;
            colBotones.appendChild(cancelBtn);
            cancelBtn.style.display = "block";
            cancelBtn.style.marginTop = "20px";

            // Asegurar que el contenedor use flex en columna
            //colBotones.classList.add("d-flex", "flex-column", "align-items-stretch");

            // Aplicar clases al botón Guardar para que tenga margen inferior y se alinee bien
            //document.getElementById("add_new_alarma").classList.add("mb-2", "w-100");

            // Configurar y alinear el botón Cancelar
            //cancelBtn.style.display = "block";
            //cancelBtn.classList.add("btn", "btn-danger", "w-100", "mt-0");

            // Agregarlo debajo del botón Guardar
            //colBotones.appendChild(cancelBtn);
            }

    });
</script>
