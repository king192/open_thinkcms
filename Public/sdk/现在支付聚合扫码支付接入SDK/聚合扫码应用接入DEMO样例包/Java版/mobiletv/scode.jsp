<%@ page language="java" import="java.util.*" pageEncoding="utf-8"%>
<%
String path = request.getContextPath();
String basePath = request.getScheme()+"://"+request.getServerName()+":"+request.getServerPort()+path+"/";
String responseCode = (String)request.getAttribute("responseCode");
String responseMsg = (String)request.getAttribute("responseMsg");
String qrcode_base64 = request.getAttribute("qrcode_base64")!=null?request.getAttribute("qrcode_base64").toString():"";
String scanCodeResponseContent = request.getAttribute("scanCodeResponseContent")!=null?request.getAttribute("scanCodeResponseContent").toString():"";

String weixinScanCode = request.getAttribute("weixinScanCode")!=null?request.getAttribute("weixinScanCode").toString():"";

String aliScanCode = request.getAttribute("aliScanCode")!=null?request.getAttribute("aliScanCode").toString():"";

String unionScanCode = request.getAttribute("unionScanCode")!=null?request.getAttribute("unionScanCode").toString():"";
%>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <base href="<%=basePath%>">
    
    <title>扫码展示页面</title>
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="0">    
	<meta http-equiv="keywords" content="keyword1,keyword2,keyword3">
	<meta http-equiv="description" content="This is my page">
	<!--
	<link rel="stylesheet" type="text/css" href="styles.css">
	-->
  </head>
  
  <body>
    <div>
    <%
      if("A001".equals(responseCode)){
    %>
        <table>
          <tr>
             <td><h3>请扫码下面的二维码</h3></td>
          </tr>
          <tr>
          		<%if(!"".equals(qrcode_base64)){
        	    %>
          			<td><img src="data:image/png;base64,<%=qrcode_base64%>"></img></td>
	          	<%
	          	  }
	          	%>
          		<%if(!"".equals(weixinScanCode)){
        	    %>
          			<td><img src="data:image/png;base64,<%=weixinScanCode%>"></img></td>
	          	<%
	          	  }
	          	%>
          		<%if(!"".equals(aliScanCode)){
        	    %>
          			<td><img src="data:image/png;base64,<%=aliScanCode%>"></img></td>
	          	<%
	          	  }
	          	%>
          		<%if(!"".equals(unionScanCode)){
        	    %>
          			<td><img src="data:image/png;base64,<%=unionScanCode%>"></img></td>
	          	<%
	          	  }
	          	%>
          </tr>
        </table>
        <%
      }else{
        %>
         生成二维码异常：<%=responseCode %>,<%=responseMsg %>
        <%
      }
        %>
    </div>
    <div>
       <div><h3>返回报文:</h3></div><div><%=scanCodeResponseContent %></div>
    </div>
  </body>
</html>
