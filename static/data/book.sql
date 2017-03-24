SET NAMES UTF8;
DROP DATABASE IF EXISTS bookvue;
CREATE DATABASE bookvue CHARSET=UTF8;
use bookvue;
CREATE TABLE books(
bid INT PRIMARY KEY AUTO_INCREMENT,
name VARCHAR(512),
img_sm VARCHAR(128),
img_lg VARCHAR(128),
author VARCHAR(64),
publish  VARCHAR(128),
star INT,
comment INT,
newprice FLOAT(6,2),
oldprice FLOAT(6,2),
introduction VARCHAR(2048)
);
INSERT INTO books VALUES
(NULL,'拉普拉斯的魔女（东野圭吾的人性实验室：《解忧杂货店》之后，回归推理之作。）','24157996-1_b_2.jpg','24157996-1_e_2.jpg;24157996-2_e_2.jpg','(日) 东野圭吾著 王蕴洁译','北京联合出版公司，2017年01月','5','542','27.90','39.80','角川书店70周年、东野圭吾作家生涯30周年纪念作品。 东野圭吾：“我想摧毁自己以前写的小说，于是，这部作品就此诞生。”'),
(NULL,'走在有光的路上','24146240-1_b.jpg','24146240-1_e_7.jpg;24146240-2_e_8.jpg;24146240-4_e_8.jpg','王义博','中国友谊出版公司','5','1482','19.50','25.50','(专享签名本+寄语+3张明信片+预售期间还有惊喜大礼等你呦）苑子文、苑子豪、卢思浩、邹市明、冉莹颖推荐。90后知名摄影师王义博首部图文集。特别收录《爸爸去哪儿》摄影经历+欧洲旅行日志+超值摄影教程。'),
(NULL,'巨婴国：武志红2016年新书力作','24135106-1_b_14.jpg','24135106-1_e_14.jpg;24135106-2_e_15.jpg;24135106-3_e_15.jpg','武志红 ','浙江人民出版社，2016年12月','5','23','40.00','58.00','（知名心理学家武志红思索21年书写5年的重要作品，系统透视中国国民性。曾奇峰、岳敏君、罗振宇、张德芬、高铭阅后叹服推荐。）'),
(NULL,'我不过低配的人生','24035034-1_b.jpg','24035034-1_e_27.jpg;24035034-3_e_14.jpg;24035034-4_e_10.jpg','雾满拦江 著 ','中国友谊出版社','5','7749','19.50','30.50','知名作家雾满拦江力作！俞敏洪、罗振宇联合推荐！够犀利、够辛辣，一本可以下酒的智慧之书。在你看不到的地方，有一双慧眼，为你拭去迷惑；在你搞不懂的世界，有一盏明灯，带你穿越迷雾。'),
(NULL,'丝绸之路：一部全新的世界史（关心国家战略，一带一路必读书）','24017630-1_b.jpg','24017630-1_e_12.jpg;24017630-3_e_22.jpg','[英]彼得.弗兰科潘 (Peter Frankopan) 著，邵旭东，孙芳 译，徐文堪 审校','浙江大学出版社','5','6356','62.70','102.50','轰动世界的现象级畅销书，横扫英国、美国、德国、意大利、土耳其、印度等23个国家。《人民日报》19天内罕见两度推荐。牛津大学资深历史学家全新视角解读世界史，理清“一带一路”的前世今生！读客出品'),
(NULL,'跟美国儿科医生学育儿','24157035-1_b.jpg','24157035-1_e_1.jpg;24157035-2_e_3.jpg','大J 著 ','中国妇女出版社','4','82','29.80','40.20','*有温度的育儿公众号“大J小D”重磅力作；李一诺、陈一佳、倪明辉联合感动推荐；50万粉丝信赖的育儿科普知识；做学习型和知识型妈妈，让宝宝和妈妈都遇见更好的自己。'),
(NULL,'此刻花开（一本精美绝伦的手工纸雕书）','24134991-1_b.jpg','24134991-1_e_6.jpg;24134991-2_e_5.jpg','徐静','百花洲文艺出版社','5','952','33.30','50.00','一场轻松自由的创作体验！风靡全球的纸雕艺术，比《秘密花园》更给力的减压新玩法。虽然我们不断被这个世界雕刻着，但我们亦可以雕刻出一个世界！随书附赠手工刻刀和雕刻垫板。酷威文化'),
(NULL,'《太空》手绘百科绘本','24102036-1_b.jpg','24102036-1_e_6.jpg;24102036-2_e_6.jpg','【波】亚历山德拉·米热林斯卡，丹尼尔·米热林斯基 著，乌兰 刘博洋 译','贵州人民出版社','5','334','33.30','42.70','《地图（人文版）》《地下水下》作者又一重磅力作。浩瀚宇宙万千奇观，《太空》带你探索发现！本书献给喜欢仰望星空的少年科学家和梦想家！陆海空三部曲，引领儿童科普阅读！（蒲公英童书馆）新书特惠限时4.9折抢'),
(NULL,'我与世界只差一个你（亲笔签名卡片精装版）','24157237-1_b.jpg','24157237-1_e_2.jpg;24157237-2_e_3.jpg','张皓宸 ','天津人民出版社','3','8','31.90','45.20','张皓宸现象级畅销书百万纪念精装版。全新修订，新增暖心情话全彩拉页，致读者的手写感谢信，以及写真明信片。'),
(NULL,'晓松奇谈·世界卷','24143730-1_b.jpg','24143730-1_e_10.jpg','高晓松','湖南文艺出版社','5','14','22.10','30.80','高晓松*受欢迎脱口秀《晓松奇谈》未删减版完整收录 爱奇艺总播放量突破7亿次 开创脱口秀“大主题”模式 跟高晓松一起——奇闻说今古，谈笑有鸿儒。'),
(NULL,'哈利·波特与被诅咒的孩子（哈利波特8，随书限时独家赠送腾讯视频VIP会员电影卡，先到先得）（特例品，应出版社要求不参加促销，敬请理解）','24044345-1_b.jpg','24044345-1_e_5.jpg;24044345-2_e_5.jpg','J.K罗琳(英)约翰.蒂法尼&杰克.索恩(英)剧本','人民文学出版社','5','2074','53.80','80.50','随书赠送腾讯视频VIP会员！数量有限，先抢先得！哈利.波特系列第8个故事！ 中文版特别彩排剧本重榜上市！'),
(NULL,'灵魂摆渡人：重口味心理咨询实录','24058528-1_b.jpg','24058528-1_e_6.jpg;24058528-3_e_5.jpg','朱佳','文汇出版社 ','5','578','17.20','23.10','原中国现代文学馆馆长、散文名家 舒乙，社会学家、性学家 李银河，文学博士、文学评论家 王向东  联袂推荐'),
(NULL,'物种日历（果壳网物种日历，一本高颜值、涨知识的科普日历！）','24048673-1_b.jpg','24048673-1_e_18.jpg','果壳网','天地出版社','5','609','32.30','51.30','365天，每天一篇自然科普短文；53周，每周一幅生物手绘写真：每天一个物种，带你重新认识这个世界！与60万人共度酷炫科普的2017！'),
(NULL,'你的善良，请小心轻放','24143245-1_b.jpg','24143245-1_e_3.jpg','高瑞沣','台海出版社','5','79','15.70','26.60','只知善良不懂聪明，终将被自己蠢哭！文艺暖男高瑞沣犀利剖析人性，拆穿一切伪善，教你如何聪明地善良。写给那些对这个世界有些不知所措的你。');

