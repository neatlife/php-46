-- 192.168.1.1
-- 1.1.1.1
-- 255.255.255.255

-- signed 有符号的 + -
-- tinyint signed -127 ~ +128
-- tinyint unsigned 0 ~ 255
-- id 唯一表示一行记录
-- 用户名 字符串 char varchar(16)
-- 昵称 字符串 varchar(16)
-- 邮箱 字符串 varchar(64)
-- 上次登录时间 int unsigned 表示整数的时间戳 time()
-- 上次登录IP 字符串 varchar(15)

CREATE TABLE `user` (
  `id` INT UNSIGNED NOT NULL PRIMARY KEY auto_increment,
  `username` VARCHAR(16) NOT NULL,
  `nickname` VARCHAR(16) NOT NULL DEFAULT '',-- null值不能被mysql索引
  `email` VARCHAR(64) NOT NULL DEFAULT '',
  `last_login_time` INT UNSIGNED NOT NULL DEFAULT 0, -- 默认值0表示从来没有登录系统
  `last_login_ip` VARCHAR(15) NOT NULL DEFAULT ''
)engine=innodb DEFAULT CHARSET utf8;