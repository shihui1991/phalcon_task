/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50718
 Source Host           : 127.0.0.1:3306
 Source Schema         : task_v2

 Target Server Type    : MySQL
 Target Server Version : 50718
 File Encoding         : 65001

 Date: 17/09/2019 18:01:35
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for job
-- ----------------------------
DROP TABLE IF EXISTS `job`;
CREATE TABLE `job`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标题',
  `start_at` date NOT NULL COMMENT '预计开始',
  `status` tinyint(2) UNSIGNED NOT NULL COMMENT '状态',
  `develop` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '开发人员',
  `days` decimal(10, 2) UNSIGNED NOT NULL COMMENT '天数',
  `difficult_level` tinyint(2) UNSIGNED NULL DEFAULT NULL COMMENT '难度',
  `pro_vali` tinyint(2) UNSIGNED NULL DEFAULT NULL COMMENT '专业验证',
  `finish_at` date NULL DEFAULT NULL COMMENT '预计结束',
  `handle` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '处理人',
  `priority` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '优先级',
  `version` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '迭代',
  `grade` tinyint(2) UNSIGNED NULL DEFAULT NULL COMMENT '评价',
  `require_vali` tinyint(2) UNSIGNED NULL DEFAULT NULL COMMENT '需求验证',
  `test` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '测试',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'TAPD任务' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for job_grade
