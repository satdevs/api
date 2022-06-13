<?xml version="1.0" encoding="UTF-8"?><SimplePay><item><invoiceId><?= $simplepay->invoiceId ?></invoiceId><transactionId><?= $simplepay->transaction_id ?></transactionId><winszlaStatus><?php
	if($simplepay->winszlaStatus !== null){
		echo $simplepay->winszlaStatus;
	}else{
		echo 'EMPTY';
	}
?></winszlaStatus><message><?= $message ?></message></item></SimplePay>