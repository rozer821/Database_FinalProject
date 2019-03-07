/*
 Navicat Premium Data Transfer

 Source Server         : homework
 Source Server Type    : MySQL
 Source Server Version : 80013
 Source Host           : localhost:3306
 Source Schema         : final

 Target Server Type    : MySQL
 Target Server Version : 80013
 File Encoding         : 65001

 Date: 13/12/2018 16:26:45
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for actions
-- ----------------------------
DROP TABLE IF EXISTS `actions`;
CREATE TABLE `actions` (
  `aid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `alongitude` decimal(18,6) NOT NULL,
  `alatitude` decimal(18,6) NOT NULL,
  `atime` datetime NOT NULL,
  PRIMARY KEY (`aid`),
  KEY `uid` (`uid`),
  CONSTRAINT `actions_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of actions
-- ----------------------------
BEGIN;
INSERT INTO `actions` VALUES (1, 1, -73.987190, 40.756039, '2018-11-15 11:55:00');
INSERT INTO `actions` VALUES (2, 1, -73.997227, 40.730529, '2018-11-15 12:00:00');
INSERT INTO `actions` VALUES (3, 1, -73.986556, 40.694055, '2018-11-15 12:05:00');
INSERT INTO `actions` VALUES (4, 2, -73.987190, 40.756039, '2018-11-15 11:55:00');
INSERT INTO `actions` VALUES (5, 2, -73.987190, 40.756039, '2018-11-15 12:00:00');
INSERT INTO `actions` VALUES (6, 2, -73.987190, 40.756039, '2018-11-15 12:05:00');
INSERT INTO `actions` VALUES (7, 3, -73.986556, 40.694055, '2018-11-15 11:55:00');
INSERT INTO `actions` VALUES (8, 3, -73.986556, 40.694055, '2018-11-15 12:00:00');
INSERT INTO `actions` VALUES (9, 3, -73.986556, 40.694055, '2018-11-15 12:05:00');
INSERT INTO `actions` VALUES (10, 4, -73.987190, 40.756039, '2018-11-15 11:55:00');
INSERT INTO `actions` VALUES (11, 4, -73.987190, 40.756039, '2018-11-15 12:00:00');
INSERT INTO `actions` VALUES (12, 4, -73.987190, 40.756039, '2018-11-15 12:05:00');
INSERT INTO `actions` VALUES (13, 5, -73.987190, 40.756039, '2018-11-15 11:55:00');
INSERT INTO `actions` VALUES (14, 5, -73.987190, 40.756039, '2018-11-15 12:00:00');
INSERT INTO `actions` VALUES (15, 5, -73.987190, 40.756039, '2018-11-15 12:05:00');
INSERT INTO `actions` VALUES (16, 6, -73.987190, 40.756039, '2018-11-15 11:55:00');
INSERT INTO `actions` VALUES (17, 6, -73.987190, 40.756039, '2018-11-15 12:00:00');
INSERT INTO `actions` VALUES (18, 6, -73.987190, 40.756039, '2018-11-15 12:05:00');
INSERT INTO `actions` VALUES (19, 1, -73.997669, 40.690084, '2018-11-11 11:11:11');
INSERT INTO `actions` VALUES (20, 1, -73.996038, 40.693468, '2018-11-15 00:55:00');
INSERT INTO `actions` VALUES (21, 10, -73.986556, 40.694055, '2018-12-09 02:25:03');
INSERT INTO `actions` VALUES (22, 1, -73.986310, 40.691716, '2018-12-09 15:00:00');
INSERT INTO `actions` VALUES (23, 11, -73.986556, 40.694055, '2018-12-09 17:34:43');
INSERT INTO `actions` VALUES (24, 11, -73.989086, 40.691483, '2018-12-11 11:30:00');
INSERT INTO `actions` VALUES (25, 11, -73.994451, 40.697893, '2018-12-10 11:30:00');
INSERT INTO `actions` VALUES (26, 1, -73.990116, 40.691744, '2018-12-09 23:11:11');
INSERT INTO `actions` VALUES (27, 2, -73.995223, 40.704474, '2018-12-09 10:00:00');
INSERT INTO `actions` VALUES (28, 4, -73.996553, 40.705441, '2018-12-09 11:11:11');
INSERT INTO `actions` VALUES (29, 4, -73.987799, 40.693045, '2018-11-15 11:11:11');
INSERT INTO `actions` VALUES (30, 4, -73.987756, 40.692980, '2018-11-15 13:00:00');
INSERT INTO `actions` VALUES (31, 4, -73.986511, 40.693696, '2018-11-15 13:00:00');
INSERT INTO `actions` VALUES (32, 4, -73.997369, 40.693078, '2018-12-26 11:11:11');
INSERT INTO `actions` VALUES (33, 4, -73.986656, 40.693924, '2018-12-02 11:11:11');
INSERT INTO `actions` VALUES (34, 4, -73.986517, 40.693995, '2018-11-15 13:00:00');
INSERT INTO `actions` VALUES (35, 1, -73.995566, 40.691255, '2018-12-02 11:11:11');
INSERT INTO `actions` VALUES (36, 1, -73.988442, 40.668730, '2018-12-12 11:30:00');
INSERT INTO `actions` VALUES (37, 1, -73.991371, 40.663520, '2018-12-12 23:11:11');
INSERT INTO `actions` VALUES (38, 9, -73.000000, 40.000000, '2018-12-12 23:00:00');
INSERT INTO `actions` VALUES (39, 9, -73.980517, 40.690856, '2018-12-23 23:50:00');
INSERT INTO `actions` VALUES (40, 1, -73.982306, 40.690995, '2018-12-23 20:00:00');
INSERT INTO `actions` VALUES (41, 12, -73.986556, 40.694055, '2018-12-10 03:37:14');
INSERT INTO `actions` VALUES (42, 12, -74.012303, 40.671533, '2018-12-10 10:00:00');
INSERT INTO `actions` VALUES (43, 12, -74.011102, 40.670882, '2018-12-17 11:00:00');
INSERT INTO `actions` VALUES (44, 1, -74.011016, 40.672673, '2018-12-10 16:00:00');
INSERT INTO `actions` VALUES (45, 1, -74.013248, 40.672347, '2018-12-10 15:00:00');
INSERT INTO `actions` VALUES (46, 12, -74.011331, 40.671460, '2018-12-17 11:11:11');
INSERT INTO `actions` VALUES (47, 12, -74.013505, 40.671859, '2018-12-24 11:11:11');
INSERT INTO `actions` VALUES (48, 12, -73.990042, 40.669051, '2018-12-24 01:00:00');
INSERT INTO `actions` VALUES (49, 12, -73.988228, 40.692752, '2018-12-10 13:11:11');
INSERT INTO `actions` VALUES (50, 12, -73.988228, 40.692752, '2018-12-10 13:11:11');
INSERT INTO `actions` VALUES (51, 5, -73.988099, 40.692297, '2018-12-12 00:12:12');
INSERT INTO `actions` VALUES (52, 5, -73.963509, 40.670891, '2018-12-10 00:00:00');
INSERT INTO `actions` VALUES (53, 5, -73.966725, 40.670826, '2019-01-01 13:00:00');
INSERT INTO `actions` VALUES (54, 5, -73.965182, 40.672184, '2019-01-01 14:00:00');
INSERT INTO `actions` VALUES (55, 5, -73.966684, 40.672738, '2018-01-02 14:22:22');
INSERT INTO `actions` VALUES (56, 5, -74.009706, 40.671036, '2018-12-24 13:00:00');
INSERT INTO `actions` VALUES (57, 12, -74.012218, 40.671501, '2018-12-10 10:00:00');
INSERT INTO `actions` VALUES (58, 12, -74.013248, 40.672176, '2018-12-17 14:00:00');
INSERT INTO `actions` VALUES (59, 1, -73.987885, 40.693143, '2018-12-10 13:00:00');
INSERT INTO `actions` VALUES (60, 1, -74.013848, 40.671989, '2018-12-24 11:00:00');
INSERT INTO `actions` VALUES (61, 5, -73.987412, 40.692785, '2018-12-10 11:30:00');
INSERT INTO `actions` VALUES (62, 5, -73.988099, 40.693143, '2018-12-10 12:30:00');
INSERT INTO `actions` VALUES (63, 10, -73.987498, 40.692785, '2018-12-25 13:00:00');
INSERT INTO `actions` VALUES (64, 1, -73.982434, 40.691232, '2018-11-15 12:00:00');
INSERT INTO `actions` VALUES (65, 1, -73.993936, 40.704205, '2018-12-12 11:11:11');
INSERT INTO `actions` VALUES (66, 1, -73.987026, 40.693305, '2018-12-12 12:12:12');
INSERT INTO `actions` VALUES (67, 12, -74.012561, 40.671891, '2018-01-01 10:00:00');
INSERT INTO `actions` VALUES (68, 12, -74.012218, 40.671599, '2018-12-10 13:00:00');
INSERT INTO `actions` VALUES (69, 12, -74.013677, 40.671966, '2018-12-16 13:00:00');
INSERT INTO `actions` VALUES (70, 12, -74.012604, 40.671859, '2018-12-10 14:00:00');
INSERT INTO `actions` VALUES (71, 12, -73.989773, 40.669190, '2018-12-23 23:59:59');
INSERT INTO `actions` VALUES (72, 1, -73.976340, 40.681924, '2018-12-12 00:12:12');
INSERT INTO `actions` VALUES (73, 1, -73.965093, 40.690267, '2018-12-12 12:12:12');
INSERT INTO `actions` VALUES (74, 1, -73.981791, 40.691093, '2018-12-10 11:11:11');
INSERT INTO `actions` VALUES (75, 2, -73.994650, 40.704393, '2018-12-12 00:12:12');
INSERT INTO `actions` VALUES (76, 2, -73.995226, 40.704473, '2018-12-09 11:11:11');
INSERT INTO `actions` VALUES (77, 2, -73.995270, 40.704457, '2018-01-01 01:01:01');
INSERT INTO `actions` VALUES (78, 2, -73.986522, 40.703168, '2018-12-12 00:12:12');
COMMIT;

-- ----------------------------
-- Table structure for comment
-- ----------------------------
DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `cid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `ctext` text NOT NULL,
  `nid` int(11) NOT NULL,
  `ctime` datetime NOT NULL,
  `reply_cid` int(11) DEFAULT NULL,
  PRIMARY KEY (`cid`),
  KEY `uid` (`uid`),
  KEY `nid` (`nid`),
  FULLTEXT KEY `ctext` (`ctext`),
  CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE CASCADE,
  CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`nid`) REFERENCES `note` (`nid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of comment
-- ----------------------------
BEGIN;
INSERT INTO `comment` VALUES (1, 2, 'nice comment1', 1, '2018-11-15 12:05:00', NULL);
INSERT INTO `comment` VALUES (2, 1, 'Good beer', 12, '2018-12-09 23:11:11', NULL);
INSERT INTO `comment` VALUES (3, 1, 'and good snack', 12, '2018-12-09 23:11:11', 2);
INSERT INTO `comment` VALUES (4, 1, 'lmao', 11, '2018-12-10 11:11:11', NULL);
COMMIT;

-- ----------------------------
-- Table structure for filters
-- ----------------------------
DROP TABLE IF EXISTS `filters`;
CREATE TABLE `filters` (
  `fid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `fname` varchar(45) NOT NULL,
  `flongitude` decimal(18,6) DEFAULT NULL,
  `flatitude` decimal(18,6) DEFAULT NULL,
  `fradius` int(11) NOT NULL,
  `fstart_time` datetime NOT NULL,
  `fend_time` datetime NOT NULL,
  `fstatus` varchar(45) DEFAULT NULL,
  `ftag` varchar(45) DEFAULT NULL,
  `frepeat_type` int(11) NOT NULL,
  `flimit_view` int(11) NOT NULL,
  `fstart_date` datetime DEFAULT NULL,
  `fend_date` datetime DEFAULT NULL,
  `frepeat_date` int(11) DEFAULT NULL,
  PRIMARY KEY (`fid`),
  KEY `uid` (`uid`),
  CONSTRAINT `filters_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of filters
-- ----------------------------
BEGIN;
INSERT INTO `filters` VALUES (1, 4, 'time_square_eating_filter for 4', -73.987190, 40.756039, 100, '2018-11-15 12:00:00', '2018-11-15 14:00:00', 'work', '#eat1', 0, 0, NULL, NULL, NULL);
INSERT INTO `filters` VALUES (2, 4, 'tandon_work_filter2', -73.986556, 40.694055, 100, '2018-11-15 12:00:00', '2018-11-15 14:00:00', 'work', '#work1', 0, 1, NULL, NULL, NULL);
INSERT INTO `filters` VALUES (3, 5, 'time_square_having_fun_filter for 5', -73.987190, 40.756039, 100, '2018-11-15 12:00:00', '2018-11-15 14:00:00', 'lunch', '#nice trip1', 0, 0, NULL, NULL, NULL);
INSERT INTO `filters` VALUES (5, 4, 'School', -73.980000, 40.750000, 1000, '2018-12-01 00:00:00', '2018-12-31 23:59:59', NULL, NULL, 0, 0, NULL, NULL, NULL);
INSERT INTO `filters` VALUES (6, 4, 'school1', -73.980000, 40.750000, 1000, '1971-01-01 00:00:00', '2100-01-01 23:59:59', NULL, NULL, 0, 0, NULL, NULL, NULL);
INSERT INTO `filters` VALUES (7, 4, 'test', -73.986556, 40.694055, 1000, '1971-01-01 00:00:00', '2100-01-01 23:59:59', NULL, NULL, 0, 0, NULL, NULL, NULL);
INSERT INTO `filters` VALUES (8, 5, 'freeTicket', -73.964367, 40.672176, 1000, '1971-01-01 00:00:00', '2100-01-01 23:59:59', 'nap', NULL, 0, 0, NULL, NULL, NULL);
INSERT INTO `filters` VALUES (9, 5, 'lunch', -73.987541, 40.692918, 2000, '2018-01-01 11:30:00', '2018-01-01 14:00:00', 'school', '#food', 1, 0, '2018-01-01 00:00:00', '2019-12-31 00:00:00', 0);
INSERT INTO `filters` VALUES (10, 10, 'seekFood', -73.989558, 40.694404, 2000, '2018-01-01 11:00:00', '2018-01-01 23:59:00', NULL, '#food', 1, 0, '2018-12-20 00:00:00', '2019-12-31 00:00:00', 0);
INSERT INTO `filters` VALUES (11, 1, 'tour', -73.994708, 40.704360, 500, '1971-01-01 00:00:00', '2100-01-01 23:59:59', 'tour', '#tour', 0, 0, NULL, NULL, NULL);
INSERT INTO `filters` VALUES (12, 12, 'FriendParty', -73.989859, 40.669312, 1000, '2018-12-20 00:00:00', '2018-12-31 23:59:59', NULL, NULL, 0, 1, NULL, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for friend_relation
-- ----------------------------
DROP TABLE IF EXISTS `friend_relation`;
CREATE TABLE `friend_relation` (
  `uid1` int(11) NOT NULL,
  `uid2` int(11) NOT NULL,
  KEY `uid1` (`uid1`),
  KEY `uid2` (`uid2`),
  CONSTRAINT `friend_relation_ibfk_1` FOREIGN KEY (`uid1`) REFERENCES `user` (`uid`) ON DELETE CASCADE,
  CONSTRAINT `friend_relation_ibfk_2` FOREIGN KEY (`uid2`) REFERENCES `user` (`uid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of friend_relation
-- ----------------------------
BEGIN;
INSERT INTO `friend_relation` VALUES (1, 4);
INSERT INTO `friend_relation` VALUES (1, 5);
INSERT INTO `friend_relation` VALUES (1, 6);
INSERT INTO `friend_relation` VALUES (2, 4);
INSERT INTO `friend_relation` VALUES (5, 6);
INSERT INTO `friend_relation` VALUES (1, 10);
INSERT INTO `friend_relation` VALUES (9, 1);
INSERT INTO `friend_relation` VALUES (2, 10);
COMMIT;

-- ----------------------------
-- Table structure for friend_request
-- ----------------------------
DROP TABLE IF EXISTS `friend_request`;
CREATE TABLE `friend_request` (
  `from_whom` int(11) NOT NULL,
  `to_whom` int(11) NOT NULL,
  `frstatus` int(11) NOT NULL,
  `ftime` datetime NOT NULL,
  KEY `from_whom` (`from_whom`),
  KEY `to_whom` (`to_whom`),
  CONSTRAINT `friend_request_ibfk_1` FOREIGN KEY (`from_whom`) REFERENCES `user` (`uid`) ON DELETE CASCADE,
  CONSTRAINT `friend_request_ibfk_2` FOREIGN KEY (`to_whom`) REFERENCES `user` (`uid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of friend_request
-- ----------------------------
BEGIN;
INSERT INTO `friend_request` VALUES (1, 3, 1, '2018-11-15 11:55:00');
INSERT INTO `friend_request` VALUES (1, 2, 2, '2018-11-15 11:55:00');
INSERT INTO `friend_request` VALUES (1, 4, 2, '2018-11-15 11:55:00');
INSERT INTO `friend_request` VALUES (1, 5, 2, '2018-11-15 11:55:00');
INSERT INTO `friend_request` VALUES (1, 6, 2, '2018-11-15 11:55:00');
INSERT INTO `friend_request` VALUES (2, 3, 1, '2018-11-15 11:55:00');
INSERT INTO `friend_request` VALUES (2, 4, 2, '2018-11-15 11:55:00');
INSERT INTO `friend_request` VALUES (5, 6, 2, '2018-11-15 11:55:00');
INSERT INTO `friend_request` VALUES (1, 10, 2, '2018-12-09 15:00:00');
INSERT INTO `friend_request` VALUES (9, 1, 2, '2018-12-12 23:00:00');
INSERT INTO `friend_request` VALUES (12, 1, 1, '2018-12-10 03:37:14');
INSERT INTO `friend_request` VALUES (2, 10, 2, '2018-12-09 11:11:11');
COMMIT;

-- ----------------------------
-- Table structure for n_tag
-- ----------------------------
DROP TABLE IF EXISTS `n_tag`;
CREATE TABLE `n_tag` (
  `nid` int(11) NOT NULL,
  `ntag` varchar(45) NOT NULL,
  KEY `nid` (`nid`),
  CONSTRAINT `n_tag_ibfk_1` FOREIGN KEY (`nid`) REFERENCES `note` (`nid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of n_tag
-- ----------------------------
BEGIN;
INSERT INTO `n_tag` VALUES (1, '#eat1');
INSERT INTO `n_tag` VALUES (1, '#eat2');
INSERT INTO `n_tag` VALUES (2, '#nice trip1');
INSERT INTO `n_tag` VALUES (4, '#work1');
INSERT INTO `n_tag` VALUES (6, '#girlfriend');
INSERT INTO `n_tag` VALUES (7, 'eat1');
INSERT INTO `n_tag` VALUES (8, '#work2');
INSERT INTO `n_tag` VALUES (8, '#girlfriend');
INSERT INTO `n_tag` VALUES (9, '#work1');
INSERT INTO `n_tag` VALUES (9, '#nice trip1');
INSERT INTO `n_tag` VALUES (10, '#Restaurant');
INSERT INTO `n_tag` VALUES (11, '#Lunch');
INSERT INTO `n_tag` VALUES (12, '#bar');
INSERT INTO `n_tag` VALUES (13, '#Tour');
INSERT INTO `n_tag` VALUES (14, '#Party');
INSERT INTO `n_tag` VALUES (15, '#Christmas');
INSERT INTO `n_tag` VALUES (17, '#ticket');
INSERT INTO `n_tag` VALUES (19, '#food');
INSERT INTO `n_tag` VALUES (20, '#sale');
INSERT INTO `n_tag` VALUES (21, '#luck');
COMMIT;

-- ----------------------------
-- Table structure for note
-- ----------------------------
DROP TABLE IF EXISTS `note`;
CREATE TABLE `note` (
  `nid` int(11) NOT NULL,
  `ncontent` text NOT NULL,
  `uid` int(11) NOT NULL,
  `nlongitude` decimal(18,6) NOT NULL,
  `nlatitude` decimal(18,6) NOT NULL,
  `nradius` int(11) NOT NULL,
  `is_comment` tinyint(1) NOT NULL,
  `ntime` datetime NOT NULL,
  `nstart_time` datetime NOT NULL,
  `nend_time` datetime NOT NULL,
  `nrepeat_type` int(11) NOT NULL,
  `limit_view` int(11) NOT NULL,
  `nstart_date` datetime DEFAULT NULL,
  `nend_date` datetime DEFAULT NULL,
  `nrepeat_date` int(11) DEFAULT NULL,
  PRIMARY KEY (`nid`),
  KEY `uid` (`uid`),
  FULLTEXT KEY `ncontent` (`ncontent`),
  CONSTRAINT `note_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of note
-- ----------------------------
BEGIN;
INSERT INTO `note` VALUES (1, 'this is a test1 in time square by Bob(1) ', 1, -73.987190, 40.756039, 100, 1, '2018-11-15 11:55:00', '2018-11-15 12:00:00', '2018-11-15 14:00:00', 0, 0, NULL, NULL, NULL);
INSERT INTO `note` VALUES (2, 'this is a test2 in time square by Bob(1).limit by friend keyword=travel', 1, -73.987190, 40.756039, 100, 1, '2018-11-15 11:55:00', '2018-11-15 12:00:00', '2018-11-15 14:00:00', 0, 1, NULL, NULL, NULL);
INSERT INTO `note` VALUES (3, 'this is a test3 in time square by Bob(1),limit by himself', 1, -73.987190, 40.756039, 100, 1, '2018-11-15 11:55:00', '2018-11-15 12:00:00', '2018-11-15 14:00:00', 0, 2, NULL, NULL, NULL);
INSERT INTO `note` VALUES (4, 'this is a test4 in time square by Sam(2).', 2, -73.987190, 40.756039, 100, 1, '2018-11-15 11:55:00', '2018-11-15 12:00:00', '2018-11-15 14:00:00', 0, 0, NULL, NULL, NULL);
INSERT INTO `note` VALUES (5, 'this is a test5 in time square by Sam(2),limit by friend', 2, -73.987190, 40.756039, 100, 1, '2018-11-15 11:55:00', '2018-11-15 12:00:00', '2018-11-15 14:00:00', 0, 1, NULL, NULL, NULL);
INSERT INTO `note` VALUES (6, 'this is a test6 in time square by Sam(2),limit by himself', 2, -73.987190, 40.756039, 100, 1, '2018-11-15 11:55:00', '2018-11-15 12:00:00', '2018-11-15 14:00:00', 0, 2, NULL, NULL, NULL);
INSERT INTO `note` VALUES (7, 'this is a test7 in Washington square by Bob(1). ', 1, -73.997227, 40.730529, 100, 1, '2018-11-15 12:00:00', '2018-11-15 12:00:00', '2018-11-15 14:00:00', 0, 0, NULL, NULL, NULL);
INSERT INTO `note` VALUES (8, 'this is a test8 in tandon by Bob(1). ', 1, -73.986556, 40.694055, 100, 1, '2018-11-15 12:05:00', '2018-11-15 12:00:00', '2018-11-15 14:00:00', 0, 0, NULL, NULL, NULL);
INSERT INTO `note` VALUES (9, 'this is a test9 in tandon by Bob(1). limit by friend,keyword=travel', 1, -73.986556, 40.694055, 100, 1, '2018-11-15 12:05:00', '2018-11-15 12:00:00', '2018-11-15 14:00:00', 0, 1, NULL, NULL, NULL);
INSERT INTO `note` VALUES (10, 'Our happy hour menu updated, walk by and see what new we have. ', 1, -73.986310, 40.691716, 1000, 1, '2018-12-09 15:00:00', '2018-12-09 00:00:00', '2018-12-31 23:59:59', 0, 0, NULL, NULL, NULL);
INSERT INTO `note` VALUES (11, 'Check lunch!', 11, -73.986556, 40.694055, 1000, 1, '2018-12-09 17:34:43', '2018-01-01 11:00:00', '2018-01-01 14:00:00', 1, 0, '2018-12-09 00:00:00', '2018-12-31 23:59:59', 0);
INSERT INTO `note` VALUES (12, 'Recommendation on this bar', 11, -73.989086, 40.691483, 500, 1, '2018-12-11 11:30:00', '2018-01-01 18:00:00', '2018-12-31 23:30:00', 0, 0, NULL, NULL, NULL);
INSERT INTO `note` VALUES (13, 'Beautiful view!', 2, -73.995223, 40.704474, 500, 1, '2018-12-09 10:00:00', '1971-01-01 00:00:00', '2100-01-01 23:59:59', 0, 1, NULL, NULL, NULL);
INSERT INTO `note` VALUES (14, 'There is a big PARTY!', 1, -73.988442, 40.668730, 1000, 1, '2018-12-12 11:30:00', '2018-12-12 11:30:00', '2018-12-12 23:59:00', 0, 1, NULL, NULL, NULL);
INSERT INTO `note` VALUES (15, 'Our school will have free food for Christmas.', 9, -73.980517, 40.690856, 1000, 1, '2018-12-23 23:50:00', '2018-12-20 00:00:00', '2018-12-24 23:59:59', 0, 1, NULL, NULL, NULL);
INSERT INTO `note` VALUES (17, 'Every month free tickets. On the first day of month.', 5, -73.963509, 40.670891, 1000, 1, '2018-12-10 00:00:00', '2018-01-01 10:00:00', '2018-01-01 17:00:00', 3, 0, '2018-12-10 00:00:00', '2019-12-31 23:59:59', 1);
INSERT INTO `note` VALUES (19, 'Chinese food at there is excellent ', 5, -73.988099, 40.693143, 1000, 1, '2018-12-10 12:30:00', '2018-01-01 11:00:00', '2018-01-01 14:30:00', 1, 0, '2018-01-01 00:00:00', '2019-12-31 23:59:59', 0);
INSERT INTO `note` VALUES (20, 'Monday Sale!', 12, -74.013677, 40.671966, 1000, 1, '2018-12-16 13:00:00', '2018-01-01 10:00:00', '2018-01-01 17:00:00', 2, 0, '2018-01-01 00:00:00', '2019-12-31 23:59:59', 2);
INSERT INTO `note` VALUES (21, 'I find one buck at there', 2, -73.986522, 40.703168, 500, 0, '2018-12-12 00:12:12', '1971-01-01 00:00:00', '2100-01-01 23:59:59', 0, 2, NULL, NULL, NULL);
INSERT INTO `note` VALUES (22, '123', 1, -73.981791, 40.691093, -1, 0, '2018-12-10 11:11:11', '1971-01-01 00:00:00', '2100-01-01 23:59:59', 0, 0, NULL, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `uid` int(11) NOT NULL,
  `uname` varchar(45) NOT NULL,
  `uemail` varchar(45) NOT NULL,
  `upwd` varchar(45) NOT NULL,
  `ustatus` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of user
-- ----------------------------
BEGIN;
INSERT INTO `user` VALUES (1, 'bob', '1234567@gmail.com', '123456', 'work');
INSERT INTO `user` VALUES (2, 'Sam', '1111111@gmail.com', '111111', 'work');
INSERT INTO `user` VALUES (3, 'Mike', '2222222@gmail.com', '111111', 'nap');
INSERT INTO `user` VALUES (4, 'Trump', '3333333@gmail.com', '111111', 'work');
INSERT INTO `user` VALUES (5, 'John', '4444444@gmail.com', '111111', 'school');
INSERT INTO `user` VALUES (6, 'Joker', '5555555@gmail.com', '222222', 'dinner');
INSERT INTO `user` VALUES (9, 'teriyaki', 'tryk@jp.com', '123456', NULL);
INSERT INTO `user` VALUES (10, 'linda', 'linda@gmail.com', 'linda', 'offline');
INSERT INTO `user` VALUES (11, 'Restaurant 1', 'rs@gmail.com', '123456', NULL);
INSERT INTO `user` VALUES (12, 'niko', 'niko@gmail', 'niko123', NULL);
COMMIT;

-- ----------------------------
-- View structure for latest_action
-- ----------------------------
DROP VIEW IF EXISTS `latest_action`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `latest_action` AS select `actions`.`aid` AS `aid`,`actions`.`uid` AS `uid`,`actions`.`alongitude` AS `alongitude`,`actions`.`alatitude` AS `alatitude`,`actions`.`atime` AS `atime` from `actions` where (`actions`.`uid`,`actions`.`aid`) in (select `actions`.`uid`,max(`actions`.`aid`) from `actions` group by `actions`.`uid`);

-- ----------------------------
-- Function structure for getdistance
-- ----------------------------
DROP FUNCTION IF EXISTS `getdistance`;
delimiter ;;
CREATE FUNCTION `final`.`getdistance`(lat1 decimal(18,6), lon1 decimal(18,6),
        lat2 decimal(18,6), lon2 decimal(18,6))
 RETURNS float
  NO SQL 
  DETERMINISTIC
BEGIN

    RETURN 6373000*(ACOS(COS(RADIANS(lat1)) *COS(RADIANS(lat2)) *COS(RADIANS(lon2) - RADIANS(lon1)) +SIN(RADIANS(lat1)) * SIN(RADIANS(lat2))
            ));

END
;;
delimiter ;

-- ----------------------------
-- Function structure for pulas
-- ----------------------------
DROP FUNCTION IF EXISTS `pulas`;
delimiter ;;
CREATE FUNCTION `final`.`pulas`(lat1 INT, lon1 int)
 RETURNS int(11)
  NO SQL 
  DETERMINISTIC
BEGIN

    RETURN lat1+lon1;

END
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
