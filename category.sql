-- 分类的名称 字符串 varchar(20)
-- 分类的别名 字符串 varchar(10)
-- 分类的排序 数字 和id字段类型一致，int
-- 分类的父类 数字 保存一个id INT UNSIGNED

CREATE TABLE `category` (
  `id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(20) NOT NULL,
  `alias` VARCHAR(10) NOT NULL DEFAULT '',
  `sort` INT UNSIGNED NOT NULL DEFAULT 0,
  `parent_id` INT UNSIGNED NOT NULL DEFAULT 0
)engine=innodb DEFAULT CHARSET utf8;


-- 插入数据
insert into category (id, name, alias, parent_id, sort) values
  (null,'科技','',0,50), -- 1
  (null,'武侠','',0,50), -- 2
  (null,'旅游','',0,50), -- 3
  (null,'美食','',0, 50), -- 4
  (null,'IT','',1,50),   -- 5
  (null,'生物','',1,50), -- 6
  (null,'鸟类','',6,50), -- 7
  (null,'湘菜','',4,50), -- 8
  (null,'粤菜','',4,50), -- 9
  (null,'川菜','',4,50), -- 10
  (null,'跳跳蛙','',8,50), -- 11
  (null,'口味虾','',8,50), -- 12
  (null,'臭豆腐','',8,50), -- 13
  (null,'白切鸡','',9,50), -- 14
  (null,'隆江猪脚','',9,50); -- 15