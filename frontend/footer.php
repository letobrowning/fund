</div>
<?php if(isset($_SESSION['translate_mod'])){ ?>
<div class="modal fade modal_tinymce" id="modal-translate">
	<div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title"><?php echo(t_get_val('Translate')); ?> '<span class="tname"></span>'</h4>
		  </div>
		  <div class="modal-body">
			<div class="row lang_form">
				
			</div>
		  </div>
		  <div class="modal-footer action_wrapper">
			<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?php echo(t_get_val('Close')); ?></button>
			<button type="button" class="btn btn-primary translate_do"><?php echo(t_get_val('Translate')); ?></button>
		  </div>
		</div>
		<!-- /.modal-content -->
	</div>
  <!-- /.modal-dialog -->
</div>
<?php } ?>
<!-- Bootstrap 3.3.7 -->
<script src="/frontend/js/bootstrap/bootstrap.min.js"></script>

<!-- DataTables -->
<script src="/frontend/js/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/frontend/js/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="/frontend/js/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/frontend/js/fastclick/lib/fastclick.js"></script>

<!-- AdminLTE App -->
<script src="/frontend/js/adminlte.min.js"></script>
<!-- tinymce -->
<script src="/frontend/js/tinymce/tinymce.min.js"></script>
<script src="/frontend/js/jquery-ui.min.js"></script>
<script src="/frontend/js/translate.js"></script>
<script src="/frontend/js/my.js"></script>
</body>
</html>