</div>
</div>
</div>

<!-- Select -->
<div class="select" style="display: none;" tabindex="-1">
  <table>
  </table>
</div>
</div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="excluirModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmação</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Tem certeza que deseja excluir?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <a href="#" id="confirmSim" class="btn btn-primary">Sim</a>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo URL ?>/public/js/main.js?v=<?php echo time(); ?>"></script>
<script>
if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}
</script>
</body>
</html>
