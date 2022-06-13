<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Simplepay $simplepay
 */
?>
<?php // Baked at 2022.05.09. 10:42:08  ?>
<?php use Cake\Core\Configure; ?>
<?php use Cake\I18n\FrozenTime; ?>
<?php use Cake\I18n\I18n; ?>
<?php 
	$prefix = strtolower( $this->request->getParam('prefix') );	
	$config = Configure::read('Theme.' . $prefix);	
	$config['form_show_counts'] = false;
?>
<?php $locale = I18n::getLocale(); ?>
<?php //$formats = Configure::read('Formats'); ?>
<?php //$format = $formats[$locale]; ?>
		<div class="add col-sm-10">
			<div class="card card-lightblue">
				<div class="card-header">
					<h3 class="card-title"><?= __('Add') ?>: <?= $title ?><i id="card-loader-icon" class="icon-spin4 animate-spin" style="font-size: 24px; opacity: 1; color: white; font-weight: bold;"></i></h3>
				</div><!-- /.card-header -->

				<!-- form start -->
				<?= $this->Form->create($simplepay, ['id' => 'main-form', 'class'=>'form-horizontal']) ?>
			  
					<!-- card-body -->
					<div class="card-body" style="opacity: 0;">
						<!-- 6. string -->
						<div class="form-group row">
							<label for="sub-id" class="col-sm-2 col-form-label"><?= __('Sub Id') ?>:</label>
							<div class="col-sm-9">
								<?= $this->Form->control('sub_id', ['placeholder' => __(''), 'type'=>'text', 'class'=>'form-control', 'label' => false, 'autofocus' => false, "required" => false]) ?>
							</div>
						</div>

						<!-- 6. string -->
						<div class="form-group row">
							<label for="retEvent" class="col-sm-2 col-form-label"><?= __('RetEvent') ?>:</label>
							<div class="col-sm-9">
								<?= $this->Form->control('retEvent', ['placeholder' => __(''), 'type'=>'text', 'class'=>'form-control', 'label' => false, 'autofocus' => false, "required" => false]) ?>
							</div>
						</div>

						<!-- 6. string -->
						<div class="form-group row">
							<label for="ipnStatus" class="col-sm-2 col-form-label"><?= __('IpnStatus') ?>:</label>
							<div class="col-sm-9">
								<?= $this->Form->control('ipnStatus', ['placeholder' => __(''), 'type'=>'text', 'class'=>'form-control', 'label' => false, 'autofocus' => false, "required" => false]) ?>
							</div>
						</div>

						<!-- 6. string -->
						<div class="form-group row">
							<label for="winszlaStatus" class="col-sm-2 col-form-label"><?= __('WinszlaStatus') ?>:</label>
							<div class="col-sm-9">
								<?= $this->Form->control('winszlaStatus', ['placeholder' => __(''), 'type'=>'text', 'class'=>'form-control', 'label' => false, 'autofocus' => false, "required" => false]) ?>
							</div>
						</div>

						<!-- 6. string -->
						<div class="form-group row">
							<label for="invoiceId" class="col-sm-2 col-form-label"><?= __('InvoiceId') ?>:</label>
							<div class="col-sm-9">
								<?= $this->Form->control('invoiceId', ['placeholder' => __(''), 'type'=>'text', 'class'=>'form-control', 'label' => false, 'autofocus' => false, "required" => false]) ?>
							</div>
						</div>

						<!-- 6. string -->
						<div class="form-group row">
							<label for="invoiceBiz" class="col-sm-2 col-form-label"><?= __('InvoiceBiz') ?>:</label>
							<div class="col-sm-9">
								<?= $this->Form->control('invoiceBiz', ['placeholder' => __(''), 'type'=>'text', 'class'=>'form-control', 'label' => false, 'autofocus' => false, "required" => false]) ?>
							</div>
						</div>

						<?php // https://tempusdominus.github.io/bootstrap-4/Usage/ ?>
						<!-- 3. datetime -->
						<div class="form-group row">
							<label for="invoiceInsertDate" class="col-sm-2 col-form-label"><?= __('InvoiceInsertDate') ?>:</label>
							<div class="col-md-10 col-sm-10 col-xs-10">
								<div class="input-group datetime" id="invoiceInsertDate" data-target-input="nearest">
									<?= $this->Form->control('invoiceInsertDate', ['type'=>'text', 'label'=>false, 'placeholder' => __('InvoiceInsertDate'), 'class'=>'form-control datetimepicker-input', 'data-target'=>'#invoiceInsertDate', 'autocomplete'=>'off', 'data-validity-message'=>__('This field cannot be left empty'), "required" => false]); ?>
									<div class="input-group-append" data-target="#invoiceInsertDate" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="icon-calendar"></i></div>
									</div>
								</div>
							</div>
						</div>

						<!-- 6. string -->
						<div class="form-group row">
							<label for="invoiceUser" class="col-sm-2 col-form-label"><?= __('InvoiceUser') ?>:</label>
							<div class="col-sm-9">
								<?= $this->Form->control('invoiceUser', ['placeholder' => __(''), 'type'=>'text', 'class'=>'form-control', 'label' => false, 'autofocus' => false, "required" => false]) ?>
							</div>
						</div>

						<!-- 6. string -->
						<div class="form-group row">
							<label for="ids" class="col-sm-2 col-form-label"><?= __('Ids') ?>:</label>
							<div class="col-sm-9">
								<?= $this->Form->control('ids', ['placeholder' => __(''), 'type'=>'text', 'class'=>'form-control', 'label' => false, 'autofocus' => false, "required" => false]) ?>
							</div>
						</div>

						<!-- 6. string -->
						<div class="form-group row">
							<label for="name" class="col-sm-2 col-form-label"><?= __('Name') ?>:</label>
							<div class="col-sm-9">
								<?= $this->Form->control('name', ['placeholder' => __(''), 'type'=>'text', 'class'=>'form-control', 'label' => false, 'autofocus' => true, "required" => false]) ?>
							</div>
						</div>

						<!-- 4.a. integer -->
						<div class="form-group row">
							<label for="amount" class="col-sm-2 col-form-label"><?= __('Amount') ?>:</label>
							<div class="input-group col-xs-12 col-sm-10 col-md-8 col-lg-4 col-xl-3">
								<?= $this->Form->control('amount', ['type' => 'number', 'class' => 'form-control number', 'label' => false, 'templates'=>[ 'inputContainer' => '{{content}}', 'inputContainerError' => '{{content}}{{error}}'], "required" => false]) ?>
							</div>
						</div>

						<!-- 6. string -->
						<div class="form-group row">
							<label for="retResponseCode" class="col-sm-2 col-form-label"><?= __('RetResponseCode') ?>:</label>
							<div class="col-sm-9">
								<?= $this->Form->control('retResponseCode', ['placeholder' => __(''), 'type'=>'text', 'class'=>'form-control', 'label' => false, 'autofocus' => false, "required" => false]) ?>
							</div>
						</div>

						<!-- 6. string -->
						<div class="form-group row">
							<label for="retTransactionId" class="col-sm-2 col-form-label"><?= __('RetTransactionId') ?>:</label>
							<div class="col-sm-9">
								<?= $this->Form->control('retTransactionId', ['placeholder' => __(''), 'type'=>'text', 'class'=>'form-control', 'label' => false, 'autofocus' => false, "required" => false]) ?>
							</div>
						</div>

						<!-- 6. string -->
						<div class="form-group row">
							<label for="retMercant" class="col-sm-2 col-form-label"><?= __('RetMercant') ?>:</label>
							<div class="col-sm-9">
								<?= $this->Form->control('retMercant', ['placeholder' => __(''), 'type'=>'text', 'class'=>'form-control', 'label' => false, 'autofocus' => false, "required" => false]) ?>
							</div>
						</div>

						<!-- 6. string -->
						<div class="form-group row">
							<label for="retOrderId" class="col-sm-2 col-form-label"><?= __('RetOrderId') ?>:</label>
							<div class="col-sm-9">
								<?= $this->Form->control('retOrderId', ['placeholder' => __(''), 'type'=>'text', 'class'=>'form-control', 'label' => false, 'autofocus' => false, "required" => false]) ?>
							</div>
						</div>

						<!-- 6. string -->
						<div class="form-group row">
							<label for="ipnSalt" class="col-sm-2 col-form-label"><?= __('IpnSalt') ?>:</label>
							<div class="col-sm-9">
								<?= $this->Form->control('ipnSalt', ['placeholder' => __(''), 'type'=>'text', 'class'=>'form-control', 'label' => false, 'autofocus' => false, "required" => false]) ?>
							</div>
						</div>

						<!-- 6. string -->
						<div class="form-group row">
							<label for="ipnOrderRef" class="col-sm-2 col-form-label"><?= __('IpnOrderRef') ?>:</label>
							<div class="col-sm-9">
								<?= $this->Form->control('ipnOrderRef', ['placeholder' => __(''), 'type'=>'text', 'class'=>'form-control', 'label' => false, 'autofocus' => false, "required" => false]) ?>
							</div>
						</div>

						<!-- 6. string -->
						<div class="form-group row">
							<label for="ipnSignature" class="col-sm-2 col-form-label"><?= __('IpnSignature') ?>:</label>
							<div class="col-sm-9">
								<?= $this->Form->control('ipnSignature', ['placeholder' => __(''), 'type'=>'text', 'class'=>'form-control', 'label' => false, 'autofocus' => false, "required" => false]) ?>
							</div>
						</div>

						<!-- 6. string -->
						<div class="form-group row">
							<label for="ipnMethod" class="col-sm-2 col-form-label"><?= __('IpnMethod') ?>:</label>
							<div class="col-sm-9">
								<?= $this->Form->control('ipnMethod', ['placeholder' => __(''), 'type'=>'text', 'class'=>'form-control', 'label' => false, 'autofocus' => false, "required" => false]) ?>
							</div>
						</div>

						<!-- 6. string -->
						<div class="form-group row">
							<label for="ipnMerchant" class="col-sm-2 col-form-label"><?= __('IpnMerchant') ?>:</label>
							<div class="col-sm-9">
								<?= $this->Form->control('ipnMerchant', ['placeholder' => __(''), 'type'=>'text', 'class'=>'form-control', 'label' => false, 'autofocus' => false, "required" => false]) ?>
							</div>
						</div>

						<?php // https://tempusdominus.github.io/bootstrap-4/Usage/ ?>
						<!-- 3. datetime -->
						<div class="form-group row">
							<label for="ipnFinishDate" class="col-sm-2 col-form-label"><?= __('IpnFinishDate') ?>:</label>
							<div class="col-md-10 col-sm-10 col-xs-10">
								<div class="input-group datetime" id="ipnFinishDate" data-target-input="nearest">
									<?= $this->Form->control('ipnFinishDate', ['type'=>'text', 'label'=>false, 'placeholder' => __('IpnFinishDate'), 'class'=>'form-control datetimepicker-input', 'data-target'=>'#ipnFinishDate', 'autocomplete'=>'off', 'data-validity-message'=>__('This field cannot be left empty'), "required" => false]); ?>
									<div class="input-group-append" data-target="#ipnFinishDate" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="icon-calendar"></i></div>
									</div>
								</div>
							</div>
						</div>

						<?php // https://tempusdominus.github.io/bootstrap-4/Usage/ ?>
						<!-- 3. datetime -->
						<div class="form-group row">
							<label for="ipnPaymentDate" class="col-sm-2 col-form-label"><?= __('IpnPaymentDate') ?>:</label>
							<div class="col-md-10 col-sm-10 col-xs-10">
								<div class="input-group datetime" id="ipnPaymentDate" data-target-input="nearest">
									<?= $this->Form->control('ipnPaymentDate', ['type'=>'text', 'label'=>false, 'placeholder' => __('IpnPaymentDate'), 'class'=>'form-control datetimepicker-input', 'data-target'=>'#ipnPaymentDate', 'autocomplete'=>'off', 'data-validity-message'=>__('This field cannot be left empty'), "required" => false]); ?>
									<div class="input-group-append" data-target="#ipnPaymentDate" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="icon-calendar"></i></div>
									</div>
								</div>
							</div>
						</div>

						<!-- 6. string -->
						<div class="form-group row">
							<label for="ipnTransactionId" class="col-sm-2 col-form-label"><?= __('IpnTransactionId') ?>:</label>
							<div class="col-sm-9">
								<?= $this->Form->control('ipnTransactionId', ['placeholder' => __(''), 'type'=>'text', 'class'=>'form-control', 'label' => false, 'autofocus' => false, "required" => false]) ?>
							</div>
						</div>

						<?php // https://tempusdominus.github.io/bootstrap-4/Usage/ ?>
						<!-- 3. datetime -->
						<div class="form-group row">
							<label for="ipnReceiveDate" class="col-sm-2 col-form-label"><?= __('IpnReceiveDate') ?>:</label>
							<div class="col-md-10 col-sm-10 col-xs-10">
								<div class="input-group datetime" id="ipnReceiveDate" data-target-input="nearest">
									<?= $this->Form->control('ipnReceiveDate', ['type'=>'text', 'label'=>false, 'placeholder' => __('IpnReceiveDate'), 'class'=>'form-control datetimepicker-input', 'data-target'=>'#ipnReceiveDate', 'autocomplete'=>'off', 'data-validity-message'=>__('This field cannot be left empty'), "required" => false]); ?>
									<div class="input-group-append" data-target="#ipnReceiveDate" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="icon-calendar"></i></div>
									</div>
								</div>
							</div>
						</div>

						<!-- 6. string -->
						<div class="form-group row">
							<label for="state" class="col-sm-2 col-form-label"><?= __('State') ?>:</label>
							<div class="col-sm-9">
								<?= $this->Form->control('state', ['placeholder' => __(''), 'type'=>'text', 'class'=>'form-control', 'label' => false, 'autofocus' => false, "required" => false]) ?>
							</div>
						</div>

						<!-- 6. string -->
						<div class="form-group row">
							<label for="zip" class="col-sm-2 col-form-label"><?= __('Zip') ?>:</label>
							<div class="col-sm-9">
								<?= $this->Form->control('zip', ['placeholder' => __(''), 'type'=>'text', 'class'=>'form-control', 'label' => false, 'autofocus' => false, "required" => false]) ?>
							</div>
						</div>

						<!-- 6. string -->
						<div class="form-group row">
							<label for="city" class="col-sm-2 col-form-label"><?= __('City') ?>:</label>
							<div class="col-sm-9">
								<?= $this->Form->control('city', ['placeholder' => __(''), 'type'=>'text', 'class'=>'form-control', 'label' => false, 'autofocus' => false, "required" => false]) ?>
							</div>
						</div>

						<!-- 6. string -->
						<div class="form-group row">
							<label for="address" class="col-sm-2 col-form-label"><?= __('Address') ?>:</label>
							<div class="col-sm-9">
								<?= $this->Form->control('address', ['placeholder' => __(''), 'type'=>'text', 'class'=>'form-control', 'label' => false, 'autofocus' => false, "required" => false]) ?>
							</div>
						</div>

						<!-- 6. string -->
						<div class="form-group row">
							<label for="country" class="col-sm-2 col-form-label"><?= __('Country') ?>:</label>
							<div class="col-sm-9">
								<?= $this->Form->control('country', ['placeholder' => __(''), 'type'=>'text', 'class'=>'form-control', 'label' => false, 'autofocus' => false, "required" => false]) ?>
							</div>
						</div>

						<!-- 6. string -->
						<div class="form-group row">
							<label for="email" class="col-sm-2 col-form-label"><?= __('Email') ?>:</label>
							<div class="col-sm-9">
								<?= $this->Form->control('email', ['placeholder' => __(''), 'type'=>'email', 'class'=>'form-control', 'label' => false, 'autofocus' => false, "required" => false]) ?>
							</div>
						</div>

						<!-- 6. string -->
						<div class="form-group row">
							<label for="provider" class="col-sm-2 col-form-label"><?= __('Provider') ?>:</label>
							<div class="col-sm-9">
								<?= $this->Form->control('provider', ['placeholder' => __(''), 'type'=>'text', 'class'=>'form-control', 'label' => false, 'autofocus' => false, "required" => false]) ?>
							</div>
						</div>

						<!-- 6. string -->
						<div class="form-group row">
							<label for="provide-id" class="col-sm-2 col-form-label"><?= __('Provide Id') ?>:</label>
							<div class="col-sm-9">
								<?= $this->Form->control('provide_id', ['placeholder' => __(''), 'type'=>'text', 'class'=>'form-control', 'label' => false, 'autofocus' => false, "required" => false]) ?>
							</div>
						</div>

						<!-- 6. string -->
						<div class="form-group row">
							<label for="transaction-id" class="col-sm-2 col-form-label"><?= __('Transaction Id') ?>:</label>
							<div class="col-sm-9">
								<?= $this->Form->control('transaction_id', ['placeholder' => __(''), 'type'=>'text', 'class'=>'form-control', 'label' => false, 'autofocus' => false, "required" => false]) ?>
							</div>
						</div>

						<!-- 7. text -->
						<div class="form-group row">
							<label for="request" class="col-sm-2 col-form-label"><?= __('Request') ?>:</label>
							<div class="col-sm-10">
								<?= $this->Form->textarea('request', ['type'=>'textarea', 'class'=>'summernote', 'label' => false, 'placeholder'=>__('Place some text here'), 'style'=>'width: 100%; height: 249px;', "required" => false ]) ?>
							</div>
						</div>

						<!-- 7. text -->
						<div class="form-group row">
							<label for="returnData" class="col-sm-2 col-form-label"><?= __('ReturnData') ?>:</label>
							<div class="col-sm-10">
								<?= $this->Form->textarea('returnData', ['type'=>'textarea', 'class'=>'summernote', 'label' => false, 'placeholder'=>__('Place some text here'), 'style'=>'width: 100%; height: 249px;', "required" => false ]) ?>
							</div>
						</div>

						<!-- 5. boolean -->
						<div class="form-group row">
							<div class="offset-sm-2 col-sm-10">
								<?= $this->Form->control('luhn_ok', ['id'=>'luhn-ok', 'div'=>false, 'type'=>'checkbox', 'class'=>'flat', 'label'=>false, 'templates'=>[ 'inputContainer' => '{{content}}', 'inputContainerError' => '{{content}}{{error}}' ], "required" => false ]); ?>
								<label class="checkbox" for="luhn-ok"><?= __('Luhn Ok') ?></label>
							</div>
						</div>


					</div><!-- /.card-body -->
				
					<div class="card-footer">
						<button type="submit" class="offset-sm-2 btn btn-info" data-bs-tooltip="tooltip" data-bs-placement="top" title="<?= __('Save and back to list') ?>" ><span class="btn-label"><i class="fa fa-save"></i></span> <?= __('Save') ?></button>
						<?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class'=>'btn btn-default', 'role'=>'button', 'escape'=>false, 'data-bs-tooltip'=>'tooltip', 'data-bs-placement'=>'top', 'title' => __('Back to list without save') ] ) ?>
					</div><!-- /.card-footer -->

				<?= $this->Form->end() ?>

            </div>
        </div>

