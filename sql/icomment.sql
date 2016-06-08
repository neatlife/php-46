-- icomment表：

-- 原始写法
-- 用户 用户名 varchar(20)
-- 用户 用户的头像
-- 用户的邮箱等信息...

-- 更简单的写法：
-- 主键 id 数字 不能为空 没有默认值
-- 用户 用户的id
-- 发布时间 datetime
-- 发布时间 更灵活的时间类型 INT 时间戳
-- 评论内容 字符串 varchar(200) 200不是固定的，适量调整
-- 回复的是那个评论 reply_id 数字 如果不评论不回复另一个评论 reply_id应该找不到回复的评论, 默认空（空数字 0）
-- 评论是评论的那一个文章呢？文章的id 数字 不能为空 没有默认值

CREATE TABLE `icomment` (
  `id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `publish_time` INT NOT NULL,
  `content` varchar(200) NOT NULL,
  `reply_id` INT UNSIGNED NOT NULL DEFAULT 0,
  `article_id` INT NOT NULL
)engine=innodb DEFAULT CHARSET utf8;

insert into icomment values
(null, 1, 0, '萌萌哒，今天天气很好。', 19, 513),
(null, 1, 0, '萌萌哒', 0, 513),
(null, 1, 0, '萌萌哒', 0, 513),
(null, 1, 0, '萌萌哒', 0, 513),
(null, 1, 0, '萌萌哒', 0, 513),
(null, 1, 0, '萌萌哒', 0, 1),
(null, 1, 0, '萌萌哒', 0, 1),
(null, 1, 0, '萌萌哒', 0, 1),
(null, 1, 0, '萌萌哒', 0, 1),
(null, 1, 0, '萌萌哒', 0, 1),
(null, 1, 0, '萌萌哒', 0, 1),
(null, 1, 0, '萌萌哒', 0, 1),
(null, 1, 0, '萌萌哒', 0, 1),
(null, 1, 0, '萌萌哒', 0, 1),
(null, 1, 0, '萌萌哒', 0, 1),
(null, 1, 0, '萌萌哒', 0, 1),
(null, 1, 0, '萌萌哒', 0, 1);

select icomment.*, article.name as article_name, user.username as user_name, ic.content as reply_content from icomment left join article on icomment.article_id=article.id left join user on icomment.user_id=user.id left join icomment ic on icomment.reply_id=ic.id