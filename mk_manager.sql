/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 50725
 Source Host           : localhost:3306
 Source Schema         : mk_manager

 Target Server Type    : MySQL
 Target Server Version : 50725
 File Encoding         : 65001

 Date: 12/02/2019 01:13:29
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for general_statuses
-- ----------------------------
DROP TABLE IF EXISTS `general_statuses`;
CREATE TABLE `general_statuses`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID única de cada registro',
  `name` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Nome do status',
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NOT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of general_statuses
-- ----------------------------
INSERT INTO `general_statuses` VALUES (1, 'Ativo', NULL, '2019-01-30 00:56:12', NULL);
INSERT INTO `general_statuses` VALUES (2, 'Inativo', NULL, '2019-01-30 00:56:12', NULL);

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (3, '2016_06_01_000001_create_oauth_auth_codes_table', 1);
INSERT INTO `migrations` VALUES (4, '2016_06_01_000002_create_oauth_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1);
INSERT INTO `migrations` VALUES (6, '2016_06_01_000004_create_oauth_clients_table', 1);
INSERT INTO `migrations` VALUES (7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1);

-- ----------------------------
-- Table structure for oauth_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `oauth_access_tokens`;
CREATE TABLE `oauth_access_tokens`  (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NULL DEFAULT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `scopes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `expires_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `oauth_access_tokens_user_id_index`(`user_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of oauth_access_tokens
-- ----------------------------
INSERT INTO `oauth_access_tokens` VALUES ('7488d9aa5002d3e4cd8a742e34f88268916562766d4d374a2c207b6cd234b97a9dcd75392c8084cb', 2, 1, 'Personal Access Token', '[]', 1, '2019-01-19 04:01:04', '2019-01-19 04:01:04', '2020-01-19 04:01:04');
INSERT INTO `oauth_access_tokens` VALUES ('79753ce2279e81d6ad814e44c6daf6a786e66c424d31e810cde4b53c5e541af5a2bbfb89ca8ee15b', 2, 1, 'Personal Access Token', '[]', 0, '2019-01-19 04:00:49', '2019-01-19 04:00:49', '2020-01-19 04:00:49');
INSERT INTO `oauth_access_tokens` VALUES ('eebdc1f186f39195d8ace8171fec2dc6660886fdc7a3178494fcdbcb9a1703065f24c0725b95c827', 2, 1, 'Personal Access Token', '[]', 0, '2019-01-19 04:05:12', '2019-01-19 04:05:12', '2020-01-19 04:05:12');

-- ----------------------------
-- Table structure for oauth_auth_codes
-- ----------------------------
DROP TABLE IF EXISTS `oauth_auth_codes`;
CREATE TABLE `oauth_auth_codes`  (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `scopes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for oauth_clients
-- ----------------------------
DROP TABLE IF EXISTS `oauth_clients`;
CREATE TABLE `oauth_clients`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `oauth_clients_user_id_index`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of oauth_clients
-- ----------------------------
INSERT INTO `oauth_clients` VALUES (1, NULL, 'Laravel Personal Access Client', '9yITPOK3buDAX6Oz9cZWtLUG0cbLVEB6tHQNWRiA', 'http://localhost', 1, 0, 0, '2019-01-19 02:20:19', '2019-01-19 02:20:19');
INSERT INTO `oauth_clients` VALUES (2, NULL, 'Laravel Password Grant Client', '3sZgjqLBt4XCdQtfc8OQwMsPv13f2M7GLezdroZY', 'http://localhost', 0, 1, 0, '2019-01-19 02:20:19', '2019-01-19 02:20:19');

-- ----------------------------
-- Table structure for oauth_personal_access_clients
-- ----------------------------
DROP TABLE IF EXISTS `oauth_personal_access_clients`;
CREATE TABLE `oauth_personal_access_clients`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `oauth_personal_access_clients_client_id_index`(`client_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of oauth_personal_access_clients
-- ----------------------------
INSERT INTO `oauth_personal_access_clients` VALUES (1, 1, '2019-01-19 02:20:19', '2019-01-19 02:20:19');

-- ----------------------------
-- Table structure for oauth_refresh_tokens
-- ----------------------------
DROP TABLE IF EXISTS `oauth_refresh_tokens`;
CREATE TABLE `oauth_refresh_tokens`  (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `oauth_refresh_tokens_access_token_id_index`(`access_token_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  INDEX `password_resets_email_index`(`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for plans
-- ----------------------------
DROP TABLE IF EXISTS `plans`;
CREATE TABLE `plans`  (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID única',
  `id_hotspot` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ID do perfil no hotspot',
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ID do produto relacionado',
  `price` decimal(10, 2) NOT NULL DEFAULT 999.99 COMMENT 'ID do distribuidor',
  `shared_users` int(5) NOT NULL DEFAULT 1 COMMENT '1 - Está vendendo esse produto hoje; 0 - Não está vendendo hoje',
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `created_at` datetime(0) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'Planos disponíveis' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of plans
-- ----------------------------
INSERT INTO `plans` VALUES (1, '*0', 'default', 999.99, 10, '2019-01-31 03:44:05', '2019-01-31 03:44:05');
INSERT INTO `plans` VALUES (2, '*1', 'Plano1', 999.99, 1, '2019-01-31 03:44:05', '2019-01-31 03:44:05');
INSERT INTO `plans` VALUES (3, '*2', 'Plano2', 999.99, 5, '2019-01-31 03:44:05', '2019-01-31 03:44:05');
INSERT INTO `plans` VALUES (4, '*3', 'Plano4', 999.99, 20, '2019-01-31 03:44:05', '2019-01-31 03:44:05');
INSERT INTO `plans` VALUES (5, '*4', 'Plano3', 999.99, 10, '2019-01-31 03:44:05', '2019-01-31 03:44:05');

-- ----------------------------
-- Table structure for product_types
-- ----------------------------
DROP TABLE IF EXISTS `product_types`;
CREATE TABLE `product_types`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID única',
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Nome do tipo do produto',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'Cada registro dessa tabela representa um tipo de produto. Ex.: Água, Gás.' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_types
-- ----------------------------
DROP TABLE IF EXISTS `user_types`;
CREATE TABLE `user_types`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID única',
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Nome do tipo de usuário',
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'Cara registro dessa tabela representa um tipo de usuário.' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_types
-- ----------------------------
INSERT INTO `user_types` VALUES (1, 'Administrador', NULL, NULL, NULL);
INSERT INTO `user_types` VALUES (2, 'Operador', NULL, NULL, NULL);
INSERT INTO `user_types` VALUES (3, 'Membro', NULL, NULL, NULL);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificação única de cada registro.',
  `name` varchar(90) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nome do usuário',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Email do usuário',
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Apelido público, pensado para utilizar nos vouchers de campanhas dos distribuidores.',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Senha de acesso ao sistema',
  `email_verified_at` timestamp(0) NULL DEFAULT NULL,
  `phone` bigint(11) NULL DEFAULT NULL COMMENT 'Telefone secundário',
  `celphone` bigint(11) NULL DEFAULT NULL COMMENT 'Número do celular',
  `cpf_cnpj` bigint(15) NULL DEFAULT NULL COMMENT 'CPF ou CNPJ do usuário',
  `user_type_id` int(2) NULL DEFAULT 1 COMMENT 'Tipo de usuario: 1-Consumidor, 2-Distribuidor, 3-Envasadora',
  `plan_id` int(10) NULL DEFAULT NULL COMMENT 'ID do plano do usuário',
  `last_payment` date NULL DEFAULT NULL COMMENT 'Data do último pagamento efetuado',
  `payment_promise` int(1) NULL DEFAULT 0 COMMENT 'Total de promessas de pagamento da pendência atual',
  `id_hotspot` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'ID do usuário no hotspot',
  `general_status_id` int(11) NOT NULL COMMENT 'ID do status geral referente à situação atual do membro',
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT 'Data de atualização do registro',
  `deleted_at` datetime(0) NULL DEFAULT NULL COMMENT 'Data de desativação do cadastro',
  `created_at` datetime(0) NOT NULL COMMENT 'Data de cadastro',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_user_type_fk`(`user_type_id`) USING BTREE,
  INDEX `user_plan_fk`(`plan_id`) USING BTREE,
  INDEX `users_general_status_fk`(`general_status_id`) USING BTREE,
  CONSTRAINT `users_general_status_fk` FOREIGN KEY (`general_status_id`) REFERENCES `general_statuses` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `users_ibfk_2` FOREIGN KEY (`user_type_id`) REFERENCES `user_types` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 126 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = 'Cada registro representa um usuário do sistema. Seja envasadora, distribuidor ou consumidor.' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Admin', 'admin@mail.com', NULL, '$2y$10$3li2ISWhcDGCBUC6ms2t5OJtEeCz.VhDU9eCozj1wqxi9DAq4GjwK', '2019-01-10 00:10:14', NULL, NULL, NULL, 1, NULL, '2018-12-12', 0, NULL, 1, 'HS8IwUgZm240sOXhEC2LO8bxr32UWYFJesaUYxikZrlV7J8KxhJ5JW6DpE7s', NULL, NULL, '2019-01-17 00:10:21');
INSERT INTO `users` VALUES (2, 'adminjk', 'adminjk@mail.com', 'adminjk', '$2y$10$3li2ISWhcDGCBUC6ms2t5OJtEeCz.VhDU9eCozj1wqxi9DAq4GjwK', NULL, NULL, NULL, NULL, 2, NULL, '2019-01-31', 0, NULL, 1, 'Ae7rP95vGi0jOk0n5mD9GodrmCc2SdY8GYwWebS4L2Mfdlr8j9kKykYpwwtp', '2019-01-31 05:25:02', NULL, '2019-01-31 03:44:06');
INSERT INTO `users` VALUES (3, 'mariano', 'mariano91@login.net', 'mariano', '$2y$10$3VAgcWLbVFZxHIcItUQfqe3pNzzrvpqw8aZ0PrROnE0juaDcrwIzm', NULL, NULL, NULL, NULL, 3, 5, '2019-01-16', 0, '*3', 1, NULL, '2019-01-31 05:25:03', NULL, '2019-01-31 03:44:06');
INSERT INTO `users` VALUES (4, 'drak', 'drak16@login.net', 'drak', '$2y$10$SVyifvwruA.rpPteGuZK.uQUaUqzSOlHYVj60sKefwTkTSlI54n8q', NULL, NULL, NULL, NULL, 3, 5, '2019-01-31', 0, '*4', 2, NULL, '2019-01-31 05:28:04', NULL, '2019-01-31 03:44:06');
INSERT INTO `users` VALUES (5, 'pela', 'pela84@login.net', 'pela', '$2y$10$LKRiNS2dKEff62.L9pAMwOzgQdgT1xhIyGuNJAij3FRXnFbeq8ZPK', NULL, NULL, NULL, NULL, 3, 3, '2019-02-10', 0, '*5', 1, NULL, '2019-01-31 05:25:03', NULL, '2019-01-31 03:44:06');
INSERT INTO `users` VALUES (6, 'leandro', 'leandro48@login.net', 'leandro1', '$2y$10$9zeAZZuerV/IykK5f.WuvOHp0CNiWeQrSBwJ1kZlGvQEuthEhcY.G', NULL, NULL, NULL, NULL, 3, 5, '2018-10-27', 0, '*6', 2, NULL, '2019-01-31 05:25:03', NULL, '2019-01-31 03:44:06');
INSERT INTO `users` VALUES (7, 'pitoco', 'pitoco25@login.net', 'pitoco', '$2y$10$Gxyh9A9MRSciYAmoWdsvju6AcoLmrAi3fKv1Nisqc3ZIHRuSkdn8C', NULL, NULL, NULL, NULL, 3, 3, '2019-01-18', 0, '*7', 1, NULL, '2019-01-31 05:25:03', NULL, '2019-01-31 03:44:06');
INSERT INTO `users` VALUES (8, 'adriana', 'adriana16@login.net', 'adriana', '$2y$10$bpLPRgGdvKrthdoZ1UKvtevoRJGzia8mA7bdbBynMbVKwFyhlX9/u', NULL, NULL, NULL, NULL, 3, 3, '2019-01-02', 0, '*8', 1, NULL, '2019-01-31 05:25:03', NULL, '2019-01-31 03:44:06');
INSERT INTO `users` VALUES (9, 'DDP', 'DDP30@login.net', 'DDP', '$2y$10$Tq7HwtYaaqodHpGepr/5Ue8hM7IBe96jvNwEYuM8Fz1C8RR0CEBY6', NULL, NULL, NULL, NULL, 3, 3, '2019-01-18', 0, '*9', 1, NULL, '2019-01-31 05:25:03', NULL, '2019-01-31 03:44:06');
INSERT INTO `users` VALUES (10, 'lulu', 'lulu56@login.net', 'lulu', '$2y$10$ZLuz20rcHKumnS8T5jquL.CKbBBTv3f4DEVjxVPDXPC5MifFTZiZO', NULL, NULL, NULL, NULL, 3, 3, '2019-01-02', 1, '*A', 1, NULL, '2019-01-31 05:25:03', NULL, '2019-01-31 03:44:06');
INSERT INTO `users` VALUES (11, 'HW', 'HW27@login.net', 'HW', '$2y$10$lI1y.txb3Re5whcTs169LOY8OIfrJlfPmOB6HtyBrdx9Iv3Pm/1Di', NULL, NULL, NULL, NULL, 3, 3, '2019-01-15', 0, '*B', 1, NULL, '2019-01-31 05:25:03', NULL, '2019-01-31 03:44:06');
INSERT INTO `users` VALUES (12, 'Amanda', 'Amanda70@login.net', 'Amanda', '$2y$10$KWy1s2P7UndJeoXpflbB6O.tmkM/XB3FW0y4pxt91IRnCznms0jAC', NULL, NULL, NULL, NULL, 3, 3, '2018-12-24', 2, '*C', 2, NULL, '2019-01-31 05:25:03', NULL, '2019-01-31 03:44:06');
INSERT INTO `users` VALUES (13, 'familiadiniz', 'familiadiniz30@login.net', 'familiadiniz', '$2y$10$W040EQDsPRefJx5hendFr.yWHBIDGGNmpLvjLKeLq8EkEmlBcrKMW', NULL, NULL, NULL, NULL, 3, 3, '2019-01-07', 0, '*D', 1, NULL, '2019-01-31 05:25:03', NULL, '2019-01-31 03:44:06');
INSERT INTO `users` VALUES (14, 'Verdao', 'Verdao65@login.net', 'Verdao', '$2y$10$zM1qYlgX87u.g/q0aRstae8Ka2z81AItO1f7MO/1YV/Y784C60dQ6', NULL, NULL, NULL, NULL, 3, 5, '2019-01-16', 0, '*E', 1, NULL, '2019-01-31 05:25:03', NULL, '2019-01-31 03:44:07');
INSERT INTO `users` VALUES (15, 'costasilva', 'costasilva97@login.net', 'costasilva', '$2y$10$7F91jHIbjfHeERg3j7V7le85auR4X2zV.Wc4cYOuVS.P/T1i14h7.', NULL, NULL, NULL, NULL, 3, 2, '2019-01-16', 0, '*10', 1, NULL, '2019-01-31 05:25:03', NULL, '2019-01-31 03:44:07');
INSERT INTO `users` VALUES (16, 'anthonnyvictor', 'anthonnyvictor55@login.net', 'anthonnyvictor', '$2y$10$zrahTjd4.a.ob1RQ9duEHOKvydsr9QibItJ7TxpCUwOYlZ82THWYO', NULL, NULL, NULL, NULL, 3, 2, '2019-01-07', 0, '*12', 1, NULL, '2019-01-31 05:25:03', NULL, '2019-01-31 03:44:07');
INSERT INTO `users` VALUES (17, 'keylapenha', 'keylapenha31@login.net', 'keylapenha', '$2y$10$jvOgz0DXXQBgoEkSfmGEg.nncwgUdPWMGLawKdWBR8hxSKuAegOA2', NULL, NULL, NULL, NULL, 3, 3, '2019-01-18', 0, '*13', 1, NULL, '2019-01-31 05:25:03', NULL, '2019-01-31 03:44:07');
INSERT INTO `users` VALUES (18, 'luzia', 'luzia66@login.net', 'luzia', '$2y$10$daWL7xTUpCvcLfZYc7M/meMeo7x1.ZKhTed.VlQ1ErNGygJuoIvWm', NULL, NULL, NULL, NULL, 3, 3, '2019-01-07', 0, '*14', 1, NULL, '2019-01-31 05:25:03', NULL, '2019-01-31 03:44:07');
INSERT INTO `users` VALUES (19, 'mateus', 'mateus84@login.net', 'mateus', '$2y$10$L7D.uO.0QES0C5ue7XO4cu89EB3VPVfK.GNccbqd8GU3irKyT6Dby', NULL, NULL, NULL, NULL, 3, 3, '2019-01-25', 0, '*15', 1, NULL, '2019-01-31 05:25:04', NULL, '2019-01-31 03:44:07');
INSERT INTO `users` VALUES (20, 'joziete.costa', 'joziete.costa17@login.net', 'joziete.costa', '$2y$10$PxMNGu.GmlmlsaNB9ER6N.qmxiP02ipwJSQWQhm0n2.9575Ezsjpq', NULL, NULL, NULL, NULL, 3, 3, '2019-01-31', 0, '*17', 1, NULL, '2019-01-31 05:25:04', NULL, '2019-01-31 03:44:07');
INSERT INTO `users` VALUES (21, 'Andrealves', 'Andrealves42@login.net', 'Andrealves', '$2y$10$WZ3l3xwzK4FcBRGgejdc2.n/5rOHVPSZcJ4jrcCYIDmfrCzqgMvMu', NULL, NULL, NULL, NULL, 3, 3, '2019-01-08', 0, '*18', 1, NULL, '2019-01-31 05:25:04', NULL, '2019-01-31 03:44:07');
INSERT INTO `users` VALUES (22, 'dudu', 'dudu61@login.net', 'dudu', '$2y$10$3ykOl5CwX1TrHLEWEcES0.x27hy2Sudbck7LHB6MECOiMmDSbu4ou', NULL, NULL, NULL, NULL, 3, 2, '2017-07-25', 0, '*19', 2, NULL, '2019-01-31 05:25:04', NULL, '2019-01-31 03:44:07');
INSERT INTO `users` VALUES (23, 'edna', 'edna76@login.net', 'edna', '$2y$10$2bkT4IEOgvKIlPKQx4aBqOu6vu33uaG.qkICvXtkyEaT7dgvrxk1y', NULL, NULL, NULL, NULL, 3, 2, '2019-01-15', 0, '*1A', 1, NULL, '2019-01-31 05:25:04', NULL, '2019-01-31 03:44:07');
INSERT INTO `users` VALUES (24, 'Manchaverde', 'Manchaverde80@login.net', 'Manchaverde', '$2y$10$2/dCWhkaP7MRVozs.beFnO.OJs0LVryQuRdUPEZStzCkHzrXIXQOu', NULL, NULL, NULL, NULL, 3, 3, '2019-01-13', 0, '*1B', 1, NULL, '2019-01-31 05:25:04', NULL, '2019-01-31 03:44:07');
INSERT INTO `users` VALUES (25, 'rosa', 'rosa16@login.net', 'rosa', '$2y$10$Fq9cTCwhjgAuu2gwrON9G.7m8mlOPcyFueusDweV5jjJHCubLlIOG', NULL, NULL, NULL, NULL, 3, 2, '2019-01-28', 0, '*1C', 1, NULL, '2019-01-31 05:25:04', NULL, '2019-01-31 03:44:07');
INSERT INTO `users` VALUES (26, 'rodrigo', 'rodrigo83@login.net', 'rodrigo', '$2y$10$6fcorknrMEymEgqXexin6.BAMToxau76Soyj3kPHq/hAHS4xZrc2m', NULL, NULL, NULL, NULL, 3, 2, '2019-01-28', 0, '*1D', 1, NULL, '2019-01-31 05:25:04', NULL, '2019-01-31 03:44:07');
INSERT INTO `users` VALUES (27, 'cleyson', 'cleyson24@login.net', 'cleyson', '$2y$10$1R04TNXGIqn9F2/k0YGWW.1JYD7dEym6/IoE8zTYsL24edCjlsnMG', NULL, NULL, NULL, NULL, 3, 2, '2019-01-10', 0, '*1E', 1, NULL, '2019-01-31 05:25:04', NULL, '2019-01-31 03:44:07');
INSERT INTO `users` VALUES (28, 'fernando', 'fernando74@login.net', 'fernando', '$2y$10$pOr4v/BYVq6VMSuJ.aykJuI9WYtSUNJwK0bPxCaQ9WSmvrNVlH4uy', NULL, NULL, NULL, NULL, 3, 2, '2019-01-12', 0, '*1F', 1, NULL, '2019-01-31 05:25:04', NULL, '2019-01-31 03:44:07');
INSERT INTO `users` VALUES (29, 'edvan', 'edvan20@login.net', 'edvan', '$2y$10$iWVngQ0TIvM42a8jNtwOIutR3K5jhwTRmHKhzgHvAbL9heb06AOXq', NULL, NULL, NULL, NULL, 3, 2, '2019-01-18', 0, '*20', 1, NULL, '2019-01-31 05:25:04', NULL, '2019-01-31 03:44:07');
INSERT INTO `users` VALUES (30, 'myrelle', 'myrelle78@login.net', 'myrelle', '$2y$10$6e3lFq.AAr.E64bQM5xaheUZaY0VyySgml8hfenVbeKqRhJkYHm5u', NULL, NULL, NULL, NULL, 3, 2, '2018-11-16', 0, '*21', 2, NULL, '2019-01-31 05:25:04', NULL, '2019-01-31 03:44:07');
INSERT INTO `users` VALUES (31, 'livramento', 'livramento47@login.net', 'livramento', '$2y$10$SvQl.Gn5r0rIzZSVhWSkxuNb7heXGCD.p1d85utFYvEEliDR9svWO', NULL, NULL, NULL, NULL, 3, 2, '2019-03-06', 0, '*22', 1, NULL, '2019-01-31 05:25:04', NULL, '2019-01-31 03:44:08');
INSERT INTO `users` VALUES (32, 'douglas', 'douglas45@login.net', 'douglas', '$2y$10$C0jdEet5RhH.2N54MZWM6eWbl0QeQt3BO8P.pCAYcui6Vqknweroa', NULL, NULL, NULL, NULL, 3, 2, '2019-01-29', 0, '*23', 1, NULL, '2019-01-31 05:25:04', NULL, '2019-01-31 03:44:08');
INSERT INTO `users` VALUES (33, 'maria', 'maria39@login.net', 'maria', '$2y$10$mm.83jLPtXyGCBA8sciqU.WBtlnDQbbFjF6f6wfx4OnD8w19/6Uu6', NULL, NULL, NULL, NULL, 3, 2, '2018-08-11', 0, '*24', 2, NULL, '2019-01-31 05:25:04', NULL, '2019-01-31 03:44:08');
INSERT INTO `users` VALUES (34, 'Elinaldo', 'Elinaldo10@login.net', 'Elinaldo', '$2y$10$CXH0usb56EiQ9elamH5Po.wi49e2NybAyFR0oNacQR58BljOPzAg2', NULL, NULL, NULL, NULL, 3, 3, '2018-11-24', 0, '*25', 2, NULL, '2019-01-31 05:25:04', NULL, '2019-01-31 03:44:08');
INSERT INTO `users` VALUES (35, 'luney', 'luney70@login.net', 'luney', '$2y$10$in35pnwdE82Ln8hHmxfhYuxLLK.NbjYFZTrkmSHugb/8Iu4Fe7KES', NULL, NULL, NULL, NULL, 3, 3, '2019-01-12', 0, '*26', 1, NULL, '2019-01-31 05:25:04', NULL, '2019-01-31 03:44:08');
INSERT INTO `users` VALUES (36, 'rochedo', 'rochedo92@login.net', 'rochedo', '$2y$10$7WPmNxnE50zj314xIM3f7uhrVE64h0LaaM8vhHAZG5WPUZ9sjKOly', NULL, NULL, NULL, NULL, 3, 5, '2019-01-13', 0, '*27', 1, NULL, '2019-01-31 05:25:05', NULL, '2019-01-31 03:44:08');
INSERT INTO `users` VALUES (37, 'Sabrina', 'Sabrina97@login.net', 'Sabrina', '$2y$10$3IKCKZmQqoXtg1rVwN0mceS48cHRsEWRoKfhemqOudKzIXWyrjO4.', NULL, NULL, NULL, NULL, 3, 3, '2018-10-14', 0, '*28', 2, NULL, '2019-01-31 05:25:05', NULL, '2019-01-31 03:44:08');
INSERT INTO `users` VALUES (38, 'andreluis', 'andreluis76@login.net', 'andreluis', '$2y$10$2P2hZQ876.CB4lVUuh9.N.y4JQtOJjO.3PLPLNQt4v1YF3H2p8uAW', NULL, NULL, NULL, NULL, 3, 3, '2018-12-04', 0, '*29', 2, NULL, '2019-01-31 05:25:05', NULL, '2019-01-31 03:44:08');
INSERT INTO `users` VALUES (39, 'noemiacelia', 'noemiacelia48@login.net', 'noemiacelia', '$2y$10$6.Pl9BlkEpGeQ/GUoJHxhutInFp9oqJt7J8FaO087/EXCMrmEBT7i', NULL, NULL, NULL, NULL, 3, 5, '2019-01-06', 0, '*2A', 1, NULL, '2019-01-31 05:25:05', NULL, '2019-01-31 03:44:08');
INSERT INTO `users` VALUES (40, 'fbsantos', 'fbsantos48@login.net', 'fbsantos', '$2y$10$HgaSP.0FU4kZLIebbbDvz.k/4h4jpHHQvii0ondkvpnUMX2zY4DGu', NULL, NULL, NULL, NULL, 3, 3, '2019-01-18', 0, '*2B', 1, NULL, '2019-01-31 05:25:05', NULL, '2019-01-31 03:44:08');
INSERT INTO `users` VALUES (41, 'analucia', 'analucia31@login.net', 'analucia', '$2y$10$pq2lUehZk3.FAwJYJxjkTeFeoQoC7lDlSjOI5b/yrToENrVwfheKC', NULL, NULL, NULL, NULL, 3, 3, '2019-01-26', 0, '*2C', 1, NULL, '2019-01-31 05:25:05', NULL, '2019-01-31 03:44:08');
INSERT INTO `users` VALUES (42, 'edinaldo', 'edinaldo61@login.net', 'edinaldo', '$2y$10$kH2tNVjSmxQqrXJsZMBeCuB1vTvHry7KVisQ8AoDlyB/b4rhd6xUG', NULL, NULL, NULL, NULL, 3, 2, '2019-01-11', 0, '*2D', 1, NULL, '2019-01-31 05:25:05', NULL, '2019-01-31 03:44:08');
INSERT INTO `users` VALUES (43, 'drolle', 'drolle89@login.net', 'drolle', '$2y$10$nLs8K.YXhylJ.obtw6O6W.U7e.mpMfY39n.xuYBT1ZwfsjRkhI3uy', NULL, NULL, NULL, NULL, 3, 3, '2019-01-14', 0, '*2E', 1, NULL, '2019-01-31 05:25:05', NULL, '2019-01-31 03:44:08');
INSERT INTO `users` VALUES (44, 'caco', 'caco67@login.net', 'caco', '$2y$10$hxsPc4dwm.7NScj8krlIYeW1rKY9FAU/ZTN5e6MP3iSkCizbyIUqW', NULL, NULL, NULL, NULL, 3, 3, '2019-02-17', 0, '*2F', 1, NULL, '2019-01-31 05:25:05', NULL, '2019-01-31 03:44:08');
INSERT INTO `users` VALUES (45, 'Juanvictor', 'Juanvictor33@login.net', 'Juanvictor', '$2y$10$/Nw2sBgKPFq8ypVwJWqMNu53q.LuViCfYVACAP1raAEkAhYT46zO2', NULL, NULL, NULL, NULL, 3, 5, '2019-01-20', 0, '*30', 1, NULL, '2019-01-31 05:25:05', NULL, '2019-01-31 03:44:08');
INSERT INTO `users` VALUES (46, 'reginaldo', 'reginaldo25@login.net', 'reginaldo', '$2y$10$DiavrQsNUKspX6OFsPn9bupJzMF.EGpmSzyuGhmYRV9NcAPxdXYlO', NULL, NULL, NULL, NULL, 3, 5, '2019-01-22', 0, '*31', 1, NULL, '2019-01-31 05:25:05', NULL, '2019-01-31 03:44:08');
INSERT INTO `users` VALUES (47, 'Rayka', 'Rayka74@login.net', 'Rayka', '$2y$10$wSuFgd2ptF2jstns.gXNFOkq0cQrQB7oHFENUVn1kARkTFRIwXDEm', NULL, NULL, NULL, NULL, 3, 3, '2019-01-25', 0, '*32', 1, NULL, '2019-01-31 05:25:05', NULL, '2019-01-31 03:44:08');
INSERT INTO `users` VALUES (48, 'fatima', 'fatima42@login.net', 'fatima', '$2y$10$9L../vVOV8mOLtebd70Ou.reEb41BkYgOAxRQ/d8uEVBpHl2WYVV2', NULL, NULL, NULL, NULL, 3, 5, '2019-01-14', 0, '*35', 1, NULL, '2019-01-31 05:25:05', NULL, '2019-01-31 03:44:08');
INSERT INTO `users` VALUES (49, 'felipe', 'felipe13@login.net', 'felipe', '$2y$10$eJqiSROB.YMM04QkjprglOaONc/GnsNhaNiAlg0HTLaPsmZfPq45i', NULL, NULL, NULL, NULL, 3, 2, '2019-01-31', 0, '*36', 1, NULL, '2019-01-31 05:25:05', NULL, '2019-01-31 03:44:09');
INSERT INTO `users` VALUES (50, 'rosario', 'rosario52@login.net', 'rosario', '$2y$10$/hdAbDjM8f2rFgODDVWM.emJpaBIID6X7OUFwPzTv2LyagHFjb.gW', NULL, NULL, NULL, NULL, 3, 2, '2019-01-06', 0, '*37', 1, NULL, '2019-01-31 05:25:05', NULL, '2019-01-31 03:44:09');
INSERT INTO `users` VALUES (51, 'pllay', 'pllay96@login.net', 'pllay', '$2y$10$4MIXIpNKnJhCb5xy8CeoyOCXw4jbZhc7HMS0OI.L1GGcInUphXSHi', NULL, NULL, NULL, NULL, 3, 2, '2019-01-02', 0, '*38', 1, NULL, '2019-01-31 05:25:05', NULL, '2019-01-31 03:44:09');
INSERT INTO `users` VALUES (52, 'carlos', 'carlos52@login.net', 'carlos', '$2y$10$2Dq42W/imdIYwAkrSRpCtuJgz8Si5kylTRFl9SOGL1p.b4RO1IzgK', NULL, NULL, NULL, NULL, 3, 3, '2019-01-07', 0, '*39', 1, NULL, '2019-01-31 05:25:05', NULL, '2019-01-31 03:44:09');
INSERT INTO `users` VALUES (53, 'matrix', 'matrix76@login.net', 'matrix', '$2y$10$8MFILfx5O7Hshg5UWPSaIurVhLrJNdo9C66vT7BJKpJBYaLICFEii', NULL, NULL, NULL, NULL, 3, 3, '2019-01-08', 0, '*3B', 1, NULL, '2019-01-31 05:25:06', NULL, '2019-01-31 03:44:09');
INSERT INTO `users` VALUES (54, 'deusfiel', 'deusfiel83@login.net', 'deusfiel', '$2y$10$LdEs9SlqQTcBPg4yXVuKnebyKUCQwP8fIvZp7HmTXlY/EW2/rPPo.', NULL, NULL, NULL, NULL, 3, 5, '2018-12-30', 2, '*3C', 2, NULL, '2019-02-01 04:39:48', NULL, '2019-01-31 03:44:09');
INSERT INTO `users` VALUES (55, 'martatei', 'martatei64@login.net', 'martatei', '$2y$10$thKg14zU8GYhoUiIoo1AEObtwpIaSXDYyBuu0abcfa/6JKlOS4IKu', NULL, NULL, NULL, NULL, 3, 5, '2019-01-07', 0, '*3F', 1, NULL, '2019-01-31 05:25:06', NULL, '2019-01-31 03:44:09');
INSERT INTO `users` VALUES (56, 'vascodagama', 'vascodagama76@login.net', 'vascodagama', '$2y$10$7Bd3Lv.Jp.aYh1iWsAI1cuVSU2gHxm4ZfUKmtI8gThippaQIAMAbW', NULL, NULL, NULL, NULL, 3, 3, '2019-01-26', 0, '*40', 1, NULL, '2019-01-31 05:25:06', NULL, '2019-01-31 03:44:09');
INSERT INTO `users` VALUES (57, 'mauro', 'mauro88@login.net', 'mauro', '$2y$10$dSLwebQz9Vv82rSnpR175OZFAp8bj.GBuhwrzXTpdezvMZS/2Goqa', NULL, NULL, NULL, NULL, 3, 2, '2018-11-19', 0, '*41', 2, NULL, '2019-01-31 05:25:06', NULL, '2019-01-31 03:44:09');
INSERT INTO `users` VALUES (58, 'camila', 'camila26@login.net', 'camila', '$2y$10$HEL0ggf75Tl1wr/XH7hvBe3/zdGM9wpii2uUJf4NqzfRhmKmP8Vxa', NULL, NULL, NULL, NULL, 3, 3, '2018-12-30', 0, '*42', 2, NULL, '2019-01-31 05:25:06', NULL, '2019-01-31 03:44:09');
INSERT INTO `users` VALUES (59, 'jotadouglas', 'jotadouglas60@login.net', 'jotadouglas', '$2y$10$X4W4dDVwXibjnsx28wr.9OjUYMo42DZaRVKkdjmNzRNiU/DedM7yO', NULL, NULL, NULL, NULL, 3, 5, '2019-01-02', 0, '*43', 1, NULL, '2019-01-31 05:25:06', NULL, '2019-01-31 03:44:09');
INSERT INTO `users` VALUES (60, 'jouzecarol', 'jouzecarol92@login.net', 'jouzecarol', '$2y$10$2nnhtEWvEsTC45dF.wPEPOeiSBGYUsNejFenM.gdk1PR68QP8Xq0O', NULL, NULL, NULL, NULL, 3, 5, '2019-01-16', 0, '*44', 1, NULL, '2019-01-31 05:25:06', NULL, '2019-01-31 03:44:09');
INSERT INTO `users` VALUES (61, 'anderson', 'anderson18@login.net', 'anderson', '$2y$10$6fJiDm8Bnk/bP86o5WtMueStIZAqbHQ88nq6sz/YGi3w.ELkhgSyi', NULL, NULL, NULL, NULL, 3, 3, '2019-01-26', 0, '*45', 1, NULL, '2019-01-31 05:25:06', NULL, '2019-01-31 03:44:09');
INSERT INTO `users` VALUES (62, 'kaiorocha', 'kaiorocha32@login.net', 'kaiorocha', '$2y$10$X42IyIbafqYIRk6XYBtTnOed.xe4xCrcaRdj3nKuz/6Ju55lNfVBG', NULL, NULL, NULL, NULL, 3, 5, '2018-12-25', 0, '*46', 2, NULL, '2019-01-31 05:25:06', NULL, '2019-01-31 03:44:09');
INSERT INTO `users` VALUES (63, 'cristiano', 'cristiano30@login.net', 'cristiano', '$2y$10$gUogPY8ZhxR2v8eMy0lQqeB4M8aBRMIZC6MJ3Ci0htDqhrrtuGlr.', NULL, NULL, NULL, NULL, 3, 2, '2019-01-07', 0, '*47', 1, NULL, '2019-01-31 05:25:06', NULL, '2019-01-31 03:44:09');
INSERT INTO `users` VALUES (64, 'yarasantos', 'yarasantos74@login.net', 'yarasantos', '$2y$10$PGzbCjAQHYDwIlu6esdcMeo3S/NjsBwCSR9otZ51b71wCGLtHE6Zm', NULL, NULL, NULL, NULL, 3, 2, '2018-04-16', 0, '*48', 2, NULL, '2019-01-31 05:25:06', NULL, '2019-01-31 03:44:09');
INSERT INTO `users` VALUES (65, 'dileuza', 'dileuza27@login.net', 'dileuza', '$2y$10$gh5fS11OoZjKpA3mayeTrOx1aYPS7MQi44s/ZrVfX4R1OfKZ3vVpy', NULL, NULL, NULL, NULL, 3, 3, '2018-12-27', 2, '*49', 1, NULL, '2019-02-01 04:39:42', NULL, '2019-01-31 03:44:09');
INSERT INTO `users` VALUES (66, 'HULK', 'HULK28@login.net', 'HULK', '$2y$10$Ru9PB9pY0cmGNZDwjVIUJeTI9oCHIrWEeAMug2jnLTXozuUsG37ym', NULL, NULL, NULL, NULL, 3, 5, '2018-12-21', 0, '*4A', 1, NULL, '2019-01-31 05:25:06', NULL, '2019-01-31 03:44:10');
INSERT INTO `users` VALUES (67, 'brunno', 'brunno17@login.net', 'brunno', '$2y$10$5gR8MXg5nxa3GoaoqEPY1OPBI3psd1vDIUwL/u/78tuo8CGqu3up.', NULL, NULL, NULL, NULL, 3, 2, '2019-01-08', 0, '*4B', 1, NULL, '2019-01-31 05:25:06', NULL, '2019-01-31 03:44:10');
INSERT INTO `users` VALUES (68, 'fbsantos1', 'fbsantos179@login.net', 'fbsantos1', '$2y$10$D3BoBTB6sEOiXcKY76PFdO4EecG0bNw7O/AJsYeLiiE96jlcsm/Cy', NULL, NULL, NULL, NULL, 3, 2, '2019-01-18', 0, '*4C', 1, NULL, '2019-01-31 05:25:06', NULL, '2019-01-31 03:44:10');
INSERT INTO `users` VALUES (69, 'roro', 'roro81@login.net', 'roro', '$2y$10$w34rxffuc2myQBtgdre2UOEyhduBmEdgwBswa7MBDgl/dSnuxPSZy', NULL, NULL, NULL, NULL, 3, 2, '2018-11-30', 0, '*4D', 2, NULL, '2019-01-31 05:25:06', NULL, '2019-01-31 03:44:10');
INSERT INTO `users` VALUES (70, 'adailtonln', 'adailtonln67@login.net', 'adailtonln', '$2y$10$l33ZMvVG0kA9J7mSyuc1D.7vHaRPHfv6OIA4MtZ4khB1qoZ5XXDeS', NULL, NULL, NULL, NULL, 3, 3, '2019-01-08', 0, '*4E', 1, NULL, '2019-01-31 05:25:06', NULL, '2019-01-31 03:44:10');
INSERT INTO `users` VALUES (71, 'emily', 'emily50@login.net', 'emily', '$2y$10$vpoqn0ZX1JQwDp6Ug0bl8OMrN3RTDGf0p9CKHbFIY0QEgnS5NuI9y', NULL, NULL, NULL, NULL, 3, 2, '2019-01-22', 0, '*4F', 1, NULL, '2019-01-31 05:25:07', NULL, '2019-01-31 03:44:10');
INSERT INTO `users` VALUES (72, 'nina', 'nina19@login.net', 'nina', '$2y$10$NBZHz7fadEj81gkIjEDiMOT8m0QLavV.snyo2p8IFLxcfKiJk6gOi', NULL, NULL, NULL, NULL, 3, 2, '2018-12-18', 0, '*50', 2, NULL, '2019-01-31 05:25:07', NULL, '2019-01-31 03:44:10');
INSERT INTO `users` VALUES (73, 'galeno', 'galeno25@login.net', 'galeno', '$2y$10$evwk9AkvTei2TZxK.aX1gOFaBVFWeVaJ3Bwlw/g1RBQF09E60iHDe', NULL, NULL, NULL, NULL, 3, 3, '2019-01-26', 0, '*51', 1, NULL, '2019-01-31 05:25:07', NULL, '2019-01-31 03:44:10');
INSERT INTO `users` VALUES (74, 'nilton', 'nilton30@login.net', 'nilton', '$2y$10$5up7IQMNdT3B6hEEZrp2ce9dlqS04u8OJRT9PVQeBsx6dPqOKuSUe', NULL, NULL, NULL, NULL, 3, 3, '2019-01-05', 0, '*52', 1, NULL, '2019-01-31 05:25:07', NULL, '2019-01-31 03:44:10');
INSERT INTO `users` VALUES (75, 'Princesasophia', 'Princesasophia31@login.net', 'Princesasophia', '$2y$10$g26NI7NxEmKGjlpI7tfLCOXspue.IhD9Befqulf9M5rW9zkhza.Da', NULL, NULL, NULL, NULL, 3, 5, '2019-01-13', 0, '*53', 1, NULL, '2019-01-31 05:25:07', NULL, '2019-01-31 03:44:10');
INSERT INTO `users` VALUES (76, 'adriano', 'adriano63@login.net', 'adriano', '$2y$10$lDA9sAGRy/mplXyLFt8vle3NgLMKkmUfyb.qmuTF15O7Q6VHEwiw2', NULL, NULL, NULL, NULL, 3, 3, '2019-01-21', 0, '*54', 1, NULL, '2019-01-31 05:25:07', NULL, '2019-01-31 03:44:10');
INSERT INTO `users` VALUES (77, 'eduardo2', 'eduardo243@login.net', 'eduardo2', '$2y$10$FkHcKjGDJgsXgrZHh3eM7OfO0blVc0ku6/kRElDTTPopDeidHAno6', NULL, NULL, NULL, NULL, 3, 2, '2018-08-27', 0, '*55', 2, NULL, '2019-02-02 04:37:59', NULL, '2019-01-31 03:44:10');
INSERT INTO `users` VALUES (78, 'kelvin', 'kelvin46@login.net', 'kelvin', '$2y$10$j91IKH95LXitbxs.VGhjAehJUyfnTGNRpRr4bfoUhwqnJCc.SjFbm', NULL, NULL, NULL, NULL, 3, 5, '2019-01-18', 0, '*59', 1, NULL, '2019-01-31 05:25:07', NULL, '2019-01-31 03:44:10');
INSERT INTO `users` VALUES (79, 'xtmodas', 'xtmodas33@login.net', 'xtmodas', '$2y$10$qQA8tQxKCtfFSLWi.z1Miu30Ny5DNCwVRW.675S52NwVAdaVcdywi', NULL, NULL, NULL, NULL, 3, 3, '2019-01-26', 0, '*5A', 1, NULL, '2019-01-31 05:25:07', NULL, '2019-01-31 03:44:10');
INSERT INTO `users` VALUES (80, 'cristina', 'cristina83@login.net', 'cristina', '$2y$10$Ay3FEssMATySjdg2LQ4zuO69YOgkYDd2.A6XKCbOHUPOYHvmbBK/i', NULL, NULL, NULL, NULL, 3, 3, '2019-01-05', 0, '*5B', 1, NULL, '2019-01-31 05:25:07', NULL, '2019-01-31 03:44:10');
INSERT INTO `users` VALUES (81, 'pedrovictor', 'pedrovictor13@login.net', 'pedrovictor', '$2y$10$NYYdnDpHGRkQH4nFPja/KuljsKJwDEF3QdKy44OTztHKvzTc8aGpm', NULL, NULL, NULL, NULL, 3, 2, '2018-12-28', 0, '*5C', 2, NULL, '2019-01-31 05:25:07', NULL, '2019-01-31 03:44:10');
INSERT INTO `users` VALUES (82, 'denice', 'denice40@login.net', 'denice', '$2y$10$Ham223mPAks22KzCShu/iOckfTMaiMAm8Ck/6.0b.0Tsbrww9tV6W', NULL, NULL, NULL, NULL, 3, 2, '2018-12-20', 0, '*5D', 2, NULL, '2019-01-31 05:25:07', NULL, '2019-01-31 03:44:10');
INSERT INTO `users` VALUES (83, 'Danyella', 'Danyella84@login.net', 'Danyella', '$2y$10$WHfo6FRS.L/XpyTQI9RE2ONZ8kPWW9oR2YHPkiHF4QOyNi1EZBRQG', NULL, NULL, NULL, NULL, 3, 3, '2019-01-20', 0, '*5E', 1, NULL, '2019-01-31 05:25:07', NULL, '2019-01-31 03:44:10');
INSERT INTO `users` VALUES (84, 'caina04', 'caina0444@login.net', 'caina04', '$2y$10$ndoVqXR.zUR2rU8I7rf7XehZlVbmejk9VgypOnwg1Uv.QPf1s2p7u', NULL, NULL, NULL, NULL, 3, 2, '2018-08-12', 0, '*5F', 2, NULL, '2019-01-31 05:25:07', NULL, '2019-01-31 03:44:11');
INSERT INTO `users` VALUES (85, 'luisfelipe', 'luisfelipe47@login.net', 'luisfelipe', '$2y$10$7WwWa3uf/x4tKz7a5aVvC.T2pQGi5j2Szy6FBdsgVf9m1efRmbtOK', NULL, NULL, NULL, NULL, 3, 3, '2019-01-28', 0, '*60', 1, NULL, '2019-01-31 05:25:07', NULL, '2019-01-31 03:44:11');
INSERT INTO `users` VALUES (86, 'Luce', 'Luce22@login.net', 'Luce', '$2y$10$tKL/ACealijKVEnIoKIKgeY5ZtdFGsBoQTcDPU1P5DenMnnYKXPr2', NULL, NULL, NULL, NULL, 3, 3, '2019-01-08', 0, '*61', 1, NULL, '2019-01-31 05:25:07', NULL, '2019-01-31 03:44:11');
INSERT INTO `users` VALUES (87, 'melissa', 'melissa97@login.net', 'melissa', '$2y$10$4GFP7QibizqHWWkGlORPkuMxRjGOr4AIu1QqvqAzgvREd3hIUt8ru', NULL, NULL, NULL, NULL, 3, 2, '2018-08-28', 0, '*62', 2, NULL, '2019-01-31 05:25:07', NULL, '2019-01-31 03:44:11');
INSERT INTO `users` VALUES (88, 'familiasouza', 'familiasouza84@login.net', 'familiasouza', '$2y$10$IW2BUECguKN5unAo/4eoSOscAFjqUuhnEhV6vC39fgJaHXz.j8nKS', NULL, NULL, NULL, NULL, 3, 5, '2019-01-11', 0, '*63', 1, NULL, '2019-01-31 05:25:08', NULL, '2019-01-31 03:44:11');
INSERT INTO `users` VALUES (89, 'paulo', 'paulo20@login.net', 'paulo', '$2y$10$Akww9gENBq5FiJRXI1X8MumOU.r/6x4jSHBqCJtgbVt/flIi8fjfi', NULL, NULL, NULL, NULL, 3, 5, '2019-01-09', 0, '*64', 1, NULL, '2019-01-31 05:25:08', NULL, '2019-01-31 03:44:11');
INSERT INTO `users` VALUES (90, 'jessicaregina', 'jessicaregina14@login.net', 'jessicaregina', '$2y$10$jAm7i.kCQP6.eBfGcjTz0OGVCP2XITIY3hDoqrAZgjyl18V116Dfq', NULL, NULL, NULL, NULL, 3, 2, '2019-01-08', 0, '*66', 1, NULL, '2019-01-31 05:25:08', NULL, '2019-01-31 03:44:11');
INSERT INTO `users` VALUES (91, 'nivea08', 'nivea0849@login.net', 'nivea08', '$2y$10$8aWCQYXe2qXQS4/wPkkfBOthIp/0k9MfwP9cSLJU7J6MoN97ob7WW', NULL, NULL, NULL, NULL, 3, 3, '2019-01-15', 0, '*67', 1, NULL, '2019-01-31 05:25:08', NULL, '2019-01-31 03:44:11');
INSERT INTO `users` VALUES (92, 'honorio', 'honorio95@login.net', 'honorio', '$2y$10$UIumWplsiYPnt2Io6dkcle3UeBXhSq5.7XWS5hYbilHI0xGfMcFtC', NULL, NULL, NULL, NULL, 3, 3, '2019-01-24', 0, '*69', 1, NULL, '2019-01-31 05:25:08', NULL, '2019-01-31 03:44:11');
INSERT INTO `users` VALUES (93, 'beth', 'beth48@login.net', 'beth', '$2y$10$7z0NJERhSSEi5sF3ZKic2eMo5sXNHUpur4GhfHXJxK50Sj/yyOraq', NULL, NULL, NULL, NULL, 3, 2, '2019-01-24', 0, '*6A', 1, NULL, '2019-01-31 05:25:08', NULL, '2019-01-31 03:44:11');
INSERT INTO `users` VALUES (94, 'wagnerloura', 'wagnerloura73@login.net', 'wagnerloura', '$2y$10$OQvQ.iuHWycvB9k/KV5OZ.4fQa2Cd25QUIcttiTQq8A1AHRCPX7lC', NULL, NULL, NULL, NULL, 3, 2, '2019-01-09', 0, '*6B', 1, NULL, '2019-01-31 05:25:08', NULL, '2019-01-31 03:44:11');
INSERT INTO `users` VALUES (95, 'geise', 'geise99@login.net', 'geise', '$2y$10$b9R1znFQ1/s9CEAKX/baReFQ3tnz5Fl4wZhX/6YuNxZ.WxLY.iK.q', NULL, NULL, NULL, NULL, 3, 3, '2019-01-13', 0, '*6C', 1, NULL, '2019-01-31 05:25:08', NULL, '2019-01-31 03:44:11');
INSERT INTO `users` VALUES (96, 'rose', 'rose78@login.net', 'rose', '$2y$10$TVFjjpuQPLbh4PNhgcWRFuI0188Wqa6NBLBytpey34BS6TxPaYCqG', NULL, NULL, NULL, NULL, 3, 2, '2018-12-19', 0, '*6D', 2, NULL, '2019-01-31 05:25:08', NULL, '2019-01-31 03:44:11');
INSERT INTO `users` VALUES (97, 'isaac', 'isaac25@login.net', 'isaac', '$2y$10$x0OBatEnFViK3IxdFFuB6e8YqqSebWXvz77hcq1degGKEgoDUCuwe', NULL, NULL, NULL, NULL, 3, 2, '2018-12-18', 0, '*6E', 2, NULL, '2019-01-31 05:25:08', NULL, '2019-01-31 03:44:11');
INSERT INTO `users` VALUES (98, 'evillyn', 'evillyn97@login.net', 'evillyn', '$2y$10$qOPjcsNxkHUDjASDNkDAR.d/TMGYCl2lUgSrfHBxU07ztqembFcQ2', NULL, NULL, NULL, NULL, 3, 2, '2019-01-02', 0, '*6F', 1, NULL, '2019-01-31 05:25:08', NULL, '2019-01-31 03:44:11');
INSERT INTO `users` VALUES (99, 'walleria', 'walleria74@login.net', 'walleria', '$2y$10$PV0/EnINmyevNvbJmHS0jutDSjaU5reP57Z/DAQS0bcjMmHcwXS1W', NULL, NULL, NULL, NULL, 3, 2, '2019-01-07', 0, '*70', 1, NULL, '2019-01-31 05:25:08', NULL, '2019-01-31 03:44:11');
INSERT INTO `users` VALUES (100, 'launchercell', 'launchercell37@login.net', 'launchercell', '$2y$10$1dK58DlNwH7x3YdsobqOm.po2esJiMbJVBjH2IGAVvvQw8mhF3LDW', NULL, NULL, NULL, NULL, 3, 3, '2019-01-12', 0, '*71', 1, NULL, '2019-01-31 05:25:08', NULL, '2019-01-31 03:44:11');
INSERT INTO `users` VALUES (101, 'jeferson', 'jeferson58@login.net', 'jeferson', '$2y$10$5jydn4sXY7KNbjNd7YQ5.e6PeWa4tbLjuGggYPtbRLtpTzyLxtUHm', NULL, NULL, NULL, NULL, 3, 2, '2018-12-17', 0, '*73', 2, NULL, '2019-01-31 05:25:08', NULL, '2019-01-31 03:44:12');
INSERT INTO `users` VALUES (102, 'Harrison', 'Harrison65@login.net', 'Harrison', '$2y$10$F1cW2YD4xBbmxZbjI9Bo5uhpNuWvMcLCb4RpBnVFCJpwSYCv4BDWK', NULL, NULL, NULL, NULL, 3, 2, '2019-01-22', 0, '*74', 1, NULL, '2019-01-31 05:25:08', NULL, '2019-01-31 03:44:12');
INSERT INTO `users` VALUES (103, 'luis', 'luis83@login.net', 'luis', '$2y$10$xRRLCJwSm9mACIvdZMeZk.FnpAggwrPidzmcsCFaeHP0EaCu4MKx6', NULL, NULL, NULL, NULL, 3, 2, '2019-01-21', 0, '*75', 1, NULL, '2019-01-31 05:25:08', NULL, '2019-01-31 03:44:12');
INSERT INTO `users` VALUES (104, 'Leandro', 'Leandro74@login.net', 'Leandro', '$2y$10$mNqY9Va4DtiA6O3wuRYlMu.CIbId8VDj2C/dvXn0ONqNiRmIVFK8S', NULL, NULL, NULL, NULL, 3, 2, '2019-01-10', 0, '*76', 1, NULL, '2019-01-31 05:25:08', NULL, '2019-01-31 03:44:12');
INSERT INTO `users` VALUES (105, 'laerte', 'laerte89@login.net', 'laerte', '$2y$10$JuL5yu1oq7w8f2t7bq70NeQZDDpxitun7VAVnlpJ4UHIUzmwNN8uq', NULL, NULL, NULL, NULL, 3, 2, '2019-01-05', 0, '*77', 1, NULL, '2019-01-31 05:25:09', NULL, '2019-01-31 03:44:12');
INSERT INTO `users` VALUES (106, 'vinicius', 'vinicius46@login.net', 'vinicius', '$2y$10$zyWbxyyJQss1mu2su6CsmeVmaS7ghFEHT4CnYrlS16vCYR.uLLu72', NULL, NULL, NULL, NULL, 3, 2, '2019-01-03', 0, '*7B', 1, NULL, '2019-01-31 05:25:09', NULL, '2019-01-31 03:44:12');
INSERT INTO `users` VALUES (107, 'jonas', 'jonas75@login.net', 'jonas', '$2y$10$kTyziX9avuOfkOTzBk2mhuzNrn0D7v/edPzODmPoHqsSvtObwJhwi', NULL, NULL, NULL, NULL, 3, 2, '2019-01-07', 0, '*7C', 1, NULL, '2019-01-31 05:25:09', NULL, '2019-01-31 03:44:12');
INSERT INTO `users` VALUES (108, 'luciaramendes', 'luciaramendes76@login.net', 'luciaramendes', '$2y$10$PKRBk5TEJb384lQNOHMuJ..LZqEVyHzMvP5HCFYU0C0WcXsaRdEee', NULL, NULL, NULL, NULL, 3, 2, '2019-01-08', 0, '*7D', 1, NULL, '2019-01-31 05:25:09', NULL, '2019-01-31 03:44:12');
INSERT INTO `users` VALUES (109, 'rayanna', 'rayanna59@login.net', 'rayanna', '$2y$10$uD5.2i0I5cmfNLKzzOqTw.8sODCHW9H5S8cPFpYoTvpeaSLFKaasS', NULL, NULL, NULL, NULL, 3, 2, '2019-01-09', 0, '*7E', 1, NULL, '2019-01-31 05:25:09', NULL, '2019-01-31 03:44:12');
INSERT INTO `users` VALUES (110, 'ducilea', 'ducilea78@login.net', 'ducilea', '$2y$10$XTJvfJdbdMq9ZmeUcxCee.UFAbUSHyBiIER4Aosv/OeVC5bdVSzy.', NULL, NULL, NULL, NULL, 3, 2, '2019-01-16', 0, '*80', 1, NULL, '2019-01-31 05:25:09', NULL, '2019-01-31 03:44:12');
INSERT INTO `users` VALUES (111, 'yanearthur', 'yanearthur49@login.net', 'yanearthur', '$2y$10$qUug5/qUGDojv2CKWTfgEuFUVy2UrRA6nxNOHmPJg7XSVwyBld9Pu', NULL, NULL, NULL, NULL, 3, 5, '2019-01-22', 0, '*81', 1, NULL, '2019-01-31 05:25:09', NULL, '2019-01-31 03:44:12');
INSERT INTO `users` VALUES (112, 'Aladim', 'Aladim63@login.net', 'Aladim', '$2y$10$C64hNGvJZWrW11sPgDS.fOa0ioeVpQ2c.WTteIvbm76l.ehqOqMS2', NULL, NULL, NULL, NULL, 3, 3, '2019-01-24', 0, '*82', 1, NULL, '2019-01-31 05:25:09', NULL, '2019-01-31 03:44:12');
INSERT INTO `users` VALUES (113, 'Taina', 'Taina48@login.net', 'Taina', '$2y$10$ta9hCdi6CGLhKxqc44J4NO4M27wjD10h4aHGB3NQUaTgc6/ks5ReS', NULL, NULL, NULL, NULL, 3, 2, '2019-01-24', 0, '*83', 1, NULL, '2019-01-31 05:25:09', NULL, '2019-01-31 03:44:12');
INSERT INTO `users` VALUES (114, 'Tatiana', 'Tatiana81@login.net', 'Tatiana', '$2y$10$xSymqZaxnCe9ZW6dGCNWQOyEEEE6aeXc5NnuTDl47V.U9FjtKJ2Si', NULL, NULL, NULL, NULL, 3, 2, '2019-01-24', 0, '*84', 1, NULL, '2019-01-31 05:25:09', NULL, '2019-01-31 03:44:12');
INSERT INTO `users` VALUES (115, 'Cristiane', 'Cristiane36@login.net', 'Cristiane', '$2y$10$tQWv/s7LEUR6gZh5GBc6EOg4261V0pxPLb89TL9GFVNcsoYyg/gcG', NULL, NULL, NULL, NULL, 3, 2, '2019-01-24', 0, '*85', 1, NULL, '2019-01-31 05:25:09', NULL, '2019-01-31 03:44:12');
INSERT INTO `users` VALUES (116, 'mariana', 'mariana79@login.net', 'mariana', '$2y$10$Y7KlkgKQkGbjmu8zP0XXA.rc05Ekg4rSqA95C4g2511MYSI9ihmQ2', NULL, NULL, NULL, NULL, 3, 2, '2019-01-28', 0, '*86', 1, NULL, '2019-01-31 05:25:09', NULL, '2019-01-31 03:44:12');
INSERT INTO `users` VALUES (117, 'Viciada', 'Viciada83@login.net', 'Viciada', '$2y$10$phmE0d/nnu6fuENmI5ZBYeYAujvbqlxutVrJWs3o8UWmDhEdjDtgm', NULL, NULL, NULL, NULL, 3, 2, '2019-01-28', 0, '*87', 1, NULL, '2019-01-31 05:25:09', NULL, '2019-01-31 03:44:12');
INSERT INTO `users` VALUES (118, 'rosenilde', 'rosenilde58@login.net', 'rosenilde', '$2y$10$2TdPdI9VRzOSuD2XZwGUrOx3SqiRo7Il1dbh9BXfqq2Q8ofzffY7.', NULL, NULL, NULL, NULL, 3, 3, '2019-01-29', 0, '*88', 1, NULL, '2019-01-31 05:25:09', NULL, '2019-01-31 03:44:13');
INSERT INTO `users` VALUES (119, 'Ellen', 'Ellen30@login.net', 'Ellen', '$2y$10$qzc1nHRvtRv8RgrvnxGEH.FUhulpN8GRiMcmFt5ilazb4eqg18c5K', NULL, NULL, NULL, NULL, 3, 2, '2019-01-29', 0, '*89', 1, NULL, '2019-01-31 05:25:09', NULL, '2019-01-31 03:44:13');
INSERT INTO `users` VALUES (122, 'Usuário teste add 44', 'user4@mail.com', 'user55', '$2y$10$/crqD2sueKp/ZJbgTF2uouuhMT0uiE8ZS0Z8Rlr.uw8RQAdGyBmey', NULL, NULL, 98988556622, NULL, 3, 3, NULL, 0, NULL, 2, NULL, '2019-02-02 05:12:41', NULL, '2019-02-02 05:12:41');
INSERT INTO `users` VALUES (123, 'Usuário teste add 66', 'user66@mail.com', 'user666', '$2y$10$PVQQFjAjarMgkmjsXdnJJOQlKtq8EjtfGrcVXxfMr0fPFefPlcnh6', NULL, NULL, 98988774477, NULL, 3, 5, NULL, 0, NULL, 2, NULL, '2019-02-02 05:21:47', NULL, '2019-02-02 05:21:47');
INSERT INTO `users` VALUES (124, 'Usuário teste add 77', '666user3@mail.com', 'user77', '$2y$10$eXyosHu3D3EvhtUxmXMkB.x1Z5xbLiuqWLvK4Buf9Qpn2o24rMJM.', NULL, NULL, 989898988989, NULL, 3, 3, NULL, 0, NULL, 2, NULL, '2019-02-02 05:24:11', NULL, '2019-02-02 05:24:11');
INSERT INTO `users` VALUES (125, 'Usuário teste add55', 'u88ser3@mail.com', 'user88', '$2y$10$FTIZBEoiW.FEsdsQGkcXheYy5PBiplJOwOFmnwVAuJ3/C1JQGmFSy', NULL, NULL, 989898989898, NULL, 3, 3, '2019-02-02', 0, '*8D', 1, 'M9aG8A2f0I38zYUUE9k7t8slJE3N2x0UNoh93fhMw4PTzt6Ffraebh76dO63', '2019-02-02 05:26:16', NULL, '2019-02-02 05:25:52');

SET FOREIGN_KEY_CHECKS = 1;
