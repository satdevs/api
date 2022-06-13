<?php

// winktv@saghysat.hu / sTatcCe8sQB2qf8

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Invoice[]|\Cake\Collection\CollectionInterface $invoices
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
	$config['index_show_created'] 		= true;
	$config['index_show_modified'] 		= true;
	//$config['index_show_counts'] 		= true;
	//$config['index_show_actions'] 	= true;
	$config['index_enable_view'] 		= false;
	$config['index_enable_edit'] 		= true;
	$config['index_enable_delete'] 		= true;
	//$config['index_enable_db_click'] 	= true;
	//$config['index_db_click_action'] 	= 'edit';	// edit, view
	//
	//$url = $this->Url->build(['prefix' => $prefix, 'controller' => $controller , 'action' => $config['index_db_click_action']]);

	if(!isset($layoutInvoicesLastId)){
		$layoutInvoicesLastId = 0;
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

				<?php //= __('Invoices') ?>
				<div class="card-body table-responsive p-0 invoices">
<?php //debug($session->read()); ?>
					<table class="table table-hover table-striped table-bordered">
						<thead>
							<tr>
								<th class="row-id-anchor"></th>
<?php if(isset($config['index_show_id']) && $config['index_show_id']){ ?>
								<th class="id integer"><?= $this->Paginator->sort('id') ?></th>
<?php } ?>
								<!-- <th class="full-name string text-center"><?= $this->Paginator->sort('full_name', 'Létrehozó') ?></th> -->
								<th class="sub-id string text-center"><?= $this->Paginator->sort('sub_id', 'Ügyf.sz.') ?></th>
								<th class="name string"><?= $this->Paginator->sort('name') ?></th>
								<th class="invoiceNumber string text-center"><?= $this->Paginator->sort('invoiceNumber', 'Szla.sz.') ?></th>
								<th class="template-id"><?= $this->Paginator->sort('template_id') ?></th>
								<th class="status string text-center"><?= $this->Paginator->sort('status') ?></th>
								<th class="sent datetime"><?= $this->Paginator->sort('sent', 'Kiküldve') ?></th>

<?php /*
								<th class="name string"><?= $this->Paginator->sort('name') ?></th>

								<th class="user-id string"><?= $this->Paginator->sort('user_id') ?></th>

								<th class="email string"><?= $this->Paginator->sort('email') ?></th>
								<th class="filename string"><?= $this->Paginator->sort('filename') ?></th>
								<th class="date date"><?= $this->Paginator->sort('date') ?></th>
								<th class="hash string"><?= $this->Paginator->sort('hash') ?></th>
*/ ?>
<?php if(isset($config['index_show_created']) && $config['index_show_created'] || isset($config['index_show_modified']) && $config['index_show_modified']){ ?>
								<th class="datetime created-modified text-center">
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



<?php if(isset($config['index_show_actions']) && $config['index_show_actions']){ ?>
								<th class="actions"><?= __('Actions') ?></th>
<?php } ?>
							</tr>
						</thead>
						<tbody>
					<?php foreach ($invoices as $invoice): ?>
							<tr row-id="<?= $invoice->id ?>"<?php if($invoice->id == $layoutInvoicesLastId){ echo ' class="table-tr-last-id"'; } ?>  prefix="<?= $prefix ?>" controller="<?= $controller ?>" action="<?= $action ?>" aria-expanded="true">
								<td class="row-id-anchor" value="<?= $invoice->id ?>"><a class="anchor" name="<?= $invoice->id ?>"></a></td><!-- bake-0 -->
<?php if(isset($config['index_show_id']) && $config['index_show_id']){ ?>
								<td class="id integer" name="id" value="<?= $this->Number->format($invoice->id) ?>"><?= $this->Number->format($invoice->id) ?></td><!-- bake-3 -->
<?php } ?>

								<!-- <td class="full-name string text-center" name="sub-id" value="<?= $invoice->my_user->full_name ?>"><?= h($invoice->my_user->full_name) ?></td> -->

								<td class="sub-id string text-center" name="sub-id" value="<?= $invoice->sub_id ?>"><?= h($invoice->sub_id) ?></td><!-- bake-2 -->

								<td class="name string" name="name" value="<?= $invoice->name ?>">
									<b><?= h($invoice->name) ?></b><br><?= h($invoice->email) ?>
								</td>

								<td class="invoiceNumber string text-center" name="invoiceNumber" value="<?= $invoice->invoiceNumber ?>"><?= h($invoice->invoiceNumber) ?></td><!-- bake-2 -->

								<td class="template-id link text-left" value="<?= $invoice->template_id ?>"><?= $invoice->has('template') ? $this->Html->link($invoice->template->title, ['controller' => 'Templates', 'action' => 'edit', $invoice->template->id]) : '' ?></td><!-- bake-1 -->

								<td class="status string text-center" name="status" value="<?= $invoice->status ?>"><?= h($invoice->status) ?></td><!-- bake-2 -->
								<td class="sent datetime" name="sent" value="<?= $invoice->sent ?>"><?= h($invoice->sent) ?></td><!-- bake-2 -->


<?php /*
								<td class="name string" name="name" value="<?= $invoice->name ?>"><?= h($invoice->name) ?></td><!-- bake-2 -->

								<td class="user-id string link text-left" value="<?= $invoice->user_id ?>"><?= $invoice->has('my_user') ? $this->Html->link($invoice->my_user->first_name . " " . $invoice->my_user->last_name, ['controller' => 'MyUsers', 'action' => 'view', $invoice->my_user->id]) : '' ?></td><!-- bake-1 -->

								<td class="email string" name="email" value="<?= $invoice->email ?>"><?= h($invoice->email) ?></td><!-- bake-2 -->
								<td class="filename string" name="filename" value="<?= $invoice->filename ?>"><?= h($invoice->filename) ?></td><!-- bake-2 -->
								<td class="date date" name="date" value="<?= $invoice->date ?>"><?= h($invoice->date) ?></td><!-- bake-2 -->
								<td class="hash string" name="hash" value="<?= $invoice->hash ?>"><?= h($invoice->hash) ?></td><!-- bake-2 -->
*/ ?>

<?php if(isset($config['index_show_created']) && $config['index_show_created'] || isset($config['index_show_modified']) && $config['index_show_modified']){ ?>
								<td class="datetime created-modified text-center">
<?php 	if(isset($config['index_show_created']) && $config['index_show_created']){ ?>
									<?= h($invoice->created) ?>
<?php 	} ?>
<?php 	if(isset($config['index_show_created']) && $config['index_show_created'] && isset($config['index_show_modified']) && $config['index_show_modified']){ ?>
									<br>
<?php 	} ?>
<?php 	if(isset($config['index_show_modified']) && $config['index_show_modified']){ ?>
									<?= h($invoice->modified) ?>
<?php 	} ?>
								</td>
<?php } ?>


<?php if(isset($config['index_show_actions']) && $config['index_show_actions']){ ?>
								<td class="actions text-center">
<?php 	if(isset($config['index_enable_view']) && $config['index_enable_view']){ ?>
									<?= $this->Html->link('<i class="fas fa-eye"></i>', ['action' => 'view', $invoice->id], ['escape' => false, 'class' => 'btn btn-sm bg-gradient-warning action-button-view', 'data-bs-tooltip'=>'tooltip', 'data-bs-placement'=>'top', 'title' => __('View this record')]) ?>
<?php 	} ?>
<?php 	if(isset($config['index_enable_edit']) && $config['index_enable_edit']){ ?>
									<?= $this->Html->link('<i class="fas fa-edit"></i>', ['action' => 'edit', $invoice->id], ['escape' => false, 'class' => 'btn btn-sm bg-gradient-success action-button-edit', 'data-bs-tooltip'=>'tooltip', 'data-bs-placement'=>'top', 'title' => __('Edit this record')]) ?>
<?php 	} ?>
<?php 	if(isset($config['index_enable_delete']) && $config['index_enable_delete']){ ?>
									<?php //= $this->Form->postLink('<i class="fas fa-remove"></i>', ['action' => 'delete', $invoice->id], ['escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $invoice->id), 'class' => 'btn btn-sm bg-gradient-danger action-button-delete']) ?>
									<?= $this->Form->postLink('', ['action' => 'delete', $invoice->id], ['class'=>'crose-btn hide-postlink action-button-delete']) ?>
									<a href="javascript:;" class="btn btn-sm btn-danger delete postlink-delete" data-bs-tooltip="tooltip" data-bs-placement="top" title="<?= __("Delete this record!") ?>" text="<?= h($invoice->name) ?>" subText="<?= __("You will not be able to revert this!") ?>" confirmButtonText="<?= __("Yes, delete it!") ?>" cancelButtonText="<?= __("Cancel") ?>"><i class="icon-minus"></i></a>

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
<?php $url = $this->Url->build(['controller' => 'Invoices', 'action' => $config['index_db_click_action']]); ?>
		$('tr').dblclick( function(){
<?php /* window.location.href = '/<?= $prefix ?>/invoices/<?= $config['index_db_click_action'] ?>/'+$(this).attr('row-id'); */ ?>
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
		$(".pagination a[href^='<?= $base ?>/<?= $prefix ?>/invoices?sort=']").each(function(){
			this.href = this.href.replace("<?= $base ?>/<?= $prefix ?>/invoices?sort=", "<?= $base ?>/<?= $prefix ?>/invoices?page=1&sort=");
		});
		$(".pagination a[href='<?= $base ?>/<?= $prefix ?>/invoices']").each(function(){
			this.href = this.href.replace("<?= $base ?>/<?= $prefix ?>/invoices", "<?= $base ?>/<?= $prefix ?>/invoices?page=1");
		});
<?php } ?>

	});
	<?php $this->Html->scriptEnd(); ?>
