package com.ipaynow.utils;

/**
 * @author zhaoxc
 *
 */
public class SignatureTest {

	/**
	 * @param args
	 */
	public static void main(String[] args) {
		//客户原始报文
		String originReport = "appId=1425023908538242&frontNotifyUrl=http://api3.qcwan.com/order/now/front&mhtCharset=UTF-8&mhtCurrencyType=156&mhtOrderAmt=1000&mhtOrderDetail=为你的安锋账号充值10元&mhtOrderName=10安锋币&mhtOrderNo=e128e34a8ec84eeab7c32025c9725ea8&mhtOrderStartTime=20140406111529&mhtOrderType=01&mhtSignType=MD5&notifyUrl=http://api3.qcwan.com/order/now/callback&payChannelType=11";
		//客户密钥
		String key = "bvSggsUw73wVhYW3ypntq9Lh3mPqID0p";
		
		//待签名字符串
		String toMd5Report = "";
		//签名结果

	}

}
