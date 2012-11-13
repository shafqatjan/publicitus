-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 21, 2012 at 03:38 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `publicitus`
--

-- --------------------------------------------------------

--
-- Table structure for table `pub_admin`
--

CREATE TABLE IF NOT EXISTS `pub_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(32) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(70) NOT NULL,
  `verificationCode` varchar(255) NOT NULL,
  `dated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `pub_admin`
--

INSERT INTO `pub_admin` (`id`, `user_name`, `email`, `password`, `verificationCode`, `dated`, `status`) VALUES
(1, 'admin', 'admin@chilli.com', 'e10adc3949ba59abbe56e057f20f883e', '', '2012-05-02 19:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pub_categories`
--

CREATE TABLE IF NOT EXISTS `pub_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `dated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `pub_categories`
--


-- --------------------------------------------------------

--
-- Table structure for table `pub_cms`
--

CREATE TABLE IF NOT EXISTS `pub_cms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_title` varchar(255) NOT NULL,
  `page_heading` varchar(255) NOT NULL,
  `page_name` varchar(255) NOT NULL,
  `page_content` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact_no` varchar(50) NOT NULL,
  `meta_tag` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `pub_cms`
--

INSERT INTO `pub_cms` (`id`, `page_title`, `page_heading`, `page_name`, `page_content`, `email`, `contact_no`, `meta_tag`) VALUES
(1, 'Premimium', 'Premimium', 'Premimium', '&lt;p&gt;This is premimium page content: Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.&lt;br /&gt;\\\\r\\\\n&lt;br /&gt;\\\\r\\\\nIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \\''Content here, content here\\'', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \\''lorem ipsum\\'' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).&lt;/p&gt;', '', '1111-222-333', 'meta tag this si Premimium'),
(2, 'Contact us email1', 'Contact us email1', 'Contact us email', '&lt;p&gt;&amp;lt;p&amp;gt;Holisticly iterate value-added initiatives after error-free vortals. Distinctively actualize vertical content whereas cross-unit networks.  Phosfluorescently envisioneer market positioning applications and world-class &amp;amp;quot;outside the box&amp;amp;quot; thinking.&amp;lt;/p&amp;gt;&lt;/p&gt;\\\\r\\\\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\\\\r\\\\n&lt;p&gt;aaaa&lt;/p&gt;', 'admin1@chilli.com', '1111-222-333', 'meta tag this si sdfsfxxxxxxx'),
(3, 'Affiliate ', 'With mychilli you can earn money sharing your images!', 'Affiliate ', '&lt;table cellspacing=\\&quot;15\\&quot; cellpadding=\\&quot;0\\&quot; border=\\&quot;0\\&quot; images=\\&quot;\\&quot; theme=\\&quot;\\&quot; style=\\&quot;background-image: url(\\&quot;&gt;\\\\r\\\\n    &lt;tbody&gt;\\\\r\\\\n        &lt;tr&gt;\\\\r\\\\n            &lt;td align=\\&quot;left\\&quot; style=\\&quot;width: 75%;\\&quot;&gt;&lt;b&gt;Country Groups:&lt;br /&gt;\\\\r\\\\n            &lt;br /&gt;\\\\r\\\\n            A: Australia, Canada, New Zealand, United Kingdom, United States&lt;br /&gt;\\\\r\\\\n            &lt;br /&gt;\\\\r\\\\n            B: Austria, Belgium, Denmark, Finland, France, Germany, Greece, Ireland,  Italy, Luxembourg, Netherlands, Norway, Portugal, Spain, Sweden,  Switzerland&lt;br /&gt;\\\\r\\\\n            &lt;br /&gt;\\\\r\\\\n            C: Cyprus, Czech Republic, Estonia, Hungary, Israel, Japan, Latvia, Lithuania, Poland, Russia, Slovakia&lt;br /&gt;\\\\r\\\\n            &lt;br /&gt;\\\\r\\\\n            D: All Others&lt;/b&gt;&lt;br /&gt;\\\\r\\\\n            &lt;br /&gt;\\\\r\\\\n            &lt;ul&gt;\\\\r\\\\n                &lt;li&gt;Unique IP is counted once per 24 hours.&lt;/li&gt;\\\\r\\\\n                &lt;li&gt;Unlike all competition we pay from the FIRST dollar! Our minimum payout ammount is 1 dollar!&lt;/li&gt;\\\\r\\\\n                &lt;li&gt;We pay every Wednesday!&lt;/li&gt;\\\\r\\\\n                &lt;li&gt;Your images are stored indefinitely!&lt;/li&gt;\\\\r\\\\n                &lt;li&gt;We support many methods of payment!&lt;/li&gt;\\\\r\\\\n            &lt;/ul&gt;\\\\r\\\\n            &lt;br /&gt;\\\\r\\\\n            &amp;nbsp;&lt;/td&gt;\\\\r\\\\n            &lt;td align=\\&quot;right\\&quot; style=\\&quot;width: 25%;\\&quot;&gt;\\\\r\\\\n            &lt;table cellspacing=\\&quot;1\\&quot; cellpadding=\\&quot;4\\&quot; border=\\&quot;0\\&quot; class=\\&quot;table_bb\\&quot; style=\\&quot;width: 100%; background-color: rgb(66, 156, 127);\\&quot;&gt;\\\\r\\\\n                &lt;tbody&gt;\\\\r\\\\n                    &lt;tr&gt;\\\\r\\\\n                        &lt;th&gt;&lt;font color=\\&quot;#fefefe\\&quot;&gt;Zone&lt;/font&gt;&lt;/th&gt;\\\\r\\\\n                        &lt;th&gt;&lt;font color=\\&quot;#fefefe\\&quot;&gt;$/ 1000 views&lt;/font&gt;&lt;/th&gt;\\\\r\\\\n                    &lt;/tr&gt;\\\\r\\\\n                    &lt;tr&gt;\\\\r\\\\n                        &lt;td class=\\&quot;tdrow1 text_align_center\\&quot;&gt;&lt;strong&gt;Zone A&lt;/strong&gt;&lt;/td&gt;\\\\r\\\\n                        &lt;td class=\\&quot;tdrow1 text_align_center\\&quot;&gt;$3.00&lt;/td&gt;\\\\r\\\\n                    &lt;/tr&gt;\\\\r\\\\n                    &lt;tr&gt;\\\\r\\\\n                        &lt;td class=\\&quot;tdrow1 text_align_center\\&quot;&gt;&lt;strong&gt;Zone B&lt;/strong&gt;&lt;/td&gt;\\\\r\\\\n                        &lt;td class=\\&quot;tdrow1 text_align_center\\&quot;&gt;$1.00&lt;/td&gt;\\\\r\\\\n                    &lt;/tr&gt;\\\\r\\\\n                    &lt;tr&gt;\\\\r\\\\n                        &lt;td class=\\&quot;tdrow1 text_align_center\\&quot;&gt;&lt;strong&gt;Zone C&lt;/strong&gt;&lt;/td&gt;\\\\r\\\\n                        &lt;td class=\\&quot;tdrow1 text_align_center\\&quot;&gt;$0.20&lt;/td&gt;\\\\r\\\\n                    &lt;/tr&gt;\\\\r\\\\n                    &lt;tr&gt;\\\\r\\\\n                        &lt;td class=\\&quot;tdrow1 text_align_center\\&quot;&gt;&lt;strong&gt;Zone D&lt;/strong&gt;&lt;/td&gt;\\\\r\\\\n                        &lt;td class=\\&quot;tdrow1 text_align_center\\&quot;&gt;$0.10&lt;/td&gt;\\\\r\\\\n                    &lt;/tr&gt;\\\\r\\\\n                    &lt;tr&gt;\\\\r\\\\n                        &lt;td class=\\&quot;table_footer5\\&quot;&gt;&amp;nbsp;&lt;/td&gt;\\\\r\\\\n                    &lt;/tr&gt;\\\\r\\\\n                &lt;/tbody&gt;\\\\r\\\\n            &lt;/table&gt;\\\\r\\\\n            &lt;br /&gt;\\\\r\\\\n            &lt;br /&gt;\\\\r\\\\n            &lt;br /&gt;\\\\r\\\\n            &lt;br /&gt;\\\\r\\\\n            &lt;br /&gt;\\\\r\\\\n            &lt;br /&gt;\\\\r\\\\n            &amp;nbsp;&lt;/td&gt;\\\\r\\\\n        &lt;/tr&gt;\\\\r\\\\n    &lt;/tbody&gt;\\\\r\\\\n&lt;/table&gt;', '', '1111-222-333', 'meta tag this si Affiliate '),
(4, 'Report Abuse', 'Report Abuse', 'Report Abuse', '&lt;p&gt;This is report abuse page content: Lorem Ipsum is simply dummy text of the printing and typesetting  industry. Lorem Ipsum has been the industry\\''s standard dummy text ever  since the 1500s, when an unknown printer took a galley of type and  scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap  into electronic typesetting, remaining essentially unchanged. It was  popularised in the 1960s with the release of Letraset sheets containing  Lorem Ipsum passages, and more recently with desktop publishing software  like Aldus PageMaker including versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and  typesetting industry. Lorem Ipsum has been the industry\\''s standard dummy  text ever since the 1500s, when an unknown printer took a galley of  type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap  into electronic typesetting, remaining essentially unchanged. It was  popularised in the 1960s with the release of Letraset sheets containing  Lorem Ipsum passages, and more recently with desktop publishing software  like Aldus PageMaker including versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and  typesetting industry. Lorem Ipsum has been the industry\\''s standard dummy  text ever since the 1500s, when an unknown printer took a galley of  type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap  into electronic typesetting, remaining essentially unchanged. It was  popularised in the 1960s with the release of Letraset sheets containing  Lorem Ipsum passages, and more recently with desktop publishing software  like Aldus PageMaker including versions of Lorem I&lt;/p&gt;', '', '1111-222-333', 'meta tag this si Report Abuse'),
(5, 'Term of  Service', 'Term of  Service', 'Term of  Services', '&lt;p&gt;This is term of service page content. Lorem Ipsum is simply dummy text of the printing and typesetting  industry. Lorem Ipsum has been the industry\\''s standard dummy text ever  since the 1500s, when an unknown printer took a galley of type and  scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap  into electronic typesetting, remaining essentially unchanged. It was  popularised in the 1960s with the release of Letraset sheets containing  Lorem Ipsum passages, and more recently with desktop publishing software  like Aldus PageMaker including versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and  typesetting industry. Lorem Ipsum has been the industry\\''s standard dummy  text ever since the 1500s, when an unknown printer took a galley of  type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap  into electronic typesetting, remaining essentially unchanged. It was  popularised in the 1960s with the release of Letraset sheets containing  Lorem Ipsum passages, and more recently with desktop publishing software  like Aldus PageMaker including versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and  typesetting industry. Lorem Ipsum has been the industry\\''s standard dummy  text ever since the 1500s, when an unknown printer took a galley of  type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap  into electronic typesetting, remaining essentially unchanged. It was  popularised in the 1960s with the release of Letraset sheets containing  Lorem Ipsum passages, and more recently with desktop publishing software  like Aldus PageMaker including versions of Lorem I&lt;/p&gt;', '', '1111-222-333', 'meta tag this si Term of  Services'),
(6, 'Privacy Policy', 'Privacy Policy', 'Privacy Policy', '&lt;p&gt;This is Privacy Policy page content:&amp;nbsp;Lorem Ipsum is simply dummy text of the printing and typesetting  industry. Lorem Ipsum has been the industry\\''s standard dummy text ever  since the 1500s, when an unknown printer took a galley of type and  scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap  into electronic typesetting, remaining essentially unchanged. It was  popularised in the 1960s with the release of Letraset sheets containing  Lorem Ipsum passages, and more recently with desktop publishing software  like Aldus PageMaker including versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and  typesetting industry. Lorem Ipsum has been the industry\\''s standard dummy  text ever since the 1500s, when an unknown printer took a galley of  type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap  into electronic typesetting, remaining essentially unchanged. It was  popularised in the 1960s with the release of Letraset sheets containing  Lorem Ipsum passages, and more recently with desktop publishing software  like Aldus PageMaker including versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and  typesetting industry. Lorem Ipsum has been the industry\\''s standard dummy  text ever since the 1500s, when an unknown printer took a galley of  type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap  into electronic typesetting, remaining essentially unchanged. It was  popularised in the 1960s with the release of Letraset sheets containing  Lorem Ipsum passages, and more recently with desktop publishing software  like Aldus PageMaker including versions of Lorem I&lt;/p&gt;', '', '1111-222-333', 'meta tag this si Privacy Policy');

-- --------------------------------------------------------

--
-- Table structure for table `pub_media_type`
--

CREATE TABLE IF NOT EXISTS `pub_media_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `dated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `pub_media_type`
--


-- --------------------------------------------------------

--
-- Table structure for table `pub_users`
--

CREATE TABLE IF NOT EXISTS `pub_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(40) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `cell` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `company` varchar(100) NOT NULL,
  `website` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `zipcode` varchar(20) NOT NULL,
  `country` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `user_type` tinyint(1) NOT NULL COMMENT '1=expert,2=manager,3=advertiser,4=media',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `dated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `verification_code` varchar(100) NOT NULL,
  `last_login` datetime NOT NULL,
  `current_login` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `pub_users`
--

INSERT INTO `pub_users` (`id`, `first_name`, `last_name`, `email`, `password`, `phone`, `cell`, `address`, `company`, `website`, `city`, `zipcode`, `country`, `state`, `user_type`, `status`, `dated`, `verification_code`, `last_login`, `current_login`) VALUES
(1, 'Abdul', 'Sattar', 'abdulsattarpalli@gmail.com', '123', '123213213', '12323232', 'address', 'company', 'website', 'city', '46000', 'country', 'state', 1, 1, '2012-10-20 18:23:56', '', '2012-10-19 17:31:18', '2012-10-20 17:31:26');

-- --------------------------------------------------------

--
-- Table structure for table `pub_users_categories_map`
--

CREATE TABLE IF NOT EXISTS `pub_users_categories_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `pub_users_categories_map`
--


-- --------------------------------------------------------

--
-- Table structure for table `pub_users_media_map`
--

CREATE TABLE IF NOT EXISTS `pub_users_media_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `pub_users_media_map`
--

