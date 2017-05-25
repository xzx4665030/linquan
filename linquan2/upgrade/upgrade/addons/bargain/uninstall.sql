DROP TABLE IF EXISTS `lqsj_bargains`;
DROP TABLE IF EXISTS `lqsj_bargain_users`;
DROP TABLE IF EXISTS `lqsj_bargain_helps`;
delete from `lqsj_datas` where dataVal='BARGAIN_GOODS_ALLOW';
delete from `lqsj_datas` where dataVal='BARGAIN_GOODS_REJECT';
delete from `lqsj_datas` where dataVal='WX_BARGAIN_GOODS_ALLOW';
delete from `lqsj_datas` where dataVal='WX_BARGAIN_GOODS_REJECT';

delete from `lqsj_template_msgs` where tplCode='BARGAIN_GOODS_ALLOW';
delete from `lqsj_template_msgs` where tplCode='BARGAIN_GOODS_REJECT';
delete from `lqsj_template_msgs` where tplCode='WX_BARGAIN_GOODS_ALLOW';
delete from `lqsj_template_msgs` where tplCode='WX_BARGAIN_GOODS_REJECT';

delete from `lqsj_ad_positions` where positionCode='wx-ads-bargain';
delete a from `lqsj_ads` a left join `lqsj_ad_positions` ap on ap.positionId=a.adPositionId where ap.positionCode='wx-ads-bargain';

