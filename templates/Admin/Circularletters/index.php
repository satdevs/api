<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Circularletter[]|\Cake\Collection\CollectionInterface $circularletters
 */
?>
<?php
	use Cake\Core\Configure;

	//$session 			= $this->getRequest()->getSession();
	//$prefix 			= strtolower( $this->request->getParam('prefix') );
	//$controller 		= $this->request->getParam('controller');	// for DB click on <tr>
	//$action 			= $this->request->getParam('action');		// for DB click on <tr>
	//$passedArgs 		= $this->request->getParam('pass');			// for DB click on <tr>

	$config = Configure::read('Theme.' . $prefix);
	//-------> More config from \config\jeffadmin.php <------
	//$config['index_show_id'] 			= true;
	//$config['index_show_visible'] 	= true;
	//$config['index_show_pos'] 		= true;
	//$config['index_show_created'] 	= true;
	//$config['index_show_modified'] 	= true;
	//$config['index_show_counts'] 		= true;
	//$config['index_show_actions'] 	= true;
	//$config['index_enable_view'] 		= true;
	//$config['index_enable_edit'] 		= true;
	//$config['index_enable_delete'] 	= true;
	//$config['index_enable_db_click'] 	= true;
	//$config['index_db_click_action'] 	= 'edit';	// edit, view
	//
	//$url = $this->Url->build(['prefix' => $prefix, 'controller' => $controller , 'action' => $config['index_db_click_action']]);

	if(!isset($layoutCircularlettersLastId)){
		$layoutCircularlettersLastId = 0;
	}

?>
		<div class="index col-12">
            <div class="card card-lightblue">
				<div class="card-header">
					<h4 class="card-title"><?= __('Index') ?>: <?= $title ?><?php
					if(isset($search) && $search != ''){
						echo " &rarr; " . __('filter') . ": <b>" . $search . "</b>";
					}
				?></h4>
					<div class="card-tools">
						<?= $this->element('JeffAdmin.paginateTop') ?>
					</div>
				</div><!-- ./card-header -->

				<?php //= __('Circularletters') ?>
				<div class="card-body table-responsive p-0 circularletters">
<?php //debug($session->read()); ?>
					<table class="table table-hover table-striped table-bordered text-nowrap">
						<thead>
							<tr>
								<th class="row-id-anchor"></th>
<?php if(isset($config['index_show_id']) && $config['index_show_id']){ ?>
								<th class="id integer"><?= $this->Paginator->sort('id') ?></th>
<?php } ?>
								<th class="name string" scope="col">
									<?= $this->Paginator->sort('name') ?> • (<?= $this->Paginator->sort('sub_id') ?>)<br>
									<?= $this->Paginator->sort('email') ?>
								</th>
								<th class="email string" scope="col"><?= $this->Paginator->sort('template_id') ?></th>
								<th class="tipus string text-center" scope="col"><?= $this->Paginator->sort('tipus') ?></th>
								<th class="status string text-center" scope="col"><?= $this->Paginator->sort('status') ?></th>
								<th class="sent datetime text-center" scope="col"><?= $this->Paginator->sort('sent') ?></th>
								<th class="created datetime" scope="col">
									<?= $this->Paginator->sort('created') ?><br>
									<?= $this->Paginator->sort('modified') ?>
								</th>

<?php /*
								<th class="template-id integer"><?= $this->Paginator->sort('template_id') ?></th>
								<th class="sub-id string"><?= $this->Paginator->sort('sub_id') ?></th>
								<th class="name string"><?= $this->Paginator->sort('name') ?></th>
								<th class="email string"><?= $this->Paginator->sort('email') ?></th>
								<th class="tipus string"><?= $this->Paginator->sort('tipus') ?></th>
								<th class="link string"><?= $this->Paginator->sort('link') ?></th>
								<th class="tmp string"><?= $this->Paginator->sort('tmp') ?></th>
								<th class="status string"><?= $this->Paginator->sort('status') ?></th>
								<th class="sent datetime"><?= $this->Paginator->sort('sent') ?></th>
<?php if(isset($config['index_show_created']) && $config['index_show_created'] || isset($config['index_show_modified']) && $config['index_show_modified']){ ?>
								<th class="datetime created-modified">
<?php 	if(isset($config['index_show_created']) && $config['index_show_created']){ ?>
									<?= $this->Paginator->sort('created') ?>
<?php 	} ?>
<?php 	if(isset($config['index_show_created']) && $config['index_show_created'] && isset($config['index_show_modified']) && $config['index_show_modified']){ ?>
									<br>
<?php 	} ?>
<?php 	if(isset($config['index_show_modified']) && $config['index_show_modified']){ ?>
									<?= $this->Paginator->sort('modified') ?>
<?php 	} ?>
								</th>
<?php } ?>
*/ ?>


