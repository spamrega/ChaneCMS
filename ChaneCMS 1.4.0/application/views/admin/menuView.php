<?php
    $location = '/' . Router::$location;

    $isAdmin = AdminModel::isAdmin();

    $menu = [
        ['/admin', 'Платежи', false],
        ['/admin/goods', 'Товары', false],
        ['/admin/pages', 'Страницы', false],
        ['/admin/users', 'Пользователи', true],
        ['/admin/design', 'Дизайн', true],
        ['/admin/settings', 'Настройки', true],
    ];

    foreach ($menu as $li) {
        if ($li[0] == $location) {
            echo '<li class="active"><a href="' .$li[0]. '">' .$li[1]. '</a></li>';
        } else {
            if ($li[2]) {
                if ($isAdmin) {
                    echo '<li class=""><a href="' .$li[0]. '">' .$li[1]. '</a></li>';
                } else {
                    echo '<li class="disabled"><a href="">' .$li[1]. '</a></li>';
                }
            } else {
                echo '<li class=""><a href="' .$li[0]. '">' .$li[1]. '</a></li>';
            }
        }
    }

    $response = Utilites::getRequest('https://api.as-code.ru/chanecms/version.php');
    $response = json_decode($response, true);

    if ($response['version'] != VER) {
        echo '<li class="update"><a target="_blank" href="' .$response['url']. '">Обнаружена новая версия ChangeCMS</a>';
    }
