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
			$_POST['time'] = time();
			$post = $_POST;
			$array_to_update = array();
			$array_to_update['title'] = $post['title'];
			$array_to_update['time'] = $post['time'];
			$array_to_update['slug'] = $post['slug'];
			$array_to_update['content'] = $post['content'];
			$array_to_update['category'] = $post['category'];
			if($_FILES){
				if( $_FILES['file']['size'] > 0){
					$file = $_FILES['file'];
					$img_upload = image_upload($file);
					if($img_upload){
						//echo('OK');
						//echo($img_upload);
						$array_to_update['img'] = $img_upload;
					}else{
						//echo('NO');
						$errorF = true;
						$error = t_get_val('Img Error');
					}
				}
			}
			$result = article_create($array_to_update);
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
				<form class="form-horizontal" method="POST" role="form" enctype='multipart/form-data'>
				<div class="box-header with-border">
					<h3 class="box-title"><?php echo(t_get_val('Create aticle')); ?></h3>
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
						<div class="row mb15">
							<div class="col-sm-12">
								<div class="checkbox">
								  <label>
									<input type="checkbox" name="only_for_logged" value="1"> <?php echo(t_get_val('Only for loged in')); ?>
								  </label>
								</div>
							</div>
						</div>
						<div class="row mb15">
							<div class="col-sm-12">
									<?php 
									$categorys = category_list();
									
									?>
									<div class="form-group">
									  <label for="inputEmail3" class="col-sm-1 control-label">Category</label>
									  <div class="col-sm-3">
										 <select class="form-control" name="category" id="category" required>
											<?php 
											foreach($categorys as $category){
												?>
												<option value="<?php echo($category['_id']); ?>"><?php echo($category['title'][$_SESSION['lang']]); ?></option>
												<?php
											}
											?>
										  </select>
									  </div>
									 
									</div>
							</div>
						</div>
						<div class="row mb15">
							<div class="col-sm-12">
								  <label>
									<input type="file" name="file">
								  </label>
							</div>
						</div>
						<div class="row content_row">
							<div class="col-sm-12">
								<div class="nav-tabs-custom">
									<ul class="nav nav-tabs">
										<?php 
										$i = 1;
										foreach($langs as $lang_toecho){
											if($i == 1){
												$i++;
												$class = 'active';
											}else{
												$class = '';
											}
										?>
											 <li class="<?php echo($class); ?>"><a href="#tab_<?php echo($lang_toecho); ?>" data-toggle="tab" aria-expanded="false"><b><?php echo(t_get_val('Content')); ?> <span class="title_lang"><?php echo($lang_toecho); ?></span></b></a></li>
										<?php } ?>
									</ul>
									<div class="tab-content">
										<?php 
										$i = 1;
										foreach($langs as $lang_toecho){
											if($i == 1){
												$i++;
												$class = 'active';
											}else{
												$class = '';
											}
										?>
											<div class="tab-pane <?php echo($class); ?>" id="tab_<?php echo($lang_toecho); ?>">
												<?php echo(lang_input('textarea', 'content['.$lang_toecho.']', 'form-control tinymce','txtarea'.$lang_toecho,false,'Content')); ?>
												
											</div>
										<?Php } ?>
									  
									  <!-- /.tab-pane -->
									</div>
									<!-- /.tab-content -->
								  </div>
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