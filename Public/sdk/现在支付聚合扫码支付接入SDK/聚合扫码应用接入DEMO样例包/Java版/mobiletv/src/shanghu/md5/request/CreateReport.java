package shanghu.md5.request;

import com.ipaynow.utils.MD5;
import com.ipaynow.utils.MD5Facade;
import com.ipaynow.utils.URLUtils;

public class CreateReport {

	public static String doMd5(String toMd5Str,String key){
		String mhtSignature = "";
		try {
			System.out.println("toMdtString=" + toMd5Str);
			String securityKeyMD5 = MD5.md5(key,"");
			System.out.println("加密后密钥=" + securityKeyMD5);
			toMd5Str=toMd5Str+"&" + securityKeyMD5;
			System.out.println("待签名字符串:" + toMd5Str);
			 mhtSignature = MD5.md5(toMd5Str, "UTF-8");
			 System.out.println("签名结果:mhtSignature=" + mhtSignature);
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return mhtSignature;
	}
	
	public static void urlDecodeReport(String originString){
		System.out.println(URLUtils.urldecode(originString, "UTF-8"));
	}
	
	/**
	 * @param args
	 */
	public static void main(String[] args) {
		String  key= "I2Amkip6V4gRCtgNRQ9qM3kT7LdRK6So";
		String toMd5Str  = "appId=1426229942501339&mhtCharset=UTF-8&mhtCurrencyType=156&mhtOrderAmt=1&mhtOrderDetail=我爱撕名牌-Baby&mhtOrderName=我爱撕名牌-Baby&mhtOrderNo=128&mhtOrderStartTime=20150313151716&mhtOrderTimeOut=3600&mhtOrderType=01&notifyUrl=http://youline.com.cn/index.php/api/Weixin/result&payChannelType=13";
		doMd5(toMd5Str,key);
		
		//String origniString = "appId%3D1423708943726208%26consumerId%3D1%26consumerName%3D%E4%BE%AF%E6%96%87%E5%AF%8C%26mhtCharset%3DUTF-8%26mhtCurrencyType%3D156%26mhtOrderAmt%3D100%26mhtOrderDetail%3D%E5%85%B3%E4%BA%8E%E8%AE%A2%E5%8D%95%E9%AA%8C%E8%AF%81%E6%8E%A5%E5%8F%A3%E7%9A%84%E6%B5%8B%E8%AF%95%26mhtOrderName%3D%E5%A9%9A%E8%BD%A6%E6%9D%A5%E5%95%A6%E8%AE%A2%E5%8D%95%E6%94%AF%E4%BB%98%26mhtOrderNo%3D1000001%26mhtOrderStartTime%3D20150213120419%26mhtOrderTimeOut%3D3600%26mhtOrderType%3D01%26mhtReserved%3Dtest%26notifyUrl%3Dhttp%3A%2F%2Fwww.hunchelaila.com%2FIndex%2FnowPayCallback";
		//urlDecodeReport(origniString);
	}
	
	

}
