<!--
 --  Copyright (c) 2012-2013 Malhar, Inc.
 --  All Rights Reserved.
 -->
    
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Data Torrent : Ads Demo </title>

<link rel="stylesheet" type="text/css" href="malhar.css">

<!-- Google charts include -->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
google.load('visualization', '1', {'packages':['corechart']});
google.load('visualization', '1', {'packages':['table']});

</script>

<!-- Malhar charting utils -->
<script type="text/javascript" src="global.js"></script>
<script type="text/javascript" src="DrawPageViewTimeChart.js"></script>
<script type="text/javascript" src="TopUrlChart.js"></script>
<script type="text/javascript" src="TopServer.js"></script>
<script type="text/javascript" src="TopIpClientChart.js"></script>
<script type="text/javascript" src="server.js"></script>
<script type="text/javascript" src="TopIpData.js"></script>
<script type="text/javascript" src="TotalViews.js"></script>
<script type="text/javascript" src="Url404.js"></script>
<script type="text/javascript" src="ClientData.js"></script>
<script type="text/javascript" src="serverfail.js"></script>
<script type="text/javascript" src="TotalViews.js"></script>

<!-- window onload -->
<script type="text/javascript">

window.onload = function() {
  
  // Initialize variables   
  InitializeGlobal();
   
  // Draw top charts 
  DrawClientDataTableChart();
  DrawTotalViewsTableChart();
  DrawTopUrlTableChart();
  DrawTopServerTableChart();
  DrawRiskyClientTableChart();
  DrawTopIpClientTableChart(); 
  DrawUrl404TableChart();
  DrawServer404TableChart();
  setInterval(DrawClientDataTableChart, 1000)
  setInterval(DrawTotalViewsTableChart, 1000);
  setInterval(DrawTopUrlTableChart, 1000);
  setInterval(DrawTopServerTableChart, 1000);
  setInterval(DrawRiskyClientTableChart, 1000);
  setInterval(DrawTopIpClientTableChart, 1000);
  setInterval(DrawUrl404TableChart, 1000);
  setInterval(DrawServer404TableChart, 1000);
};

</script>

</head>
<body>

    <div id="header">
        <ul class="dashboard-modes">
            <li>
                <a href="#" class="active">Ads Dimensions Demo</a>
            </li>
        </ul>

        <div id="logo"><img src="main_banner.png" style="margin-left:10px;"/></div>
    </div>
	
	<div id="main">
    <div id="pagecontent">
        <div class="dashboardMgr">
            <div class="inner" style="">
                <h2 class="title">Page views vs Time Chart</h2> 
                <form onsubmit="return false;">
                        Select Page:
                        <select name="page" id="page" style="width:200px;" onchange="handleUrlChange();">
                           <option value="all">ALL</option>
                           <option value="home">home.php</option>
                           <option value="contact">cpontactus.php</option>
                           <option value="about">about.php</option>
                           <option value="support">support.php</option>
                           <option value="product">products.php</option>
                           <option value="services">services.php</option>
                           <option value="partners">partners.php</option>
            		</select><br>
                        Product/Services/Support/Partners Index : 
                        <select name="index" id="index" style="width:200px;" disabled="true" >
                          <option value=\"$i\"></option>
                          <?php
                            for ($i = 0; $i < 100; $i++) {
                              print "<option value=\"$i\">$i</option>\n";
                            }
        	           ?>
                        </select><br>
                        Refresh Interval(Secs):
                        <input type="text" name="refresh" id="pageviewrefresh" class="input-small"/><br>
		        Look Back(Hours):
                        <input type="text" name="lookback" id="pageviewlookback" class="input-small"/>
                </form><br>
                <a href="javascript:void(0)" onclick="HandlePageViewTimeSubmit();">View Chart</a><br><br>

                <h2 class="title">Server Load vs Time Chart</h2> 
                <form onsubmit="return false;">
                        Server Name : 
                        <select name="servername" id="servername" style="width:200px;">
                          <option value="all">All</option>
                          <?php
                            for ($i = 0; $i < 10; $i++) {
                              print "<option value=\"server{$i}.mydomain.com:80\">Server$i.mydomain.com</option>\n";
                            }
        	           ?>
                        </select><br>
                        Server Load Refresh Interval(Secs):
                        <input type="text" name="serverloadrefresh" id="serverloadrefresh" class="input-small"/><br>
		        Server Load Look Back(Hours):
                        <input type="text" name="serverloadlookback" id="serverloadlookback" class="input-small"/>
                </form><br>
                <a href="javascript:void(0)" onclick="HandleServerLoadTimeSubmit();">View Server Load Chart</a><br><br>
                
                <b>Data Served/Sec :</b> <b id="totaldata"> </b> <br 
                <b>Total Views/Sec :</b> <b id="totalviews"> </b> 
            </div>
        </div>
        <div class="dashboardMain">
           <div class="dbib">     
                <div id="pageview_chart_div"></div>
		<div id="server_load_div"></div>
           </div>
           <div class="dbib">
                <table><tbody><tr>
      
		         <td>       <h1>Top 10 Queried Url/sec</h1>
		                    <div  id="top_url_div" ></div><br><br>
                                    <h1>Top 10 Client IP with high use</h1>
                                    <div id="top_IpClient_div"></div> <br><br>
                                    <h1>Top 10 Url Status 404 (per sec)</h1>
                                    <div id="url_404_div"></div>
		          </td>
		          <td>
                                   <h1>Server Load (views/sec)</h1>
		                   <div id="top_server_div"></div> <br><br>
                                   <h1>Top 10 Client IP with high use (Bytes/sec)</h1>
                                   <div id="top_ipdata_div"></div> <br><br>
                                   <h1>Number of 404 per Server (per sec)</h1>
                                   <div id="server_404_div"></div-->
		           </td>
                          
               </tr></tbody></table>
           </div>
        </div>		
</body>
</html>
