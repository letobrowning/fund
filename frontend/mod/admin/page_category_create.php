<?php 
if(!isset($_SESSION['admin_login'])){
	header('Location: /?action=admin_login');
}
include($basedir . '/frontend/sidebar_admin.php'); 
?>

<div class="content-wrapper h100vh">
	<section class="content">
		<pre2>
		<?php 
		if($_POST){
			$result = category_create($_POST);
			if($result < 0){
				//print_r($result);
				$error = '';
				switch ($result) {
					case ERROR_INCORRECT_PARAMETERS:
						$error = t_get_val('ERROR_INCORRECT_PARAMETERS');
						break;
				}
				$errorF = true;
			}else{
				$errorF = false;
				$error = t_get_val('Success');
			}
		}
		?>
		</pre2>
      <div class="row">
        <div class="col-md-12">
			<div class="box box-info">
				<form class="form-horizontal" method="POST" role="form">
				<div class="box-header with-border">
					<h3 class="box-title"><?php echo(t_get_val('Create category')); ?></h3>
				</div>
			<!-- /.box-header -->
			<!-- form start -->

					  <div class="box-body ">
						<div class="row titles_row mb15">
							<?php 
								$langs = get_all_lang_name();
								//print_r($langs);
								foreach($langs as $lang_toecho){
									?>
									<div class="col-sm-4">
										<div class="row">
											<div class="col-sm-12 mb5"><b><?php echo(t_get_val('Title')); ?> <span class="title_lang"><?php echo($lang_toecho); ?></span></b></div>
											<div class="col-sm-12">
												<?php echo(lang_input('text', 'title['.$lang_toecho.']', 'form-control','page_title',true,'Titile')); ?>
											</div>
										</div>
									</div>
									<?php
								}
							?>
						</div>
						<div class="row slug_row mb15">
							<div class="col-sm-12">
								<?php echo(lang_input('text', 'slug', 'form-control','slug',true,'Slug')); ?>
							</div>
						</div>
						<div class="col-sm-12">
						<?php 
							if($_POST){
							  if($errorF){
								  ?>
								  <div class="alert alert-danger alert-dismissible">
									<?php echo($error); ?>
								  </div>
								  <?php
							  }else{
								  
								  ?>
								  <div class="alert alert-success alert-dismissible">
									<?php echo($error); ?>
								  </div>
								  <?php
							  }
							}
						  ?>
						  </div>
					  </div>
					  
					  <!-- /.box-body -->
					  <div class="box-footer">
						<button type="submit" class="btn btn-info pull-right"><?php echo(t_get_val('Create')); ?></button>
					  </div>
					 </form>
					  <!-- /.box-footer -->
					</form>
				</div>
			</div>
		</div>
	</section>
</div>
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