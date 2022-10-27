<?php 
if(!isset($_SESSION['admin_login'])){
	header('Location: http://95.179.236.117/?action=admin_login');
}
include($basedir . '/frontend/sidebar_admin.php');

$query = $_GET;
?>
 <div class="content-wrapper h100vh">
		<!-- Content Header (Page header) -->
		<section class="content-header">
		  <h1>
			<?php echo(t_get_val('categorys')); ?>
		  </h1>
		  <ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i><?php echo(t_get_val('Home')); ?></a></li>
			<li class="active"><?php echo(t_get_val('Admin panel')); ?></li>
		  </ol>
		</section>
		    <!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-md-12 mb30">
					<div class="row">
						<div class="col-md-4">
							<a href="/?action=admin&subaction=category_create" class="btn btn-info"><?php echo(t_get_val('Create')); ?></a>
						</div>
					</div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12">
					<?php
						//Получим все страницы
						$categorys = category_list();
						//echo($_SESSION['lang']);
					?>
				  <div class="box box-primary">
					<div class="box-body box-profile">
						<div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
							<div class="row">
								<div class="col-sm-12">
									<table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
										<thead>
										<tr role="row">
											<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('Title')); ?></th>
											<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('Slug')); ?></th>
										</tr>
										</thead>
										<tbody>
											<?php 
											$i = 'odd';
											
											
											foreach($categorys as $category){
												$edit_url = ['subaction'=>'category_edit'];
												$edit_url['cid'] = $category['_id'];
												?>
												<tr role="row" class="<?php echo($i); ?>">
												  <td class=""><a href="/?<?php echo(updateGET($query,$edit_url)); ?>"><?php echo($category['title'][$_SESSION['lang']]); ?></a></td>
												  <td class=""><?php echo($category['slug']); ?></td>
												</tr>
												<?php
												if($i == 'odd'){
													$i = 'even';
												}else{
													$i = 'odd';
												}
											}
											
											?>
											
										</tbody>
										<tfoot>
										<tr>
											<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('Title')); ?></th>
											<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('Slug')); ?></th>
										</tr>
										</tfoot>
									</table>
								</div>
							</div>
						</div>
						<pre2>
						<?php 
							
							//print_r($pages);
						?>
						</pre2>
					</div>
					<!-- /.box-body -->
				  </div>
				  <!-- /.box -->
				  <!-- /.box -->
				</div>
			</div>
		</section>
</div>
<script>
  $(function () {
    $('#example2').DataTable()
  })
</script>