<?php
	$this->Html->css(
		[
			"JeffAdmin./plugins/fontello/css/animation",
			"JeffAdmin./plugins/icheck-bootstrap/icheck-bootstrap.min",
			"JeffAdmin./plugins/icheck-1.x/skins/flat/blue",
			"JeffAdmin./plugins/summernote/summernote-bs4.min",
		],
		['block' => true]);


	$this->Html->script(
		[
			"JeffAdmin./plugins/icheck-1.x/icheck.min",
			"JeffAdmin./plugins/moment/moment.min",
			"JeffAdmin./plugins/moment/locale/hu",
			"JeffAdmin./plugins/bootstrap4-datetime-picker-rails-master/vendor/assets/javascripts/tempusdominus-bootstrap-4.min",
			"JeffAdmin./plugins/summernote/summernote-bs4.min",
			"JeffAdmin./plugins/summernote/lang/summernote-hu-HU.min",
		],
		['block' => 'scriptBottom']
	);
?>

<?php $this->Html->scriptStart(['block' => 'javaScriptBottom']); ?>
		
		$(document).ready( function(){

			$('input[type="checkbox"]').iCheck({
				handle: 'checkbox',
				checkboxClass: 'icheckbox_flat-blue'
			});			$('.summernote').summernote({
				height: 180,
				lang: 'hu-HU'
			});



<?php 		/* //$("input[type='number']").inputSpinner({ */ ?>
			$(".spinner").inputSpinner({
				decrementButton: "<strong>-</strong>",
				incrementButton: "<strong>+</strong>",
				groupClass: "", 						// css class of the resulting input-group
				buttonsClass: "btn-outline-secondary",
				buttonsWidth: "2.5rem",
				textAlign: "center",
				autoDelay: 500, 						// ms holding before auto value change
				autoInterval: 100, 						// speed of auto value change
				boostThreshold: 10, 					// boost after these steps
				boostMultiplier: "auto" 				// you can also set a constant number as multiplier
			});			
<?php /* https://tempusdominus.github.io/bootstrap-4/Usage/ */ ?>
			
			tooltips = {
				today: 			'<?= __('Go to today') ?>',
				clear: 			'<?= __('Clear selection') ?>',
				close: 			'<?= __('Close the picker') ?>',
				selectMonth: 	'<?= __('Select Month') ?>',
				prevMonth: 		'<?= __('Previous Month') ?>',
				nextMonth: 		'<?= __('Next Month') ?>',
				selectYear: 	'<?= __('Select Year') ?>',
				prevYear: 		'<?= __('Previous Year') ?>',
				nextYear: 		'<?= __('Next Year') ?>',
				selectDecade: 	'<?= __('Select Decade') ?>',
				prevDecade: 	'<?= __('Previous Decade') ?>',
				nextDecade: 	'<?= __('Next Decade') ?>',
				prevCentury: 	'<?= __('Previous Century') ?>',
				nextCentury: 	'<?= __('Next Century') ?>',
				incrementHour: 	'<?= __('Increment Hour') ?>',
				pickHour: 		'<?= __('Pick Hour') ?>',
				decrementHour:	'<?= __('Decrement Hour') ?>',
				incrementMinute:'<?= __('Increment Minute') ?>',
				pickMinute: 	'<?= __('Pick Minute') ?>',
				decrementMinute:'<?= __('Decrement Minute') ?>',
				incrementSecond:'<?= __('Increment Second') ?>',
				pickSecond: 	'<?= __('Pick Second') ?>',
				decrementSecond:'<?= __('Decrement Second') ?>'
			}
			
			$('#invoiceInsertDate').datetimepicker({
				locale: moment.locale("hu"),	
				format: 'L LTS',
<?php //if(isset($simplepay->invoiceInsertDate) && $simplepay->invoiceInsertDate != '00:00:00' && $simplepay->invoiceInsertDate != '0:' ){ ?>
<?php if(!empty($simplepay->invoiceInsertDate)){ ?>
				defaultDate: moment("<?= FrozenTime::parse($simplepay->invoiceInsertDate)->i18nFormat('yyyy-MM-dd H:ii:ss') ?>", "YYYY-MM-DD H:mm:ss"),
<?php } ?>
				//locale: moment.locale(),
				buttons: {
					showToday: true,
					showClear: true,
					showClose: true
				},				
				//viewDate: true,
				icons: {
					time: "icon-clock",
					date: "icon-calendar",
					up: "icon-up-big",
					down: "icon-down-big",
	                previous: 'icon-left-big',
	                next: 'icon-right-big',
	                today: 'icon-calendar',
	                clear: 'icon-trash-empty',
	                close: 'icon-window-close-o'
				},
				tooltips: tooltips
			});

			$('#ipnFinishDate').datetimepicker({
				locale: moment.locale("hu"),	
				format: 'L LTS',
<?php //if(isset($simplepay->ipnFinishDate) && $simplepay->ipnFinishDate != '00:00:00' && $simplepay->ipnFinishDate != '0:' ){ ?>
<?php if(!empty($simplepay->ipnFinishDate)){ ?>
				defaultDate: moment("<?= FrozenTime::parse($simplepay->ipnFinishDate)->i18nFormat('yyyy-MM-dd H:ii:ss') ?>", "YYYY-MM-DD H:mm:ss"),
<?php } ?>
				//locale: moment.locale(),
				buttons: {
					showToday: true,
					showClear: true,
					showClose: true
				},				
				//viewDate: true,
				icons: {
					time: "icon-clock",
					date: "icon-calendar",
					up: "icon-up-big",
					down: "icon-down-big",
	                previous: 'icon-left-big',
	                next: 'icon-right-big',
	                today: 'icon-calendar',
	                clear: 'icon-trash-empty',
	                close: 'icon-window-close-o'
				},
				tooltips: tooltips
			});

			$('#ipnPaymentDate').datetimepicker({
				locale: moment.locale("hu"),	
				format: 'L LTS',
<?php //if(isset($simplepay->ipnPaymentDate) && $simplepay->ipnPaymentDate != '00:00:00' && $simplepay->ipnPaymentDate != '0:' ){ ?>
<?php if(!empty($simplepay->ipnPaymentDate)){ ?>
				defaultDate: moment("<?= FrozenTime::parse($simplepay->ipnPaymentDate)->i18nFormat('yyyy-MM-dd H:ii:ss') ?>", "YYYY-MM-DD H:mm:ss"),
<?php } ?>
				//locale: moment.locale(),
				buttons: {
					showToday: true,
					showClear: true,
					showClose: true
				},				
				//viewDate: true,
				icons: {
					time: "icon-clock",
					date: "icon-calendar",
					up: "icon-up-big",
					down: "icon-down-big",
	                previous: 'icon-left-big',
	                next: 'icon-right-big',
	                today: 'icon-calendar',
	                clear: 'icon-trash-empty',
	                close: 'icon-window-close-o'
				},
				tooltips: tooltips
			});

			$('#ipnReceiveDate').datetimepicker({
				locale: moment.locale("hu"),	
				format: 'L LTS',
<?php //if(isset($simplepay->ipnReceiveDate) && $simplepay->ipnReceiveDate != '00:00:00' && $simplepay->ipnReceiveDate != '0:' ){ ?>
<?php if(!empty($simplepay->ipnReceiveDate)){ ?>
				defaultDate: moment("<?= FrozenTime::parse($simplepay->ipnReceiveDate)->i18nFormat('yyyy-MM-dd H:ii:ss') ?>", "YYYY-MM-DD H:mm:ss"),
<?php } ?>
				//locale: moment.locale(),
				buttons: {
					showToday: true,
					showClear: true,
					showClose: true
				},				
				//viewDate: true,
				icons: {
					time: "icon-clock",
					date: "icon-calendar",
					up: "icon-up-big",
					down: "icon-down-big",
	                previous: 'icon-left-big',
	                next: 'icon-right-big',
	                today: 'icon-calendar',
	                clear: 'icon-trash-empty',
	                close: 'icon-window-close-o'
				},
				tooltips: tooltips
			});


<?php /*	// ----------- talán ----------
			$("input[data-bootstrap-switch]").each(function(){
				$(this).bootstrapSwitch('state', $(this).prop('checked'));
			});
*/ ?>

			$('#button-submit').click( function(){
				$('#main-form').submit();
			});			

			// --- to bottom ---
			$('.card-body').animate({opacity: '1'}, 500, 'linear');
			$('#card-loader-icon').animate({opacity: '0'}, 1000, 'linear');
			
		});
		
<?php $this->Html->scriptEnd(); ?>

