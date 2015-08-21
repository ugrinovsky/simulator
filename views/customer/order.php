<p>
	Название: <?php print $order['name'] ?>
</p>
<p>
	Цена: <?php print $order['price'] ?>	
</p>
<p>
	Штрих-код:
</p>
<p>
	<?php
    	$code = sprintf('%06d', $order['id']);
  	?>
	<img src='http://barcode.tec-it.com/barcode.ashx?data=<?php print $code ?>&code=Code128&dpi=306' alt='Barcode Generator TEC-IT'/>
</p>