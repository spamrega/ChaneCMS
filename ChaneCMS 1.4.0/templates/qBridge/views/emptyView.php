<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?=$data['page_title']?></title>
    <link rel="shortcut icon" sizes="16x16 24x24 32x32 48x48 64x64" href="{$shop_icon}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?=$data['shop_desc']?>">
    <meta name="keywords" content="<?=$data['shop_tags']?>">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/templates/qBridge/css/style.css">
    <link rel="stylesheet" type="text/css" href="/templates/qBridge/css/bootstrap-grid.min.css">
</head>
<body>
<header class="header box-shadow">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <a class="simple" href="/"><h3 class="logo">ChaneCMS</h3></a>
            </div>

            <div class="col-md-6 text-right lh-36">
                <?foreach ($data['pages'] as $page){?>
                    <a class="simple gray menu" href="/page/<?=$page['page_url']?>"><?=$page['page_title']?></a>
                <?}?>
            </div>
        </div>
    </div>
</header>

<div class="container margin-top-65">
    <div class="banner box-shadow" style="background: url('/templates/qBridge/images/bg.jpg') center"></div>
</div>

<div class="container margin-top-30">
    <div class="block box-shadow">
        <h4 class="gray text-center roboto"><?=$data['shop_desc']?></h4>
    </div>
</div>

<?include_once(APPPATH . '/templates/'.$template.'/views/'.$viewName.'.php')?>

<footer class="box-shadow">
    <div class="container">
        <div class="text-right black-gray roboto thin">
            ChaneCMS, <a href="https://as-code.ru" class="simple black-gray">by as-code.ru</a>
        </div>
    </div>
</footer>

<script src="//npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
<script type="text/javascript" src="/templates/qBridge/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="/templates/qBridge/js/bootstrap.min.js"></script>
</body>
</html>