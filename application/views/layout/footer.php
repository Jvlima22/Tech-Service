
 <?php if ($this->router->fetch_class() != 'login') : ?>
<!-- 
Tech Service - TGL Solutions
------------------------------
By: Josué Lima  
E-mail: targetlogsolutions@gmail.com
Todos os direitos reservados
Versão do PHP 7.2.30
-->
      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Tech Service - <?php echo date('Y') ?>&nbsp; | By TGL Solutions</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->
<?php endif; ?>

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Deseja mesmo sair?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Clique em "Sair" para encerrar a sessão.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Não</button>
          <a class="btn btn-primary btn-sm" href="<?php echo base_url('login/logout'); ?>">Sair</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url('public/vendor/jquery/jquery.min.js'); ?>"></script>
  <script src="<?php echo base_url('public/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url('public/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?php echo base_url('public/js/sb-admin-2.min.js'); ?>"></script>
   <!-- Carregando o arquivo util.js-->
   <script src="<?php echo base_url('public/js/util.js'); ?>"></script>
   
    <script src="<?php echo base_url('public/js/summernote-bs4.min.js'); ?>"></script>

  <?php if (isset($scripts)): ?>

<?php foreach ($scripts as $script ) : ?>
  <script src="<?php echo base_url('public/' . $script); ?>"></script>

<?php endforeach; ?>
<?php endif; ?>
<script>
  $(document).ready(function() {
  $('#summernote').summernote({
    height: 200,
  });
  
});
</script>
</body>

</html>
