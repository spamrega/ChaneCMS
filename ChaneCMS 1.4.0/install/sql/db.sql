SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `shop_goods` (
  `id` int(11) NOT NULL,
  `item_name` varchar(32) NOT NULL,
  `item_desc` varchar(400) NOT NULL,
  `item_desc_a` varchar(400) NOT NULL,
  `item_price` decimal(11,2) NOT NULL,
  `item_img_1` varchar(128) NOT NULL,
  `item_img_2` varchar(128) NOT NULL,
  `item_selling` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `shop_pages` (
  `id` int(11) NOT NULL,
  `page_url` varchar(32) NOT NULL,
  `page_title` varchar(32) NOT NULL,
  `page_body` varchar(900) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `shop_payments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `item` varchar(32) NOT NULL,
  `amount` decimal(11,2) NOT NULL,
  `state` int(11) NOT NULL,
  `ip` varchar(32) NOT NULL,
  `email` varchar(32) NOT NULL,
  `date` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_selling` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `shop_settings` (
  `id` int(11) NOT NULL,
  `shop_name` varchar(32) NOT NULL,
  `shop_desc` varchar(32) NOT NULL,
  `shop_tags` varchar(128) NOT NULL,
  `shop_icon` varchar(128) NOT NULL,
  `template` varchar(32) NOT NULL,
  `primearea_merchant` varchar(8) NOT NULL,
  `primearea_secret` varchar(32) NOT NULL,
  `cryptonator_merchant` varchar(32) NOT NULL,
  `cryptonator_secret` varchar(32) NOT NULL,
  `telegram_token` varchar(128) NOT NULL,
  `telegram_id` varchar(32) NOT NULL,
  `recaptcha_public` varchar(64) NOT NULL,
  `recaptcha_private` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `users_admin` (
  `id` int(11) NOT NULL,
  `user_login` varchar(16) NOT NULL,
  `user_password` varchar(32) NOT NULL,
  `user_hash` varchar(32) NOT NULL,
  `user_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `shop_goods`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `shop_pages`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `shop_payments`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users_admin`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `shop_goods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `shop_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `shop_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `users_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


INSERT INTO `shop_goods` (`id`, `item_name`, `item_desc`, `item_desc_a`, `item_price`, `item_img_1`, `item_img_2`, `item_selling`) VALUES
(1, 'Товар высокого качества', 'Проснувшись однажды утром после беспокойного сна, Грегор Замза обнаружил, что он у себя в постели превратился в страшное насекомое.', 'На портрете была изображена дама в меховой шляпе и боа, она сидела очень прямо и протягивала зрителю тяжелую меховую муфту, в которой целиком исчезала ее рука. Затем взгляд Грегора устремился в окно, и пасмурная погода – слышно было, как по жести подоконника стучат капли дождя – привела его и вовсе в грустное настроение. «Хорошо бы еще немного поспать и забыть всю эту чепуху», – подумал он, но это', '150.00', 'http://i.imgur.com/TO2LFAW.png', 'http://i.imgur.com/1cevgVz.png', 'dasdasda\r\ndssadsadasdas');

INSERT INTO `shop_pages` (`id`, `page_url`, `page_title`, `page_body`) VALUES
(1, 'install', 'Спасибо за установку', 'Спасибо за установку ChaneCMS<br><p><a style=\"border:1px solid #000;border-radius:10px;padding:5px;color:#000;\" href=\"https://donate.as-code.ru/\">Помочь развитию проекта</a></p>');

INSERT INTO `shop_settings` (`id`, `shop_name`, `shop_desc`, `shop_tags`, `shop_icon`, `template`, `primearea_merchant`, `primearea_secret`, `cryptonator_merchant`, `cryptonator_secret`, `telegram_token`, `telegram_id`, `recaptcha_public`, `recaptcha_private`) VALUES
(1, '%shop_name%', '%shop_desc%', '%shop_tags%', '%shop_icon%', 'qBridge', '', '', '', '', '', '', '', '');

INSERT INTO `users_admin` (`id`, `user_login`, `user_password`, `user_hash`, `user_role`) VALUES
(1, '%user_login%', '%user_password%', '', 1);

