<?php 
namespace wstmart\home\validate;
use think\Validate;
/**
 
 * 店铺验证器
 */
class Shops extends Validate{
	protected $rule = [
        ['shopImg'  ,'require','请上传店铺图标'],
        ['isInvoice'  ,'in:0,1','无效的发票类型'],
        ['invoiceRemarks','checkInvoiceRemark:1','请输入发票说明'],
        ['serviceStartTime','require','请选择服务时间'],
        ['serviceEndTime','require','请选择服务时间'],
        ['freight','integer','请输入运费'],
        ['bankId'  ,'require','请选择结算银行'],
        ['bankAreaId'  ,'require','请选择开户所地区'],
        ['bankNo'  ,'require','请选择银行账号'],
        ['bankUserName'  ,'require|max:100','请输入持卡人名称|持卡人名称长度不能能超过50个字符']
    ];

    protected $scene = [
        'editInfo'   =>  ['shopImg','isInvoice','serviceStartTime','serviceEndTime','freight'],
        'editBank'  =>  ['bankId','bankAreaId','bankNo','bankUserName']
    ]; 
    
    protected function checkInvoiceRemark($value){
    	$isInvoice = Input('post.isInvoice/d',0);
    	$key = Input('post.invoiceRemarks');
    	return ($isInvoice==1 && $key=='')?'请输入发票说明':true;
    }
}