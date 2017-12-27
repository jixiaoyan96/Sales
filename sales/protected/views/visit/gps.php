<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <style type="text/css">
        body, html {width: 100%;height: 100%; margin:0;font-family:"微软雅黑";}
        #l-map{height:500px;width:100%;}
        #r-result,#r-result table{width:100%;}
        #st{
            height:50px;width:100%;
        }
    </style>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=oLDQLh0Srqwa7niIcNAyOKxUYTVVpsIl"></script>
    <title>导航</title>
</head>
<body>
<input type="hidden" id="area" value="<?php echo $area ?>">
<input type="hidden" id="road" value="<?php echo $road ?>">
<div id="l-map"></div>
<div id="r-result"></div>
</body>
</html>
<script type="text/javascript">
    var stat;//起点
    var end;  //终点
    stat = "成都市青羊区江信大厦";
    var t = document.getElementById("area").value;
    var y  = document.getElementById("road").value;
    end = t+y;
    var map = new BMap.Map("l-map");
    map.centerAndZoom(new BMap.Point(104.06792346,30.67994285), 12);
    var transit = new BMap.DrivingRoute(map, {
        renderOptions: {
            map: map,
            panel: "r-result",
            enableDragging : true //起终点可进行拖拽
        },
    });
    transit.search(stat,end);

</script>