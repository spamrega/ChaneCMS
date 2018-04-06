<div class="container margin-top-30">
	<div class="block box-shadow">
		<div class="row">
			<div class="col-md-4">
				<div class="item-big-img" style="background: url('<?=$data['item_img_2']?>') center;"></div>
			</div>

			<div class="col-md-8 gray-black">
				<div class="description"><?=$data['item_desc']?></div>
				<div class="description">
                    <?=$data['item_desc_a']?>
				</div>
				<div style="text-align: right;">
					<div class="price"><h5>цена </h5><h3><?=$data['item_price']?></h3></div>
					<a class="in-button" href="/buy/<?=$data['id']?>"><div class="button">КУПИТЬ</div></a>
				</div>
			</div>
		</div>
	</div>
</div>