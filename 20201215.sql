-- MySQL dump 10.13  Distrib 5.7.26, for Linux (x86_64)
--
-- Host: localhost    Database: jinku
-- ------------------------------------------------------
-- Server version	5.7.26-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin_menu`
--

DROP TABLE IF EXISTS `admin_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `is_menu` tinyint(1) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `uri` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_menu`
--

LOCK TABLES `admin_menu` WRITE;
/*!40000 ALTER TABLE `admin_menu` DISABLE KEYS */;
INSERT INTO `admin_menu` VALUES (1,0,1,1,'首页','el-icon-monitor','/auth/main',NULL,NULL,'2020-09-19 08:35:36'),(2,0,1,100,'系统设置','el-icon-setting','system',NULL,NULL,'2020-10-04 09:09:21'),(3,2,1,3,'管理员','fa-ban','/admin/users/list','[1]',NULL,'2020-09-19 08:01:49'),(4,2,1,4,'角色','fa-ban','/admin/roles/list',NULL,NULL,'2020-09-19 08:01:42'),(5,2,1,5,'权限','fa-ban','/admin/permissions/list',NULL,NULL,'2020-09-19 07:59:33'),(6,2,1,6,'菜单','fa-bars','/admin/menu/list',NULL,NULL,'2020-09-19 08:55:40'),(7,2,1,7,'操作日志','fa-ban','/admin/logs/list',NULL,NULL,'2020-09-19 08:34:12'),(9,0,1,10,'种子管理','el-icon-ice-cream-round','/admin/photo/list','[]','2020-10-03 06:03:45','2020-12-15 02:42:06'),(10,0,1,10,'用户管理','el-icon-user-solid','/admin/user/list','[]','2020-10-03 06:23:41','2020-12-15 02:42:15'),(11,0,1,10,'收取订单','el-icon-s-order','/admin/order/list','[]','2020-10-04 02:51:11','2020-12-15 02:42:21'),(14,0,1,1,'按钮','el-icon-switch-button','/admin/button/index','[1]','2020-10-13 10:29:17','2020-10-13 10:30:39'),(15,0,1,1,'布局','el-icon-menu','/admin/demo/index','[1]','2020-10-13 10:39:34','2020-10-13 10:40:43'),(16,0,1,1,'表单','el-icon-s-platform','/admin/form/create','[1]','2020-10-13 10:42:39','2020-10-13 10:42:39'),(17,0,1,1,'表格交互','el-icon-postcard','/admin/top/list','[1]','2020-10-13 10:44:19','2020-10-13 10:44:19'),(18,0,1,1,'商户管理','el-icon-shopping-bag-1','/admin/merchant/list','[]','2020-12-15 02:40:41','2020-12-15 02:40:41');
/*!40000 ALTER TABLE `admin_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_operation_log`
--

DROP TABLE IF EXISTS `admin_operation_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_operation_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `input` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `runtime` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `admin_operation_log_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_operation_log`
--