#用户表
CREATE table book_user(
uid INT PRIMARY KEY AUTO_INCREMENT,
phone BIGINT,
upwd VARCHAR(64)
);
INSERT INTO book_user VALUES(NULL,'13760987293','123456');

#用户与购物车对应关系
CREATE table cart(
cid INT PRIMARY KEY AUTO_INCREMENT,
uid INT,
phone BIGINT
);
INSERT INTO cart VALUES(NULL,'1','13760987293');

#购物车表
CREATE table cartlist(
kid INT PRIMARY KEY AUTO_INCREMENT,
cid INT,
bid INT,
count INT,
single_price FLOAT(6,2),
selected INT
);
INSERT INTO cartlist VALUES('NULL','1','1','1','20','5');#5是选中，6是没选中
INSERT INTO cartlist VALUES('NULL','1','1','1','20','5');

#订单表
CREATE table book_order(
oid INT PRIMARY KEY AUTO_INCREMENT,
bid INT,
count INT,
address VARCHAR(256),
single_price FLOAT(6,2),
phone BIGINT
);

#用户信息表
CREATE table person_detail(
pid INT PRIMARY KEY AUTO_INCREMENT,
uid INT,
phone BIGINT,
nickname varchar(128),
email varchar(128)
);
INSERT INTO person_detail VALUES(NULL,'1','13760987293','Joshua','dwd555@qq.com');

#地址表
CREATE table address(
aid INT PRIMARY KEY AUTO_INCREMENT,
uid INT,
name varchar(64),
phone BIGINT,
address varchar(256),
choose INT
);
INSERT INTO address VALUES(NULL,1,'丁文东',13760987293,'佛山市禅城区','5');

#轮播表
CREATE table carousel(
cid INT PRIMARY KEY AUTO_INCREMENT,
src varchar(256)
);
INSERT INTO carousel VALUES
(NULL,"img/carousel/700x270_gr_12151.png"),
(NULL,"img/carousel/700x270gift_lyx_1218.jpg"),
(NULL,"img/carousel/1218-wx-y-700-270.jpg"),
(NULL,"img/carousel/wuxian-shoujiao-H5.jpg"),
(NULL,"img/carousel/ebook12166720270.jpg");

#图标表
CREATE TABLE icons(
id INT PRIMARY KEY AUTO_INCREMENT,
src varchar(256)
);
INSERT INTO icons VALUES
(NULL,"img/icon-list/android-icons_01.png"),
(NULL,"img/icon-list/android-icons_02.png"),
(NULL,"img/icon-list/android-icons_03.png"),
(NULL,"img/icon-list/android-icons_04.png"),
(NULL,"img/icon-list/android-icons_05.png"),
(NULL,"img/icon-list/android-icons_06.png"),
(NULL,"img/icon-list/android-icons_07.png"),
(NULL,"img/icon-list/android-icons_08.png"),
(NULL,"img/icon-list/android-icons_09.png"),
(NULL,"img/icon-list/android-icons_10.png");

#m我的订单表
CREATE TABLE myorder(
mid INT PRIMARY KEY AUTO_INCREMENT,
cid INT
bid INT,
count INT,
price FLOAT(6,2)
);