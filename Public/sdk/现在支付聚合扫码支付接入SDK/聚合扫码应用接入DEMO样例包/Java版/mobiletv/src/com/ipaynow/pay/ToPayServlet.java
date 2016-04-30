package com.ipaynow.pay;

import java.io.IOException;
import java.io.InputStream;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.HashMap;
import java.util.Map;
import java.util.Properties;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import com.alibaba.fastjson.JSONObject;
import com.ipaynow.utils.FormDateReportConvertor;
import com.ipaynow.utils.HttpClientUtil;
import com.ipaynow.utils.HttpsClientWithoutCheckSSL;
import com.ipaynow.utils.MD5Facade;
import com.ipaynow.utils.URLUtils;

/**
 * 支付表单数据准备
 * 
 * @author christ
 * 
 */
public class ToPayServlet extends HttpServlet {

	private static final long serialVersionUID = -3240794927782965682L;

	@Override
	protected void doPost(HttpServletRequest req, HttpServletResponse resp)
			throws ServletException, IOException {
		
		//商户自己的订单数据
		String funcode = req.getParameter("funcode");
		String appId = req.getParameter("appId");
		String mhtOrderNo = System.currentTimeMillis()+"";
		String mhtOrderName = req.getParameter("mhtOrderName");
		String mhtCurrencyType = req.getParameter("mhtCurrencyType");
		String mhtOrderAmt = req.getParameter("mhtOrderAmt");
		String mhtOrderDetail = req.getParameter("mhtOrderDetail");
		String mhtOrderType = req.getParameter("mhtOrderType");
		SimpleDateFormat dateFormat = new SimpleDateFormat("yyyyMMddHHmmss");
		String mhtOrderStartTime = dateFormat.format(new Date());
		String notifyUrl = req.getParameter("notifyUrl");
		String frontNotifyUrl = req.getParameter("frontNotifyUrl");
		String mhtCharset = req.getParameter("mhtCharset");
		String deviceType = req.getParameter("deviceType");
		String payChannelType = req.getParameter("payChannelType");
		String appKey = req.getParameter("appKey");
		String mhtReserved = req.getParameter("mhtReserved");
		
		//做MD5签名
		Map<String, String> dataMap = new HashMap<String, String>();
		dataMap.put("appId", appId);
		dataMap.put("mhtOrderNo", mhtOrderNo);
		dataMap.put("mhtOrderName", mhtOrderName);
		dataMap.put("mhtCurrencyType", mhtCurrencyType);
		dataMap.put("mhtOrderAmt", mhtOrderAmt);
		dataMap.put("mhtOrderDetail", mhtOrderDetail);
		dataMap.put("mhtOrderType", mhtOrderType);
		dataMap.put("mhtOrderStartTime", mhtOrderStartTime);
		dataMap.put("notifyUrl", notifyUrl);
		dataMap.put("frontNotifyUrl", frontNotifyUrl);
		dataMap.put("mhtCharset", mhtCharset);
		dataMap.put("payChannelType", payChannelType);
		//商户保留域， 可以不用填。 如果商户有需要对每笔交易记录一些自己的东西，可以放在这个里面
		dataMap.put("mhtReserved", mhtReserved);
		String mhtSignature = MD5Facade.getFormDataParamMD5(dataMap, appKey, "UTF-8");
		if("08".equals(deviceType)){
			req.setAttribute("appId", appId);
			req.setAttribute("mhtOrderNo", mhtOrderNo);
			req.setAttribute("mhtOrderName", mhtOrderName);
			req.setAttribute("mhtCurrencyType", mhtCurrencyType);
			req.setAttribute("mhtOrderAmt", mhtOrderAmt);
			req.setAttribute("mhtOrderDetail", mhtOrderDetail);
			req.setAttribute("mhtOrderType", mhtOrderType);
			req.setAttribute("mhtOrderStartTime", mhtOrderStartTime);
			req.setAttribute("notifyUrl", notifyUrl);
			req.setAttribute("frontNotifyUrl", frontNotifyUrl);
			req.setAttribute("mhtCharset", mhtCharset);
			
			req.setAttribute("mhtSignType", "MD5");
			req.setAttribute("mhtSignature", mhtSignature);
			req.setAttribute("funcode", funcode);
			req.setAttribute("deviceType", deviceType);
			req.setAttribute("payChannelType", payChannelType);
			req.setAttribute("mhtReserved", mhtReserved);
			
			req.getRequestDispatcher("topay.jsp").forward(req, resp);		
		}
		else{
			dataMap.put("deviceType", deviceType);
			dataMap.put("payChannelType", payChannelType);
			dataMap.put("mhtReserved", mhtReserved);
			dataMap.put("funcode", funcode);
			dataMap.put("mhtSignType", "MD5");
			dataMap.put("mhtSignature", mhtSignature);
			scanCode(req,resp,dataMap);
		}
	}