LOCK TABLES `admin_operation_log` WRITE;
/*!40000 ALTER TABLE `admin_operation_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_operation_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_permissions`
--

DROP TABLE IF EXISTS `admin_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `path` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `admin_permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_permissions`
--

LOCK TABLES `admin_permissions` WRITE;
/*!40000 ALTER TABLE `admin_permissions` DISABLE KEYS */;
INSERT INTO `admin_permissions` VALUES (1,'所有权限','*','[\"*\"]',NULL,'2020-11-17 09:23:28',1,3,0),(2,'首页','0','[\"GET::\\/auth\\/main\"]',NULL,'2020-11-17 09:24:05',1,2,0),(3,'登录/退出','1','[\"ANY::\\/auth\\/*\"]',NULL,'2020-09-21 04:41:20',1,0,0),(6,'菜单管理','0','[\"GET::\\/admin\\/menu\\/*\"]','2020-09-08 07:49:27','2020-09-08 10:49:09',1,0,0),(8,'添加菜单','menu:create','[\"GET::\\/admin\\/menu\\/create\",\"POST::\\/admin\\/menu\",\"POST::\\/api\\/v1\\/user\\/wx_register\",\"ANY::\\/upload\\/*\",\"POST::\\/swagger\\/api\",\"ANY::\\/swagger\\/*\",\"POST::\\/swagger\",\"POST::\\/upload\\/file\",\"POST::\\/api\\/v1\\/photo\\/pay\",\"ANY::\\/api\\/v1\\/photo\\/*\",\"ANY::\\/api\\/v1\\/order\\/*\",\"ANY::\\/api\\/v1\\/user_address\\/*\",\"ANY::\\/api\\/v1\\/user\\/*\",\"POST::\\/api\\/v1\\/user\\/send_code\",\"POST::\\/api\\/v1\\/user\\/verify_code\",\"ANY::\\/admin\\/*\",\"ANY::\\/admin\\/order\\/*\",\"GET::\\/swagger\\/index\",\"ANY::\\/*\"]','2020-09-08 10:49:31','2020-11-27 10:11:05',1,6,0),(9,'删除菜单','menu:delete','[\"DELETE::\\/admin\\/menu\\/{id}\"]','2020-09-08 10:50:27','2020-09-21 04:41:58',1,6,0),(10,'修改菜单','menu:update','[\"GET::\\/admin\\/menu\\/{id:\\\\d+}\",\"PUT::\\/admin\\/menu\\/{id:\\\\d+}\"]','2020-09-08 10:50:59','2020-09-21 04:42:15',1,6,0),(11,'管理员','users','[\"ANY::\\/admin\\/users\\/*\"]','2020-09-08 10:53:23','2020-09-21 04:42:45',1,0,0),(12,'test','test','[\"ANY::\\/api\\/v1\\/photo\\/*\"]','2020-10-13 10:29:08','2020-10-13 10:29:08',1,2,0),(13,'测试','ceshi','[]','2020-11-30 09:59:32','2020-11-30 09:59:32',1,11,0);
/*!40000 ALTER TABLE `admin_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_role_menu`
--

DROP TABLE IF EXISTS `admin_role_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_role_menu` (
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_role_menu_role_id_menu_id_index` (`role_id`,`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_role_menu`
--

LOCK TABLES `admin_role_menu` WRITE;
/*!40000 ALTER TABLE `admin_role_menu` DISABLE KEYS */;
INSERT INTO `admin_role_menu` VALUES (1,2,NULL,NULL),(1,8,NULL,NULL),(1,4,NULL,NULL),(1,1,NULL,NULL),(2,3,NULL,NULL),(1,9,NULL,NULL),(1,10,NULL,NULL),(1,11,NULL,NULL),(1,12,NULL,NULL),(1,13,NULL,NULL),(1,14,NULL,NULL),(1,15,NULL,NULL),(1,16,NULL,NULL),(1,17,NULL,NULL),(1,18,NULL,NULL);
/*!40000 ALTER TABLE `admin_role_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_role_permissions`
--

DROP TABLE IF EXISTS `admin_role_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_role_permissions` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_role_permissions_role_id_permission_id_index` (`role_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_role_permissions`
--

LOCK TABLES `admin_role_permissions` WRITE;
/*!40000 ALTER TABLE `admin_role_permissions` DISABLE KEYS */;
INSERT INTO `admin_role_permissions` VALUES (2,2,NULL,NULL),(2,3,NULL,NULL),(1,1,NULL,NULL),(1,2,NULL,NULL),(1,3,NULL,NULL),(1,6,NULL,NULL),(1,8,NULL,NULL),(1,9,NULL,NULL),(1,10,NULL,NULL),(1,11,NULL,NULL),(1,12,NULL,NULL),(1,13,NULL,NULL);
/*!40000 ALTER TABLE `admin_role_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_role_users`
--

DROP TABLE IF EXISTS `admin_role_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_role_users` (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_role_users_role_id_user_id_index` (`role_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_role_users`
--

LOCK TABLES `admin_role_users` WRITE;
/*!40000 ALTER TABLE `admin_role_users` DISABLE KEYS */;
INSERT INTO `admin_role_users` VALUES (1,1,NULL,NULL),(1,4,NULL,NULL),(1,2,NULL,NULL);
/*!40000 ALTER TABLE `admin_role_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_roles`
--

DROP TABLE IF EXISTS `admin_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_roles_name_unique` (`name`),
  UNIQUE KEY `admin_roles_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_roles`
--

LOCK TABLES `admin_roles` WRITE;
/*!40000 ALTER TABLE `admin_roles` DISABLE KEYS */;
INSERT INTO `admin_roles` VALUES (1,'超级管理员','administrator','2020-09-03 08:19:02','2020-09-03 08:19:02');
/*!40000 ALTER TABLE `admin_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_user_permissions`
--

DROP TABLE IF EXISTS `admin_user_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_user_permissions` (
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_user_permissions_user_id_permission_id_index` (`user_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_user_permissions`
--

LOCK TABLES `admin_user_permissions` WRITE;
/*!40000 ALTER TABLE `admin_user_permissions` DISABLE KEYS */;
INSERT INTO `admin_user_permissions` VALUES (1,1,NULL,NULL),(4,1,NULL,NULL);
/*!40000 ALTER TABLE `admin_user_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_users`
--

DROP TABLE IF EXISTS `admin_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_users`
--

LOCK TABLES `admin_users` WRITE;
/*!40000 ALTER TABLE `admin_users` DISABLE KEYS */;
INSERT INTO `admin_users` VALUES (1,'admin','$2y$10$wMQWO.DaBH6ec0j95tPA9uCs0Rr1L39VV9.YX4u3rI.rGqjkyta7C','管理员','https://gw.alipayobjects.com/zos/antfincdn/XAosXuNZyF/BiazfanxmamNRoxxVxka.png','Uh5tXnhDocmTgAApkpyIMMEXsUQCxKUUh9LeULMHYW8alxpv3OtrUDptkfVx','2020-09-03 08:19:02','2020-10-13 10:45:49');
/*!40000 ALTER TABLE `admin_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `config`
--

DROP TABLE IF EXISTS `config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `namespace` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '命名空间, 字母',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '配置名, 字母',
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '可读配置名',
  `remark` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
  `rules` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '配置规则描述',
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '具体配置值 key:value',
  `permissions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '权限',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_need_form` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用表单：0，否；1，是',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`name`,`namespace`),
  KEY `namespace` (`namespace`),
  KEY `update_at` (`updated_at`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='通用配置';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config`
--

LOCK TABLES `config` WRITE;
/*!40000 ALTER TABLE `config` DISABLE KEYS */;
INSERT INTO `config` VALUES (1,'system','namespace','可用空间','系统模块',NULL,'{\"system\":\"\\u7cfb\\u7edf\",\"common\":\"\\u901a\\u7528\",\"shop\":\"\\u5546\\u54c1\",\"home\":\"\\u524d\\u53f0\"}',NULL,'2019-10-18 16:47:52','2020-08-10 15:29:22',0),(2,'system','website_config','站点配置','','{\"open_export|\\u5f00\\u542f\\u5bfc\\u51fa\":{\"type\":\"switch\"},\"navbar_notice|\\u5168\\u5c40\\u63d0\\u9192\":\"\",\"system_module|\\u7cfb\\u7edf\\u6a21\\u5757\":{\"type\":\"sub-form\",\"children\":{\"icon\":{\"type\":\"icon-select\"},\"name\":\"\",\"label\":\"\",\"indexUrl\":\"\"},\"repeat\":true,\"props\":{\"sort\":true}},\"open_screen_lock|\\u95f2\\u7f6e\\u9501\\u5c4f\":{\"type\":\"switch\"},\"screen_autho_lock_time|\\u95f2\\u7f6e\\u9501\\u5c4f\\u65f6\\u957f\":{\"type\":\"number\",\"info\":\"\\u5355\\u4f4d\\u79d2\"}}','{\"open_export\":0,\"navbar_notice\":\"\\u6b22\\u8fce\\u4f7f\\u7528\",\"system_module\":[{\"icon\":\"el-icon-setting\",\"name\":\"system\",\"label\":\"\\u7cfb\\u7edf\",\"indexUrl\":\"\\/system\\/#\\/dashboard\"},{\"icon\":\"eye-open\",\"name\":\"default\",\"label\":\"\\u9996\\u98751\",\"indexUrl\":\"\\/default\\/#\\/dashboard\"}],\"open_screen_lock\":0,\"screen_autho_lock_time\":36}',NULL,'2020-03-17 08:29:10','2020-08-02 14:23:31',1),(3,'system','permissions','公共权限','','{\"open_api|\\u516c\\u5171\\u8d44\\u6e90\":{\"rule\":\"array\",\"type\":\"table-transfer\",\"props\":{\"tableHeader\":[{\"title\":\"\\u8def\\u7531\\u5730\\u5740\",\"field\":\"controller\"},{\"title\":\"\\u65b9\\u6cd5\",\"field\":\"action\"},{\"title\":\"\\u8bf7\\u6c42\\u65b9\\u5f0f\",\"field\":\"http_method\"}],\"remoteApi\":\"\\/menu\\/getOpenApis?field=open_api\"}},\"user_open_api|\\u7528\\u6237\\u5f00\\u653e\\u8d44\\u6e90\":{\"rule\":\"array\",\"type\":\"table-transfer\",\"props\":{\"tableHeader\":[{\"title\":\"\\u63a7\\u5236\\u5668\",\"field\":\"controller\"},{\"title\":\"\\u65b9\\u6cd5\",\"field\":\"action\"},{\"title\":\"\\u8bf7\\u6c42\\u65b9\\u5f0f\",\"field\":\"http_method\"}],\"remoteApi\":\"\\/menu\\/getOpenApis?field=user_open_api\"}}}','{\"open_api\":[\"POST::\\/api\\/user\\/login\",\"GET::\\/api\\/system\\/config\",\"GET::\\/api\\/user\\/menu\",\"GET::\\/swagger\\/index\",\"GET::\\/swagger\",\"GET::\\/swagger\\/api\"],\"user_open_api\":[]}',NULL,'2020-03-29 15:47:19','2020-08-05 15:44:42',1),(4,'agent','agent','运营商配置','','{\"open_export|\\u5f00\\u542f\\u5bfc\\u51fa\":{\"type\":\"switch\"},\"navbar_notice|\\u5168\\u5c40\\u63d0\\u9192\":\"\",\"open_screen_lock|\\u95f2\\u7f6e\\u9501\\u5c4f\":{\"type\":\"switch\"},\"screen_autho_lock_time|\\u95f2\\u7f6e\\u9501\\u5c4f\\u65f6\\u957f\":{\"type\":\"number\",\"info\":\"\\u5355\\u4f4d\\u79d2\"}}','\"\"',NULL,'2020-08-02 15:06:02','2020-08-02 15:09:10',1),(5,'common','share_home','赠送家人','','{\"system_module|\\u56fe\\u7247\\u5217\\u8868\":{\"type\":\"sub-form\",\"children\":{\"name|\\u6807\\u9898\":{\"type\":\"input\"},\"img_url|\\u56fe\\u7247\":{\"type\":\"image\",\"props\":{\"limit\":10,\"downloadable\":true}}},\"repeat\":true}}','{\"system_module\":[{\"name\":\"\\u7f8e\\u597d\\u65f6\\u523b\",\"img_url\":[\"http:\\/\\/47.112.215.194\\/upload\\/202008\\/09\\/05d023d078b07813a185cb0dd4fdb4c4.jpg\"]},{\"name\":\"\\u5bb6\\u4eba\\u56e2\\u805a\",\"img_url\":[\"http:\\/\\/47.112.215.194\\/upload\\/202008\\/09\\/7a054cb1e3828e8ba0444658c1d528b3.jpg\"]},{\"name\":\"\\u611f\\u6069\\u8282\",\"img_url\":[\"http:\\/\\/47.112.215.194\\/upload\\/202008\\/09\\/477d2af76b2570217bd7fbe5a45e9b08.jpg\"]},{\"name\":\"\\u6700\\u4f73\\u8001\\u5a46\",\"img_url\":[\"http:\\/\\/47.112.215.194\\/upload\\/202008\\/09\\/80dc18aff5e4febd459e68a6a057ada9.jpg\"]}]}',NULL,'2020-08-09 19:54:50','2020-08-09 23:56:08',1),(6,'common','system_config','系统设置','','{\"title|\\u7ad9\\u70b9\\u540d\\u79f0\":{\"type\":\"input\"},\"storage|\\u4e0a\\u4f20\\u50a8\\u5b58\\u81f3\":{\"type\":\"select\",\"value\":[\"local\"],\"options\":[{\"value\":\"local\",\"label\":\"\\u672c\\u5730\\u786c\\u76d8\"},{\"value\":\"oss\",\"label\":\"\\u963f\\u91cc\\u4e91OSS\"},{\"value\":\"qiniu\",\"label\":\"\\u4e03\\u725b\\u4e91\"},{\"value\":\"cos\",\"label\":\"\\u817e\\u8baf\\u4e91\\u50a8\\u5b58\"}],\"compute\":[{\"when\":[\"in\",[\"local\",\"qiniu\",\"cos\"]],\"set\":{\"oss_key_id\":{\"type\":\"hidden\"},\"oss_key_secret\":{\"type\":\"hidden\"}}},{\"when\":[\"=\",\"oss\"],\"set\":{\"oss_key_id\":{\"rule\":\"required\"},\"oss_key_secret\":{\"rule\":\"required\"}}}]},\"oss_key_id|KeyID\":{\"type\":\"input\"},\"oss_key_secret|Secret\":{\"type\":\"input\"},\"image_size|\\u6700\\u5927\\u9650\\u5236\":{\"type\":\"input\"},\"allow_ext|\\u5141\\u8bb8\\u4e0a\\u4f20\\u540e\\u7f00\":{\"type\":\"select\",\"value\":[\"png\",\"jpg\",\"gif\",\"jpeg\"],\"options\":[{\"value\":\"png\",\"label\":\"png\"},{\"value\":\"jpg\",\"label\":\"jpg\"},{\"value\":\"jpeg\",\"label\":\"jpeg\"},{\"value\":\"gif\",\"label\":\"gif\"}],\"props\":{\"multiple\":true}}}','{\"title\":\"\\u5feb\\u4e50\\u91d1\\u5e93\",\"storage\":\"local\",\"oss_key_id\":\"\",\"oss_key_secret\":\"\",\"image_size\":\"10240000\",\"allow_ext\":[\"png\",\"jpg\",\"gif\",\"jpeg\"]}',NULL,'2020-08-09 20:59:43','2020-08-09 23:13:59',1),(7,'shop','shop_price','商品价格配置','','{\"sku|\\u89c4\\u683c\\u5217\\u8868\":{\"type\":\"sub-form\",\"children\":{\"name|\\u6807\\u7b7e\":{\"type\":\"input\",\"col\":{\"span\":10}},\"money|\\u4ef7\\u683c\":{\"type\":\"number\",\"col\":{\"span\":10}}},\"repeat\":true},\"express|\\u5feb\\u9012\\u65b9\\u5f0f\":{\"type\":\"sub-form\",\"children\":{\"name|\\u6807\\u7b7e\":{\"type\":\"input\",\"col\":{\"span\":10}},\"money|\\u4ef7\\u683c\":{\"type\":\"number\",\"col\":{\"span\":10}}},\"repeat\":true},\"type|\\u76f8\\u518c\\u7c7b\\u578b\":{\"type\":\"sub-form\",\"children\":{\"name|\\u6807\\u7b7e\":{\"type\":\"input\",\"col\":{\"span\":10}},\"money|\\u4ef7\\u683c\":{\"type\":\"number\",\"col\":{\"span\":10}}},\"repeat\":true}}','{\"sku\":[{\"name\":\"10\\u5bf8\",\"money\":30},{\"name\":\"12\\u5bf8\",\"money\":35}],\"express\":[{\"name\":\"\\u90ae\\u5bc4\",\"money\":10},{\"name\":\"\\u7f51\\u7edc\\u90ae\\u7bb1\",\"money\":0}],\"type\":[{\"name\":\"\\u6709\\u8fb9\\u6846\",\"money\":10},{\"name\":\"\\u65e0\\u8fb9\\u6846\",\"money\":0}]}',NULL,'2020-08-10 15:26:15','2020-08-10 15:44:28',1);
/*!40000 ALTER TABLE `config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member`
--

DROP TABLE IF EXISTS `member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `member` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '账号',
  `password` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '密码',
  `id_card` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '身份证',
  `mobile` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '手机',
  `total` int(11) NOT NULL DEFAULT '0' COMMENT '快乐个数',
  `email` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '邮箱',
  `openid` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'openid',
  `unionid` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'openid',
  `is_email` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否验证 0=否 1=是',
  `nickname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '昵称',
  `head_pic` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '头像',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=保密 1=男 2=女',
  `birthday` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '生日',
  `level_icon` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '等级图标',
  `user_level_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '对应user_level表',
  `user_address_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '对应user_address表',
  `money` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '金额',
  `last_login` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录日期',
  `last_ip` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '最后登录ip',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=禁用 1=启用',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=未删 1=已删',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建日期',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新日期',
  `user_type` int(11) NOT NULL DEFAULT '0' COMMENT 'step',
  `introduce` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '个人介绍',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上级id',
  `family_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `mobile` (`mobile`) USING BTREE,
  KEY `email` (`email`) USING BTREE,
  KEY `nickname` (`nickname`) USING BTREE,
  KEY `user_level_id` (`user_level_id`) USING BTREE,
  KEY `status` (`status`) USING BTREE,
  KEY `is_delete` (`is_delete`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=156 DEFAULT CHARSET=utf8mb4 COMMENT='顾客组账号';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member`
--

LOCK TABLES `member` WRITE;
/*!40000 ALTER TABLE `member` DISABLE KEYS */;
INSERT INTO `member` VALUES (134,'春哥','4f9e16bd329dcb2c9a88afc33ed6bf62','','13888888888',100,'','ohVHJ5W6fHLuI1wGQ61GxowMwV9g','',0,'春哥','https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTL0kn5T9874iazkyWnIrjr3WeFdDflUkYNsqTIZsmBPaxG8kcpDqc8HRE19v7t6POrMAYs6MEYCAhQ/132',0,'','',1,0,10000,1597972972,'120.82.116.49',1,0,1594810437,1601797279,0,'',0,0),(135,'Michael','569c81a39b242e878dfde49e72c62827','','13411111111',0,'','ohVHJ5bQkr-VEYQM6xrCm3y6_k88','',0,'艺人','https://wx.qlogo.cn/mmopen/vi_32/mdF8b8eAMZ60ea2sK6XyTyGoeHOic7ltiacPiahibJwfQQTE7FqRoB7gSoNypGMkVibTsVGVhpIAFNZ6cOVynCPk6Nw/132',0,'','',1,0,1,1596465814,'113.109.244.206',1,0,1594810587,1596465814,0,'我是个艺人',0,0),(137,'Smile💬','f022ccfa33b5718373547bae90251224','','18533333333',0,'','ohVHJ5WZjlYcrgiYAGIS5KZ6k8TU1','',0,'哈哈','https://wx.qlogo.cn/mmopen/vi_32/ajNVdqHZLLCc7nicBHXYlvAphEfT9MpL1G1ib2iaBZ11gAUodicicMnib9Z3jSRBlS15XAlL651Wibic5hwjsrdHBic3ibpQ/132',0,'','',1,0,1000,1596776767,'61.158.149.159',1,0,1594957983,1597043840,0,'',0,0),(138,'小倩','2685d8429a53eae86d77d773badfe3f0','','',0,'','ohVHJ5T3BBN-ueOd5POdSDBoqmk8','',0,'小倩','https://wx.qlogo.cn/mmopen/vi_32/proaRF0lED8OChUtsEBVj98on6ccOqw3UxuFElZJR98TX5JicjcumFKkBvr0eyskWvjzwyS1yjNq1DdNOk3ZOew/132',0,'','',1,0,1,1596075842,'175.24.19.194',1,0,1596075842,1596075842,0,'',0,0),(141,'蓝色妖姬','c9ff91f1fff8bc4ab042b5fb468e376c','','',0,'','ohVHJ5QArrAWXlpuLcxgTsoqMhiM','',0,'蓝色妖姬','https://wx.qlogo.cn/mmopen/vi_32/PiajxSqBRaEJxVV9skaYGmrUSZuugvN6lZcbDbQrhP1Sd9LypfradJfLBu0U8LlX9r39W3tDR5LSzf52akUr8Aw/132',0,'','',1,0,1,1596166255,'175.24.110.237',1,0,1596166255,1596166255,0,'',0,0),(142,'崔佳东','f24a8c193458b2ce2ba9ef52ae48364b','','',0,'','ohVHJ5YOVykqeso9YLFuo41a2A4Y','',0,'崔佳东','https://wx.qlogo.cn/mmhead/3zy9Y5UvbBYIQODURE8yVnObMPOvYTb7yCUyYD1rjYk/132',0,'','',1,0,1,1596170832,'81.68.171.20',1,0,1596170824,1596170832,0,'',0,0),(145,'曹祯仁','4de757a30d065614554a4c41d4aa1223','','',0,'','ohVHJ5d8XpE2tfHXkTdvC5NUv9vQ','',0,'曹祯仁','https://wx.qlogo.cn/mmhead/JtQ8QicCZvkF2oIHuxSh7aHA38PYFDjvo42MPic2kU0u0/132',0,'','',1,0,1,1596851579,'81.68.168.124',1,0,1596851579,1596851579,0,'',0,0),(146,'Smile💬','cabb5a672b31998ba5664b65094c45e6','410421111111111111','18538710107',0,'','or_n15UOf2NBeWenzRfxV86_tkhs','',0,'Smile💬','https://wx.qlogo.cn/mmopen/vi_32/ajNVdqHZLLBpqXMk6kUC4PeB5VrIVtHyUqrcPg65sjKdPxlkBINiaQ1NG6nZC9iaWOh9qdO6VaApJzgWA1wu5h8Q/132',0,'','',1,0,0,1601714628,'222.137.55.250',1,0,1597465037,1601802081,0,'',0,0),(147,'11','32c13e0e377005ab4a241eddded1d6e1','131232111112111122','12321312313',0,'','oF0qI5BGpki1dTgQjcd9R9zIKyZI','',0,'是个胖子。','https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83eoaEmxrMcEwRPARTJGlBLjCaETZLbibgVSmkQ6XrKgaicpXE9cQ9HDJbqqkAWY7MBIR4BAAIzSGDVdQ/132',0,'','',2,0,0,1602522852,'36.24.239.188',1,0,1597500298,1602576359,0,'',0,0),(149,'老白','55b9d76948d4c0b6f89407873376d0d5','','',0,'','oF0qI5J4S_VaZcDmsFAekmCkC1dY','',0,'老白','https://thirdwx.qlogo.cn/mmopen/vi_32/kVroh8aKgIKkBBu2zHjiaMgrrFG8icoxTTEGLyXRBSyeWKI6xJibibway8kLz4wwrvDW2ic5UoRKAxKWsibYj7NKVDDw/132',0,'','',0,0,0,1598854330,'120.82.117.86',1,0,1598256897,1598854330,0,'',0,0),(150,'测试','4d427611bdb59be05439a535283b3a8a','410421199109180000','18538710107',10,'','oF0qI5Kx2HWryV4k_il9djL2-3zs','',0,'Smile💬','https://thirdwx.qlogo.cn/mmopen/vi_32/ajNVdqHZLLDJIZRhp4wv5arUFzmsrMzvBjFyYQyhEZS4jqZ7s5TBI7fXWM1alCibujnfyUs97WTBPclp7GtMdnQ/132',0,'','',2,0,10000,1602572365,'61.158.152.247',1,0,1598517925,1602572365,0,'',0,0);
/*!40000 ALTER TABLE `member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `merchant`
--

DROP TABLE IF EXISTS `merchant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `merchant` (
  `merchant_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '商户id',
  `cate_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商户分类 id',
  `name` varchar(32) NOT NULL COMMENT '商户名称',
  `real_name` varchar(32) NOT NULL COMMENT '商户姓名',
  `address` varchar(64) NOT NULL COMMENT '商户地址',
  `keyword` varchar(64) DEFAULT NULL COMMENT '商户关键字',
  `avatar` varchar(128) DEFAULT NULL COMMENT '商户头像',
  `banner` varchar(128) DEFAULT NULL COMMENT '商户banner图片',
  `sales` int(11) unsigned DEFAULT '0' COMMENT '销量',
  `mark` varchar(256) NOT NULL COMMENT '商户备注',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '总后台管理员ID',
  `sort` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '商户是否禁用0锁定,1正常',
  `is_del` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0未删除1删除',
  `is_audit` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '添加的产品是否审核0不审核1审核',
  `is_best` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否推荐',
  `state` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '商户是否1开启0关闭',
  `info` varchar(256) NOT NULL DEFAULT '' COMMENT '店铺简介',
  `phone` varchar(13) NOT NULL DEFAULT '' COMMENT '店铺电话',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `wd_money` int(11) NOT NULL DEFAULT '0' COMMENT '已提现金额',
  `lock_money` int(11) NOT NULL DEFAULT '0' COMMENT '冻结资金(即提现中，审核中的金额)',
  `bank_name` varchar(255) NOT NULL DEFAULT '0' COMMENT '提现的开户行名称',
  `bank_user` varchar(255) NOT NULL COMMENT '提现的开户行户名',
  `total_money` int(11) NOT NULL DEFAULT '0' COMMENT '累计资金',
  PRIMARY KEY (`merchant_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8 COMMENT='商户表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `merchant`
--

LOCK TABLES `merchant` WRITE;
/*!40000 ALTER TABLE `merchant` DISABLE KEYS */;
INSERT INTO `merchant` VALUES (55,0,'分店2','老板','分店2分店2',NULL,NULL,NULL,0,'',0,0,1,0,0,0,0,'','13422222222','2020-10-02 00:14:26','2020-10-04 12:26:50',0,0,'中国黄金储备库','6666666666666666',0),(61,0,'分店1','测试','分店1',NULL,NULL,NULL,0,'',0,0,1,0,0,0,0,'','13422222222','2020-10-03 22:08:07','2020-10-04 12:26:11',0,0,'中国黄金储备库','8888888888888888888',0);
/*!40000 ALTER TABLE `merchant` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `merchant_users`
--

DROP TABLE IF EXISTS `merchant_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `merchant_users` (
  `merchant_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `merchant_users_id_user_id_index` (`merchant_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `merchant_users`
--

LOCK TABLES `merchant_users` WRITE;
/*!40000 ALTER TABLE `merchant_users` DISABLE KEYS */;
INSERT INTO `merchant_users` VALUES (56,14916,NULL,NULL),(56,14917,NULL,NULL);
/*!40000 ALTER TABLE `merchant_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT '0' COMMENT '会员ID',
  `order_no` varchar(50) DEFAULT '0' COMMENT '订单单号',
  `from_mid` bigint(20) unsigned DEFAULT '0' COMMENT '推荐会员ID',
  `price_total` int(11) unsigned DEFAULT '0' COMMENT '待付金额统计',
  `price_goods` int(11) unsigned DEFAULT '0' COMMENT '商品费用统计',
  `pay_state` tinyint(1) unsigned DEFAULT '0' COMMENT '支付状态(0未支付,1已支付)',
  `pay_type` varchar(10) DEFAULT '' COMMENT '支付方式',
  `pay_price` int(11) unsigned DEFAULT '0' COMMENT '支付金额',
  `pay_no` varchar(100) DEFAULT '' COMMENT '支付单号',
  `pay_at` datetime DEFAULT NULL COMMENT '支付时间',
  `delivery_type` tinyint(1) unsigned DEFAULT '0' COMMENT '邮寄方式',
  `cancel_at` datetime DEFAULT NULL COMMENT '取消时间',
  `cancel_desc` varchar(500) DEFAULT '' COMMENT '取消描述',
  `type` tinyint(1) unsigned DEFAULT '0' COMMENT '相册类型 1 有边框 2 无边框',
  `delivery_at` datetime DEFAULT NULL COMMENT '邮寄时间',
  `refund_no` varchar(50) DEFAULT '' COMMENT '退款单号',
  `refund_price` decimal(20,2) DEFAULT '0.00' COMMENT '退款金额',
  `out_transaction_id` varchar(50) DEFAULT '' COMMENT '退款单号',
  `refund_desc` varchar(500) DEFAULT '' COMMENT '退款描述',
  `out_state` tinyint(1) unsigned DEFAULT '0' COMMENT '发货状态(0未发货,1已发货,2已签收 3 异常)',
  `express_at` datetime DEFAULT NULL COMMENT '发货时间',
  `express_no` varchar(50) DEFAULT NULL COMMENT '发货单号',
  `express_company` varchar(50) DEFAULT NULL COMMENT '物流公司',
  `title` varchar(255) DEFAULT '' COMMENT '商品名称',
  `photo_id` int(11) DEFAULT '0' COMMENT 'skuid',
  `address_id` int(11) NOT NULL DEFAULT '0' COMMENT '邮寄地址',
  `transaction_id` varchar(255) DEFAULT '' COMMENT '第三方订单号',
  `status` tinyint(1) unsigned DEFAULT '0' COMMENT '订单状态(0待支付,1待发货,2已发货,3已完成）',
  `is_deleted` tinyint(1) unsigned DEFAULT '0' COMMENT '删除状态',
  `create_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `id` (`id`),
  KEY `idx_store_groups_order_mid` (`user_id`) USING BTREE,
  KEY `idx_store_groups_order_order_no` (`order_no`) USING BTREE,
  KEY `idx_store_groups_order_pay_no` (`pay_no`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=568 DEFAULT CHARSET=utf8mb4 COMMENT='订单-记录';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
INSERT INTO `order` VALUES (558,141,'0',0,0,0,0,'',0,'',NULL,0,NULL,'',0,NULL,'',0.00,'','',0,'2020-11-25 19:06:26','11','ems','',0,0,'',2,0,'2020-11-02 16:54:34','2020-11-25 19:06:26'),(559,NULL,'0',0,100,0,0,'',0,'',NULL,0,NULL,'',0,NULL,'',0.00,'','',0,'2020-11-25 19:06:17','123','SF','',0,0,'',2,0,'2020-11-05 08:56:04','2020-11-25 19:06:17'),(560,141,'0',0,10,0,0,'',0,'',NULL,0,NULL,'',0,NULL,'',0.00,'','',0,'2020-11-25 19:06:38','23','sf','',0,0,'',2,0,'2020-11-09 15:34:20','2020-11-25 19:06:38'),(561,NULL,'0',0,0,0,0,'',0,'',NULL,0,NULL,'',0,NULL,'',0.00,'','',0,NULL,NULL,NULL,'',0,0,'',0,0,'2020-11-11 09:54:29','2020-11-25 19:08:02'),(562,NULL,'0',0,0,0,0,'',0,'',NULL,0,NULL,'',0,NULL,'',0.00,'','',0,NULL,NULL,NULL,'',0,0,'',NULL,0,'2020-11-13 10:02:54','2020-11-13 10:02:54'),(564,NULL,'0',0,0,0,0,'',0,'',NULL,0,NULL,'',0,NULL,'',0.00,'','',0,NULL,NULL,NULL,'',0,0,'',1,0,'2020-11-24 15:43:13','2020-11-24 15:43:13'),(565,NULL,'0',0,0,0,0,'',0,'',NULL,0,NULL,'',0,NULL,'',0.00,'','',0,NULL,NULL,NULL,'',0,0,'',1,0,'2020-11-26 16:41:30','2020-11-26 16:41:30'),(566,NULL,'0',0,0,0,0,'',0,'',NULL,0,NULL,'',0,NULL,'',0.00,'','',0,NULL,NULL,NULL,'',0,0,'',NULL,0,'2020-12-06 23:41:07','2020-12-06 23:41:07'),(567,147,'0',0,132,0,0,'',0,'',NULL,0,NULL,'',0,NULL,'',0.00,'','',0,NULL,NULL,NULL,'',0,0,'',0,0,'2020-12-11 16:12:15','2020-12-11 16:12:15');
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `photo`
--

DROP TABLE IF EXISTS `photo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `photo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '可读配置名',
  `remark` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
  `content` varchar(1000) COLLATE utf8mb4_bin DEFAULT '[]' COMMENT 'json',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `image` varchar(1000) COLLATE utf8mb4_bin NOT NULL DEFAULT '' COMMENT '照片',
  `user_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `update_at` (`updated_at`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='通用配置';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `photo`
--

LOCK TABLES `photo` WRITE;
/*!40000 ALTER TABLE `photo` DISABLE KEYS */;
INSERT INTO `photo` VALUES (1,'故事名称','朋友聚会','[{\"sign\": \"签名签名签名\", \"content\": \"内容1\", \"nickname\": \"222内容1\"}]',1,'2019-10-18 16:47:52','2020-10-04 16:06:43','/upload/image/202010/04/4cc424c8f66c10b636b25341cfa996c0.png',146),(8,'string','备注备注备注备注','[{\"sign\": \"签名\", \"content\": \"内容\", \"nickname\": \"名称\"}]',0,'2020-08-11 17:59:57','2020-10-04 12:35:07','/upload/image/202010/03/4adaccaa31739633b5072a260770f2ea.jpg',146),(9,'biaoti ','备注内容','[{\"sign\": \"签名\", \"content\": \"内容\", \"nickname\": \"名称\"}]',0,'2020-08-11 18:00:00','2020-10-04 12:35:03','/upload/image/202010/03/a513ce728e0b42ba7ec9018ec4f76497.jpg',146),(19,'12','','[{\"nickname\":\"qq\",\"content\":\"www\",\"sign\":\"e\"}]',1,'2020-10-11 22:30:31','2020-10-11 22:30:31','http://api.jiayoujiafu.com/upload/image/202010/11/bc0de3d7062f61ddb283e60f546d2015.jpg',147),(20,'11','','[{\"nickname\":\"22\",\"content\":\"33\",\"sign\":\"qq\"}]',1,'2020-10-11 22:50:04','2020-10-11 22:50:04','http://api.jiayoujiafu.com/upload/image/202010/11/7ed1d4f43a105a84489b11618b9c454e.jpg',147),(21,'11','','[{\"nickname\":\"22\",\"content\":\"33\",\"sign\":\"ww\"}]',1,'2020-10-11 22:51:08','2020-10-11 22:51:08','http://api.jiayoujiafu.com/upload/image/202010/11/6dd4dddce36d3067dbb3d6fe5cf83d26.jpg',147),(22,'11','','[{\"nickname\":\"22\",\"content\":\"33\",\"sign\":\"ee\"}]',1,'2020-10-11 22:51:39','2020-10-11 22:51:39','http://api.jiayoujiafu.com/upload/image/202010/11/87cf4cc2f8db500a96fbac2ba6e114ed.jpg',147),(23,'11','','[{\"nickname\":\"22\",\"content\":\"33\",\"sign\":\"rr\"}]',1,'2020-10-11 22:55:00','2020-10-11 22:55:00','http://api.jiayoujiafu.com/upload/image/202010/11/56b33cef1ba2ec36f06e0d7fd5c93c98.jpg',147),(26,'哈哈','','[{\"nickname\":\"\\u54c8\\u54c8\\u54c8\",\"content\":\"\\u54c8\\u54c8\",\"sign\":\"\"}]',1,'2020-10-12 21:01:01','2020-10-12 21:01:01','http://api.jiayoujiafu.com/upload/image/202010/12/c2f328263d5fd8a240e94a9bf18ed9b0.jpg',150),(27,'啊啊啊','','[{\"nickname\":\"\\u50a8\\u5b58\",\"content\":\"\\u63d2\\u4e0a\\u7684\",\"sign\":\"\\u6d4b\"}]',1,'2020-10-12 22:38:46','2020-10-12 22:38:46','http://api.jiayoujiafu.com/upload/image/202010/12/b5843536a58ff157f94dae344fb45ace.png',150);
/*!40000 ALTER TABLE `photo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_address`
--

DROP TABLE IF EXISTS `user_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_address` (
  `address_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户地址id',
  `user_id` int(11) unsigned NOT NULL COMMENT '用户id',
  `real_name` varchar(32) NOT NULL DEFAULT '' COMMENT '收货人姓名',
  `phone` varchar(16) NOT NULL DEFAULT '' COMMENT '收货人电话',
  `province` varchar(64) NOT NULL DEFAULT '' COMMENT '收货人所在省',
  `city` varchar(64) NOT NULL DEFAULT '' COMMENT '收货人所在市',
  `city_id` int(11) NOT NULL DEFAULT '0' COMMENT '城市id',
  `district` varchar(64) NOT NULL DEFAULT '' COMMENT '收货人所在区',
  `detail` varchar(256) NOT NULL DEFAULT '' COMMENT '收货人详细地址',
  `post_code` int(10) unsigned NOT NULL COMMENT '邮编',
  `longitude` varchar(16) NOT NULL DEFAULT '0' COMMENT '经度',
  `latitude` varchar(16) NOT NULL DEFAULT '0' COMMENT '纬度',
  `is_default` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否默认',
  `is_del` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`address_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='用户地址表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_address`
--

LOCK TABLES `user_address` WRITE;
/*!40000 ALTER TABLE `user_address` DISABLE KEYS */;
INSERT INTO `user_address` VALUES (1,137,'毛自豪','18538710107','河南','郑州',0,'二七区','火车站附近',0,'0','0',0,0,'2020-10-04 13:35:06','2020-10-09 23:32:23'),(4,154,'张三','string','string','string',0,'string','string',0,'0','0',0,0,'2020-10-09 23:32:43','2020-10-09 23:32:43'),(5,154,'张三','string','string','string',0,'string','string',123333,'0','0',0,0,'2020-10-09 23:44:08','2020-10-09 23:44:08'),(6,154,'张三','string','string','string',0,'string','string',123333,'0','0',0,0,'2020-10-09 23:44:09','2020-10-09 23:44:09'),(10,150,'张三','020-81167888','广东省','广州市',0,'海珠区','新港中路397号',510000,'0','0',0,0,'2020-10-13 15:01:14','2020-10-13 15:01:14');
/*!40000 ALTER TABLE `user_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `verification`
--

DROP TABLE IF EXISTS `verification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `verification` (
  `verification_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mobile` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '号码',
  `send_ip` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'ip',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT 'user',
  `code` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '验证码',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=无效 1=有效',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1:绑定手机  2:安全验证 3:登录',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建日期',
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建日期',
  `time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`verification_id`) USING BTREE,
  KEY `number` (`mobile`) USING BTREE,
  KEY `code` (`code`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='验证码';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `verification`
--

LOCK TABLES `verification` WRITE;
/*!40000 ALTER TABLE `verification` DISABLE KEYS */;
INSERT INTO `verification` VALUES (14,'13522222222','61.158.148.27',154,'385998',1,1,'2020-10-11 16:44:04','2020-10-11 16:44:04',0),(15,'13522222222','61.158.148.27',154,'479562',2,1,'2020-10-11 16:52:58','2020-10-11 16:53:06',1602406378),(16,'18538710107','61.158.148.27',150,'863939',2,1,'2020-10-11 21:02:35','2020-10-11 21:03:28',1602421355),(17,'13312341234','36.24.239.188',147,'326260',2,1,'2020-10-11 22:27:27','2020-10-11 22:27:36',1602426447);
/*!40000 ALTER TABLE `verification` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-12-15 10:58:40
