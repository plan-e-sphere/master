-- phpMyAdmin SQL Dump
-- version 3.4.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 21, 2011 at 02:40 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tuto`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`) VALUES
(1, 'Music', 'music'),
(2, 'Jeux vidéos', 'jeux-videos'),
(3, 'Sport', 'sport');

-- --------------------------------------------------------

--
-- Table structure for table `configs`
--

CREATE TABLE IF NOT EXISTS `configs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `medias`
--

CREATE TABLE IF NOT EXISTS `medias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_medias_posts` (`post_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `medias`
--

INSERT INTO `medias` (`id`, `name`, `file`, `post_id`, `type`) VALUES
(10, '', '2011-09/if-ifttt-com-then-1066.jpg', 9, 'img'),
(7, '', '2011-09/1password-votre-coffre-fort-virtuel-1070.jpg', 19, 'img'),
(6, '', '2011-09/grafikart-32.png', 20, 'img'),
(9, '', '2011-09/cetait-mieux-pas-mieux-avant-1063.jpg', 17, 'img');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `content` text,
  `created` date DEFAULT NULL,
  `online` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_posts_users1` (`user_id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `name`, `content`, `created`, `online`, `type`, `slug`, `user_id`, `category_id`) VALUES
(1, 'Accueil', '<div class="hero-unit">\r\n<h1>Bienvenue !</h1>\r\n<p>Vestibulum id ligula porta felis euismod semper. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>\r\n<p><a href="#">Voir le blog &raquo;</a></p>\r\n</div>\r\n<div class="row">\r\n<div class="span6">\r\n<h2>Heading</h2>\r\n<p>Etiam porta sem malesuada magna mollis euismod. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>\r\n<p><a class="btn" href="#">View details &raquo;</a></p>\r\n</div>\r\n<div class="span5">\r\n<h2>Heading</h2>\r\n<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p>\r\n<p><a class="btn" href="#">View details &raquo;</a></p>\r\n</div>\r\n<div class="span5">\r\n<h2>Heading</h2>\r\n<p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>\r\n<p><a class="btn" href="#">View details &raquo;</a></p>\r\n</div>\r\n</div>', '2011-09-15', 1, 'page', 'accueil', 0, 0),
(2, 'A propos', '<h1>A propos</h1>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla in accumsan justo. Integer nec urna quam. Nunc ut dui elit, eu facilisis nisl. Pellentesque varius tellus vel felis condimentum iaculis. Vestibulum ultrices turpis eu tellus eleifend scelerisque. Donec vitae odio dui, vel bibendum odio. Praesent vestibulum turpis at massa sollicitudin imperdiet. Fusce pulvinar, elit id facilisis vestibulum, urna dolor auctor lorem, non fringilla neque erat sit amet purus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur posuere magna ut eros tincidunt tristique. Praesent eros ligula, volutpat et hendrerit a, interdum ut libero. Nullam metus lacus, tincidunt egestas sagittis ut, ultricies eu tellus. Vivamus consequat lectus sed magna sodales non lobortis libero interdum.</p>\r\n<blockquote>\r\n<p>Quisque et risus purus. Integer varius, neque in egestas hendrerit, purus orci suscipit est, ac vehicula.</p>\r\n<small>Maitre yoda</small></blockquote>\r\n<ul>\r\n<li>Aliquam dapibus ligula at leo luctus feugiat.</li>\r\n<li>Etiam egestas commodo lacus, ut euismod lectus dignissim quis.</li>\r\n</ul>\r\n<ul>\r\n<li>Praesent sed risus a turpis vehicula lobortis.</li>\r\n<li>Nullam luctus ullamcorper arcu, interdum hendrerit sapien suscipit in.</li>\r\n<li>Phasellus adipiscing elementum ipsum, eu pharetra sapien aliquam eu.</li>\r\n</ul>\r\n<p>Nunc est risus, dapibus ut iaculis at, aliquam non libero. Curabitur ipsum elit, volutpat quis fringilla sed, aliquet sit amet est. Aenean est nulla, ullamcorper id viverra quis, vestibulum nec nisl. Maecenas eget nisi elit. Cras tempor porta sapien ut volutpat. Sed sodales tortor et nulla aliquam fermentum. Pellentesque eu quam arcu, lacinia ultricies lectus. Nunc interdum aliquam blandit.</p>\r\n<p>In accumsan facilisis tempus. Quisque elit nunc, cursus quis ullamcorper in, ultrices et est. Proin lectus ipsum, eleifend at iaculis quis, tincidunt vitae sem. Mauris vel est felis, ut pharetra lorem. Donec nunc magna, eleifend vitae sagittis at, blandit id elit. Mauris pellentesque ligula id dui condimentum ut gravida mi accumsan. Nullam tincidunt urna eros, et ultricies dolor. Aenean sit amet adipiscing tortor.</p>\r\n<p>Nam nibh nunc, cursus a blandit id, vestibulum sed lectus. Praesent quis neque ipsum. Aliquam arcu quam, condimentum quis consequat et, ultricies eget ligula. Cras sed metus laoreet orci dignissim pharetra. Suspendisse varius, mauris ut egestas placerat, nunc mauris vestibulum risus, et porttitor ante arcu sit amet lorem. Nulla laoreet urna quis augue blandit venenatis. Donec ullamcorper, augue ac vestibulum semper, lorem leo pharetra urna, nec imperdiet leo lorem sit amet dui. Pellentesque cursus nunc in lacus bibendum sit amet sagittis velit fringilla. Mauris ornare justo dui, at mattis felis. Duis orci purus, tincidunt vel eleifend sit amet, rutrum tempor massa. Praesent nec dui mauris. Sed viverra venenatis pellentesque. Phasellus sodales odio vel nunc molestie sed placerat ipsum sollicitudin. Integer quam lacus, dignissim vel vulputate vitae, aliquam quis velit.</p>', '2011-09-15', 1, 'page', 'a-propos', 0, 0),
(19, '1Password, votre coffre fort virtuel', '<p><strong><a title="" href="http://ifttt.com/"><img style="margin-right: 20px; float: left;" src="/Tuto/Site/img/2011-09/1password-votre-coffre-fort-virtuel-1070.jpg" alt="" width="277" height="157" /></a></strong>Si comme moi vous avez pass&eacute; des heures &agrave; chercher des mots de passes vieux de 2 ans dans une boite mail super charg&eacute;es alors vous allez aimer&nbsp;1Password. Cette application va vous permettre d&rsquo;avoir un coffre virtuel prot&eacute;g&eacute; contenant l&rsquo;ensemble de vos identifiants (acc&egrave;s FTP, acc&egrave;s MySQL, clef Servers, Formulaire Web&hellip;) en un seul endroit.<strong><a title="" href="http://ifttt.com/"><br /></a></strong></p>', '2011-11-18', 1, 'post', '1password-votre-coffre-fort-virtuel', NULL, 3),
(17, 'C’était (mieux || pas mieux) avant', '<p><img style="margin-right: 20px; float: left;" src="/Tuto/Site/img/2011-09/cetait-mieux-pas-mieux-avant-1063.jpg" alt="" width="277" height="157" />Et voila la version 2011 de Grafikart.fr est en ligne. Cette nouvelle version est l&rsquo;occasion pour moi de revenir a mes premiers amours en terme de Webdesign (le bois et le blanc) mais aussi d&rsquo;am&eacute;liorer l&rsquo;interface des compte membres. Dor&eacute;navant vous pouvez suivre depuis votre compte toute l&rsquo;actualit&eacute; du site et de vos sujets sur le forum. La fonctionnalit&eacute; n&rsquo;a pas encore &eacute;t&eacute; test&eacute; &agrave; grande &eacute;chelle donc vous serez mes cobayes. N&rsquo;h&eacute;sitez pas &agrave; faire des retours sur ce point l&agrave;.</p>', '2011-11-20', 1, 'post', 'article-update', NULL, 2),
(9, 'if ifttt.com then', '<p><a title="" href="http://ifttt.com/"><img style="margin-right: 20px; float: left;" src="/Tuto/Site/img/2011-09/if-ifttt-com-then-1066.jpg" alt="" width="277" height="157" />Ifttt.com</a>&nbsp;est un site qui propose d&rsquo;automatiser la publication de contenu entre r&eacute;seaux sociaux &agrave; l&rsquo;aide d&rsquo;un op&eacute;rateur bien connu des d&eacute;veloppeur :&nbsp;<strong>Si&hellip; Alors&hellip;</strong>. Le principe est&nbsp;extr&ecirc;mement&nbsp;simple et efficace, on d&eacute;signe dans un premier temps un &laquo;&nbsp;<strong>d&eacute;clencheur</strong>&nbsp;&raquo; (une op&eacute;ration sp&eacute;cifique sur un premier site, comme par exemple un nouveau tweet) et dans un second temps &laquo;&nbsp;<strong>l&rsquo;action</strong>&nbsp;&raquo; que cela va d&eacute;clencher sur un autre site (la publication du tweet en question sur facebook). Le site est actuellement en B&eacute;ta mais laisse entrapercevoir des centaines de possibilit&eacute;s et pour ne rien g&acirc;cher l&rsquo;interface est tr&egrave;s intuitive.</p>', '2011-09-20', 1, 'post', 'if-ifttt-com-then', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `role`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
