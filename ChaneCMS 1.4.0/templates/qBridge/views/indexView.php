<div class="container container-10 margin-top-30">
	<div class="block-transparent">
		<div class="goods">
			<?foreach ($data['goods'] as $item) {?>
				<div class="good box-shadow">
					<a class="simple" href="/item/<?=$item['id']?>">
						<img src="<?=$item['item_img_1']?>" alt="">
						<div class="title roboto"><?=$item['item_name']?></div>
						<div class="price roboto"><?=$item['item_price']?></div>
					</a>
				</div>
            <?}?>
		</div>
	</div>
</div>