<?php

class adminController
{
	/* Загрузка страницы авторизации */
	public function actionSignin ()
	{
		require_once(ROOT . '/models/admin/adminModel.php');
		
		$settings = AdminModel::getShopSettings();
		$settings['title'] = 'Авторизация | ChaneCMS';
		
		if (isset($_POST['submit'])) {
			$result = AdminModel::signin($_POST['login'], $_POST['password'], $settings['recaptcha_private'], $_POST['g-recaptcha-response'], $settings['captcha']);
			if ($result['result'] === true) {
				$error_message = '';
				Router::redirect('/admin');
			} else {
				$error_message = $result['message'];
			}
		}
		require_once(ROOT . '/views/admin/signinView.php');
		
		return true;
	}
	/* END Загрузка страницы авторизации */
	
	/* Загрузка главной страницы (список платежей) */
	public function actionIndex ()
	{
		require_once(ROOT . '/models/admin/adminModel.php');
		
		if (AdminModel::isAuth()) {
			$settings = AdminModel::getShopSettings();
			$settings['title'] = 'Платежи | ChaneCMS';
			
			if (isset($_POST['action'])) {
				$order_id = $_POST['order_id'];
			} else {
				$order_id = 0;
			}
			
			$payments = AdminModel::getPayments($order_id);
			require_once(ROOT . '/views/admin/indexView.php');
		} else {
			Router::redirect('/admin/signin');
		}
		
		return true;
	}
	/* END Загрузка главной страницы (список платежей) */
	
	/* Загрузка страницы товаров */
	public function actionGoods ($params)
	{
		require_once(ROOT . '/models/admin/adminModel.php');
		
		if (AdminModel::isAuth()) {
			$settings = AdminModel::getShopSettings();
			$settings['title'] = 'Товары | ChaneCMS';
			
			switch ($params[0]) {
				case 'load':
					$goods = AdminModel::getGoods();
					require_once(ROOT . '/views/admin/goodsView.php');
				break;
				
				case 'add':
					if (!isset($_POST['add'])) {
						$template = Buble::getTeplateSettings();
						require_once(ROOT . '/views/admin/goodsAddView.php');
					} else {
						AdminModel::addItem($_POST);
						Router::redirect('/admin/goods');
					}
				break;
				
				case 'edit':
					if (!isset($_POST['save'])) {
						$item = AdminModel::getItem(intval($params[1]));
						$template = Buble::getTeplateSettings();
						require_once(ROOT . '/views/admin/goodsEditView.php');
					} else {
						AdminModel::updateItem(intval($params[1]), $_POST);
						$item = AdminModel::getItem(intval($params[1]));
						$template = Buble::getTeplateSettings();
						require_once(ROOT . '/views/admin/goodsEditView.php');
					}
					
				break;
				
				case 'upload':
					if (!isset($_POST['add'])) {
						$selling_list = AdminModel::getListing(intval($params[1]));
						require_once(ROOT . '/views/admin/goodsUploadView.php');
					} else {
						AdminModel::uploadListing(intval($params[1]), $_POST['item_listing']);
						$selling_list = AdminModel::getListing(intval($params[1]));
						require_once(ROOT . '/views/admin/goodsUploadView.php');
					}
					
				break;
					
				case 'delete':
					AdminModel::deleteItem(intval($params[1]));
					Router::redirect('/admin/goods');
				break;
					
				default:
				break;
			}		
		} else {
			Router::redirect('/admin/signin');
		}
		
		return true;
	}
	
