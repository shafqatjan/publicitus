<style>
body{
background:#D2D2D2;
font-family: "Lucida Grande",Tahoma,Arial,Verdana,sans-serif;
font-size: 12px;
}
div {
background-color: white;
border: 3px solid #7E7E7E;
color: #757575;
display: block;
margin: 100px auto 0;
padding: 30px;
width: 550px;
}
h2 {
color: #4D9A49;
color:red;
margin: 0 0 10px;
}
</style>
<html>
<head>
<title><?php $error404MsgMenu ?></title>
</head>
<body>
<div class="message">
<h2><?php echo $restrictedAreaErrorMenu?></h2>
<?php echo $pleaseMenu?> <a href="javascript:history.go(-1);" style="font-family:Arial, Helvetica, sans-serif;"><?php echo $goBackMenu?></a> <?php echo $toPreviousPageMenu?>.</div>
</body>
</html>