<?php if(isset($config['index_show_actions']) && $config['index_show_actions']){ ?>
								<th class="actions"><?= __('Actions') ?></th>
<?php } ?>
							</tr>
						</thead>
						<tbody>
					<?php foreach ($circularletters as $circularletter): ?>
							<tr row-id="<?= $circularletter->id ?>"<?php if($circularletter->id == $layoutCircularlettersLastId){ echo ' class="table-tr-last-id"'; } ?>  prefix="<?= $prefix ?>" controller="<?= $controller ?>" action="<?= $action ?>" aria-expanded="true">
								<td class="row-id-anchor" value="<?= $circularletter->id ?>"><a class="anchor" name="<?= $circularletter->id ?>"></a></td><!-- bake-0 -->
<?php if(isset($config['index_show_id']) && $config['index_show_id']){ ?>
								<td class="id integer" name="id" value="<?= $this->Number->format($circularletter->id) ?>"><?= $this->Number->format($circularletter->id) ?></td><!-- bake-3 -->
<?php } ?>
								<td class="template_id string">
									<b><?= h($circularletter->name) ?></b> • (<?= h($circularletter->sub_id) ?>)<br>
									<?= h($circularletter->email) ?>

								</td>
								<td class="email string"><?= $circularletter->has('template') ? $this->Html->link($circularletter->template->name, ['controller' => 'Templates', 'action' => 'edit', $circularletter->template->id]) : '' ?></td>
								<td class="tipus string text-center"><?= h($circularletter->tipus) ?></td>
								<td class="status string text-center"><?= h($circularletter->status) ?></td>
								<td class="sent datetime text-center"><?= h($circularletter->sent) ?></td>
								<td class="created datetime">
									<?= h($circularletter->created) ?><br>
									<?= h($circularletter->modified) ?>
								</td>

<?php /*
								<td class="template-id integer link text-left" value="<?= $circularletter->template_id ?>"><?= $circularletter->has('template') ? $this->Html->link($circularletter->template->title, ['controller' => 'Templates', 'action' => 'view', $circularletter->template->id]) : '' ?></td><!-- bake-1 -->
								<td class="sub-id string" name="sub-id" value="<?= $circularletter->sub_id ?>"><?= h($circularletter->sub_id) ?></td><!-- bake-2 -->
								<td class="name string" name="name" value="<?= $circularletter->name ?>"><?= h($circularletter->name) ?></td><!-- bake-2 -->
								<td class="email string" name="email" value="<?= $circularletter->email ?>"><?= h($circularletter->email) ?></td><!-- bake-2 -->
								<td class="tipus string" name="tipus" value="<?= $circularletter->tipus ?>"><?= h($circularletter->tipus) ?></td><!-- bake-2 -->
								<td class="link string" name="link" value="<?= $circularletter->link ?>"><?= h($circularletter->link) ?></td><!-- bake-2 -->
								<td class="tmp string" name="tmp" value="<?= $circularletter->tmp ?>"><?= h($circularletter->tmp) ?></td><!-- bake-2 -->
								<td class="status string" name="status" value="<?= $circularletter->status ?>"><?= h($circularletter->status) ?></td><!-- bake-2 -->
								<td class="sent datetime" name="sent" value="<?= $circularletter->sent ?>"><?= h($circularletter->sent) ?></td><!-- bake-2 -->


<?php if(isset($config['index_show_created']) && $config['index_show_created'] || isset($config['index_show_modified']) && $config['index_show_modified']){ ?>
								<td class="datetime created-modified">
<?php 	if(isset($config['index_show_created']) && $config['index_show_created']){ ?>
									<?= h($circularletter->created) ?>
<?php 	} ?>
<?php 	if(isset($config['index_show_created']) && $config['index_show_created'] && isset($config['index_show_modified']) && $config['index_show_modified']){ ?>
									<br>
<?php 	} ?>
<?php 	if(isset($config['index_show_modified']) && $config['index_show_modified']){ ?>
									<?= h($circularletter->modified) ?>
<?php 	} ?>
								</td>
<?php } ?>
*/ ?>

