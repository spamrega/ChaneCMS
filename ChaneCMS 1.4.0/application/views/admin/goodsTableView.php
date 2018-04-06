<tr>
<td><?=$item["id"]?></td>
<td><?=$item["item_name"]?></td>
<td><?=$item["item_price"]?> руб.</td>
<td><?=Utilites::countGoods($item["item_selling"])?></td>
<td>
	<a href="/admin/goods/edit/<?=$item["id"]?>"><i class="glyphicon glyphicon-edit icon"></i></a>
	<a class="link" onclick="upload(<?=$item["id"]?>)"><i class="glyphicon glyphicon-upload"></i></a>
	<a href="/admin/goods/delete/<?=$item["id"]?>"><i class="glyphicon glyphicon-remove icon-red"></i></a>
</td>
</tr>