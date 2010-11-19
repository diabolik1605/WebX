<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
  <title>WebX</title>

  <style type="text/css">
    html,body {
      width:100%;
      height:100%;
      overflow:hidden;
      font:14px Geneva, "Myriad Pro", helvetica;
      color:#eeeeec;
      margin:0;
      padding:0
    }
    
    #wallpaper {
      width:100%;
      height:100%;
      z-index:1;
      position:absolute
    }
    
    .stretch {
      width:100%;
      height:100%;
    }

    #webxWrapper {
      height:100%;
      width:100%;
      margin:0;
      padding:0;
      position:relative
    }
    
    /*--- DOCK ICONS 42PX ---*/
	  .iIcon {
      width: 42px;
      height: 42px;
      -webkit-border-radius: 8px;
      -moz-border-radius: 8px;
      border-radius: 8px;
      background: #fff;
      float: left;
      margin: 0px auto;
      -webkit-box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.5);
      -moz-box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.5);
      box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.5);
      position:relative;
	  }
	  
	  .iIcon img {
  		border:0;
  		position: absolute;
  		left:50%;
  		top:50%;
  		height:42px;
  		width:42px;
  		margin-top:-21px;
  		margin-left:-21px;
  		z-index:4;
	  }
	  
	  .iGloss {
      background: -moz-linear-gradient(top, rgba(255, 255, 255, 0.35), rgba(255, 255, 255, 0.1));
      background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(rgba(255, 255, 255, 0.35)), to(rgba(255, 255, 255, 0.1)));
      height: 23px;
      width: 42px;
      position: relative;
      -webkit-border-top-left-radius: 8px;
      -webkit-border-top-right-radius: 8px;
      -webkit-border-bottom-right-radius: 30px 4px;
      -webkit-border-bottom-left-radius: 30px 4px;
      -moz-border-radius-topleft: 8px;
      -moz-border-radius-topright: 8px;
      -moz-border-radius-bottomright: 30px 4px;
      -moz-border-radius-bottomleft: 30px 4px;
      border-top-left-radius: 8px;
      border-top-right-radius: 8px;
      border-bottom-right-radius: 30px 4px;
      border-bottom-left-radius: 30px 4px;
      z-index: 5;
      -webkit-box-shadow: inset 0px 2px 1px rgba(255, 255, 255, 0.4);
      -moz-box-shadow: inset 0px 2px 1px rgba(255, 255, 255, 0.4);
      box-shadow: inset 0px 2px 1px rgba(255, 255, 255, 0.4);
	  }
	  
	  /*--- MENUBAR ---*/
    #menubar {
      background: -moz-linear-gradient(top, rgba(69, 72, 77, 0.6) 0%, rgba(0, 0, 0, 0.6) 100%);
      background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(69, 72, 77, 0.6)), color-stop(100%,rgba(0, 0, 0, 0.6)));
      background: rgba(0, 0, 0, 0.6);
      border-bottom: 1px solid rgba(0,0,0,0.7);
      -webkit-box-shadow: 0px 6px 10px rgba(0,0,0,0.5);
      -moz-box-shadow: 0px 6px 10px rgba(0,0,0,0.5);
      box-shadow: 0px 6px 10px rgba(0,0,0,0.5);
    }
    
    /*--- MENUBAR PANELS ---*/
    .mbWindow {
      background: rgba(0,0,0,0.4);
      border-right: 1px solid rgba(0,0,0,0.6);
      border-bottom: 1px solid rgba(0,0,0,0.6);
      border-left: 1px solid rgba(0,0,0,0.6);
      -webkit-border-bottom-right-radius:8px;
      -webkit-border-bottom-left-radius:8px;
      -moz-border-radius-bottomright:8px;
      -moz-border-radius-bottomleft:8px;
      border-bottom-right-radius:8px;
      border-bottom-left-radius:8px;
      -webkit-box-shadow: 0px 6px 10px rgba(0,0,0,0.4);
      -moz-box-shadow: 0px 6px 10px rgba(0,0,0,0.4);
      box-shadow: 0px 6px 10px rgba(0,0,0,0.4);
    }
    
    /*--- WINDOWS ---*/
    .wxWindow {
    	width:350px;
    	height:250px;
    	position:absolute;
    	top:35px;
    	left:35px;
    	padding:0;
    	margin:0;
    	border:1px solid rgba(155,155,155,1);
    	-webkit-border-radius: 4px;
    	-moz-border-radius: 4px;
    	border-radius: 4px;
    	-webkit-box-shadow: 0px 8px 40px rgba(0, 0, 0, 0.5);
      -moz-box-shadow: 0px 8px 40px rgba(0, 0, 0, 0.5);
      box-shadow: 0px 8px 40px rgba(0, 0, 0, 0.5);
    	z-index:10;
    }
    
    /*--- WINDOW TYPE APP ---*/
    .wxWindow_app {
      -webkit-border-radius: 4px 4px 0px 0px;
      -moz-border-radius: 4px 4px 0px 0px;
      border-radius: 4px 4px 0px 0px;
    }
    
    .wxWindow_top {
    	width:100%;
    	height:60px;
    	background: -moz-linear-gradient(top, #CBCBCB 0%, #A7A7A7 100%);
      background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#CBCBCB), color-stop(100%,#A7A7A7));
    	background:rgba(167,167,167,1);
    	border-bottom:1px solid rgba(81,81,81,1);
    	overflow:hidden;
    }
    
    .wxWindow_top_wrapper {
    	width:100%;
    	height:100px;
    	-webkit-box-shadow: inset 0px 5px 30px rgba(255,255,255,0.7);
    	-moz-box-shadow: inset 0px 5px 30px rgba(255,255,255,0.7);
    	box-shadow: inset 0px 5px 30px rgba(255,255,255,0.7);
    	margin:0 auto 0px;
    	-webkit-border-radius: 4px 4px 0px 0px;
    	-moz-border-radius: 4px 4px 0px 0px;
    	border-radius: 4px 4px 0px 0px;
    	position:relative;
    }
    
    .wxWindow_top_buttons {
    	left: 7px;
    	position: absolute;
    	top: 4px;
    }
    
    .wxWindow_top_buttons .button {
      width:10px;
      height:10px;
      -webkit-border-radius: 11px;
      -moz-border-radius: 11px;
      border-radius: 11px;
      float:left;
      padding: 0px;
      margin: 0;
      margin-right:7.35px;
      border: 1px solid rgba(87, 94, 107, 0.85);
      background: -moz-linear-gradient(top, rgba(0, 0, 0, 0.15), rgba(0, 0, 0, 0.1));
      background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(rgba(0, 0, 0, 0.15)), to(rgba(0, 0, 0, 0.1)));
      font: small-caps bold 10px/10px Lucida;
      text-align:center;
      cursor:default;
    }
    
    .wxWindow_top_pill {
      width:16.35px;
      height:6.35px;
      -webkit-border-radius: 10px;
      -moz-border-radius: 10px;
      border-radius: 10px;
      float:left;
      border: 1px solid rgba(81, 81, 81, 0.85);
      background: -moz-linear-gradient(top, rgba(0, 0, 0, 0.15), rgba(0, 0, 0, 0.1));
      background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(rgba(0, 0, 0, 0.15)), to(rgba(0, 0, 0, 0.1)));
      font: small-caps bold 8px/8px Lucida;
      text-align:center;
      cursor:default;
      position:absolute;
      top:5.5px;
      right:7px;
    }
    
    .wxWindow_top_title {
    	width:100%;
    	height:21px;
    	position:absolute;
    	top:0;
    	text-align:center;
    	font: 12px/21px "Lucida Grande";
    	color: #000000;
    }
    
    .wxWindow_top_toolbar {
    	width:100%;
    	height:39px;
    	position:absolute;
    	top:21px;
    }
    
    .wxWindow_body {
    	width:100%;
    	background: #ffffff;
    	color: #000000;
    	padding: 0;
    	margin: 0;
    }
    
    .wxWindow_body_wrapper {
      width: 100%;
      height: 100%;
      position: relative;
      overflow: hidden;
    }
    
    .wxWindow_body_sidebar {
      width: 135px;
      height: 100%;
      overflow: hidden;
      background: rgba(221, 228, 235, 1);
      border-right:1px solid rgba(180, 180, 180, 1);
    }
    
    .wxWindow_body_content {
      height: 100%;
      position: absolute;
      top: 0px;
      left: 135px;
      overflow-y: auto;
    }
    
    .wxWindow_footer {
    	width:100%;
    	height:23px;
    	background: -moz-linear-gradient(top, #CBCBCB 0%, #A7A7A7 100%);
      background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#CBCBCB), color-stop(100%,#A7A7A7));
    	background:rgba(167,167,167,1);
    	border-top:1px solid rgba(81,81,81,1);
    	position:absolute;
    	bottom:0;
    	overflow:hidden;
    }
    
    .wxWindow_footer_wrapper {
    	width:100%;
    	height:46px;
    	-webkit-box-shadow: inset 0px 1px 30px rgba(255,255,255,0.4);
    	-moz-box-shadow: inset 0px 1px 30px rgba(255,255,255,0.4);
    	box-shadow: inset 0px 1px 30px rgba(255,255,255,0.4);
    	margin:-23px auto 0px;
    	-webkit-border-radius: 0px 0px 4px 4px;
    	-moz-border-radius: 0px 0px 4px 4px;
    	border-radius: 0px 0px 4px 4px;
    }
    
    /*--- WINDOW TYPE APP FOOTER ---*/
    .wxWindow_app .wxWindow_footer {
      display: none;
    }
    
    #sortable li { margin: 3px 3px 3px 0; padding: 1px; float: left; width: 100px; height: 90px; font-size: 4em; text-align: center; }
    
    .wx_dock_item {
    	width: 42px;
    	height: 42px;
    	margin: 0 6px 13px;
    	padding: 0;
    	list-style-type: none;
    	float: left;
    	position: relative;
    }
    
    #dock_Dashboard {
      background: url("<?=base_url()?>assets/imgs/dock/dock_sprite.png") 0 0 no-repeat;
    }
    
    #dock_Files {
      background: url("<?=base_url()?>assets/imgs/dock/dock_sprite.png") 0 -42px no-repeat;
    }
    
    #dock_Settings {
      background: url("<?=base_url()?>assets/imgs/dock/dock_sprite.png") 0 -84px no-repeat;
    }
    
    #dock_Paste {
      background: url("<?=base_url()?>assets/imgs/dock/dock_sprite.png") 0 -42px no-repeat;
    }
    
    .wxTipText {
      -webkit-border-radius: 20px;
      -moz-border-radius: 20px;
      border-radius: 20px;
      background: rgba(30, 30, 30, 0.85);
      height: 20px;
      color: #fff;
      font: 13px/20px "Myriad Pro", Geneva, helvetica;
      margin: 0px;
      padding: 0px 12px;
    }
    
    .wxTipText:after {
      border-color:rgba(30, 30, 30, 0.85) transparent;
      border-style:solid;
      border-width:6px 6px 0;
      bottom:1px;
      content:"";
      display:block;
      height:0;
      position:absolute;
      width:0;
      left:50%;
      margin-left: -5px;
    }
    
  </style>
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
    	<img id="wallpaper" src="<?=base_url()?>assets/imgs/WebXWallpaperOfficial.png" alt="" title="" />
    </div>
  </div>
</body>
</html>