<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<html>
<head>
</head>
<body>
<form action="/mobiletv/topay" METHOD=POST>
<input type=hidden name="funcode" value="WP001"/>
应用ID：<input type=text name="appId" value="1410853543946442"/><br>
应用密钥：<input type=text name="appKey" value="hcNmo3CBAZ9bnQKd65aP8hE9KPI5glrc"/><br>
<input type=hidden name="mhtOrderNo" value=""/>
订单名称：<input type=text name="mhtOrderName" value="merchantTest"/><br>
<input type=hidden name="mhtCurrencyType" value="156"/>
订单金额：<input type=text name="mhtOrderAmt" value="10"/><br>
订单详情：<input type=text name="mhtOrderDetail" value="mhtOrderDetail"/><br>
<input type=hidden name="mhtOrderType" value="01"/>
<input type=hidden name="mhtOrderStartTime" value="20150493201030"/><br>
<input type=hidden name="notifyUrl" value="http://posp.ipaynow.cn:10808/mobilewaptest/notify"/>
<input type=hidden name="frontNotifyUrl" value="http://posp.ipaynow.cn:10808/mobilewaptest/frontnotify"/>
<input type=hidden name="mhtCharset" value="UTF-8">

现在支付网关号：<input type=text name="payChannelType" value=""><br>
设备类型：<input type=text name="deviceType" value="0801"><span>08:返回页面，0801：返回报文</span> <br>
商户保留域：<input type=text name="mhtReserved" value="${mhtReserved}"><br>


<button type=submit>submit</button>
</form>
</body>
</html> 