<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
  <title>WebX</title>

  <link rel="stylesheet" href="<?=base_url()?>assets/css/WebX.css" type="text/css" media="screen" charset="utf-8">
  <link rel="stylesheet" href="<?=base_url()?>assets/css/WebX.Browser.css" type="text/css" media="screen" charset="utf-8">
  <script type="text/javascript" src="<?=base_url()?>assets/js/jquery-1.4.3.js"></script>
  <script type="text/javascript" src="<?=base_url()?>assets/js/jquery.transform-0.8.0.min.js"></script>
  <script type="text/javascript" src="<?=base_url()?>assets/js/json2.js"></script>
  <script type="text/javascript" src="<?=base_url()?>assets/js/jquery-ui-1.8.6.custom.min.js"></script>
  <? $this->load->view('js/webx_js'); ?>
</head>
<body>
  <div id="webxWrapper">
    <div id="starter" style="width:250px;height:100px;position:absolute;left:50%;margin-left:-125px;top:50%;margin-top:-50px;z-index:10;background:#cccccc;text-align:center;color:#333333;">
      <p  style="margin-top:35px;cursor:default;">Click Me to start</p>
    </div>
    <div>
    	<img id="wallpaper" src="<?=base_url()?>assets/imgs/wallpaper/Vitrieth_by_iumazark.jpg" alt="" title="" />
    </div>
  </div>
</body>
</html>