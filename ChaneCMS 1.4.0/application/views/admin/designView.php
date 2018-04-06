<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<?=AdminModel::generateHeader($settings['title'])?>
</head>
<body>
	<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">ChaneCMS <?=VER?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
              <? include(ROOT . '/views/admin/menuView.php')?>
          </ul>
        </div>
      </div>
    </nav>
	
	<div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
              <? include(ROOT . '/views/admin/menuView.php')?>
          </ul>
        </div>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">Дизайн</h1>
			<div class="settings">
				<form action="" method="POST">
					<h3 class="page-header">Настройки дизайна магазина</h3>
					<h4>Текущий шаблон: <?=$activeTemplate['title']?></h4>
					<p>Шаблон: 
						<select class="form-control" name="templateName" id="templateName">
							<?
								foreach ($templates as $template) {
									if ($template['active'] == 1) {
										$selected = 'selected';
									} else {
										$selected = '';
									}
									echo '
										<option ' .$selected. ' value="' .$template['name']. '">' .$template['title']. ' [' .$template['name']. ']' . '</option>
									';
								}
							?>
							
						</select>
					</p>
					<p><button type="submit" name="changeTemplate" value="changeTemplate" class="btn btn-primary">Сохранить</button></p>
				</form>
				
				
				<?
					foreach ($templates as $template) {
						if ($template['active'] == 1) {
							$style = 'display:block;';
						} else {
							$style = 'display:none;';
						}
						echo '
							<div class="design" id="template_' .$template['name']. '" style="' .$style. '">
								<div class="title">' .$template['title']. '</div>
								<div class="author">' .$template['author']. '</div>
								<div class="description">' .$template['description']. '</div>
								<div class="modules">' .$template['modules']. '</div>
								<div class="version">' .$template['version']. '</div>
								<div class="product_min">' .$template['product_min_width']. 'x' . $template['product_min_height'] .'px</div>
								<div class="product_max">' .$template['product_max_width']. 'x' . $template['product_max_height'] .'px</div>
							</div>
						';
					}
				?>
			</div>
		</div>
      </div>
    </div>
	
	<script>
		var selectTemplate = document.getElementById("templateName");
		selectTemplate.onchange = function () {
			for(var i=0; i<selectTemplate.length; i++){
				document.getElementById('template_' + selectTemplate[i].value).style.display = 'none';
			}
			document.getElementById('template_' + selectTemplate[selectTemplate.selectedIndex].value).style.display = 'block';
		}
	</script>
</body>
</html>