-- ----------------------------
DROP TABLE IF EXISTS `job_grade`;
CREATE TABLE `job_grade`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `month` char(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '月份',
  `user_id` int(11) UNSIGNED NOT NULL COMMENT '人员ID',
  `grade` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '绩效评价',
  `record_days` decimal(4, 1) UNSIGNED NULL DEFAULT NULL COMMENT '日报记录天数',
  `off_days` decimal(4, 1) UNSIGNED NULL DEFAULT NULL COMMENT '缺勤天数',
  `work_days` decimal(4, 1) UNSIGNED NULL DEFAULT NULL COMMENT '工作天数',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `month_userId_unique`(`month`, `user_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '绩效评价' ROW_FORMAT = Fixed;

-- ----------------------------
-- Table structure for job_rate
-- ----------------------------
DROP TABLE IF EXISTS `job_rate`;
CREATE TABLE `job_rate`  (
  `id` char(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `skill_type` tinyint(2) UNSIGNED NOT NULL COMMENT '技术类别',
  `job_level` tinyint(2) UNSIGNED NOT NULL COMMENT '职级',
  `difficulty_level` tinyint(2) UNSIGNED NOT NULL COMMENT '难度级别',
  `rate` smallint(3) UNSIGNED NOT NULL COMMENT '难度系数',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `unique`(`skill_type`, `job_level`, `difficulty_level`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '难度系数' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of job_rate
-- ----------------------------
INSERT INTO `job_rate` VALUES ('1-1-1', 1, 1, 1, 100);
INSERT INTO `job_rate` VALUES ('1-1-2', 1, 1, 2, 100);
INSERT INTO `job_rate` VALUES ('1-1-3', 1, 1, 3, 110);
INSERT INTO `job_rate` VALUES ('1-1-4', 1, 1, 4, 120);
INSERT INTO `job_rate` VALUES ('1-1-5', 1, 1, 5, 130);
INSERT INTO `job_rate` VALUES ('1-1-6', 1, 1, 6, 100);
INSERT INTO `job_rate` VALUES ('1-1-7', 1, 1, 7, 100);
INSERT INTO `job_rate` VALUES ('1-1-8', 1, 1, 8, 100);
INSERT INTO `job_rate` VALUES ('1-1-9', 1, 1, 9, 100);
INSERT INTO `job_rate` VALUES ('1-2-1', 1, 2, 1, 90);
INSERT INTO `job_rate` VALUES ('1-2-2', 1, 2, 2, 90);
INSERT INTO `job_rate` VALUES ('1-2-3', 1, 2, 3, 95);
INSERT INTO `job_rate` VALUES ('1-2-4', 1, 2, 4, 100);
INSERT INTO `job_rate` VALUES ('1-2-5', 1, 2, 5, 115);
INSERT INTO `job_rate` VALUES ('1-2-6', 1, 2, 6, 125);
INSERT INTO `job_rate` VALUES ('1-2-7', 1, 2, 7, 135);
INSERT INTO `job_rate` VALUES ('1-2-8', 1, 2, 8, 100);
INSERT INTO `job_rate` VALUES ('1-2-9', 1, 2, 9, 100);
INSERT INTO `job_rate` VALUES ('1-3-1', 1, 3, 1, 70);
INSERT INTO `job_rate` VALUES ('1-3-2', 1, 3, 2, 70);
INSERT INTO `job_rate` VALUES ('1-3-3', 1, 3, 3, 80);
INSERT INTO `job_rate` VALUES ('1-3-4', 1, 3, 4, 90);
INSERT INTO `job_rate` VALUES ('1-3-5', 1, 3, 5, 90);
INSERT INTO `job_rate` VALUES ('1-3-6', 1, 3, 6, 100);
INSERT INTO `job_rate` VALUES ('1-3-7', 1, 3, 7, 120);
INSERT INTO `job_rate` VALUES ('1-3-8', 1, 3, 8, 150);
INSERT INTO `job_rate` VALUES ('1-3-9', 1, 3, 9, 100);
INSERT INTO `job_rate` VALUES ('1-4-1', 1, 4, 1, 70);
INSERT INTO `job_rate` VALUES ('1-4-2', 1, 4, 2, 70);
INSERT INTO `job_rate` VALUES ('1-4-3', 1, 4, 3, 80);
INSERT INTO `job_rate` VALUES ('1-4-4', 1, 4, 4, 80);
INSERT INTO `job_rate` VALUES ('1-4-5', 1, 4, 5, 80);
INSERT INTO `job_rate` VALUES ('1-4-6', 1, 4, 6, 85);
INSERT INTO `job_rate` VALUES ('1-4-7', 1, 4, 7, 90);
INSERT INTO `job_rate` VALUES ('1-4-8', 1, 4, 8, 100);
INSERT INTO `job_rate` VALUES ('1-4-9', 1, 4, 9, 110);
INSERT INTO `job_rate` VALUES ('2-1-1', 2, 1, 1, 90);
INSERT INTO `job_rate` VALUES ('2-1-2', 2, 1, 2, 100);
INSERT INTO `job_rate` VALUES ('2-1-3', 2, 1, 3, 105);
INSERT INTO `job_rate` VALUES ('2-1-4', 2, 1, 4, 110);
INSERT INTO `job_rate` VALUES ('2-1-5', 2, 1, 5, 120);
INSERT INTO `job_rate` VALUES ('2-1-6', 2, 1, 6, 130);
INSERT INTO `job_rate` VALUES ('2-1-7', 2, 1, 7, 100);
INSERT INTO `job_rate` VALUES ('2-1-8', 2, 1, 8, 100);
INSERT INTO `job_rate` VALUES ('2-1-9', 2, 1, 9, 100);
INSERT INTO `job_rate` VALUES ('2-2-1', 2, 2, 1, 80);
INSERT INTO `job_rate` VALUES ('2-2-2', 2, 2, 2, 80);
INSERT INTO `job_rate` VALUES ('2-2-3', 2, 2, 3, 90);
INSERT INTO `job_rate` VALUES ('2-2-4', 2, 2, 4, 100);
INSERT INTO `job_rate` VALUES ('2-2-5', 2, 2, 5, 105);
INSERT INTO `job_rate` VALUES ('2-2-6', 2, 2, 6, 115);
INSERT INTO `job_rate` VALUES ('2-2-7', 2, 2, 7, 125);
INSERT INTO `job_rate` VALUES ('2-2-8', 2, 2, 8, 100);
INSERT INTO `job_rate` VALUES ('2-2-9', 2, 2, 9, 100);
INSERT INTO `job_rate` VALUES ('2-3-1', 2, 3, 1, 70);
INSERT INTO `job_rate` VALUES ('2-3-2', 2, 3, 2, 70);
INSERT INTO `job_rate` VALUES ('2-3-3', 2, 3, 3, 85);
INSERT INTO `job_rate` VALUES ('2-3-4', 2, 3, 4, 90);
INSERT INTO `job_rate` VALUES ('2-3-5', 2, 3, 5, 95);
INSERT INTO `job_rate` VALUES ('2-3-6', 2, 3, 6, 100);
INSERT INTO `job_rate` VALUES ('2-3-7', 2, 3, 7, 105);
INSERT INTO `job_rate` VALUES ('2-3-8', 2, 3, 8, 120);
INSERT INTO `job_rate` VALUES ('2-3-9', 2, 3, 9, 100);
INSERT INTO `job_rate` VALUES ('2-4-1', 2, 4, 1, 65);
INSERT INTO `job_rate` VALUES ('2-4-2', 2, 4, 2, 65);
INSERT INTO `job_rate` VALUES ('2-4-3', 2, 4, 3, 75);
INSERT INTO `job_rate` VALUES ('2-4-4', 2, 4, 4, 80);
INSERT INTO `job_rate` VALUES ('2-4-5', 2, 4, 5, 85);
INSERT INTO `job_rate` VALUES ('2-4-6', 2, 4, 6, 90);
INSERT INTO `job_rate` VALUES ('2-4-7', 2, 4, 7, 95);
INSERT INTO `job_rate` VALUES ('2-4-8', 2, 4, 8, 100);
INSERT INTO `job_rate` VALUES ('2-4-9', 2, 4, 9, 110);
INSERT INTO `job_rate` VALUES ('3-1-1', 3, 1, 1, 80);
INSERT INTO `job_rate` VALUES ('3-1-2', 3, 1, 2, 100);
INSERT INTO `job_rate` VALUES ('3-1-3', 3, 1, 3, 110);
INSERT INTO `job_rate` VALUES ('3-1-4', 3, 1, 4, 120);
INSERT INTO `job_rate` VALUES ('3-1-5', 3, 1, 5, 130);
INSERT INTO `job_rate` VALUES ('3-1-6', 3, 1, 6, 100);
INSERT INTO `job_rate` VALUES ('3-1-7', 3, 1, 7, 100);
INSERT INTO `job_rate` VALUES ('3-1-8', 3, 1, 8, 100);
INSERT INTO `job_rate` VALUES ('3-1-9', 3, 1, 9, 100);
INSERT INTO `job_rate` VALUES ('3-2-1', 3, 2, 1, 60);
INSERT INTO `job_rate` VALUES ('3-2-2', 3, 2, 2, 60);
INSERT INTO `job_rate` VALUES ('3-2-3', 3, 2, 3, 80);
INSERT INTO `job_rate` VALUES ('3-2-4', 3, 2, 4, 100);
INSERT INTO `job_rate` VALUES ('3-2-5', 3, 2, 5, 110);
INSERT INTO `job_rate` VALUES ('3-2-6', 3, 2, 6, 120);
INSERT INTO `job_rate` VALUES ('3-2-7', 3, 2, 7, 130);
INSERT INTO `job_rate` VALUES ('3-2-8', 3, 2, 8, 100);
INSERT INTO `job_rate` VALUES ('3-2-9', 3, 2, 9, 100);
INSERT INTO `job_rate` VALUES ('3-3-1', 3, 3, 1, 50);
INSERT INTO `job_rate` VALUES ('3-3-2', 3, 3, 2, 60);
INSERT INTO `job_rate` VALUES ('3-3-3', 3, 3, 3, 70);
INSERT INTO `job_rate` VALUES ('3-3-4', 3, 3, 4, 80);
INSERT INTO `job_rate` VALUES ('3-3-5', 3, 3, 5, 80);
INSERT INTO `job_rate` VALUES ('3-3-6', 3, 3, 6, 100);
INSERT INTO `job_rate` VALUES ('3-3-7', 3, 3, 7, 120);
INSERT INTO `job_rate` VALUES ('3-3-8', 3, 3, 8, 135);
INSERT INTO `job_rate` VALUES ('3-3-9', 3, 3, 9, 100);
INSERT INTO `job_rate` VALUES ('3-4-1', 3, 4, 1, 50);
INSERT INTO `job_rate` VALUES ('3-4-2', 3, 4, 2, 50);
INSERT INTO `job_rate` VALUES ('3-4-3', 3, 4, 3, 50);
INSERT INTO `job_rate` VALUES ('3-4-4', 3, 4, 4, 70);
INSERT INTO `job_rate` VALUES ('3-4-5', 3, 4, 5, 70);
INSERT INTO `job_rate` VALUES ('3-4-6', 3, 4, 6, 70);
INSERT INTO `job_rate` VALUES ('3-4-7', 3, 4, 7, 100);
INSERT INTO `job_rate` VALUES ('3-4-8', 3, 4, 8, 115);
INSERT INTO `job_rate` VALUES ('3-4-9', 3, 4, 9, 135);

-- ----------------------------
-- Table structure for job_score
-- ----------------------------
DROP TABLE IF EXISTS `job_score`;
CREATE TABLE `job_score`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `start_at` date NOT NULL COMMENT '开始日期',
  `user_id` int(10) UNSIGNED NOT NULL COMMENT '人员ID',
  `job_id` int(10) UNSIGNED NOT NULL COMMENT '任务ID',
  `job_rate` smallint(3) UNSIGNED NULL DEFAULT NULL COMMENT '难度系数',
  `score` decimal(5, 2) UNSIGNED NULL DEFAULT NULL COMMENT '评分',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `jobId_userId_unique`(`job_id`, `user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '任务评分' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '上级ID',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '名称',
  `infos` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '描述',
  `uri` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '路由',
  `is_ctrl` tinyint(1) NOT NULL COMMENT '是否限制',
  `status` tinyint(1) NOT NULL COMMENT '状态',
  `created_at` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uri_unique`(`uri`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '菜单' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES (1, 0, '菜单列表', '', '/menu', 1, 1, 1567070411, 1567070411);
INSERT INTO `menu` VALUES (2, 1, '编辑菜单', '', '/menu/store', 1, 1, 1567070446, 1567070446);
INSERT INTO `menu` VALUES (3, 1, '删除菜单', '', '/menu/del', 1, 1, 1567070466, 1567070466);

-- ----------------------------
-- Table structure for partment
-- ----------------------------
DROP TABLE IF EXISTS `partment`;
CREATE TABLE `partment`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '上级ID',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '名称',
  `created_at` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '部门' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of partment
-- ----------------------------
INSERT INTO `partment` VALUES (1, 0, '游戏研发中心', 1562550723, 1562550723);
INSERT INTO `partment` VALUES (3, 1, '微信小游戏开发组', 1562550752, 1567128716);
INSERT INTO `partment` VALUES (4, 1, '挂机卡牌开发组', 1562550781, 1567128747);
INSERT INTO `partment` VALUES (5, 0, '游戏发行中心', 1567128987, 1567128987);
INSERT INTO `partment` VALUES (6, 5, '市场部', 1567128996, 1567128996);
INSERT INTO `partment` VALUES (7, 5, '运营部', 1567129005, 1567129005);
INSERT INTO `partment` VALUES (8, 7, '运维部', 1567129023, 1567129023);

-- ----------------------------
-- Table structure for role
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '上级ID',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '名称',
  `is_root` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否超管',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态',
  `created_at` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '角色' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role
-- ----------------------------
INSERT INTO `role` VALUES (1, 0, '开发者', 1, 1, 1562550690, 1562550690);
INSERT INTO `role` VALUES (2, 0, '管理员', 0, 1, 1562552514, 1562552514);

-- ----------------------------
-- Table structure for role_menu
-- ----------------------------
DROP TABLE IF EXISTS `role_menu`;
CREATE TABLE `role_menu`  (
  `role_id` int(10) UNSIGNED NOT NULL,
  `menu_id` int(10) UNSIGNED NOT NULL,
  UNIQUE INDEX `roleId_menuId_unique`(`role_id`, `menu_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '角色授权菜单' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role_menu
-- ----------------------------
INSERT INTO `role_menu` VALUES (2, 1);
INSERT INTO `role_menu` VALUES (2, 2);
INSERT INTO `role_menu` VALUES (2, 3);

-- ----------------------------
-- Table structure for task
-- ----------------------------
DROP TABLE IF EXISTS `task`;
CREATE TABLE `task`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL COMMENT '日期',
  `user_id` int(10) UNSIGNED NOT NULL COMMENT '人员ID',
  `task` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '今日任务',
  `next_task` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '明日任务',
  `issues` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '问题与建议',
  `mark` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '备注',
  `created_at` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `date_userId_unique`(`date`, `user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '每日任务' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of task
-- ----------------------------
INSERT INTO `task` VALUES (1, '2019-08-14', 1, '14日工作1', '', '', '', 1565751000, 1565751871);
INSERT INTO `task` VALUES (2, '2019-08-13', 1, '13日工作1222', '', '', '', 1565751016, 1565751912);
INSERT INTO `task` VALUES (3, '2019-08-12', 1, '12日工作1', '', '', '', 1565751880, 1565751880);
INSERT INTO `task` VALUES (6, '2019-08-13', 190, '51-', '61-', '85-', '5-', 1565834696, 1565946236);
INSERT INTO `task` VALUES (7, '2019-08-16', 190, 'test1', '', '', '', 1565945086, 1565945767);
INSERT INTO `task` VALUES (9, '2019-09-12', 190, '任务上报', '消息中心', '', '', 1568268929, 1568269106);
INSERT INTO `task` VALUES (10, '2019-09-16', 190, 'task: 0916每日任务内容0916每日任务内容0916每日任务内容0916每日任务内容0916每日任务内容0916每日任务内容0916每日任务内容', 'next_task: 0917预计每日任务内容0917预计每日任务内容0917预计每日任务内容0917预计每日任务内容0917预计每日任务内容0917预计每日任务内容', 'issues: 0916没有什么意思0916没有什么意思0916没有什么意思0916没有什么意思0916没有什么意思', 'mark: 0916没有备注0916没有备注0916没有备注0916没有备注0916没有备注0916没有备注0916没有备注', 1568619699, 1568619699);

-- ----------------------------
-- Table structure for task_reader
-- ----------------------------
DROP TABLE IF EXISTS `task_reader`;
CREATE TABLE `task_reader`  (
  `task_id` int(11) UNSIGNED NOT NULL COMMENT '任务ID',
  `user_id` int(11) UNSIGNED NOT NULL COMMENT '用户ID',
  `created_at` int(11) UNSIGNED NOT NULL COMMENT '标记时间',
  UNIQUE INDEX `taskId_userId_unique`(`task_id`, `user_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '日报标记阅读' ROW_FORMAT = Fixed;

-- ----------------------------
-- Table structure for task_reply
-- ----------------------------
DROP TABLE IF EXISTS `task_reply`;
CREATE TABLE `task_reply`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0 COMMENT '上一条ID',
  `task_id` int(11) UNSIGNED NOT NULL COMMENT '任务ID',
  `user_id` int(11) UNSIGNED NOT NULL COMMENT '人员ID',
  `to_user_id` int(11) UNSIGNED NOT NULL COMMENT '接收人员ID',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '回复内容',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '状态',
  `created_at` int(11) UNSIGNED NOT NULL COMMENT '回复时间',
  `updated_at` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '日报回复' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of task_reply
-- ----------------------------
INSERT INTO `task_reply` VALUES (1, 0, 9, 190, 190, 'kwkwkw', 1, 12, 1568708730);
INSERT INTO `task_reply` VALUES (2, 1, 9, 190, 190, 'ddddddd', 1, 43232, 1568708741);
INSERT INTO `task_reply` VALUES (3, 0, 9, 190, 190, 'qwerqwerwr', 0, 123131, 123);
INSERT INTO `task_reply` VALUES (4, 2, 9, 190, 190, '4444444', 0, 5555, NULL);
INSERT INTO `task_reply` VALUES (5, 1, 9, 190, 190, '5555555', 0, 66666, NULL);

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '名称',
  `partment_id` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '部门ID',
  `skill_type` tinyint(2) NULL DEFAULT NULL COMMENT '技术类别',
  `job` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '职务',
  `job_level` tinyint(2) NULL DEFAULT NULL COMMENT '职级',
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户名',
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '密码',
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '邮箱',
  `phone` char(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '电话',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  `joined_at` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '入职时间',
  `leaved_at` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '离职时间',
  `created_at` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '更新时间',
  `is_core` tinyint(1) NULL DEFAULT 0 COMMENT '是否为核心人员',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 249 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '职员' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (3, '段丽娜', 0, 0, '财务主管', 4, '', '', '2853697693@qq.com', '13718439385', 1, 1421251200, 0, 0, 1567663718, 0);
INSERT INTO `user` VALUES (4, '高鹭', 2, 2, '美术中心经理', 4, 'gaolu', '$2y$10$k291bOqQH/wLbG9ftfHf7eKf7ojjgby4EUqTL8Wqmlyk1DnZmF0yG', '2853697688@qq.com', '13554847357', 1, 1561713803, NULL, 1561713803, 1561713803, 0);
INSERT INTO `user` VALUES (21, '叶青', 4, 2, '角色原画', 2, 'yeqing', '$2y$10$k291bOqQH/wLbG9ftfHf7eKf7ojjgby4EUqTL8Wqmlyk1DnZmF0yG', '3003513796@qq.com', NULL, 1, 1561713803, NULL, 1561713803, 1561713803, 0);
INSERT INTO `user` VALUES (23, '李欣蔚', 2, 2, '角色原画', 2, 'lixinwei', '$2y$10$k291bOqQH/wLbG9ftfHf7eKf7ojjgby4EUqTL8Wqmlyk1DnZmF0yG', '2853081673@qq.com', '15096663381', 1, 1561713803, NULL, 1561713803, 1561713803, 0);
INSERT INTO `user` VALUES (29, '吴明辉', 4, 2, '主美', 3, 'wuminghui', '$2y$10$k291bOqQH/wLbG9ftfHf7eKf7ojjgby4EUqTL8Wqmlyk1DnZmF0yG', '2853697685@qq.com', '15814466671', 1, 1561713803, NULL, 1561713803, 1561713803, 0);
INSERT INTO `user` VALUES (30, '周雪', 2, 2, 'UI设计师', 2, 'zhouxue', '$2y$10$k291bOqQH/wLbG9ftfHf7eKf7ojjgby4EUqTL8Wqmlyk1DnZmF0yG', '3001548832@qq.com', NULL, 1, 1561713803, NULL, 1561713803, 1561713803, 0);
INSERT INTO `user` VALUES (56, '李霞', 4, 2, 'UI设计师', 2, 'lixia', '$2y$10$k291bOqQH/wLbG9ftfHf7eKf7ojjgby4EUqTL8Wqmlyk1DnZmF0yG', '3002892855@qq.com', '17688902201', 1, 1561713803, NULL, 1561713803, 1561713803, 0);
INSERT INTO `user` VALUES (58, '彭红梅', 2, 2, '3D特效师', 2, 'penghongmei', '$2y$10$k291bOqQH/wLbG9ftfHf7eKf7ojjgby4EUqTL8Wqmlyk1DnZmF0yG', '2885726942@qq.com', '13027992609', 1, 1561713803, NULL, 1561713803, 1561713803, 0);
INSERT INTO `user` VALUES (65, '戴晨露', 4, 1, '客户端主程', 4, 'daichenlu', '$2y$10$k291bOqQH/wLbG9ftfHf7eKf7ojjgby4EUqTL8Wqmlyk1DnZmF0yG', '3003022098@qq.com', '18030011153', 1, 1561713803, NULL, 1561713803, 1561713803, 0);
INSERT INTO `user` VALUES (81, '刘惟樵', 3, 1, '服务器主程', 4, 'liuweiqiao', '$2y$10$k291bOqQH/wLbG9ftfHf7eKf7ojjgby4EUqTL8Wqmlyk1DnZmF0yG', '2853697702@qq.com', '13823526686', 1, 1561651200, NULL, 1561713803, 1564641856, 0);
INSERT INTO `user` VALUES (108, '应俊', 3, NULL, '产品负责人', NULL, 'yingjun', '$2y$10$k291bOqQH/wLbG9ftfHf7eKf7ojjgby4EUqTL8Wqmlyk1DnZmF0yG', '3002868258@qq.com', '13133603983', 1, 1561713803, NULL, 1561713803, 1561713803, 0);
INSERT INTO `user` VALUES (118, '彭鑫', 2, 2, '美术中心副经理', 4, 'pengxin', '$2y$10$k291bOqQH/wLbG9ftfHf7eKf7ojjgby4EUqTL8Wqmlyk1DnZmF0yG', '3002848269@qq.com', '18677212166', 1, 1561651200, NULL, 1561713803, 1564641899, 0);
INSERT INTO `user` VALUES (120, '曾舒婷', 2, 2, 'UI设计师', 3, 'zengshuting', '$2y$10$k291bOqQH/wLbG9ftfHf7eKf7ojjgby4EUqTL8Wqmlyk1DnZmF0yG', '3004642035@qq.com', '15813324423', 1, 1561651200, NULL, 1561713803, 1564641881, 0);
INSERT INTO `user` VALUES (121, '李廷亮', 2, 2, '原画师', 2, 'litingliang', '$2y$10$k291bOqQH/wLbG9ftfHf7eKf7ojjgby4EUqTL8Wqmlyk1DnZmF0yG', '2853081675@qq.com', '13827436905', 1, 1561713803, NULL, 1561713803, 1561713803, 0);
INSERT INTO `user` VALUES (122, '何安心', 2, 2, '3d模型师', 2, 'heanxin', '$2y$10$k291bOqQH/wLbG9ftfHf7eKf7ojjgby4EUqTL8Wqmlyk1DnZmF0yG', '2853697697@qq.com', '15112351378', 1, 1561713803, NULL, 1561713803, 1561713803, 0);
INSERT INTO `user` VALUES (123, '丁光云', 2, 2, '动画师', 2, 'dingguangyun', '$2y$10$k291bOqQH/wLbG9ftfHf7eKf7ojjgby4EUqTL8Wqmlyk1DnZmF0yG', '3001560452@qq.com', '13727010184', 1, 1561651200, NULL, 1561713803, 1564641945, 0);
INSERT INTO `user` VALUES (124, '王勇', 2, 2, '美术设计', 2, 'wangyong', '$2y$10$k291bOqQH/wLbG9ftfHf7eKf7ojjgby4EUqTL8Wqmlyk1DnZmF0yG', '2851656959@qq.com', '15622824502', 1, 1561713803, NULL, 1561713803, 1561713803, 0);
INSERT INTO `user` VALUES (127, '周明轩', 2, 2, 'U3D特效师', 2, 'zhoumingxuan', '$2y$10$k291bOqQH/wLbG9ftfHf7eKf7ojjgby4EUqTL8Wqmlyk1DnZmF0yG', '3004638011@qq.com', '18681180060', 1, 1561651200, NULL, 1561713803, 1564641928, 0);
INSERT INTO `user` VALUES (129, '林明言', 2, 2, 'UI设计师', 2, 'lingmingyan', '$2y$10$k291bOqQH/wLbG9ftfHf7eKf7ojjgby4EUqTL8Wqmlyk1DnZmF0yG', '2853697689@qq.com', '15013459696', 1, 1561713803, NULL, 1561713803, 1561713803, 0);
INSERT INTO `user` VALUES (143, '吕阳阳', 4, 1, '服务器程序', 4, 'lvyangyang', '$2y$10$k291bOqQH/wLbG9ftfHf7eKf7ojjgby4EUqTL8Wqmlyk1DnZmF0yG', '2853081688@qq.com', '13086264002', 1, 1561713803, NULL, 1561713803, 1561713803, 0);
INSERT INTO `user` VALUES (157, '王乐', 1, NULL, '高级项目助理', NULL, 'wangle', '$2y$10$k291bOqQH/wLbG9ftfHf7eKf7ojjgby4EUqTL8Wqmlyk1DnZmF0yG', '3002831416@qq.com', '15919724962', 1, 1561713803, NULL, 1561713803, 1561713803, 0);
INSERT INTO `user` VALUES (158, '郝作阳', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0);
INSERT INTO `user` VALUES (159, '武迅', 1, NULL, '技术部经理', NULL, 'wuxun', '$2y$10$k291bOqQH/wLbG9ftfHf7eKf7ojjgby4EUqTL8Wqmlyk1DnZmF0yG', '3002471609@qq.com', '18665872603', 1, 1561713803, NULL, 1561713803, 1561713803, 0);
INSERT INTO `user` VALUES (162, '肖山山', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0);
INSERT INTO `user` VALUES (166, '汪三', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0);
INSERT INTO `user` VALUES (168, '王腾', 3, 3, '策划', 2, 'wangteng', '$2y$10$k291bOqQH/wLbG9ftfHf7eKf7ojjgby4EUqTL8Wqmlyk1DnZmF0yG', '2853081681@qq.com', '18908031086', 1, 1561651200, NULL, 1561713803, 1564641561, 0);
INSERT INTO `user` VALUES (170, '胡江飞', 3, 1, '微信小程序工程师', 1, 'hujiangfei', '$2y$10$k291bOqQH/wLbG9ftfHf7eKf7ojjgby4EUqTL8Wqmlyk1DnZmF0yG', '2853697684@qq.com', '18833102737', 1, 1561713803, NULL, 1561713803, 1561713803, 0);
INSERT INTO `user` VALUES (171, '张宇翔', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0);
INSERT INTO `user` VALUES (177, '李先生', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0);
INSERT INTO `user` VALUES (184, '陈子佳', 4, 1, '客户端主程', 3, 'chenzijia', '$2y$10$k291bOqQH/wLbG9ftfHf7eKf7ojjgby4EUqTL8Wqmlyk1DnZmF0yG', '3003512800@qq.com', '15220163160', 1, 1561713803, NULL, 1561713803, 1561713803, 0);
INSERT INTO `user` VALUES (188, '唐磊', 4, 1, '客户端高级程序', 3, 'tanglei', '$2y$10$k291bOqQH/wLbG9ftfHf7eKf7ojjgby4EUqTL8Wqmlyk1DnZmF0yG', '3003573373@qq.com', '13710240616', 1, 1561651200, NULL, 1561713803, 1564641841, 0);
INSERT INTO `user` VALUES (190, '罗仕辉', 1, 1, 'php主程', 4, 'luoshihui', '$2y$10$m/FqTT3y9VzPRtJlmaxMVulPOZrf.BGl4P8GoTQ3Z87MZjyYWzUcu', '2853697690@qq.com', '17723503685', 1, 1525622400, 0, 1561713803, 1567663760, 0);
INSERT INTO `user` VALUES (191, '陈鹏', 3, 1, 'U3D客户端主程', 4, 'chenpeng', '$2y$10$k291bOqQH/wLbG9ftfHf7eKf7ojjgby4EUqTL8Wqmlyk1DnZmF0yG', '3004620018@qq.com', '13015926262', 1, 1561651200, NULL, 1561713803, 1564641587, 0);
INSERT INTO `user` VALUES (194, '石皓云', 4, NULL, '制作人', NULL, 'shihaoyun', '$2y$10$k291bOqQH/wLbG9ftfHf7eKf7ojjgby4EUqTL8Wqmlyk1DnZmF0yG', '2853081680@qq.com', '18576461356', 1, 1561713803, NULL, 1561713803, 1561713803, 0);
INSERT INTO `user` VALUES (198, '蔡晓忠', 4, 1, '服务器高程', 3, 'caixiaozhong', '$2y$10$k291bOqQH/wLbG9ftfHf7eKf7ojjgby4EUqTL8Wqmlyk1DnZmF0yG', '3003466155@qq.com', '13544246806', 1, 1561713803, NULL, 1561713803, 1561713803, 0);
INSERT INTO `user` VALUES (201, '黄城', 3, 1, '服务器高程', 3, 'huangcheng', '$2y$10$k291bOqQH/wLbG9ftfHf7eKf7ojjgby4EUqTL8Wqmlyk1DnZmF0yG', '3002837638@qq.com', '15994770100', 1, 1561713803, NULL, 1561713803, 1561713803, 0);
INSERT INTO `user` VALUES (202, '孙滇', 4, 1, 'H5开发', 2, 'sundian', '$2y$10$k291bOqQH/wLbG9ftfHf7eKf7ojjgby4EUqTL8Wqmlyk1DnZmF0yG', '2853697701@qq.com', '18994649589', 1, 1561713803, NULL, 1561713803, 1561713803, 0);
INSERT INTO `user` VALUES (203, '陈灿', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0);
INSERT INTO `user` VALUES (206, '邓保华', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0);
INSERT INTO `user` VALUES (208, '邓仲国', 3, 3, '产品策划', 3, 'dengzhongguo', '$2y$10$k291bOqQH/wLbG9ftfHf7eKf7ojjgby4EUqTL8Wqmlyk1DnZmF0yG', '3002811895@qq.com', NULL, 1, 1561713803, NULL, 1561713803, 1561713803, 0);
INSERT INTO `user` VALUES (211, '马捷', 4, 3, '关卡策划', 2, 'majie', '$2y$10$k291bOqQH/wLbG9ftfHf7eKf7ojjgby4EUqTL8Wqmlyk1DnZmF0yG', '3001485109@qq.com', '13590149071', 1, 1561713803, NULL, 1561713803, 1561713803, 0);
INSERT INTO `user` VALUES (212, '许振宁', 1, NULL, '项目经理', NULL, 'xuzhenning', '$2y$10$k291bOqQH/wLbG9ftfHf7eKf7ojjgby4EUqTL8Wqmlyk1DnZmF0yG', '2853081672@qq.com', '13691604358', 1, 1561651200, NULL, 1561713803, 1565848926, 0);
INSERT INTO `user` VALUES (216, '王梓安', 3, 3, '主策划', 4, 'wangzian', '$2y$10$k291bOqQH/wLbG9ftfHf7eKf7ojjgby4EUqTL8Wqmlyk1DnZmF0yG', '2853081684@qq.com', '15013704191', 1, 1561713803, NULL, 1561713803, 1561713803, 0);
INSERT INTO `user` VALUES (224, '甘冬妮', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0);
INSERT INTO `user` VALUES (229, '李文剑', 3, 1, 'H5客户端', 2, 'liwenjian', '$2y$10$k291bOqQH/wLbG9ftfHf7eKf7ojjgby4EUqTL8Wqmlyk1DnZmF0yG', '3003523830@qq.com', NULL, 1, 1561713803, NULL, 1561713803, 1561713803, 0);
INSERT INTO `user` VALUES (236, '王岐岩', 1, NULL, '产品总监', NULL, 'wangqiyan', '$2y$10$k291bOqQH/wLbG9ftfHf7eKf7ojjgby4EUqTL8Wqmlyk1DnZmF0yG', '3002851828@qq.com', '18565052617', 1, 1561713803, NULL, 1561713803, 1561713803, 0);
INSERT INTO `user` VALUES (238, '郭雅欣', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0);
INSERT INTO `user` VALUES (239, '赵喆', 2, 2, '3D动画师', 2, 'zhaozhe', '$2y$10$k291bOqQH/wLbG9ftfHf7eKf7ojjgby4EUqTL8Wqmlyk1DnZmF0yG', '2885726948@qq.com', '13810591411', 1, 1561713803, NULL, 1561713803, 1561713803, 0);
INSERT INTO `user` VALUES (241, '张翼', 1, 3, '文案策划', NULL, 'zhangyi', '$2y$10$k291bOqQH/wLbG9ftfHf7eKf7ojjgby4EUqTL8Wqmlyk1DnZmF0yG', '3004641729@qq.com', '13751078839', 1, 1561713803, NULL, 1561713803, 1561713803, 0);
INSERT INTO `user` VALUES (242, '杨青', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0);
INSERT INTO `user` VALUES (245, '龙湘妍', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0);
INSERT INTO `user` VALUES (246, '冯伟浩', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0);
INSERT INTO `user` VALUES (247, '程振家', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0);
INSERT INTO `user` VALUES (248, '游平', 3, 1, 'H5主程', 4, 'youping', '$2y$10$L4QeFf9QeH29EG7YT/HCtelF/N2O3k/bh1PPhEFvAiV6/YqFtkAr.', '2853081685@qq.com', '13434248318', 1, 1563984000, NULL, 1564647795, 1564647795, 0);

-- ----------------------------
-- Table structure for user_login
-- ----------------------------
DROP TABLE IF EXISTS `user_login`;
CREATE TABLE `user_login`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '登录令牌',
  `access_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'kpi平台令牌',
  `login_at` int(11) UNSIGNED NOT NULL COMMENT '登录时间',
  `access_at` int(11) UNSIGNED NOT NULL COMMENT '最后操作时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 23 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户登录' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_login
-- ----------------------------
INSERT INTO `user_login` VALUES (1, 190, 'e9feda6b9ed917c263cf04b3f8ec4a41', '', 1567737753, 1567738679);
INSERT INTO `user_login` VALUES (2, 190, '0bfc5e738231788092c345a25f999846', '', 1567739727, 1567740867);
INSERT INTO `user_login` VALUES (3, 190, 'e73ce18e7ec31f816177ef7135967b21', '', 1567741594, 1567751756);
INSERT INTO `user_login` VALUES (4, 190, '12b4a11e9c19c084134da4c299547583', NULL, 1567753160, 1567753160);
INSERT INTO `user_login` VALUES (5, 190, '76b4b4831d2fc6f02fd169b31251c05e', '', 1567753303, 1567759737);
INSERT INTO `user_login` VALUES (6, 190, '57977d3f068b267b70b5d7a7ffed104a', '', 1567759751, 1567762442);
INSERT INTO `user_login` VALUES (7, 190, '63a1d06ddc5112fca1fd34326ce0d78e', '', 1567762451, 1567763090);
INSERT INTO `user_login` VALUES (8, 190, '705aeb4b6bb15c25640fc18d342f8219', '', 1567991838, 1567991843);
INSERT INTO `user_login` VALUES (9, 190, '7ff5e71459d32309cbedc7f9724f683e', NULL, 1568084443, 1568084443);
INSERT INTO `user_login` VALUES (10, 190, '2bdc0babedfe57713189e2e196cbcd19', NULL, 1568085517, 1568085517);
INSERT INTO `user_login` VALUES (11, 190, '5c0a26ba52911a8a4b884b429a5e62ee', '', 1568085573, 1568085580);
INSERT INTO `user_login` VALUES (12, 190, 'd292f2bf0dd6cabf66d5d37d0ac67d42', '', 1568085627, 1568086080);
INSERT INTO `user_login` VALUES (13, 190, 'ab4b37ea9928e77fe5481aad29410054', '', 1568094618, 1568109726);
INSERT INTO `user_login` VALUES (14, 190, 'e8021c2eac47ca889b17214e4d52c697', '', 1568164077, 1568172555);
INSERT INTO `user_login` VALUES (15, 190, 'b80b68a1cc6b6744875ad26882c76050', '', 1568182668, 1568194864);
INSERT INTO `user_login` VALUES (16, 190, 'd65f7895a7ea4b6c0ec997e324e90fb6', NULL, 1568252456, 1568252456);
INSERT INTO `user_login` VALUES (17, 190, '94c16b607e853502e7728af51238bc38', '', 1568252549, 1568260118);
INSERT INTO `user_login` VALUES (18, 190, '64e47968e779179b10edd0c856eae8d0', '', 1568268871, 1568281995);
INSERT INTO `user_login` VALUES (19, 190, 'ef25409375ac4dd274808d92032f37b6', '', 1568595758, 1568596507);
INSERT INTO `user_login` VALUES (20, 190, '31f774e3d42484f16f47f12d6279a673', '', 1568597914, 1568623588);
INSERT INTO `user_login` VALUES (21, 190, 'fd2ce690979846cf495260d968cb474e', '', 1568686699, 1568692381);
INSERT INTO `user_login` VALUES (22, 190, '86943fb726250ca03f7781bdfd56b5a3', '', 1568699949, 1568714419);

-- ----------------------------
-- Table structure for user_role
-- ----------------------------
DROP TABLE IF EXISTS `user_role`;
CREATE TABLE `user_role`  (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  UNIQUE INDEX `userId_roleId_unique`(`user_id`, `role_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '职员角色' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_role
-- ----------------------------
INSERT INTO `user_role` VALUES (190, 1);
INSERT INTO `user_role` VALUES (212, 2);

SET FOREIGN_KEY_CHECKS = 1;