	/* Загрузка страницы страниц */
	public function actionPages ($params)
	{
		require_once(ROOT . '/models/admin/adminModel.php');
		
		if (AdminModel::isAuth()) {
			$settings = AdminModel::getShopSettings();
			$settings['title'] = 'Страницы | ChaneCMS';
			
			switch ($params[0]) {
				case 'load':
					$pages = AdminModel::getPages();
					require_once(ROOT . '/views/admin/pagesView.php');
				break;
				
				case 'add':
					if (!isset($_POST['add'])) {
						require_once(ROOT . '/views/admin/pagesAddView.php');
					} else {
						AdminModel::addPage($_POST);
						Router::redirect('/admin/pages');
					}
				break;
				
				case 'edit':
					if (!isset($_POST['save'])) {
						$page = AdminModel::getPage(intval($params[1]));
						require_once(ROOT . '/views/admin/pagesEditView.php');
					} else {
						AdminModel::updatePage(intval($params[1]), $_POST);
						$page = AdminModel::getPage(intval($params[1]));
						require_once(ROOT . '/views/admin/pagesEditView.php');
					}
				
				break;
					
				case 'delete':
					AdminModel::deletePage(intval($params[1]));
					Router::redirect('/admin/pages');
				break;
					
				default:
				break;
			}		
		} else {
			Router::redirect('/admin/signin');
		}
		
		return true;
	}
	/* END Загрузка страницы страниц */
	
	/* Загрузка страницы настроек*/
	public function actionSettings ()
	{
		require_once(ROOT . '/models/admin/adminModel.php');
		
		if (AdminModel::isAuth()) {
            if (AdminModel::isAdmin()) {
                if (isset($_POST['change'])) {
                    $result = AdminModel::changePassword(md5(md5($_POST['old_password'])), md5(md5($_POST['new_password'])), md5(md5($_POST['new_password_repeat'])));

                    if (!$result) {
                        Utilites::alert('Ошибка смены пароля');
                    } else {
                        setcookie('hash', '', 0, '/');
                        Router::redirect('/admin');
                    }
                }

                if (isset($_POST['save'])) {
                    AdminModel::saveBaseSettings($_POST);
                }

                if (isset($_POST['inform'])) {
                    AdminModel::saveInformSettings($_POST);
                }

                if (isset($_POST['regoogle'])) {
                    AdminModel::saveCaptchaSettings($_POST);
                }

                if (isset($_POST['test_inform'])) {
                    AdminModel::testTelegramInformer();
                    Utilites::alert('Сообщение отправлено');
                }

                $settings = AdminModel::getShopSettings();
                $settings['title'] = 'Настройки | ChaneCMS';

                require_once(ROOT . '/views/admin/settingsView.php');
            } else {
                Router::redirect('/admin/');
            }
		} else {
			Router::redirect('/admin/signin');
		}
		
		return true;
	}
	/* END Загрузка страницы настроек*/
	
	
	/* Загрузка страницы настроек дизайна*/
	
	public function actionDesign()
	{
		require_once(ROOT . '/models/admin/adminModel.php');
		
		if (AdminModel::isAuth()) {
            if (AdminModel::isAdmin()) {
                if (isset($_POST['changeTemplate'])) {
                    if (Buble::changeTemplate($_POST['templateName'])) {

                    } else {
                        Utilites::alert('Ошибка смены шаблона.');
                    }
                }

                $templates = Buble::getTemplates();
                $activeTemplate = Buble::getTeplateSettings();
                $settings['title'] = 'Дизайн | ChaneCMS ' . VER;
                require_once(ROOT . '/views/admin/designView.php');
            } else {
                Router::redirect('/admin/');
            }
		} else {
			Router::redirect('/admin/signin');
		}
		
		return true;
	}
	
	/* END Загрузка страницы настроек дизайна*/

    /* Загрузка страницы настроек пользователей*/

    public function actionUsers()
    {
        require_once(ROOT . '/models/admin/adminModel.php');

        if (AdminModel::isAuth()) {
            if (AdminModel::isAdmin()) {
                $settings['title'] = 'Пользователи | ChaneCMS ' .VER;
                if (isset($_POST['delete'])) {
                    AdminModel::deleteUser($_POST['id']);
                }
                if (isset($_POST['create'])) {
                    AdminModel::createUser($_POST['login'], $_POST['password'], $_POST['role']);
                }
                $users = AdminModel::getUsers();
                require_once(ROOT . '/views/admin/usersView.php');
            } else {
                Router::redirect('/admin');
            }
        } else {
            Router::redirect('/admin/signin');
        }

        return true;
    }

    /* END Загрузка страницы настроек пользователей*/
}