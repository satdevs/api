<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Simplepay[]|\Cake\Collection\CollectionInterface $simplepays
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

	if(!isset($layoutSimplepaysLastId)){
		$layoutSimplepaysLastId = 0;
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

				<?php //= __('Simplepays') ?>
				<div class="card-body table-responsive p-0 simplepays">
<?php //debug($session->read()); ?>
					<table class="table table-hover table-striped table-bordered">
						<thead>
							<tr>
								<th class="row-id-anchor"></th>
<?php if(isset($config['index_show_id']) && $config['index_show_id']){ ?>
								<th class="id integer"><?= $this->Paginator->sort('id') ?></th>
<?php } ?>
								<th class="sub_id string text-center" scope="col"><?= $this->Paginator->sort('sub_id','Ügyfél.ID') ?><br><?= $this->Paginator->sort('ids','IDS') ?></th>
								<th class="ipnStatus string text-center" scope="col">
									<?= $this->Paginator->sort('ipnStatus', 'IPN') ?><br>
									<?= $this->Paginator->sort('transaction_id', 'Tr.ID') ?>
								</th>
								<th class="winszlaStatus string text-center" scope="col"><?= $this->Paginator->sort('winszlaStatus', 'WinSzla') ?></th>
								<th class="invoiceId string text-center" scope="col">
									<?= $this->Paginator->sort('invoiceId','Inv.#id') ?><br>
									<?= $this->Paginator->sort('invoiceBiz','Biz.sz.') ?>
								</th>
								<th class="invoiceInsertDate datetime" scope="col">
									<?= $this->Paginator->sort('ipnReceiveDate', 'IPN idő') ?><br>
									<?= $this->Paginator->sort('invoiceInsertDate','Befiz.dátum') ?>
								</th>
								<th class="invoiceUser string text-center" scope="col"><?= $this->Paginator->sort('invoiceUser','User') ?></th>
								<th class="name string" scope="col"><?= $this->Paginator->sort('name') ?></th>
								<th class="amount integer text-center" scope="col" style="width: 100px;"><?= $this->Paginator->sort('amount', 'Összeg') ?></th>
								<!--th class="transaction_id string text-center" scope="col"><?= $this->Paginator->sort('transaction_id', 'Tr.ID') ?></th-->
								<!--th class="ipnReceiveDate datetime text-center" scope="col"><?= $this->Paginator->sort('ipnReceiveDate', 'IPN idő') ?></th-->
								<th class="created datetime" scope="col"><?= $this->Paginator->sort('created', 'Létrehozva') ?><br><?= $this->Paginator->sort('modified','Módosítva') ?></th>
<?php if(isset($config['index_show_actions']) && $config['index_show_actions']){ ?>
								<th class="actions"><?= __('Actions') ?></th>
<?php } ?>
							</tr>
						</thead>
						<tbody>
					<?php
						$i=0;
						$bgcolor = '';
						foreach ($simplepays as $simplepay):
							$bgcolor = ' style="background: #fdd;"';
							$cellbgcolor = '';
							if($i++ % 2 != 0){
								$bgcolor = ' style="background: #fbb;"';
							}
							if($simplepay->ipnStatus == 'FINISHED'){
								$cellbgcolor = 'green';
								$bgcolor = '#ccffcc';
							}
					?>
							<tr row-id="<?= $simplepay->id ?>"<?php if($simplepay->id == $layoutSimplepaysLastId){ echo ' class="table-tr-last-id"'; } ?>  prefix="<?= $prefix ?>" controller="<?= $controller ?>" action="<?= $action ?>" aria-expanded="true">
								<td class="row-id-anchor" value="<?= $simplepay->id ?>"><a class="anchor" name="<?= $simplepay->id ?>"></a></td><!-- bake-0 -->
<?php if(isset($config['index_show_id']) && $config['index_show_id']){ ?>
								<td class="id integer" name="id" value="<?= $this->Number->format($simplepay->id) ?>"><?= $this->Number->format($simplepay->id) ?></td><!-- bake-3 -->
<?php } ?>
								<td class="sub_id string text-center" style="font-weight: bold; padding-top: 0px; padding-bottom: 0px;"><span style="font-size: 20px;"><?= h($simplepay->sub_id) ?></span><br><?= h($simplepay->ids) ?></td>
								<td class="ipnStatus string text-center" style="color: white; background: <?= $cellbgcolor ?>;">
									<b><?= h($simplepay->ipnStatus) ?></b><br>
									<?= h($simplepay->transaction_id) ?>
								</td>

								<?php
								$color = 'red';
								if($simplepay->winszlaStatus == 'NEW'){
									$color = 'red';
								}
								if($simplepay->winszlaStatus == 'PAID'){
									$cellbgcolor = '#bbffbb';
									$color = 'green';
								}
								?>
								<td class="winszlaStatus string text-center" style="font-weight: bold; color:<?= $color ?>;"><?= h($simplepay->winszlaStatus) ?></td>
								<td class="invoiceId string text-center">
								<?php if($simplepay->winszlaStatus == 'PAID'){ ?>
									#<?= h($simplepay->invoiceId) ?><br>
									<b><?= h($simplepay->invoiceBiz) ?></b>
								<?php } ?>
								</td>
								<td class="invoiceInsertDate datetime text-center">
									<?= h($simplepay->ipnReceiveDate) ?>
									<b><?= h($simplepay->invoiceInsertDate) ?></b>
								</td>
								<td class="invoiceUser string text-center"><?= h($simplepay->invoiceUser) ?></td>
								<td class="name string">
									<span style="font-weight: bold;"><?= h($simplepay->name) ?></span>&nbsp;&nbsp;&nbsp;[&nbsp;<?= h($simplepay->email) ?>&nbsp;]<br>
									<span style="font-weight: normal;"><?= h($simplepay->zip) ?> <?= h($simplepay->city) ?>, <?= h($simplepay->address) ?></span>
								</td>
								<td class="amount integer" style="font-weight: bold;"><?=
									$this->Number->format($simplepay->amount, [
										'locale'=>'hu_HU',
										'after'     => ' Ft',
										//'places'=>0,
										//'precision'=>0,
										'pattern'=>'-# ##0',
										//'before'    => '',
									]);
								?></td>

								<!--td class="transaction_id string text-center"><?= h($simplepay->transaction_id) ?></td-->
								<!--td class="ipnReceiveDate datetime text-center"><?= h($simplepay->ipnReceiveDate) ?></td-->
								<td class="created datetime text-center" style="font-size: 14px;">
									<b><?= h($simplepay->created) ?></b><br>
									<?= h($simplepay->modified) ?>
								</td>
								<td class="action text-center">
									<?php //= $this->Html->link('<i class="fas fa-eye"></i>', ['action' => 'view', $simplepay->id], ['escape'=>false, 'role'=>'button', 'class'=>'btn btn-warning btn-sm view', 'data-tooltip'=>'tooltip', 'data-placement'=>'top', 'title'=>__('View this record')]) ?>
									<?= $this->Html->link('<i class="fas fa-edit"></i>', ['action' => 'edit', $simplepay->id], ['escape'=>false, 'role'=>'button', 'class'=>'btn btn-primary btn-sm edit', 'data-tooltip'=>'tooltip', 'data-placement'=>'top', 'title'=>__('Edit this record')]) ?>
								</td>
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
<?php $url = $this->Url->build(['controller' => 'Simplepays', 'action' => $config['index_db_click_action']]); ?>
		$('tr').dblclick( function(){
<?php /* window.location.href = '/<?= $prefix ?>/simplepays/<?= $config['index_db_click_action'] ?>/'+$(this).attr('row-id'); */ ?>
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
		$(".pagination a[href^='<?= $base ?>/<?= $prefix ?>/simplepays?sort=']").each(function(){
			this.href = this.href.replace("<?= $base ?>/<?= $prefix ?>/simplepays?sort=", "<?= $base ?>/<?= $prefix ?>/simplepays?page=1&sort=");
		});
		$(".pagination a[href='<?= $base ?>/<?= $prefix ?>/simplepays']").each(function(){
			this.href = this.href.replace("<?= $base ?>/<?= $prefix ?>/simplepays", "<?= $base ?>/<?= $prefix ?>/simplepays?page=1");
		});
<?php } ?>

	});
	<?php $this->Html->scriptEnd(); ?>