<?php if(isset($config['index_show_actions']) && $config['index_show_actions']){ ?>
								<td class="actions text-center">
<?php 	if(isset($config['index_enable_view']) && $config['index_enable_view']){ ?>
									<?= $this->Html->link('<i class="fas fa-eye"></i>', ['action' => 'view', $circularletter->id], ['escape' => false, 'class' => 'btn btn-sm bg-gradient-warning action-button-view', 'data-bs-tooltip'=>'tooltip', 'data-bs-placement'=>'top', 'title' => __('View this record')]) ?>
<?php 	} ?>
<?php 	if(isset($config['index_enable_edit']) && $config['index_enable_edit']){ ?>
									<?= $this->Html->link('<i class="fas fa-edit"></i>', ['action' => 'edit', $circularletter->id], ['escape' => false, 'class' => 'btn btn-sm bg-gradient-success action-button-edit', 'data-bs-tooltip'=>'tooltip', 'data-bs-placement'=>'top', 'title' => __('Edit this record')]) ?>
<?php 	} ?>
<?php 	if(isset($config['index_enable_delete']) && $config['index_enable_delete']){ ?>
									<?php //= $this->Form->postLink('<i class="fas fa-remove"></i>', ['action' => 'delete', $circularletter->id], ['escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $circularletter->id), 'class' => 'btn btn-sm bg-gradient-danger action-button-delete']) ?>
									<?= $this->Form->postLink('', ['action' => 'delete', $circularletter->id], ['class'=>'crose-btn hide-postlink action-button-delete']) ?>
									<a href="javascript:;" class="btn btn-sm btn-danger delete postlink-delete" data-bs-tooltip="tooltip" data-bs-placement="top" title="<?= __("Delete this record!") ?>" text="<?= h($circularletter->name) ?>" subText="<?= __("You will not be able to revert this!") ?>" confirmButtonText="<?= __("Yes, delete it!") ?>" cancelButtonText="<?= __("Cancel") ?>"><i class="icon-minus"></i></a>

<?php 	} ?>
								</td>
<?php } ?>
							</tr>
						<?php endforeach; ?>
						</tbody>
                </table>
              </div>
              <!-- /.card-body -->

			  <div class="card-footer clearfix">
				<?= $this->element('JeffAdmin.paginateBottom') ?>
				<?php //= $this->Paginator->counter(__('Page  of , showing  record(s) out of  total')) ?>
              </div>

            </div>
            <!-- /.card -->
        </div>

	<?php
	if(isset($config['index_show_actions']) && $config['index_show_actions'] && isset($config['index_enable_delete']) && $config['index_enable_delete']){
		$this->Html->script(
			[
				'JeffAdmin./dist/js/sweetalert_delete',
			],
			['block' => 'scriptBottom']
		);
	}
	?>

<?php $this->Html->scriptStart(['block' => 'javaScriptBottom']); ?>

	$(document).ready( function(){

<?php //if(isset($config['index_enable_db_click']) && $config['index_enable_db_click'] && isset($config['index_enable_edit']) && $config['index_enable_edit'] && $config['index_db_click_action'] && isset($config['index_db_click_action']) ){ ?>
<?php 	if(isset($prefix) && isset($config['index_db_click_action']) && $config['index_db_click_action'] !== ''){ ?>
<?php $url = $this->Url->build(['controller' => 'Circularletters', 'action' => $config['index_db_click_action']]); ?>
		$('tr').dblclick( function(){
<?php /* window.location.href = '/<?= $prefix ?>/circularletters/<?= $config['index_db_click_action'] ?>/'+$(this).attr('row-id'); */ ?>
			window.location.href = '<?= $url . '/' ?>' + $(this).attr('row-id');
		});
<?php 	} ?>
<?php //} ?>

<?php /*
	https://stackoverflow.com/questions/179713/how-to-change-the-href-attribute-for-a-hyperlink-using-jquery  -->
	A pagináció, ha a routerben szerepel az oldal főoldalként, akkor kell mert sessionben tárolódik néhány dolog és...
*/ ?>
<?php
	$base = '';
	if($this->request->getAttribute('base') != '/'){
		$base = $this->request->getAttribute('base');
	}
?>
		$(".pagination a[href^='<?= $base ?>/<?= $prefix ?>?sort=']").each(function(){
			this.href = this.href.replace("<?= $base ?>/<?= $prefix ?>", "<?= $base ?>/<?= $prefix ?>?page=1&sort=");
		});
		$(".pagination a[href='<?= $base ?>/<?= $prefix ?>']").each(function(){
			this.href = this.href.replace("<?= $base ?>/<?= $prefix ?>", "<?= $base ?>/<?= $prefix ?>?page=1");
		});
<?php if(isset($controller)){ ?>
		$(".pagination a[href^='<?= $base ?>/<?= $prefix ?>/circularletters?sort=']").each(function(){
			this.href = this.href.replace("<?= $base ?>/<?= $prefix ?>/circularletters?sort=", "<?= $base ?>/<?= $prefix ?>/circularletters?page=1&sort=");
		});
		$(".pagination a[href='<?= $base ?>/<?= $prefix ?>/circularletters']").each(function(){
			this.href = this.href.replace("<?= $base ?>/<?= $prefix ?>/circularletters", "<?= $base ?>/<?= $prefix ?>/circularletters?page=1");
		});
<?php } ?>

	});
	<?php $this->Html->scriptEnd(); ?>
