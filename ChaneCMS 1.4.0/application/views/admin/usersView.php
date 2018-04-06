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
			<h1 class="page-header">Пользователи</h1>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Логин</th>
                    <th>Роль</th>
                    <th>Управление</th>
                </tr>
                </thead>
                <tbody>
                <?
                function role($roleID)
                {
                    switch ($roleID) {
                        case 1:
                            return 'Администратор';
                        case 2:
                            return 'Модератор';
                    }
                }

                foreach ($users as $user) {
                    echo '<tr>
                            <td>' .$user['user_login']. '</td>
                            <td>' .role($user['user_role']). '</td>
                            <td><form action="/admin/users" method="POST"><input type="hidden" name="id" value="' .$user['id']. '"><input class="btn" type="submit" name="delete" value="Удалить"></td>
                        </tr>';
                }
                ?>
                </tbody>
            </table>

            <div class="col-sm-4">
                <form action="/admin/users" method="POST">
                    <input style="margin:5px" class="form-control" type="text" name="login" placeholder="Логин">
                    <input style="margin:5px" class="form-control" type="password" name="password" placeholder="Пароль">
                    <select style="margin:5px" class="form-control" name="role">
                        <option value="1">Администратор</option>
                        <option value="2" selected>Модератор</option>
                    </select>
                    <input style="margin:5px" class="form-control" type="submit" name="create" value="Создать">
                </form>
            </div>
		</div>
      </div>
    </div>
</body>
</html>