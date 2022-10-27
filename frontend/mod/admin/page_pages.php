<?php 
if(!isset($_SESSION['admin_login'])){
	header('Location: http://95.179.236.117/?action=admin_login');
}
include($basedir . '/frontend/sidebar_admin.php');
//Удаляем лишнюю страницу
//5cfa5babd54a3c7f7b7e0995
//$page_id = new MongoDB\BSON\ObjectId ('5cfa5babd54a3c7f7b7e0995');
//$client->content->pages->deleteOne(['_id'=>$page_id]);


//Добавляем страницы, после переноса

//Страницы категорий
/*
$page_test = array();
$page_test['type'] = 'static';
$page_test['title']['en'] = 'News';
$page_test['title']['ru'] = 'Новости';
$page_test['slug'] = 'news';
$page_test['bloks'] = [
	'info'=>['type'=>'text']
];
page_create($page_test);
//News
//5cfa5cabd54a3c15a531d4b2

//FAQ
//5cfa5c98d54a3c158c498192
*/

/*
//Главная
$page_test = array();
$page_test['type'] = 'static';
$page_test['title']['en'] = 'Main';
$page_test['title']['ru'] = 'Главная';
page_create($page_test);
//5cfa5b7cd54a3c0e6203d5e2

//Добавление статик страниц по типам планов (PLAN_TYPE_TRADING, PLAN_TYPE_MINING, PLAN_TYPE_INDEX)

$page_test = array();
$page_test['type'] = 'static';
$page_test['title']['en'] = 'Smart trading';
$page_test['title']['ru'] = 'Smart trading ru';
$page_test['slug'] = 'smart_trading';
page_create($page_test);
//5cfa5b7cd54a3c0e6203d5e3

$page_test = array();
$page_test['type'] = 'static';
$page_test['title']['en'] = 'Smart mining';
$page_test['title']['ru'] = 'Smart mining ru';
$page_test['slug'] = 'smart_mining';
page_create($page_test);
//5cfa5b7cd54a3c0e6203d5e4

$page_test = array();
$page_test['type'] = 'static';
$page_test['title']['en'] = 'Smart index';
$page_test['title']['ru'] = 'Smart index ru';
$page_test['slug'] = 'smart_index';
//5cfa5b7cd54a3c0e6203d5e5

page_create($page_test);
*/



