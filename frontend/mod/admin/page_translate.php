 <?php 
if(!isset($_SESSION['admin_login'])){
	header('Location: http://95.179.236.117/?action=admin_login');
}
include($basedir . '/frontend/sidebar_admin.php');
?> 
<div class="content-wrapper h100vh">
		<!-- Content Header (Page header) -->
		<section class="content-header">
		  <h1>
			<?php echo(t_get_val('Plans')); ?>
		  </h1>
		  <ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> <?php echo(t_get_val('Home')); ?></a></li>
			<li class="active"><?php echo(t_get_val('Plans')); ?></li>
		  </ol>
		</section>
		    <!-- Main content -->
    <section class="content">
        <div class="row">
			<div class="col-md-12">
				<div class="box box-primary">
					<div class="box-body box-profile">
						
						<?php 
						$tinyflag = false;
						$all_langs = get_all_lang_name();
						//print_r($all_langs);
						$result = array();
						$keys = array();
						//Соберем все значения в массив и посмотрим тип
						foreach($all_langs as $langs){
							$lang_array = t_file_get($langs);
							foreach($lang_array as $key=>$value){
								$keys[$key] = $key;
								//Если html то подключим редактор
								if($value[1] != strip_tags($value[1])) {
									//echo('tinymce '.$key.'<br>');
									//echo($value[1].'<br>');
									$result[$langs][$key]['type'] = 'tinymce';
									$tinyflag = true;
								}else{
									$result[$langs][$key]['type'] = 'input';
								}
								$result[$langs][$key]['value'] = $value[1];
							}
						}
						?>
						<div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
							<div class="row">
								<div class="col-sm-12">
									<table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
										<thead>
											<tr role="row">
												<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('T. key')); ?></th>
												<?php 
												foreach($all_langs as $hlang){
													?>
													<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo($hlang); ?></th>
													<?php
												}
												
												?>
												<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('Update')); ?></th>
											</tr>
										</thead>
										<tbody>
											<?php 
											$i = 'odd';
											$tk = 1;
											foreach($keys as $t_array){
												?>
												<tr role="row" class="<?php echo($i); ?>">
													<td class="tkey"><?php echo($t_array); ?></td>
													<?php 
													$tk2 = 1;
													foreach($all_langs as $lang_to_show){
														if($result[$lang_to_show][$t_array]['type'] == 'input'){
														?>
															<td class="">
																<div class="form-group">
																	<input class="form-control l_text" data-lang="<?php echo($lang_to_show); ?>" placeholder="Translate text" value="<?php echo($result[$lang_to_show][$t_array]['value']); ?>">
																	<span class="help-block" style="display:none;"></span>
																</div>
															</td>
														<?php
														}else{
														?>
															<td class="">
																<a  class="btn btn-info modal_tinymce_action" data-lang="<?php echo($lang_to_show); ?>" data-tkey="<?php echo($t_array); ?>" data-toggle="modal" data-target="#modal-tinymce"><?php echo(t_get_val('Show editor')); ?></a>
																<div style="display:none;">
																	<?php echo($result[$lang_to_show][$t_array]['value']); ?>
																</div>
															</td>
														<?php	
															
														}
														$tk2++;
													}
													if($result[$lang_to_show][$t_array]['type'] == 'input'){
														?>
														<td class="">
															<button type="button" class="btn btn-primary translate_do_admin_input" ><?php echo(t_get_val('Update')); ?></button>
														</td>
													<?php } else{
														?>
														<td class="">
															
														</td>
														<?php
													}
													?>
												</tr>
												
												<?php
												if($i == 'odd'){
													$i = 'even';
												}else{
													$i = 'odd';
												}
												$tk++;
											}
											
											?>
										</tbody>
										<tfoot>
											<tr role="row">
												<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('T. key')); ?></th>
												<?php 
												foreach($all_langs as $hlang){
													?>
													<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo($hlang); ?></th>
													<?php
												}
												
												?>
												<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('Update')); ?></th>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>
						</div>
						<?php 
						if($tinyflag){
						echo("
								<script>
								$( document ).ready(function() {
								  tinymce.init({
									selector: '.tinymce',
									protect: [
									/\<\/?(if|endif)\>/g,  // Protect <if> & </endif>
									/\<xsl\:[^>]+\>/g,  // Protect <xsl:...>
									/<\?php.*?\?>/g  // Protect php code
								  ],
								  images_upload_url: 'postAcceptor.php',
								  images_upload_base_path: '/some/basepath',
								  images_upload_credentials: true,
									  height: 200,
									  language: 'ru',
								  theme: 'modern',
								  plugins: 'fullpage searchreplace autolink directionality visualblocks visualchars fullscreen codesample charmap hr pagebreak nonbreaking toc insertdatetime advlist lists textcolor wordcount   contextmenu colorpicker textpattern help code link table',
								  toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor fontsizeselect | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | link | table | code | removeformat ',
								  image_advtab: true,
								  content_css: [
									'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
									'//www.tinymce.com/css/codepen.min.css'
								  ]
								  });
								});
								</script>
						
						");
					}
						
						?>
						
						<pre>
						<?php //print_r($result); ?>
						</pre>
					</div>
					<!-- /.box-body -->
				  </div>
			</div>

		</div>
	</section>
	<div class="modal fade modal_tinymce" id="modal-tinymce">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><?php echo(t_get_val('Translate')); ?> '<span class="tname"></span>'</h4>
			  </div>
			  <div class="modal-body">
				<textarea id="txtarea_tiny_translate" class="form-control l_text tinymce" placeholder="Translate text" required ></textarea>
			  </div>
			  <div class="modal-footer action_wrapper">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?php echo(t_get_val('Close')); ?></button>
				<button type="button" class="btn btn-primary translate_do_admin"><?php echo(t_get_val('Update')); ?></button>
			  </div>
			</div>
			<!-- /.modal-content -->
		  </div>
		  <!-- /.modal-dialog -->
	</div>
</div>
<script>
  $(function () {
	$('#example2').DataTable({
		'ordering'    : true,
		'lengthChange': true,
		'searching'   : true,
	});
  });
</script>