<?php 
if(!isset($_SESSION['admin_login'])){
	header('Location: http://95.179.236.117/?action=admin_login');
}
include($basedir . '/frontend/sidebar_admin.php');
$query = $_GET;

//$page_id = new MongoDB\BSON\ObjectId ('5cfe7d1ed54a3c235262a6e2');
//$client->content->articles->deleteOne(['_id'=>$page_id]);
?>
 <div class="content-wrapper h100vh">
		<!-- Content Header (Page header) -->
		<section class="content-header">
		  <h1>
			<?php echo(t_get_val('articles')); ?>
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
							<a href="/?action=admin&subaction=article_create" class="btn btn-info"><?php echo(t_get_val('Create')); ?></a>
						</div>
					</div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12">
					<?php
						//Получим все страницы
						$articles = article_list();
						$categorys = category_list();
						
						$temp_cat = array();
						foreach($categorys as $category){
							$temp_cat[$category['_id']] = $category;
						}
						//print_r($temp_cat);
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
											<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('Category')); ?></th>
											<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('Publish time')); ?></th>
											<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"><?php echo(t_get_val('Only for loged in')); ?></th>
										</tr>
										</thead>
										<tbody>
											<?php 
											$i = 'odd';
											
											
											foreach($articles as $article){
												//print_r($user);
												$edit_url = ['subaction'=>'article_edit'];
												$edit_url['aid'] = $article['_id'];
												?>
												<tr role="row" class="<?php echo($i); ?>">
													<td class=""><a href="/?<?php echo(updateGET($query,$edit_url)); ?>"><?php echo($article['title'][$_SESSION['lang']]); ?></a></td>
													<td class=""><?php echo($temp_cat[$article['category']]['title'][$_SESSION['lang']]); ?></td>
													<td class=""><?php echo(date('d.m.Y H:i',$article['time'])); ?></td>
													<td><?php echo($article['only_for_logged']); ?></td>
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