	/**
	 * 获取付款二维码，并跳转的扫码页面
	 */
	private void scanCode(HttpServletRequest req, HttpServletResponse resp,
			Map<String, String> dataMap)
			throws ServletException, IOException {
//for(int i=0;i<100000;i++){
	
		//1.生成获取二维码的报文
		String scanCodeRequestReport = "";
		scanCodeRequestReport  = FormDateReportConvertor.postFormLinkReportWithURLEncode(dataMap, "UTF-8");
		//2.发送报文
	       InputStream propertiesInput = Thread.currentThread().getContextClassLoader().getResourceAsStream("config.properties");
	        Properties properties = new Properties();
	        properties.load(propertiesInput);
	        String serverURL = (String) properties.get("nowPayServer.url");
		String scanCodeResponseContent = "";

		System.out.println("请求报文" + scanCodeRequestReport);
		if (serverURL.startsWith("http:")) {
			try {
				scanCodeResponseContent = HttpClientUtil.sendHttp(serverURL,
						scanCodeRequestReport, "UTF-8");
			} catch (Exception e) {
				System.out.println("发送获取聚合扫码二维码服务失败" + e);
				
			}
		} else {
			scanCodeResponseContent = HttpsClientWithoutCheckSSL.sendHttps(
					serverURL, scanCodeRequestReport, "UTF-8");
		}  
		System.out.println("聚合扫码请求的响应报文:" + scanCodeResponseContent);
		
		//3.解析报文
		try{
		//JSONObject jobj = JSONObject.parseObject(scanCodeResponseContent);
			Map<String,String> responseMap = FormDateReportConvertor.parseFormDataPatternReportWithDecode(scanCodeResponseContent, "UTF-8", "UTF-8");
		//4.返回到模拟展示页面
			
			String responseCode = responseMap.get("responseCode");
			String responseMsg = responseMap.get("responseMsg");
		
		if("A001".equals(responseCode)){
			//聚合二维码
			String qrcode_base64 = responseMap.get("scanCode");
			req.setAttribute("qrcode_base64", qrcode_base64);
			
			//微信二维码
			String weixinScanCode = responseMap.get("weixinScanCode");
			req.setAttribute("weixinScanCode", weixinScanCode);
			
			//支付宝二维码
			String aliScanCode = responseMap.get("aliScanCode");
			req.setAttribute("aliScanCode", aliScanCode);
			//银联二维码
			String unionScanCode = responseMap.get("unionScanCode");
			req.setAttribute("unionScanCode", unionScanCode);
		}
		
		req.setAttribute("scanCodeResponseContent", URLUtils.urldecode(scanCodeResponseContent, "UTF-8"));
		
		req.setAttribute("responseCode", responseCode);
		req.setAttribute("responseMsg", responseMsg);
		}catch(Exception e){
			e.printStackTrace();
		}
		   
		//System.out.println("压力测试----------------------------------------->第" + i+ "次调起."+"服务器时间： "+(endTime-startTime)+"ms");
		
//}
		req.getRequestDispatcher("scode.jsp").forward(req, resp);
	}

	@Override
	protected void doGet(HttpServletRequest req, HttpServletResponse resp)
			throws ServletException, IOException {
		// TODO Auto-generated method stub
		doPost(req, resp);
	}

}