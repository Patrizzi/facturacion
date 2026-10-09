 <!-- Modal AGREGAR CON UN CLICK UN ARTICULO -->
 <div class="modal fade bd-example-modal-lg" id="add_product_data" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
     <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLongTitle">Agregado Rápido de Artículos</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <div class="row">
                     <div class="col-lg-12" style="margin-bottom: 15px">
                         <input type="text" name="" id="search_product" class="form-control"
                             placeholder="Buscar por código o nombre del producto o Servicio" autocomplete="off">
                         <small style="padding-right: 12px;padding-left: 12px ">Filtrado por Producto o Servicio</small>
                     </div>
                     <div class="col-lg-12">
                         <div class="table-responsive">
                             <table class="table table-striped table-hover data_table_multiple"
                                 style="font-size: 90%;border-top: 1px solid #e7eaec;">
                                 <thead>
                                     <tr>
                                         <th>ID</th>
                                         <th>CÓDIGO</th>
                                         <th>ARTÍCULO</th>
                                         <th>CANTIDAD</th>
                                         <th>PRECIO U. SUGERIDO </th>
                                         <th>PRECIO S/IGV</th>
                                         <th>PRECIO C/IGV</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                 </tbody>
                             </table>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" id="close_add_product_data"
                     data-dismiss="modal">Cerrar</button>
             </div>
         </div>
     </div>
 </div>
