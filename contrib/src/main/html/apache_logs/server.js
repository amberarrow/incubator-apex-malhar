/*
 *  Copyright (c) 2012-2013 Malhar, Inc.
 *  All Rights Reserved.
 */

/**
 * Functions for drawing server load vs time chart.
 * @author Dinesh Prasad (dinesh@malhar-inc.com) 
 */

function RenderServerLoadTimeChart()
{  
  // create/delete rows 
  if (serverLoadTable.getNumberOfRows() < serverLoadDataPoints.length)
  {    
    var numRows = serverLoadDataPoints.length - serverLoadTable.getNumberOfRows();
    serverLoadTable.addRows(numRows);
  } else {
    for(var i=(serverLoadTable.getNumberOfRows()-1); i >= serverLoadDataPoints.length; i--)
    {
      serverLoadTable.removeRow(i);    
    }
  }

  // remove last 10 points
  if (serverLoadDataPoints.length > 20)
  {
    for (var i=0; i < 10; i++)
    {
      serverLoadTable.removeRow(serverLoadDataPoints.length-1-i);  
    }    
  }

  // Populate data table with time/cost data points. 
  for(var i=0; i < serverLoadTable.getNumberOfRows(); i++)
  {
    serverLoadTable.setCell(i, 0, new Date(parseInt(serverLoadDataPoints[i].timestamp)));
    serverLoadTable.setCell(i, 1, parseFloat(serverLoadDataPoints[i].view));
  }

  // Draw line chart.
  var options = {pointSize: 0, lineWidth : 1 };
  options.title = 'Site Server(s) Requests(Per Sec) vs Time Chart';
  serverLoadChart.draw(serverLoadView, options); 
}

function DrawServerLoadTime()
{
  // get url 
  var url = "ServerLoad.php?from=" + Math.floor(serverLoadLookback);
  if ( serverName && (serverName.length > 0))
  {   
    url += "&server=" + serverName;    
  }

  // fetch data  
    try
  {
    var connect = new XMLHttpRequest();
    connect.onreadystatechange = function() {
      if(connect.readyState==4 && connect.status==200) {
        serverLoadData = connect.response;
        var pts = JSON.parse(serverLoadData);
        for(var i=0; i <  pts.length; i++) 
        {
          serverLoadDataPoints.push(pts[i]);
          delete pts[i];
        }
        delete pts;
        sortByKey(serverLoadDataPoints, "timestamp");
        RenderServerLoadTimeChart();
        delete serverLoadData;
        delete serverLoadDataPoints;
        serverLoadDataPoints = new Array();
      }
    }
    connect.open('GET',  url, true);
    connect.send(null);
  } catch(e) {
  }
  serverLoadLookback = (new Date().getTime()/1000) -  (3600*serverLoadInterval) - serverLoadRefresh;
}

function HandleServerLoadTimeSubmit()
{
  // reset intercval  
  if(serverNowPlaying) clearInterval(serverNowPlaying);

  // get params 
  serverName = document.getElementById('servername').value;
  serverLoadRefresh = document.getElementById('serverloadrefresh').value;
  serverLoadLookback = document.getElementById('serverloadlookback').value;
  if ( !serverLoadRefresh || (serverLoadRefresh == "")) serverLoadRefresh = 5;
  pageViewLookback = document.getElementById('pageviewlookback').value;
  if ( !serverLoadLookback || (serverLoadLookback == "")) {
    serverLoadLookback = (new Date().getTime()/1000) - 3600;
  }  else {
    serverLoadLookback = (new Date().getTime()/1000) - 3600 * serverLoadLookback;
  }

  // set from values  
  document.getElementById('servername').value = serverName;
  document.getElementById('serverloadrefresh').value = serverLoadRefresh;
  var lookback = document.getElementById('serverloadlookback').value;
  document.getElementById('serverloadlookback').value = lookback;
  serverLoadInterval = lookback;
       
  // darw server load/time chart  
  DrawServerLoadTime();
  serverNowPlaying = setInterval(DrawServerLoadTime, serverLoadRefresh * 1000); 
}
