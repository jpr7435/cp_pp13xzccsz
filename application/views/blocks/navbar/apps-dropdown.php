<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/js/core/tools.js"></script>
<div style="padding: 8px;">
  <h5>Agregar un Ticket</h5>
  <select class="form-control" style="margin-bottom: 5px; margin-top: 5px;" name="dirigido" id="dirigido">
    <option value="0">Responsable</option>
    <option value="1">Coordinador</option>
    <option value="2">Tecnologia</option>
  </select>
  <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
  <button type="button" class="btn btn-success" style="margin: 5px auto;" name="sendticket" id="sendticket">Guardar</button>
</div>
