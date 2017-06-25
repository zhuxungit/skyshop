/*管理员表*/
DROP TABLE if EXISTS y2_admin;
CREATE TABLE if NOT EXISTS `y2_admin`(
  adminid int unsigned not NULL auto_increment COMMENT '主键id',
  adminuser VARCHAR(32) NOT NULL DEFAULT '' COMMENT '管理员账号',
  adminpass CHAR(32) NOT NULL DEFAULT '' COMMENT '管理员密码',
  adminemail VARCHAR(50) NOT NULL DEFAULT '' COMMENT '管理员邮箱',
  loginip BIGINT NOT NULL DEFAULT '0' COMMENT '登录ip',
  createtime int UNSIGNED not NULL DEFAULT '0' COMMENT '管理员创建时间',
  PRIMARY KEY (adminid),
  UNIQUE  y2_admin_adminuser_adminpass(adminuser,adminpass),
  UNIQUE  y2_admin_adminuser_adminemail(adminuser,adminemail)
)engine=innodb CHARSET=utf8;

INSERT INTO y2_admin (adminuser,adminpass,adminemail,createtime) VALUES ('admin',md5('123456'),'test@shop.com',unix_timestamp());

/*会员表*/
DROP TABLE if EXISTS y2_user;
CREATE TABLE IF NOT EXISTS y2_user(
  userid BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键id',
  username VARCHAR(32) NOT NULL DEFAULT '' COMMENT '用户名',
  userpass CHAR(32) NOT NULL DEFAULT '' COMMENT '用户密码',
  useremail VARCHAR(100) NOT NULL DEFAULT '' COMMENT '用户邮箱',
  createtime INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  PRIMARY KEY (userid),
  UNIQUE y2_user_username_userpass(username,userpass),
  UNIQUE y2_user_useremail_userpass(username,userpass)
)ENGINE = innodb CHARSET = utf8;

/*会员的详细信息*/
DROP TABLE IF EXISTS y2_profile;
CREATE TABLE IF NOT EXISTS y2_profile(
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键id',
  truename VARCHAR(32) NOT NULL DEFAULT '' COMMENT '真实姓名',
  age TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '年龄',
  sex TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '性别0-保密1-男2-女',
  birthday date NOT NULL DEFAULT '2016-1-1' COMMENT '生日',
  nickname VARCHAR(32) DEFAULT '' COMMENT '昵称',
  company VARCHAR(100) DEFAULT '' COMMENT '公司',
  userid BIGINT UNSIGNED NOT NULL COMMENT '用户id',
  createtime int UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  PRIMARY KEY (id),
  UNIQUE y2_profile_userid(userid)
)ENGINE = innodb DEFAULT CHARSET = utf8;

/*商品分类*/
DROP TABLE IF EXISTS  y2_category;
CREATE TABLE if NOT EXISTS y2_category(
  cateid BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键id',
  title VARCHAR(32) NOT NULL DEFAULT '' COMMENT '商品名',
  parentid BIGINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '父类id',
  create_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  PRIMARY KEY (cateid),
  KEY y2_category_parentid(parentid)

)ENGINE = innodb DEFAULT CHARSET = utf8 COMMENT='商品分类';

DROP TABLE IF EXISTS y2_product;
CREATE TABLE IF NOT EXISTS y2_product(
  productid BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键id',
  cateid BIGINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '分类id',
  title VARCHAR(200) NOT NULL DEFAULT '' COMMENT '商品名册',
  descr TEXT,
  num BIGINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '商品库存',
  price DECIMAL(10,2) NOT NULL DEFAULT '00.00' COMMENT '商品价格',
  cover VARCHAR(200) NOT NULL DEFAULT '' COMMENT '商品封面图片',
  pics TEXT,
  issale TINYINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否上架0下架1上架',
  saleprice DECIMAL(10,2) NOT NULL DEFAULT '00.00' COMMENT '商品售价',
  ishot TINYINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否热销0非热销1热销',
  createtime INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '商品创建时间',
  PRIMARY KEY (productid),
  KEY y2_product_cateid(cateid)
)ENGINE = innodb DEFAULT CHARSET = utf8 COMMENT = '商品表';

