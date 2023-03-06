/*
 Navicat Premium Data Transfer

 Source Server         : gilimex-xuathang.zdemo.xyz
 Source Server Type    : MySQL
 Source Server Version : 50560
 Source Host           : 103.68.68.143:3306
 Source Schema         : hailan_xuathang

 Target Server Type    : MySQL
 Target Server Version : 50560
 File Encoding         : 65001

 Date: 02/04/2020 21:37:19
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for post
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `status` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `thumb` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `banner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created` datetime NULL DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `modified` datetime NULL DEFAULT NULL,
  `modified_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for cate_news
-- ----------------------------
DROP TABLE IF EXISTS `cate_news`;
CREATE TABLE `cate_news`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `_lft` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `_rgt` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `parent_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `status` char(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created` datetime NULL DEFAULT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `modified` datetime NULL DEFAULT NULL,
  `modified_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `meta_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `meta_description` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `meta_keyword` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `menu_models__lft__rgt_parent_id_index`(`_lft`, `_rgt`, `parent_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of cate_news
-- ----------------------------
INSERT INTO `cate_news` VALUES (1, 'root', 'root', 1, 1, NULL, 'active', '2019-07-11 09:54:29', 'admin', '2019-07-11 09:54:29', 'admin', 'root', 'root', 'root');

-- ----------------------------
-- Table structure for company
-- ----------------------------
DROP TABLE IF EXISTS `company`;
CREATE TABLE `company`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `files_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `art` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `art_design_new` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `plu_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `revision` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `revision_design_new` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `code_nm` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `char_cont_internal` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `
out_of_stock_at` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `date_manufacture` datetime NULL DEFAULT NULL,
  `qa_check_fi` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `note` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `is_edit` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for company_logs
-- ----------------------------
DROP TABLE IF EXISTS `company_logs`;
CREATE TABLE `company_logs`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `company_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `user_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `created` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for email_bcc
-- ----------------------------
DROP TABLE IF EXISTS `email_bcc`;
CREATE TABLE `email_bcc`  (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `template` varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `created` datetime NULL DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `modified` datetime NULL DEFAULT NULL,
  `modified_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for email_subscribe
-- ----------------------------
DROP TABLE IF EXISTS `email_subscribe`;
CREATE TABLE `email_subscribe`  (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created` datetime NULL DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `modified` datetime NULL DEFAULT NULL,
  `modified_by` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 56 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for email_template
-- ----------------------------
DROP TABLE IF EXISTS `email_template`;
CREATE TABLE `email_template`  (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `title` varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `created` datetime NULL DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `modified` datetime NULL DEFAULT NULL,
  `modified_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for files
-- ----------------------------
DROP TABLE IF EXISTS `files`;
CREATE TABLE `files`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `file` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `created` datetime NULL DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `modified` datetime NULL DEFAULT NULL,
  `modified_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for settings
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key_value` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `value` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `created` datetime NULL DEFAULT NULL,
  `created_by` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `modified` datetime NULL DEFAULT NULL,
  `modified_by` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of settings
-- ----------------------------
INSERT INTO `settings` VALUES (4, 'setting-email', '{\"email\":\"abc@gmail.com\",\"password\":\"pass123\"}', NULL, '2019-06-18 06:06:22', 'admin', '2020-03-25 11:03:14', 'admin');
INSERT INTO `settings` VALUES (5, 'setting-main', '{\"logo1\":\"\\/upload\\/1\\/log-zendvn.png\",\"logo2\":\"\\/upload\\/1\\/log-zendvn-detail.png\",\"hotline1\":\"090 5744 470\",\"hotline2\":\"0383 308 983\",\"copyright\":\"\\u00a9 2020 - B\\u1ea3n quy\\u1ec1n c\\u1ee7a C\\u00f4ng Ty L\\u1eadp Tr\\u00ecnh Zend Vi\\u1ec7t Nam\",\"time\":\"T\\u1eeb 8h - 18h t\\u1eeb th\\u1ee9 2 \\u0111\\u1ebfn th\\u1ee9 7\",\"logan\":null,\"introduce\":\"<p>C&ocirc;ng Ty C\\u1ed5 Ph\\u1ea7n L\\u1eadp Tr&igrave;nh Zend Vi\\u1ec7t Nam&nbsp;<\\/p>\\r\\n\\r\\n<p>M&atilde; s\\u1ed1 thu\\u1ebf: 0314390745<\\/p>\\r\\n\\r\\n<p>T\\u1ea7ng 5, T&ograve;a nh&agrave; Songdo, 62A Ph\\u1ea1m Ng\\u1ecdc Th\\u1ea1ch, Ph\\u01b0\\u1eddng 6, Qu\\u1eadn 3, TP. H\\u1ed3 Ch&iacute; Minh<\\/p>\\r\\n\\r\\n<p>Gi\\u1ea5y ph&eacute;p \\u0111\\u0103ng k&yacute; kinh doanh s\\u1ed1 0314390745 do S\\u1edf K\\u1ebf ho\\u1ea1ch v&agrave; \\u0110\\u1ea7u t\\u01b0 Th&agrave;nh ph\\u1ed1 H\\u1ed3 Ch&iacute; Minh c\\u1ea5p ng&agrave;y 09\\/05\\/2017<\\/p>\",\"address\":\"T\\u1ea7ng 5, T\\u00f2a nh\\u00e0 Songdo, 62A Ph\\u1ea1m Ng\\u1ecdc Th\\u1ea1ch, Ph\\u01b0\\u1eddng 6, Qu\\u1eadn 3, HCM\"}', NULL, '2019-06-28 10:06:46', 'admin', '2020-01-03 12:01:55', 'dev');
INSERT INTO `settings` VALUES (6, 'setting-social', '{\"facebook1\":\"https:\\/\\/www.facebook.com\\/groups\\/ZendVN.Group\",\"facebook2\":\"https:\\/\\/www.facebook.com\\/zendvngroup\",\"facebook3\":\"https:\\/\\/www.facebook.com\\/luutruonghailan\",\"youtube1\":\"https:\\/\\/www.youtube.com\\/user\\/luutruonghailan\",\"youtube2\":\"https:\\/\\/www.youtube.com\\/user\\/zendvn123\",\"google\":\"training@zend.vn\",\"instagram\":null,\"twitter\":null,\"linkedin\":null}', NULL, '2019-06-28 10:06:09', 'admin', '2019-12-27 21:12:22', 'dev');
INSERT INTO `settings` VALUES (7, 'setting-script', '{\"script_head\":null,\"google_map\":null,\"google_analyst\":null}', NULL, '2020-03-25 10:46:48', 'admin', '2020-03-25 11:03:03', 'admin');
INSERT INTO `settings` VALUES (8, 'setting-chat', '{\"hotline\":\"{\\\"status\\\":\\\"active\\\"}\",\"facebook\":\"{\\\"page_id\\\":null,\\\"position\\\":\\\"right\\\",\\\"status\\\":\\\"inactive\\\"}\",\"zalo\":\"{\\\"page_id\\\":null,\\\"position\\\":\\\"left\\\",\\\"status\\\":\\\"inactive\\\"}\",\"service\":\"{\\\"page_id\\\":null,\\\"position\\\":\\\"right\\\",\\\"status\\\":\\\"inactive\\\"}\"}', NULL, '2020-03-25 10:46:50', 'admin', '2020-03-25 11:03:10', 'admin');
INSERT INTO `settings` VALUES (9, 'setting-seo', '{\"meta_title\":\"ZendVN - H\\u1ecdc l\\u1eadp tr\\u00ecnh online\",\"meta_description\":\"ZendVN \\u0111\\u00e0o t\\u1ea1o online c\\u00e1c kh\\u00f3a h\\u1ecdc l\\u1eadp tr\\u00ecnh tr\\u1ef1c tuy\\u1ebfn t\\u1eeb c\\u01a1 b\\u1ea3n \\u0111\\u1ebfn n\\u00e2ng cao\",\"meta_keyword\":\"zendvn, h\\u1ecdc l\\u1eadp tr\\u00ecnh online, h\\u1ecdc l\\u1eadp tr\\u00ecnh tr\\u1ef1c tuy\\u1ebfn, h\\u1ecdc l\\u1eadp tr\\u00ecnh offline\"}', NULL, '2019-10-18 14:10:01', 'admin', '2020-02-05 11:02:31', 'dev');

-- ----------------------------
-- Table structure for slider
-- ----------------------------
DROP TABLE IF EXISTS `slider`;
CREATE TABLE `slider`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `link` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `thumb` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `created` datetime NULL DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `modified` datetime NULL DEFAULT NULL,
  `modified_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `sort` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for suggestions
-- ----------------------------
DROP TABLE IF EXISTS `suggestions`;
CREATE TABLE `suggestions`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `created` datetime NULL DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `modified` datetime NULL DEFAULT NULL,
  `modified_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for usb
-- ----------------------------
DROP TABLE IF EXISTS `usb`;
CREATE TABLE `usb`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sort` int(11) NULL DEFAULT NULL,
  `size` double(11, 2) NULL DEFAULT NULL,
  `total` int(11) NULL DEFAULT NULL,
  `created` datetime NULL DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `modified` datetime NULL DEFAULT NULL,
  `modified_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `fullname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `level` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `created` datetime NULL DEFAULT NULL,
  `created_by` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `modified` datetime NULL DEFAULT NULL,
  `modified_by` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, 'admin', 'admin@gmail.com', 'admin', '827ccb0eea8a706c4c34a16891f84e7b', 'fXDBn28iVA.jpeg', '1', '2014-12-10 08:55:35', 'admin', '2020-02-10 00:00:00', 'dev', 'active');

SET FOREIGN_KEY_CHECKS = 1;
