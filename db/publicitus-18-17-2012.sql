-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 18, 2012 at 02:55 PM
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
(1, 'admin', 'admin@chilli.com', 'e10adc3949ba59abbe56e057f20f883e', '', '2012-05-03 02:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pub_categories`
--

CREATE TABLE IF NOT EXISTS `pub_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `dated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `pub_categories`
--

INSERT INTO `pub_categories` (`id`, `title`, `status`, `dated`) VALUES
(2, 'Family', 1, '2012-10-30 20:17:35'),
(3, 'Current Affairs', 1, '2012-10-30 20:20:21'),
(4, 'Comedy', 1, '2012-10-30 20:22:10'),
(5, 'Books and Authors', 1, '2012-10-30 20:22:50'),
(6, 'Arts & Cultures ', 1, '2012-11-10 20:30:21'),
(7, 'Consumer', 1, '2012-11-10 20:31:41'),
(8, 'General', 1, '2012-11-10 20:46:01'),
(9, 'Health', 1, '2012-11-10 20:46:14'),
(10, 'Legal', 1, '2012-11-10 20:46:44'),
(11, 'Music', 1, '2012-11-10 20:47:03'),
(12, 'Paranormal', 1, '2012-11-10 20:47:19'),
(13, 'Politics', 1, '2012-11-10 20:47:31'),
(14, 'Relationships', 1, '2012-11-10 20:47:42'),
(15, 'Religion and Spirituality', 1, '2012-11-10 20:47:56'),
(16, 'Sports', 1, '2012-11-10 20:48:07'),
(17, 'Travel', 1, '2012-11-10 20:48:18'),
(18, 'Technology', 1, '2012-11-10 20:48:29'),
(19, 'Women', 1, '2012-11-10 20:48:40'),
(20, 'new cat', 1, '2012-11-11 04:49:47'),
(21, 'abcaat', 1, '2012-11-11 05:00:35'),
(22, 'test cat', 1, '2012-11-11 05:01:51');

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
-- Table structure for table `pub_education`
--

CREATE TABLE IF NOT EXISTS `pub_education` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `degree` varchar(15) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `school` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_present` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `dated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `pub_education`
--

INSERT INTO `pub_education` (`id`, `degree`, `subject`, `start_date`, `end_date`, `school`, `user_id`, `is_present`, `status`, `dated`) VALUES
(1, 'MS', 'Software Engineering', '2011-02-02', '0000-00-00', 'SZABIST', 1, 0, 1, '0000-00-00 00:00:00'),
(2, 'BS', 'Computer Science', '2005-01-01', '2008-12-31', 'Univesity Of Sindh Jamshoro Hyderabad', 1, 0, 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `pub_experience`
--

CREATE TABLE IF NOT EXISTS `pub_experience` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_title` varchar(40) NOT NULL,
  `company` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `job_description` longtext NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_preset` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `dated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `pub_experience`
--


-- --------------------------------------------------------

--
-- Table structure for table `pub_job_app`
--

CREATE TABLE IF NOT EXISTS `pub_job_app` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_cover_letter` longtext NOT NULL,
  `user_rate` double NOT NULL,
  `status` tinyint(1) NOT NULL,
  `dated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='user apply for job will be save in this table' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `pub_job_app`
--


-- --------------------------------------------------------

--
-- Table structure for table `pub_job_app_file`
--

CREATE TABLE IF NOT EXISTS `pub_job_app_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_type` int(11) NOT NULL COMMENT 'file type 1 for file belong post file and 2 for file belong to app file',
  `file_type_id` int(11) NOT NULL COMMENT 'if file type id is 1 than filetypeid will be the job post id and if 2 than filetypeid will  be user id who is applying for the job :)',
  `file_name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `dated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `pub_job_app_file`
--


-- --------------------------------------------------------

--
-- Table structure for table `pub_job_post`
--

CREATE TABLE IF NOT EXISTS `pub_job_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_title` varchar(255) NOT NULL,
  `job_desc` longtext NOT NULL,
  `budget` double NOT NULL,
  `media_id` int(11) NOT NULL,
  `last_date` datetime NOT NULL,
  `location` text NOT NULL,
  `dated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `pub_job_post`
--

INSERT INTO `pub_job_post` (`id`, `job_title`, `job_desc`, `budget`, `media_id`, `last_date`, `location`, `dated`, `status`) VALUES
(1, 'PHP Developer required', 'this is php job description', 2, 2, '2012-11-27 23:41:40', 'php location', '2012-11-18 01:40:46', 1),
(2, 'Java Developer required', 'this is java job description', 2, 3, '2012-11-27 23:41:40', 'dasfasdffffvv', '2012-11-18 03:05:15', 1),
(3, 'C# developer required', 'this is C job description', 2, 3, '2012-11-27 23:41:40', 'dasfasdffffvv', '2012-11-18 03:05:15', 1),
(4, '.net developer required', 'asdfdasfffvvthis is netjob description', 2, 2, '2012-11-17 23:41:40', 'dasfasdffffvv', '2012-11-17 01:40:46', 1),
(5, 'PHP Developer required', 'this is php job description', 2, 2, '2012-11-27 23:41:40', 'php location', '2012-11-18 01:40:46', 1),
(6, 'Java Developer required', 'this is java job description', 2, 18, '2012-11-17 23:41:40', 'dasfasdffffvv', '2012-11-18 12:39:06', 1),
(7, 'C# developer required', 'this is C job description', 2, 6, '2012-11-27 23:41:40', 'dasfasdffffvv', '2012-11-18 03:05:15', 1),
(8, '.net developer required', 'asdfdasfffvvthis is netjob description', 2, 5, '2012-11-16 23:41:40', 'dasfasdffffvv', '2012-11-18 12:39:06', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `pub_media_type`
--

INSERT INTO `pub_media_type` (`id`, `title`, `status`, `dated`) VALUES
(1, 'media type1', 1, '2012-10-30 23:55:54'),
(2, 'media type2', 1, '2012-10-30 23:56:18');

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
  `status` tinyint(1) NOT NULL DEFAULT '3',
  `dated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `verification_code` varchar(100) NOT NULL,
  `last_login` datetime NOT NULL,
  `current_login` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `pub_users`
--

INSERT INTO `pub_users` (`id`, `first_name`, `last_name`, `email`, `password`, `phone`, `cell`, `address`, `company`, `website`, `city`, `zipcode`, `country`, `state`, `user_type`, `status`, `dated`, `verification_code`, `last_login`, `current_login`) VALUES
(1, 'Abdul', 'Sattar', 'abdulsattarpalli@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '123213213', '12323232', 'address', 'company', 'website', 'Islamabad', '46000', 'country', 'Punjab', 1, 1, '2012-11-13 16:29:05', '714a3a324181f353893afca0a9860266', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Shafqat Jan', 'Siddiqui', 'shafqatjan86@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '123213213', '12323232', 'address', 'company', 'website', 'Islamabad', '46000', 'country', 'Punjab', 1, 1, '2012-11-18 12:22:47', '714a3a324181f353893afca0a9860266', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `pub_users_categories_map`
--

CREATE TABLE IF NOT EXISTS `pub_users_categories_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `dated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `pub_users_categories_map`
--

INSERT INTO `pub_users_categories_map` (`id`, `user_id`, `category_id`, `status`, `dated`) VALUES
(1, 1, 2, 1, '2012-10-30 21:29:55'),
(2, 1, 3, 2, '2012-10-30 21:29:55'),
(3, 0, 2, 1, '2012-11-03 09:18:58'),
(4, 0, 3, 1, '2012-11-03 09:18:58'),
(5, 6, 2, 1, '2012-11-03 09:27:12'),
(6, 6, 3, 1, '2012-11-03 09:27:12'),
(7, 7, 5, 1, '2012-11-03 09:28:54'),
(8, 7, 4, 1, '2012-11-03 09:28:54'),
(9, 8, 5, 1, '2012-11-03 10:42:22'),
(10, 8, 4, 1, '2012-11-03 10:42:22'),
(11, 8, 2, 1, '2012-11-03 10:42:22'),
(12, 8, 3, 1, '2012-11-03 10:42:22'),
(13, 9, 4, 1, '2012-11-03 15:32:52'),
(14, 9, 3, 1, '2012-11-03 15:32:53'),
(15, 10, 5, 1, '2012-11-05 06:09:43'),
(16, 10, 4, 1, '2012-11-05 06:09:43'),
(17, 10, 2, 1, '2012-11-05 06:09:43'),
(18, 10, 3, 1, '2012-11-05 06:09:43'),
(19, 11, 5, 1, '2012-11-05 06:41:15'),
(20, 11, 4, 1, '2012-11-05 06:41:15'),
(21, 11, 2, 1, '2012-11-05 06:41:15'),
(22, 11, 3, 1, '2012-11-05 06:41:15'),
(23, 12, 5, 1, '2012-11-05 06:56:07'),
(24, 12, 4, 1, '2012-11-05 06:56:07'),
(25, 12, 3, 1, '2012-11-05 06:56:07'),
(26, 13, 2, 1, '2012-11-05 07:07:35'),
(27, 13, 3, 1, '2012-11-05 07:07:35'),
(28, 14, 2, 1, '2012-11-05 22:14:29'),
(29, 14, 3, 1, '2012-11-05 22:14:29'),
(30, 15, 2, 1, '2012-11-10 02:16:46'),
(31, 15, 3, 1, '2012-11-10 02:16:46'),
(32, 16, 2, 1, '2012-11-10 02:39:32'),
(33, 16, 3, 1, '2012-11-10 02:39:32'),
(34, 17, 4, 1, '2012-11-10 02:45:58'),
(35, 17, 2, 1, '2012-11-10 02:45:58'),
(36, 18, 5, 1, '2012-11-10 02:48:18'),
(37, 18, 4, 1, '2012-11-10 02:48:18'),
(38, 18, 2, 1, '2012-11-10 02:48:18'),
(39, 18, 3, 1, '2012-11-10 02:48:18'),
(40, 1, 2, 1, '2012-11-10 10:52:05'),
(41, 3, 4, 1, '2012-11-10 10:52:05'),
(42, 1, 4, 1, '2012-11-10 12:33:45'),
(43, 1, 3, 1, '2012-11-10 12:33:45');

-- --------------------------------------------------------

--
-- Table structure for table `pub_users_media_map`
--

CREATE TABLE IF NOT EXISTS `pub_users_media_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `dated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `pub_users_media_map`
--

INSERT INTO `pub_users_media_map` (`id`, `user_id`, `media_id`, `status`, `dated`) VALUES
(2, 4, 2, 1, '2012-10-30 23:56:36'),
(3, 8, 2, 1, '2012-11-03 10:42:22'),
(4, 9, 1, 1, '2012-11-03 15:32:53'),
(5, 10, 2, 1, '2012-11-05 06:09:43'),
(6, 11, 2, 1, '2012-11-05 06:41:15'),
(7, 12, 2, 1, '2012-11-05 06:56:07'),
(8, 13, 1, 1, '2012-11-05 07:07:35'),
(9, 14, 1, 1, '2012-11-05 22:14:29'),
(10, 15, 1, 1, '2012-11-10 02:16:46');
