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
	<img src='http://barcode.tec-it.com/barcode.ashx?data=<?php print $order['id'] ?>&code=Code128&dpi=306' alt='Barcode Generator TEC-IT'/>
</p>