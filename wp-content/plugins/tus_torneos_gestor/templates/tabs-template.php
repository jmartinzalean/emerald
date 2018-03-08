<br><br>
<ul class="nav nav-tabs text-weight">
    <li class="active"><a data-toggle="tab" href="#campos">Campos</a></li>
    <li><a data-toggle="tab" href="#resultados">Resultados</a></li>
</ul>

<div class="tab-content">
    <div id="campos" class="tab-pane fade in active">
    <?php include('camps-template.php');?>
    </div>
    <div id="resultados" class="tab-pane fade">
    <?php include('results-template.php');?>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="ttgModal" tabindex="-1" role="dialog" aria-labelledby="ttgModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Aviso</h4>
      </div>
      <div class="modal-body">
        <p></p>
      </div>
      <div class="modal-footer">
        <button id="ModalClose" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button id="ModalSubmit" type="button" class="btn btn-primary hidden">Guardar datos</button>
      </div>
    </div>
  </div>
</div>

<!-- Loading -->
<div class="modal fade" id="Loading" tabindex="-1" role="dialog" aria-labelledby="LoadingLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body">
        Por favor, espere...
      </div>
    </div>
  </div>
</div>