<tr>
	<td><?=$item["order_id"]?></td>
	<td><?=$item["item"]?></td>
	<td><?=$item["amount"]?> руб.</td>
	<td><?=$item["ip"]?></td>
	<td><?=$item["email"]?></td>
	<td><?=gmdate("M d Y H:i:s", $item["date"])?></td>
	<td><?=AdminModel::paid($item["state"])?></td>
	<td><a href="/purchase/<?=$item["order_id"]?>"><?=$item["order_id"]?></a></td>
</tr>