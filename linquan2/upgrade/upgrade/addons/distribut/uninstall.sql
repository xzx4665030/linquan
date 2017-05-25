
alter table `lqsj_goods` drop column isDistribut;
alter table `lqsj_goods` drop column commission;

alter table `lqsj_shop_configs` drop column isDistribut;
alter table `lqsj_shop_configs` drop column distributType;
alter table `lqsj_shop_configs` drop column distributOrderRate;

alter table `lqsj_orders` drop column distributType;
alter table `lqsj_orders` drop column distributOrderRate;
alter table `lqsj_orders` drop column distributRate;
alter table `lqsj_orders` drop column totalCommission;

alter table `lqsj_order_goods` drop column commission;

alter table `lqsj_users` drop column distributMoney;
alter table `lqsj_users` drop column isBuyer;


DROP TABLE IF EXISTS `lqsj_distribut_moneys`;
DROP TABLE IF EXISTS `lqsj_distribut_users`;

delete from `lqsj_navs` where navUrl='index.php/addon/distribut-goods-glist';