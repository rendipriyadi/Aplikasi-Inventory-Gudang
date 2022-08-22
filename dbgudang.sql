/*
 Navicat Premium Data Transfer

 Source Server         : Localhost
 Source Server Type    : MySQL
 Source Server Version : 100424
 Source Host           : localhost:3306
 Source Schema         : dbgudang

 Target Server Type    : MySQL
 Target Server Version : 100424
 File Encoding         : 65001

 Date: 11/07/2022 16:21:18
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for barang
-- ----------------------------
DROP TABLE IF EXISTS `barang`;
CREATE TABLE `barang`  (
  `brgkode` char(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `brgnama` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `brgkatid` int(10) UNSIGNED NOT NULL,
  `brgsatid` int(10) UNSIGNED NOT NULL,
  `brgharga` double NOT NULL,
  `brggambar` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `brgstok` int(11) NOT NULL,
  PRIMARY KEY (`brgkode`) USING BTREE,
  INDEX `barang_brgkatid_foreign`(`brgkatid`) USING BTREE,
  INDEX `barang_brgsatid_foreign`(`brgsatid`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of barang
-- ----------------------------
INSERT INTO `barang` VALUES ('PJ001', 'Indomie Goreng', 4, 4, 3500, '', 10);
INSERT INTO `barang` VALUES ('PJ002', 'Teh Pucuk ', 5, 4, 3500, 'upload/PJ002_1.png', 0);
INSERT INTO `barang` VALUES ('PJ003', 'Kopi Good Day', 5, 4, 6000, '', 5);
INSERT INTO `barang` VALUES ('PJ004', 'Beng-beng', 4, 5, 25000, '', 2);

-- ----------------------------
-- Table structure for barangkeluar
-- ----------------------------
DROP TABLE IF EXISTS `barangkeluar`;
CREATE TABLE `barangkeluar`  (
  `faktur` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `tglfaktur` date NULL DEFAULT NULL,
  `idpel` int(11) NULL DEFAULT NULL,
  `totalharga` double NULL DEFAULT NULL,
  `jumlahuang` double NOT NULL,
  `sisauang` double NOT NULL,
  `order_id` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `payment_type` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `payment_method` enum('C','M') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `transaction_status` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`faktur`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of barangkeluar
-- ----------------------------
INSERT INTO `barangkeluar` VALUES ('0806220001', '2022-06-08', 2, 35000, 0, 0, '1041519941', 'bank_transfer', 'M', 'settlement');
INSERT INTO `barangkeluar` VALUES ('2806220001', '2022-06-28', 2, 35000, 0, 0, '1254777318', 'bank_transfer', 'M', 'settlement');

-- ----------------------------
-- Table structure for barangmasuk
-- ----------------------------
DROP TABLE IF EXISTS `barangmasuk`;
CREATE TABLE `barangmasuk`  (
  `faktur` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `tglfaktur` date NULL DEFAULT NULL,
  `totalharga` double NULL DEFAULT NULL,
  PRIMARY KEY (`faktur`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of barangmasuk
-- ----------------------------
INSERT INTO `barangmasuk` VALUES ('F-001', '2022-06-18', 25000);

-- ----------------------------
-- Table structure for detail_barangkeluar
-- ----------------------------
DROP TABLE IF EXISTS `detail_barangkeluar`;
CREATE TABLE `detail_barangkeluar`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `detfaktur` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `detbrgkode` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `dethargajual` double NULL DEFAULT NULL,
  `detjml` int(11) NULL DEFAULT NULL,
  `detsubtotal` double NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 29 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of detail_barangkeluar
-- ----------------------------
INSERT INTO `detail_barangkeluar` VALUES (16, '2904220001', 'PJ003', 6000, 10, 60000);
INSERT INTO `detail_barangkeluar` VALUES (18, '2904220001', 'PJ001', 3500, 1, 3500);
INSERT INTO `detail_barangkeluar` VALUES (19, '2904220001', 'PJ004', 25000, 1, 25000);
INSERT INTO `detail_barangkeluar` VALUES (25, '0806220001', 'PJ002', 3500, 10, 35000);
INSERT INTO `detail_barangkeluar` VALUES (28, '2806220001', 'PJ001', 3500, 10, 35000);

-- ----------------------------
-- Table structure for detail_barangmasuk
-- ----------------------------
DROP TABLE IF EXISTS `detail_barangmasuk`;
CREATE TABLE `detail_barangmasuk`  (
  `iddetail` bigint(20) NOT NULL AUTO_INCREMENT,
  `detfaktur` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `detbrgkode` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `dethargamasuk` double NULL DEFAULT NULL,
  `dethargajual` double NULL DEFAULT NULL,
  `detjml` int(11) NULL DEFAULT NULL,
  `detsubtotal` double NULL DEFAULT NULL,
  PRIMARY KEY (`iddetail`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of detail_barangmasuk
-- ----------------------------
INSERT INTO `detail_barangmasuk` VALUES (10, 'F-001', 'PJ001', 2500, 3500, 10, 25000);

-- ----------------------------
-- Table structure for kategori
-- ----------------------------
DROP TABLE IF EXISTS `kategori`;
CREATE TABLE `kategori`  (
  `katid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `katnama` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  INDEX `katid`(`katid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kategori
-- ----------------------------
INSERT INTO `kategori` VALUES (4, 'Makanan');
INSERT INTO `kategori` VALUES (5, 'Minuman');

-- ----------------------------
-- Table structure for levels
-- ----------------------------
DROP TABLE IF EXISTS `levels`;
CREATE TABLE `levels`  (
  `levelid` int(11) NOT NULL AUTO_INCREMENT,
  `levelnama` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`levelid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of levels
-- ----------------------------
INSERT INTO `levels` VALUES (1, 'Admin');
INSERT INTO `levels` VALUES (2, 'Kasir');
INSERT INTO `levels` VALUES (3, 'Gudang');
INSERT INTO `levels` VALUES (4, 'Pimpinan');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `version` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `class` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `group` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `namespace` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2022-02-26-172025', 'App\\Database\\Migrations\\Kategori', 'default', 'App', 1645981859, 1);
INSERT INTO `migrations` VALUES (2, '2022-02-26-172033', 'App\\Database\\Migrations\\Satuan', 'default', 'App', 1645981859, 1);
INSERT INTO `migrations` VALUES (3, '2022-02-26-172041', 'App\\Database\\Migrations\\Barang', 'default', 'App', 1645981859, 1);

-- ----------------------------
-- Table structure for pelanggan
-- ----------------------------
DROP TABLE IF EXISTS `pelanggan`;
CREATE TABLE `pelanggan`  (
  `pelid` int(11) NOT NULL AUTO_INCREMENT,
  `pelnama` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `peltelp` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`pelid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pelanggan
-- ----------------------------
INSERT INTO `pelanggan` VALUES (2, 'Rendi Priyadi', '08978305336');

-- ----------------------------
-- Table structure for satuan
-- ----------------------------
DROP TABLE IF EXISTS `satuan`;
CREATE TABLE `satuan`  (
  `satid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `satnama` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  INDEX `satid`(`satid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of satuan
-- ----------------------------
INSERT INTO `satuan` VALUES (4, 'PCS');
INSERT INTO `satuan` VALUES (5, 'Karton');

-- ----------------------------
-- Table structure for temp_barangkeluar
-- ----------------------------
DROP TABLE IF EXISTS `temp_barangkeluar`;
CREATE TABLE `temp_barangkeluar`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `detfaktur` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `detbrgkode` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `dethargajual` double NULL DEFAULT NULL,
  `detjml` int(11) NULL DEFAULT NULL,
  `detsubtotal` double NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 32 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for temp_barangmasuk
-- ----------------------------
DROP TABLE IF EXISTS `temp_barangmasuk`;
CREATE TABLE `temp_barangmasuk`  (
  `iddetail` bigint(20) NOT NULL AUTO_INCREMENT,
  `detfaktur` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `detbrgkode` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `dethargamasuk` double NULL DEFAULT NULL,
  `dethargajual` double NULL DEFAULT NULL,
  `detjml` int(11) NULL DEFAULT NULL,
  `detsubtotal` double NULL DEFAULT NULL,
  PRIMARY KEY (`iddetail`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 25 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `userid` char(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `usernama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `userpassword` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `userlevelid` int(11) NULL DEFAULT NULL,
  `useraktif` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '1',
  PRIMARY KEY (`userid`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('admin', 'Administrator', '$2y$10$Y/cxr8Hzu.eUkfNbGYQSleqgtCrl6VnDzMbWg98pUyjL99KMCJdse', 1, '1');
INSERT INTO `users` VALUES ('gudang', 'Dedi Nugroho', '$2y$10$5HgLPF.lbJ/EmlEb0tkdteZcxTYV1Gq07RHeHdEt8uGG4TjR6cm5.', 3, '1');
INSERT INTO `users` VALUES ('kasir', 'Rendi Priyadi', '$2y$10$vTA6tWGCgzWk7IKQprUFr..q4bi3CLsYgsWLblszAPpeAuvThyuaq', 2, '1');
INSERT INTO `users` VALUES ('kasir2', 'Eko Julianto', NULL, 2, '0');

-- ----------------------------
-- Triggers structure for table detail_barangkeluar
-- ----------------------------
DROP TRIGGER IF EXISTS `tri_insert_detailBarangKeluar`;
delimiter ;;
CREATE TRIGGER `tri_insert_detailBarangKeluar` AFTER INSERT ON `detail_barangkeluar` FOR EACH ROW BEGIN
    UPDATE barang SET brgstok = brgstok - new.detjml WHERE brgkode = new.detbrgkode;
	END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table detail_barangkeluar
-- ----------------------------
DROP TRIGGER IF EXISTS `tri_update_detailBarangKeluar`;
delimiter ;;
CREATE TRIGGER `tri_update_detailBarangKeluar` AFTER UPDATE ON `detail_barangkeluar` FOR EACH ROW BEGIN
    UPDATE barang SET brgstok = (brgstok + old.detjml) - new.detjml WHERE brgkode = new.detbrgkode;
	END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table detail_barangkeluar
-- ----------------------------
DROP TRIGGER IF EXISTS `tri_delete_detailBarangKeluar`;
delimiter ;;
CREATE TRIGGER `tri_delete_detailBarangKeluar` AFTER DELETE ON `detail_barangkeluar` FOR EACH ROW BEGIN
    UPDATE barang SET brgstok = brgstok + old.detjml WHERE brgkode = old.detbrgkode;
	END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table detail_barangmasuk
-- ----------------------------
DROP TRIGGER IF EXISTS `tri_tambah_stok_barang`;
delimiter ;;
CREATE TRIGGER `tri_tambah_stok_barang` AFTER INSERT ON `detail_barangmasuk` FOR EACH ROW BEGIN
	update barang set barang.`brgstok` = barang.`brgstok` + new.detjml where barang.`brgkode`=new.detbrgkode;
    END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table detail_barangmasuk
-- ----------------------------
DROP TRIGGER IF EXISTS `tri_update_stok_barang`;
delimiter ;;
CREATE TRIGGER `tri_update_stok_barang` AFTER UPDATE ON `detail_barangmasuk` FOR EACH ROW BEGIN
	update barang set brgstok = (brgstok - old.detjml) +  new.detjml where brgkode = new.detbrgkode;
    END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table detail_barangmasuk
-- ----------------------------
DROP TRIGGER IF EXISTS `tri_kurangi_stok_barang`;
delimiter ;;
CREATE TRIGGER `tri_kurangi_stok_barang` AFTER DELETE ON `detail_barangmasuk` FOR EACH ROW BEGIN
	update barang set brgstok = brgstok - old.detjml where brgkode = old.detbrgkode;
    END
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
