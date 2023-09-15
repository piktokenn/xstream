SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `ads` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `type` varchar(25) COLLATE utf8_bin DEFAULT NULL,
  `ads_code` text COLLATE utf8_bin DEFAULT NULL,
  `ads_data` text COLLATE utf8_bin DEFAULT NULL,
  `display_user` int(1) DEFAULT NULL,
  `status` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `ads` (`id`, `name`, `type`, `ads_code`, `ads_data`, `display_user`, `status`) VALUES
(1, '728x90', 'code', NULL, '{\"image\":null}', 2, 2),
(2, '300 x 250', 'code', NULL, '{\"image\":null}', 2, 1),
(3, 'Popup', 'code', NULL, '{\"image\":null}', 2, 2),
(4, 'Vast', 'code', NULL, '{\"image\":null}', 2, 1),
(5, 'Pageskin', 'code', NULL, '{\"image\":null}', 2, 1);

CREATE TABLE `collections` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `self` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `color` varchar(25) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `privacy` int(11) DEFAULT NULL,
  `featured` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `collections_post` (
  `id` int(11) NOT NULL,
  `collection_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `type` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `spoiler` int(1) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `comments_reaction` (
  `id` int(11) NOT NULL,
  `comment_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `reaction` varchar(11) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `language` varchar(64) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `code` varchar(3) DEFAULT NULL,
  `icon` varchar(64) DEFAULT NULL,
  `subtitle` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `countries` (`id`, `language`, `name`, `code`, `icon`, `subtitle`) VALUES
(1, 'AD', 'Andorra', NULL, NULL, NULL),
(2, 'AE', 'United Arab Emirates', NULL, NULL, NULL),
(3, 'AF', 'Afghanistan', NULL, NULL, NULL),
(4, 'AG', 'Antigua And Barbuda', NULL, NULL, NULL),
(5, 'AI', 'Anguilla', NULL, NULL, NULL),
(6, 'AL', 'Albania', NULL, NULL, 1),
(7, 'AM', 'Armenia', NULL, NULL, NULL),
(8, 'AO', 'Angola', NULL, NULL, NULL),
(9, 'AQ', 'Antarktika', NULL, NULL, NULL),
(10, 'AR', 'Argentina', NULL, NULL, NULL),
(11, 'AS', 'American Samoa', NULL, NULL, NULL),
(12, 'AT', 'Austria', NULL, NULL, NULL),
(13, 'AU', 'Australia', NULL, NULL, NULL),
(14, 'AW', 'Aruba', NULL, NULL, NULL),
(15, 'AZ', 'Azerbaijan', NULL, NULL, NULL),
(16, 'BA', 'Bosnia And Herzegovina', NULL, NULL, NULL),
(17, 'BB', 'Barbados', NULL, NULL, NULL),
(18, 'BD', 'Bangladesh', NULL, NULL, NULL),
(19, 'BE', 'Belgium', NULL, NULL, NULL),
(20, 'BF', 'Burkina Faso', NULL, NULL, NULL),
(21, 'BG', 'Bulgaria', NULL, NULL, NULL),
(22, 'BH', 'Bahrain', NULL, NULL, NULL),
(23, 'BI', 'Burundi', NULL, NULL, NULL),
(24, 'BJ', 'Benin', NULL, NULL, NULL),
(25, 'BL', 'St Barts', NULL, NULL, NULL),
(26, 'BM', 'Bermuda', NULL, NULL, NULL),
(27, 'BN', 'Brunei', NULL, NULL, NULL),
(28, 'BO', 'Bolivia', NULL, NULL, NULL),
(29, 'BR', 'Brazil', NULL, NULL, NULL),
(30, 'BS', 'Bahamas', NULL, NULL, NULL),
(31, 'BT', 'Bhutan', NULL, NULL, NULL),
(32, 'BV', 'Bouvet Island', NULL, NULL, NULL),
(33, 'BW', 'Botswana', NULL, NULL, NULL),
(34, 'BY', 'Belarus', NULL, NULL, NULL),
(35, 'BZ', 'Belize', NULL, NULL, NULL),
(36, 'CA', 'Canada', NULL, NULL, NULL),
(37, 'CC', 'Cocos Island', NULL, NULL, NULL),
(38, 'CD', 'Democratic Republic Of Congo', NULL, NULL, NULL),
(39, 'CF', 'Central African Republic', NULL, NULL, NULL),
(40, 'CG', 'Republic Of The Congo', NULL, NULL, NULL),
(41, 'CH', 'Switzerland', NULL, NULL, NULL),
(42, 'CI', 'Ivory Coast', NULL, NULL, NULL),
(43, 'CK', 'Cook Islands', NULL, NULL, NULL),
(44, 'CL', 'Chile', NULL, NULL, NULL),
(45, 'CM', 'Cameroon', NULL, NULL, NULL),
(46, 'CN', 'China', NULL, NULL, NULL),
(47, 'CO', 'Colombia', NULL, NULL, NULL),
(48, 'CR', 'Costa Rica', NULL, NULL, NULL),
(49, 'CU', 'Cuba', NULL, NULL, NULL),
(50, 'CV', 'Cape Verde', NULL, NULL, NULL),
(51, 'CW', 'Curacao', NULL, NULL, NULL),
(52, 'CY', 'Cyprus', NULL, NULL, NULL),
(53, 'CZ', 'Czech Republic', NULL, NULL, NULL),
(54, 'DE', 'Germany', NULL, NULL, NULL),
(55, 'DJ', 'Djibouti', NULL, NULL, NULL),
(56, 'DK', 'Denmark', NULL, NULL, NULL),
(57, 'DM', 'Dominica', NULL, NULL, NULL),
(58, 'DO', 'Dominican Republic', NULL, NULL, NULL),
(59, 'DZ', 'Algeria', NULL, NULL, NULL),
(60, 'EC', 'Ecuador', NULL, NULL, NULL),
(61, 'EE', 'Estonia', NULL, NULL, NULL),
(62, 'EG', 'Egypt', NULL, NULL, NULL),
(63, 'EH', 'Sahrawi Arab Democratic Republic', NULL, NULL, NULL),
(64, 'ER', 'Eritrea', NULL, NULL, NULL),
(65, 'ES', 'Spain', NULL, NULL, NULL),
(66, 'ET', 'Ethiopia', NULL, NULL, NULL),
(67, 'FI', 'Finland', NULL, NULL, NULL),
(68, 'FJ', 'Fiji', NULL, NULL, NULL),
(69, 'FK', 'Falkland Islands', NULL, NULL, NULL),
(70, 'FM', 'Micronesia', NULL, NULL, NULL),
(71, 'FO', 'Faroe Islands', NULL, NULL, NULL),
(72, 'FR', 'France', NULL, NULL, NULL),
(73, 'GA', 'Gabon', NULL, NULL, NULL),
(74, 'GB', 'United Kingdom', NULL, NULL, NULL),
(75, 'GD', 'Grenada', NULL, NULL, NULL),
(76, 'GE', 'Georgia', NULL, NULL, NULL),
(77, 'GG', 'Guernsey', NULL, NULL, NULL),
(78, 'GH', 'Ghana', NULL, NULL, NULL),
(79, 'GI', 'Gibraltar', NULL, NULL, NULL),
(80, 'GL', 'Greenland', NULL, NULL, NULL),
(81, 'GM', 'Gambia', NULL, NULL, NULL),
(82, 'GN', 'Guinea', NULL, NULL, NULL),
(83, 'GQ', 'Equatorial Guinea', NULL, NULL, NULL),
(84, 'GR', 'Greece', NULL, NULL, NULL),
(85, 'GT', 'Guatemala', NULL, NULL, NULL),
(86, 'GU', 'Guam', NULL, NULL, NULL),
(87, 'GW', 'Guinea Bissau', NULL, NULL, NULL),
(88, 'GY', 'Guyana', NULL, NULL, NULL),
(89, 'HK', 'Hong Kong', NULL, NULL, NULL),
(90, 'HN', 'Honduras', NULL, NULL, NULL),
(91, 'HR', 'Croatia', NULL, NULL, NULL),
(92, 'HT', 'Haiti', NULL, NULL, NULL),
(93, 'HU', 'Hungary', NULL, NULL, NULL),
(94, 'ID', 'Indonesia', NULL, NULL, NULL),
(95, 'IE', 'Ireland', NULL, NULL, NULL),
(96, 'IL', 'Israel', NULL, NULL, NULL),
(97, 'IM', 'Isle Of Man', NULL, NULL, NULL),
(98, 'IN', 'India', NULL, NULL, NULL),
(99, 'IO', 'British Indian Ocean Territory', NULL, NULL, NULL),
(100, 'IQ', 'Iraq', NULL, NULL, NULL),
(101, 'IR', 'Iran', NULL, NULL, NULL),
(102, 'IS', 'Iceland', NULL, NULL, NULL),
(103, 'IT', 'Italy', NULL, NULL, NULL),
(104, 'JE', 'Jersey', NULL, NULL, NULL),
(105, 'JM', 'Jamaica', NULL, NULL, NULL),
(106, 'JO', 'Jordan', NULL, NULL, NULL),
(107, 'JP', 'Japan', NULL, NULL, NULL),
(108, 'KE', 'Kenya', NULL, NULL, NULL),
(109, 'KG', 'Kyrgyzstan', NULL, NULL, NULL),
(110, 'KH', 'Cambodia', NULL, NULL, NULL),
(111, 'KI', 'Kiribati', NULL, NULL, NULL),
(112, 'KM', 'Comoros', NULL, NULL, NULL),
(113, 'KN', 'Saint Kitts And Nevis', NULL, NULL, NULL),
(114, 'KP', 'North Korea', NULL, NULL, NULL),
(115, 'KR', 'South Korea', NULL, NULL, NULL),
(116, 'KW', 'Kwait', NULL, NULL, NULL),
(117, 'KY', 'Cayman Islands', NULL, NULL, NULL),
(118, 'KZ', 'Kazakhstan', NULL, NULL, NULL),
(119, 'LA', 'Laos', NULL, NULL, NULL),
(120, 'LB', 'Lebanon', NULL, NULL, NULL),
(121, 'LC', 'St Lucia', NULL, NULL, NULL),
(122, 'LI', 'Liechtenstein', NULL, NULL, NULL),
(123, 'LK', 'Sri Lanka', NULL, NULL, NULL),
(124, 'LR', 'Liberia', NULL, NULL, NULL),
(125, 'LS', 'Lesotho', NULL, NULL, NULL),
(126, 'LT', 'Lithuania', NULL, NULL, NULL),
(127, 'LU', 'Luxembourg', NULL, NULL, NULL),
(128, 'LV', 'Latvia', NULL, NULL, NULL),
(129, 'LY', 'Libya', NULL, NULL, NULL),
(130, 'MA', 'Morocco', NULL, NULL, NULL),
(131, 'MC', 'Monaco', NULL, NULL, NULL),
(132, 'MD', 'Moldova', NULL, NULL, NULL),
(133, 'ME', 'Montenegro', NULL, NULL, NULL),
(134, 'MG', 'Madagascar', NULL, NULL, NULL),
(135, 'MH', 'Marshall Island', NULL, NULL, NULL),
(136, 'MK', 'Republic Of Macedonia', NULL, NULL, NULL),
(137, 'ML', 'Mali', NULL, NULL, NULL),
(138, 'MM', 'Myanmar', NULL, NULL, NULL),
(139, 'MN', 'Mongolia', NULL, NULL, NULL),
(140, 'MO', 'Macao', NULL, NULL, NULL),
(141, 'MP', 'Northern Marianas Islands', NULL, NULL, NULL),
(142, 'MQ', 'Martinique', NULL, NULL, NULL),
(143, 'MR', 'Mauritania', NULL, NULL, NULL),
(144, 'MS', 'Montserrat', NULL, NULL, NULL),
(145, 'MT', 'Malta', NULL, NULL, NULL),
(146, 'MU', 'Mauritius', NULL, NULL, NULL),
(147, 'MV', 'Maldives', NULL, NULL, NULL),
(148, 'MW', 'Malawi', NULL, NULL, NULL),
(149, 'MX', 'Mexico', NULL, NULL, NULL),
(150, 'MY', 'Malasya', NULL, NULL, NULL),
(151, 'MZ', 'Mozambique', NULL, NULL, NULL),
(152, 'NA', 'Namibia', NULL, NULL, NULL),
(153, 'NC', 'New Caledonia', NULL, NULL, NULL),
(154, 'NE', 'Niger', NULL, NULL, NULL),
(155, 'NF', 'Norfolk Island', NULL, NULL, NULL),
(156, 'NG', 'Nigeria', NULL, NULL, NULL),
(157, 'NI', 'Nicaragua', NULL, NULL, NULL),
(158, 'NL', 'Netherlands', NULL, NULL, NULL),
(159, 'NO', 'Norway', NULL, NULL, NULL),
(160, 'NP', 'Nepal', NULL, NULL, NULL),
(161, 'NR', 'Nauru', NULL, NULL, NULL),
(162, 'NU', 'Niue', NULL, NULL, NULL),
(163, 'NZ', 'New Zealand', NULL, NULL, NULL),
(164, 'OM', 'Oman', NULL, NULL, NULL),
(165, 'PA', 'Panama', NULL, NULL, NULL),
(166, 'PE', 'Peru', NULL, NULL, NULL),
(167, 'PF', 'French Polynesia', NULL, NULL, NULL),
(168, 'PG', 'Papua New Guinea', NULL, NULL, NULL),
(169, 'PH', 'Philippines', NULL, NULL, NULL),
(170, 'PK', 'Pakistan', NULL, NULL, NULL),
(171, 'PL', 'Poland', NULL, NULL, NULL),
(172, 'PN', 'Pitcairn Islands', NULL, NULL, NULL),
(173, 'PR', 'Puerto Rico', NULL, NULL, NULL),
(174, 'PS', 'Palestine', NULL, NULL, NULL),
(175, 'PT', 'Portugal', NULL, NULL, NULL),
(176, 'PW', 'Palau', NULL, NULL, NULL),
(177, 'PY', 'Paraguay', NULL, NULL, NULL),
(178, 'QA', 'Qatar', NULL, NULL, NULL),
(179, 'RO', 'Romania', NULL, NULL, NULL),
(180, 'RS', 'Serbia', NULL, NULL, NULL),
(181, 'RU', 'Russia', NULL, NULL, NULL),
(182, 'RW', 'Rwanda', NULL, NULL, NULL),
(183, 'SA', 'Saudi Arabia', NULL, NULL, NULL),
(184, 'SB', 'Solomon Islands', NULL, NULL, NULL),
(185, 'SC', 'Seychelles', NULL, NULL, NULL),
(186, 'SD', 'Sudan', NULL, NULL, NULL),
(187, 'SE', 'Sweden', NULL, NULL, NULL),
(188, 'SG', 'Singapore', NULL, NULL, NULL),
(189, 'SI', 'Slovenia', NULL, NULL, NULL),
(190, 'SK', 'Slovakia', NULL, NULL, NULL),
(191, 'SL', 'Sierra Leone', NULL, NULL, NULL),
(192, 'SM', 'San Marino', NULL, NULL, NULL),
(193, 'SN', 'Senegal', NULL, NULL, NULL),
(194, 'SO', 'Somalia', NULL, NULL, NULL),
(195, 'SR', 'Suriname', NULL, NULL, NULL),
(196, 'SS', 'South Sudan', NULL, NULL, NULL),
(197, 'ST', 'Sao Tome And Prince', NULL, NULL, NULL),
(198, 'SV', 'El Salvador', NULL, NULL, NULL),
(199, 'SX', 'Sint Maarten', NULL, NULL, NULL),
(200, 'SY', 'Syria', NULL, NULL, NULL),
(201, 'SZ', 'Swaziland', NULL, NULL, NULL),
(202, 'TC', 'Turks And Caicos', NULL, NULL, NULL),
(203, 'TD', 'Chad', NULL, NULL, NULL),
(204, 'TG', 'Togo', NULL, NULL, NULL),
(205, 'TH', 'Thailand', NULL, NULL, NULL),
(206, 'TJ', 'Tajikistan', NULL, NULL, NULL),
(207, 'TK', 'Tokelau', NULL, NULL, NULL),
(208, 'TL', 'East Timor', NULL, NULL, NULL),
(209, 'TM', 'Turkmenistan', NULL, NULL, NULL),
(210, 'TN', 'Tunisia', NULL, NULL, NULL),
(211, 'TO', 'Tonga', NULL, NULL, NULL),
(212, 'Türkçe', 'Turkey', 'TR', 'turkey.svg', 1),
(213, 'TT', 'Trinidad And Tobago', NULL, NULL, NULL),
(214, 'TV', 'Tuvalu', NULL, NULL, NULL),
(215, 'TW', 'Taiwan', NULL, NULL, NULL),
(216, 'TZ', 'Tanzania', NULL, NULL, NULL),
(217, 'UA', 'Ukraine', NULL, NULL, NULL),
(218, 'UG', 'Uganda', NULL, NULL, NULL),
(219, 'UN', 'United Nations', NULL, NULL, NULL),
(220, 'US', 'United States Of America', NULL, NULL, NULL),
(221, 'UY', 'Uruguay', NULL, NULL, NULL),
(222, 'UZ', 'Uzbekistn', NULL, NULL, NULL),
(223, 'VA', 'Vatican City', NULL, NULL, NULL),
(224, 'VC', 'St Vincent And The Grenadines', NULL, NULL, NULL),
(225, 'VE', 'Venezuela', NULL, NULL, NULL),
(226, 'VG', 'British Virgin Islands', NULL, NULL, NULL),
(227, 'VI', 'Virgin Islands', NULL, NULL, NULL),
(228, 'VN', 'Vietnam', NULL, NULL, NULL),
(229, 'VU', 'Vanuatu', NULL, NULL, NULL),
(230, 'WS', 'Samoa', NULL, NULL, NULL),
(231, 'XK', 'Kosovo', NULL, NULL, NULL),
(232, 'YE', 'Yemen', NULL, NULL, NULL),
(233, 'ZA', 'South Africa', NULL, NULL, NULL),
(234, 'ZM', 'Zambia', NULL, NULL, NULL),
(235, 'ZW', 'Zimbabwe', NULL, NULL, NULL),
(236, 'EN', 'England', NULL, NULL, NULL);

CREATE TABLE `discussions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `self` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `description` text COLLATE utf8_bin DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `featured` int(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `self` varchar(255) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `footer` tinyint(1) DEFAULT NULL,
  `featured` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `languages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `language` varchar(20) DEFAULT NULL,
  `text_direction` varchar(20) DEFAULT NULL,
  `currency` varchar(25) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `languages` (`id`, `name`, `language`, `text_direction`, `currency`, `status`) VALUES
(1, 'English', 'en', 'ltr', 'Dollar', 1);

CREATE TABLE `modules` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `module_file` varchar(255) DEFAULT NULL,
  `data` text DEFAULT NULL,
  `page` varchar(25) DEFAULT NULL,
  `data_limit` int(4) DEFAULT NULL,
  `sortable` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `modules` (`id`, `name`, `module_file`, `data`, `page`, `data_limit`, `sortable`, `status`) VALUES
(1, 'The newest Movies', 'home.movies', '{\"sorting\":\"id desc\"}', 'home', 16, 2, 1),
(2, 'The newest TV Shows', 'home.series', '{\"sorting\":\"id desc\"}', 'home', 8, 5, 1),
(3, 'Slider', 'home.slider', '{\"sorting\":\"id desc\"}', 'home', 0, NULL, 1),
(4, 'Most viewed', 'home.popular', '{\"sorting\":\"id desc\"}', 'home', 12, 6, 1),
(5, 'Casting, Genres and Community Block', 'home.more', '{\"sorting\":\"id desc\"}', 'home', 12, 3, 1),
(6, 'Recommend Collections', 'home.collections', '{\"sorting\":\"id desc\"}', 'home', 3, 4, 1),
(7, 'Watch history', 'home.watch', '{\"sorting\":\"id desc\"}', 'home', 6, 1, 1);

CREATE TABLE `notifications` (
  `id` bigint(25) NOT NULL,
  `user_id` int(25) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `action_id` int(25) DEFAULT NULL,
  `action_user` int(25) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `options` (
  `id` int(11) NOT NULL,
  `type` varchar(25) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `self` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `self` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `description` varchar(600) COLLATE utf8_bin DEFAULT NULL,
  `body` text COLLATE utf8_bin DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `footer` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `peoples` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `self` varchar(255) DEFAULT NULL,
  `department` varchar(30) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `biography` varchar(999) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `gender` varchar(15) DEFAULT NULL,
  `data` text DEFAULT NULL,
  `tmdb_id` int(20) DEFAULT NULL,
  `imdb_id` varchar(25) DEFAULT NULL,
  `featured` int(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `platforms` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `self` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `tmdb_id` int(20) DEFAULT NULL,
  `featured` int(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `type` varchar(10) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `title_sub` varchar(255) DEFAULT NULL,
  `self` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `overview` text DEFAULT NULL,
  `platform` int(11) DEFAULT NULL,
  `collection` varchar(25) DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `runtime` varchar(25) DEFAULT NULL,
  `vote_average` varchar(255) DEFAULT NULL,
  `country` varchar(25) DEFAULT NULL,
  `trailer` varchar(255) DEFAULT NULL,
  `view` int(25) DEFAULT NULL,
  `private` tinyint(1) DEFAULT NULL,
  `data` text DEFAULT NULL,
  `keywords` varchar(999) DEFAULT NULL,
  `featured` tinyint(1) DEFAULT NULL,
  `upcoming` tinyint(1) DEFAULT NULL,
  `slider` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `imdb_id` varchar(25) DEFAULT NULL,
  `tmdb_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `posts_episode` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `season_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `self` varchar(255) DEFAULT NULL,
  `title_number` int(4) DEFAULT NULL,
  `overview` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `data` text DEFAULT NULL,
  `runtime` varchar(25) DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `trailer` varchar(255) DEFAULT NULL,
  `view` int(25) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `private` int(1) DEFAULT NULL,
  `featured` int(1) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `upcoming` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `posts_genre` (
  `post_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `posts_like` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `reaction` varchar(20) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `posts_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) NOT NULL,
  `episode_id` int(11) DEFAULT NULL,
  `created` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `posts_media` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `posts_people` (
  `id` int(11) NOT NULL,
  `people_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `posts_season` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `sortable` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `posts_subtitle` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `episode_id` int(11) DEFAULT NULL,
  `language_id` int(4) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `sortable` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `posts_video` (
  `id` int(11) NOT NULL,
  `post_id` int(6) DEFAULT NULL,
  `episode_id` int(6) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `source` varchar(11) DEFAULT NULL,
  `embed` varchar(255) DEFAULT NULL,
  `sortable` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `report` int(1) DEFAULT NULL,
  `body` varchar(300) COLLATE utf8_bin DEFAULT NULL,
  `type` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `report_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `tmdb_id` int(20) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `media_type` varchar(10) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `name` varchar(25) DEFAULT NULL,
  `data` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `settings` (`id`, `name`, `data`) VALUES
(1, 'general', '{\"company\":\"Xtreaming\",\"language\":\"en\",\"dashboard_language\":\"en\",\"subtitle\":\"1\",\"description\":\"Xtreaming Movie and TV Show streaming platform\",\"custom_code\":\"\",\"footer_text\":\"\",\"google_play\":\"\",\"app_store\":\"\",\"logo\":\"logo.svg\",\"favicon\":\"favicon.svg\"}'),
(2, 'customize', '{\"color\":\"#864bfc\",\"background\":\"#864bfc\",\"header\":\"v2\",\"width\":\"\",\"column\":\"6\",\"explore\":\"1\",\"movies\":\"1\",\"series\":\"1\",\"topimdb\":\"1\",\"community\":\"1\",\"request\":\"1\",\"platform\":\"1\",\"people\":\"1\"}'),
(3, 'seo', '{\"title\":\"Xtreaming – Movie and TV Show streaming platform\",\"description\":\"Xtreaming – Movie and TV Show streaming platform\",\"movies_title\":\"Explore Movies – Movie and TV Show streaming platform\",\"movies_description\":\"Explore Movies – Movie and TV Show streaming platform\",\"movie_title\":\"[title] Free watch movie\",\"movie_description\":\"[title] Free watch movie\",\"series_title\":\"Explore TV Shows – Movie and TV Show streaming platform\",\"series_description\":\"Explore TV Shows – Movie and TV Show streaming platform\",\"serie_title\":\"[title] Free watch TV show\",\"serie_description\":\"[title] Free watch TV show\",\"episode_title\":\"[title] [season] Season, [episode] Episode Free watch TV show\",\"episode_description\":\"[title] [season] Season, [episode] Episode Free watch TV show\",\"category_title\":\"Explore [title] Genre Movie and TV Shows\",\"category_description\":\"Explore [title] Genre Movie and TV Shows\",\"tag_title\":\"[title] Free watch TV Show\",\"tag_description\":\"[title] Free watch TV Show\",\"explore_title\":\"[sort] [genre] Explore Xtreaming\",\"explore_description\":\"[sort] [genre] Explore Xtreaming\",\"search_title\":\"Search result\",\"search_description\":\"Search result \\\"[keyword]\\\" Xtreaming\",\"peoples_title\":\"[sort] Peoples Explore\",\"peoples_description\":\"[sort] Peoples Explore\",\"people_title\":\"[name] Watch the actor\'s movies and series\",\"people_description\":\"[name] Watch the actor\'s movies and series\",\"community_title\":\"[sort] Community Xtreaming\",\"community_description\":\"[sort] Community Xtreaming\",\"thread_title\":\"[title] – Community Xtreaming\",\"thread_description\":\"[title] – Community Xtreaming\",\"platforms_title\":\"Platforms Watch the actor\'s movies and series\",\"platforms_description\":\"Platforms Watch the actor\'s movies and series\",\"platform_title\":\"[name] Watch the platform movies and series\",\"platform_description\":\"[name] Watch the platform movies and series\",\"profile_title\":\"[username] – Xtreaming\",\"profile_description\":\"[username] – Xtreaming\"}'),
(4, 'email', '{\"host\":\"\",\"username\":\"\",\"password\":\"\",\"port\":\"\",\"security\":\"\",\"sendemail\":\"\"}'),
(5, 'api', '{\"tmdb_api\":\"\",\"tmdb_language\":\"\",\"tmdb_people_limit\":\"\"}');

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `account_type` varchar(30) DEFAULT NULL,
  `firstname` varchar(64) DEFAULT NULL,
  `lastname` varchar(64) DEFAULT NULL,
  `username` varchar(64) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `avatar` varchar(64) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `gender` varchar(15) DEFAULT NULL,
  `about` varchar(255) DEFAULT NULL,
  `color` varchar(7) DEFAULT NULL,
  `xp` int(10) DEFAULT NULL,
  `status` tinyint(2) DEFAULT NULL,
  `deleted` tinyint(2) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `account_type`, `firstname`, `lastname`, `username`, `email`, `password`, `avatar`, `token`, `gender`, `about`, `color`, `xp`, `status`, `deleted`, `created`, `updated`) VALUES
(1, 'admin', 'Xtreaming', 'Xtreaming', 'admin', 'admin@admin.com', '938c8a307c7cd31299e70a0e4c1ad372', NULL, 'd4c1a9117adbea3effb8e8553565dafa', NULL, NULL, '864bfc', NULL, 1, NULL, '2022-06-19 05:25:56', NULL);


ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `collections`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `collections_post`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user_id`);

ALTER TABLE `comments_reaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reaction` (`comment_id`);

ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `discussions`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `options`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `peoples`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `platforms`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `featured_2` (`featured`,`slider`,`status`),
  ADD KEY `self` (`self`,`status`),
  ADD KEY `posts_idx_status_id` (`status`,`id`);

ALTER TABLE `posts_episode`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `posts_genre`
  ADD PRIMARY KEY (`post_id`,`genre_id`) USING BTREE;

ALTER TABLE `posts_like`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_reaction` (`user_id`);

ALTER TABLE `posts_log`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `posts_log_idx_post_id` (`post_id`),
  ADD KEY `created` (`created`);

ALTER TABLE `posts_media`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `posts_people`
  ADD PRIMARY KEY (`id`) USING BTREE;

ALTER TABLE `posts_season`
  ADD PRIMARY KEY (`id`),
  ADD KEY `content_id` (`post_id`);

ALTER TABLE `posts_subtitle`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `posts_video`
  ADD PRIMARY KEY (`id`),
  ADD KEY `content_id` (`post_id`);

ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_idx_id` (`id`,`firstname`,`username`,`avatar`) USING BTREE;


ALTER TABLE `ads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `collections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `collections_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `comments_reaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=237;

ALTER TABLE `discussions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `notifications`
  MODIFY `id` bigint(25) NOT NULL AUTO_INCREMENT;

ALTER TABLE `options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `peoples`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `platforms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `posts_episode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `posts_like`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `posts_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `posts_media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `posts_people`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `posts_season`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `posts_subtitle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `posts_video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;