//Протестируем добавление страницы
/*
$page_test = array();
$page_test['type'] = 'static';
$page_test['title']['en'] = 'Main';
$page_test['title']['ru'] = 'Главная';

$pid = '5cb09608e58faa4df30f5cd2';
$page_id = new MongoDB\BSON\ObjectId ($pid);
$data = array();
$data['bloks'] = [

	'main_page_t2st1'=>['type'=>'text'],
	'main_page_t5st1'=>['type'=>'text'],
];
$result_update = page_modify(['_id'=>$page_id],$data);

echo($result_update);

$pid = '5cb09608e58faa4df30f5cd2';
$page_id = new MongoDB\BSON\ObjectId ($pid);
$data = array();
$data['bloks'] = [
	'main_page_t_m_1'=>['type'=>'text'],
		'main_page_d_m_1'=>['type'=>'text'],
	'main_page_t_m_2'=>['type'=>'text'],
	'main_page_t_m_3'=>['type'=>'text'],
	'main_page_t1'=>['type'=>'title'],
	'main_page1'=>['type'=>'text'],
	'main_page_t2'=>['type'=>'title'],
		'main_page_t2st1'=>['type'=>'text'],
		'main_page_t2st2'=>['type'=>'title'],
		'main_page_t2st3'=>['type'=>'title'],
	
	'main_page_t3'=>['type'=>'title'],
	'main_page_text3'=>['type'=>'text'],
	'main_page_t4'=>['type'=>'title'],
	'main_page_t5'=>['type'=>'title'],
		'main_page_t5st1'=>['type'=>'text'],
		'main_page_t5st2'=>['type'=>'title'],
		'main_page_t5st3'=>['type'=>'title'],

];
$result_update = page_modify(['_id'=>$page_id],$data);

echo($result_update);

//Добавление статик страниц по типам планов (PLAN_TYPE_TRADING, PLAN_TYPE_MINING, PLAN_TYPE_INDEX)

$page_test = array();
$page_test['type'] = 'static';
$page_test['title']['en'] = 'Smart trading';
$page_test['title']['ru'] = 'Smart trading ru';
$page_test['slug'] = 'smart_trading';
page_create($page_test);
//5cc21822e58faa0fad4841d2

$page_test = array();
$page_test['type'] = 'static';
$page_test['title']['en'] = 'Smart mining';
$page_test['title']['ru'] = 'Smart mining ru';
$page_test['slug'] = 'smart_mining';
page_create($page_test);
//5cc21822e58faa0fad4841d3

$page_test = array();
$page_test['type'] = 'static';
$page_test['title']['en'] = 'Smart index';
$page_test['title']['ru'] = 'Smart index ru';
$page_test['slug'] = 'smart_index';
//5cc21822e58faa0fad4841d4

page_create($page_test);

$pid = '5cc21822e58faa0fad4841d2';
$page_id = new MongoDB\BSON\ObjectId ($pid);
$data = array();
$data['bloks'] = [
	'info'=>['type'=>'text']
];
page_modify(['_id'=>$page_id],$data);

$pid = '5cc21822e58faa0fad4841d3';
$page_id = new MongoDB\BSON\ObjectId ($pid);
page_modify(['_id'=>$page_id],$data);

$pid = '5cc21822e58faa0fad4841d4';
$page_id = new MongoDB\BSON\ObjectId ($pid);
page_modify(['_id'=>$page_id],$data);

//faq

$page_test = array();
$page_test['type'] = 'static';
$page_test['title']['en'] = 'FAQ';
$page_test['title']['ru'] = 'FAQ';
$page_test['slug'] = 'faq';
$page_test['bloks'] = [
	'info'=>['type'=>'text']
];
page_create($page_test);
*/
$query = $_GET;
?>
 <div class="content-wrapper h100vh">
		<!-- Content Header (Page header) -->
		<section class="content-header">
		  <h1>
			<?php echo(t_get_val('Admin panel')); ?>
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
							<a href="/?action=admin&subaction=page_create" class="btn btn-info"><?php echo(t_get_val('Create')); ?></a>
						</div>
					</div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12">
					<?php
						//Получим все страницы
						$pages = page_list();
						//echo($_SESSION['lang']);
					?>
				  <div class="box box-primary">
					<div class="box-body box-profile">
						<pre2>
							<?php //print_r($pages); ?>
						</pre2>
						<div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
							<div class="row">
								<div class="col-sm-12">
									<table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
										<thead>
										<tr role="row">
											<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('Title')); ?></th>
											<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('Type')); ?></th>
											<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"><?php echo(t_get_val('Only for loged in')); ?></th>
										</tr>
										</thead>
										<tbody>
											<?php 
											$i = 'odd';
											
											
											foreach($pages as $page){
												//print_r($user);
												if($page['type'] == 'dynamic'){
													$edit_url = ['subaction'=>'page_edit'];
												}
												if($page['type'] == 'static'){
													$edit_url = ['subaction'=>'page_edit_static'];
												}
												$edit_url['pid'] = $page['_id'];
												?>
												<tr role="row" class="<?php echo($i); ?>">
												  <td class=""><a href="/?<?php echo(updateGET($query,$edit_url)); ?>"><?php echo($page['title'][$_SESSION['lang']]); ?></a></td>
												  <td class=""><?php echo($page['type']); ?></td>
												  <td><?php echo($page['only_for_logged']); ?></td>
												 
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
											<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('Type')); ?></th>
											<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"><?php echo(t_get_val('Only for loged in')); ?></th>
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