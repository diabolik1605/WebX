<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
  <title>WebX</title>

  <link rel="stylesheet" href="<?=base_url()?>assets/css/WebX.css" type="text/css" media="screen" charset="utf-8">
  <link rel="stylesheet" href="<?=base_url()?>assets/css/WebX.Browser.css" type="text/css" media="screen" charset="utf-8">
  <link rel="stylesheet" href="<?=base_url()?>assets/css/WebX.Dashboard.css" type="text/css" media="screen" charset="utf-8">
  <link rel="stylesheet" href="<?=base_url()?>assets/css/WebX.Dock.css" type="text/css" media="screen" charset="utf-8">
  <link rel="stylesheet" href="<?=base_url()?>assets/css/WebX.Menubar.css" type="text/css" media="screen" charset="utf-8">
  <link rel="stylesheet" href="<?=base_url()?>assets/css/WebX.Finder.css" type="text/css" media="screen" charset="utf-8">
  <script type="text/javascript" src="<?=base_url()?>assets/js/ba-debug.min.js"></script>
  <script type="text/javascript" src="<?=base_url()?>assets/js/jquery-1.4.4.min.js"></script>
  <script type="text/javascript" src="<?=base_url()?>assets/js/jquery.transform-0.8.0.min.js"></script>
  <script type="text/javascript" src="<?=base_url()?>assets/js/jquery.rightClick.js"></script>
  <script type="text/javascript" src="<?=base_url()?>assets/js/json2.js"></script>
  <script type="text/javascript" src="<?=base_url()?>assets/js/jquery-ui-1.8.7.custom.min.js"></script>
  <? $this->load->view('js/webx_js'); ?>
</head>
<body>
  <div id="starter">
    <p style="margin-top:35px;cursor:default;">Loading...</p>
    <div id="start_progress"></div>
  </div>
</body>
</html>