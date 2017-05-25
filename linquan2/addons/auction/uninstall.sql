DROP TABLE IF EXISTS `lqsj_auctions`;
DROP TABLE IF EXISTS `lqsj_auction_logs`;
DROP TABLE IF EXISTS `lqsj_auction_moneys`;
delete from `lqsj_datas` where dataVal='AUCTION_GOODS_ALLOW';
delete from `lqsj_datas` where dataVal='AUCTION_GOODS_REJECT';
delete from `lqsj_datas` where dataVal='WX_AUCTION_GOODS_ALLOW';
delete from `lqsj_datas` where dataVal='WX_AUCTION_GOODS_REJECT';
delete from `lqsj_datas` where dataVal='AUCTION_USER_RESULT';
delete from `lqsj_datas` where dataVal='AUCTION_SHOP_RESULT';
delete from `lqsj_datas` where dataVal='WX_AUCTION_USER_RESULT';
delete from `lqsj_datas` where dataVal='WX_AUCTION_SHOP_RESULT';

delete from `lqsj_template_msgs` where tplCode='AUCTION_GOODS_ALLOW';
delete from `lqsj_template_msgs` where tplCode='AUCTION_GOODS_REJECT';
delete from `lqsj_template_msgs` where tplCode='WX_AUCTION_GOODS_ALLOW';
delete from `lqsj_template_msgs` where tplCode='WX_AUCTION_GOODS_REJECT';
delete from `lqsj_template_msgs` where tplCode='AUCTION_USER_RESULT';
delete from `lqsj_template_msgs` where tplCode='AUCTION_SHOP_RESULT';
delete from `lqsj_template_msgs` where tplCode='WX_AUCTION_USER_RESULT';
delete from `lqsj_template_msgs` where tplCode='WX_AUCTION_SHOP_RESULT';

delete from `lqsj_crons` where croncode='autoAuctionEnd';
delete from `lqsj_navs` where navUrl='index.php/addon/auction-goods-lists.html';