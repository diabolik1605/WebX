<style type="text/css">
#contentbox{
	background: url(http://webx.ipwn.me/assets/imgs/smhomerpollack2010.jpg)no-repeat;
	width: 760px;
	height: 428px;
	border: 0;
	padding: 0;
	margin: 0;
	position:relative;
}

#contentbox a h2{
	color: #000000;
}
#contentbox a h2:hover {
	color: #ffffff;
}
.dock_icon{
	float: left;
}
</style>

<script type="text/javascript">
<!--
var webx_data = {
    "menubar": {
		"items": [
				"start",
				"dock",
				"login"
		],
		"panels": {
			"start": [
				"about",
				"update"
			],
			"dock": [
				"create",
				"show",
				"hide",
				"edit"
			],
			"login": [
				"register",
				"login"
			]
		}
	},
	"dock":{
		"items": [
			"home",
			"files",
			"paste"
		],
		"home":{
		    "icon": "icon.jpg"
		},
		"files":{
		    "icon": "icon.jpg"
		},
		"paste":{
		    "icon": "icon.jpg"
		}		
	}
};

var dock_created = false;
//-->
</script>
<script type="text/javascript" src="<?=base_url()?>assets/js/faceQuery.js"></script>
<script type="text/javascript">
<!--

function doSomething(){
	// $('#contentbox').hover(function(){this.css('background','#ffffff');},function(){this.css('background','#666666');});
	$('a#starter').hide();
	WebX.create.menubar();
	// console.log(webx_data.userInfo);
	// $('#contentbox').html("<a href='#' id='dynamic'>ooh dynamic!</a>");
	// $('#dynamic').click(function(){  });
	// $('#contentbox').removeChild($('#contentbox').getFirstChild());
}
/*
* method $ce(element)
*	shortcut for document.createElement(element)
*/
function $ce(ele){
	return document.createElement(ele);
}
/*
* method stCap(string)
*	returns a string with first letter capitalized
*	and the rest of the string in lowercase
*/
function stCap(str){
	return(str.charAt(0).toUpperCase()+str.substr(1).toLowerCase());
}
/*
* method canvasLeft(string)
*	returns absoluteLeft() of the canvas to the browser
*/
function canvasLeft(){
	return document.getRootElement().getAbsoluteLeft();
}

var WebX = {
    create: {
        menubar: function() {
                var menubar = $ce('div');
                $(menubar).attr("id", "menubar")
                	.css({
                		"width": "100%",
                		"height": "20px",
                		"background": "#000000",
                		"color": "#ffffff",
                		"opacity": "0.74"
                });
                
                webx_data.menubar.items.forEach(function(obj){
                	var mb_item = $ce('span');
                	var mb_link = $ce('a');
                	$(mb_item).attr('class', 'mb_item')
                		.css({
                			'fontSize':'13px',
                			'lineHeight':'20px',
                			'margin':'0px 0px 0px 6px',
                			'padding': '0',
                			'float':'left'
                	});
                	$(mb_link).attr({'id':'mb_'+obj, "href": "#"})
                		.css('color','#ffffff')
                		.text(stCap(obj));
                	$(mb_link).click(function(){
                		var panel_name = "#"+obj+"_panel";
                		$(panel_name).slideToggle();
                	});
                	$(mb_item).append(mb_link);
                	$(menubar).append(mb_item);
                });
                
                $('#contentbox').append(menubar);
                var menubarHeight = $('#menubar').getDimensions().height;
                var kids = $(menubar).getChildNodes();
                kids.forEach(function(obj){
                	var thisObj = obj.getFirstChild().getId();
                	thisObj = thisObj.substring(3);
                	var thisLeft = $(obj).parentOffsets().left;
                    webx_data.menubar.panels[thisObj].offsetLeft = (thisLeft)+"px";
                });
                
                for(panel in webx_data.menubar.panels){
                	// console.log(panel+" panel: "+webx_data.menubar.panels[panel]+" - left: "+webx_data.menubar.panels[panel].styles.left);
                	var mb_panel = $ce('div');
                	var mb_link_ul = $ce('ul');
                	$(mb_link_ul).css({'listStyleType':'none'});
                	var panel_name = panel+'_panel';
                	$(mb_panel).attr('id',panel_name)
                		.css({
                			'background':'#000000',
                			'width': '150px',
                			'padding':'4px 6px',
                			'display':'none',
                			'position': 'absolute',
                			'top': menubarHeight+'px',
                			'left':webx_data.menubar.panels[panel].offsetLeft,
                			"opacity": "0.74"
                	});
                	
                	for(var i=0;i<webx_data.menubar.panels[panel].length;i++){
                		var link_name = webx_data.menubar.panels[panel][i];
                		var mb_link_li = $ce('li');
                		var mb_link_a = $ce('a');
                		$(mb_link_a).attr({'href':'#'})
                			.css({
                				'color':'#ffffff',
                				'text-decoration':'none'
                		});
                		$(mb_link_a).text(stCap(link_name));
                		switch(panel){
                			case "dock":
                				switch (link_name){
                					case "create":
                					$(mb_link_a).click(WebX.create.dock());
                					break;
                					case "show":
                					$(mb_link_a).click(function(){
                						$('#dock').show();
                						return false;
                					});
                					break;
                					case "hide":
                					$(mb_link_a).click(function(){
                						$('#dock').hide();
                						return false;
                					});
                					break;
                					case "edit":
                					$(mb_link_a).click(function(){
                						console.log($('.dock_icon'));
                						return false;
                					});
                					break;
                				}
                			break;
                			case "login":
                				switch (link_name) {
                					case "register":
                					$(mb_link_a).click(function(){
                						WebX.create.login();
                						return false;
                					});
                					break;
                					case "login":
                					$(mb_link_a).click(function(){
                						login();
                						return false;
                					});
                					break;
                				}
                			break;
                		}
                		$(mb_link_li).append(mb_link_a);
                		$(mb_link_ul).append(mb_link_li);
                	}
                	
                	$(mb_panel).append(mb_link_ul);
                	$('#contentbox').append(mb_panel);
                	$(mb_panel).slideUp();
                	
                }
                return false;
            },
            dock: function(){
                if(!dock_created){
                	var dock = $ce('div');
                	$(dock).attr("id","dock")
                		.css({
                			'height':'64px',
                			'position':'absolute',
                			'bottom':'0px',
                			'margin':'0px auto',
                			'padding':'0px',
                			'border': '1px solid red',
                			'left':'50%'
                	});
                	var dock_ul = $ce('ul');
                	$(dock_ul).css({'listStyleType':'none'});
                	webx_data.dock.items.forEach(function(obj){
                		var icon = $ce('li');
                		$(icon).attr({"id":"dock_"+obj, "class":'dock_icon'})
                			.css({
                				'height':'48px',
                				'width':'48px',
                				'background':'#ffffff',
                				'margin':'8px 4px'
                		}).text(obj);
                		$(icon).hover(function(){
                			this.css('background','#0000ff');
                		},function(){
                			this.css('background','#ffffff');
                		});
                		$(dock_ul).append(icon);
                	});
                	$(dock).append(dock_ul);
                	$('#contentbox').append(dock);
                	var dock_size = $('#dock').getDimensions().width;
                	$('#dock').css('marginLeft','-'+(dock_size/2)+'px');
                	dock_created = true;
                  $('#dock_paste').clickHold(function(){ console.log("held for 5 seconds"); },5000);
                }
                return false;
            },
            login: function(){
                var loginbox = $ce('div');
                $(loginbox).attr('id','loginbox')
                	.css({
                		"width": "100%",
                		"height": "100%",
                		"background": "#737373",
                		"color": "#000",
                		"zIndex": "20"
                	})
                	.xhtml("<label for='user_nick'>Choose a Nickname</label><br /><input type='text' name='user_nick' id='nickname_input' /><br /><p><input type='button' value='Create User' id='registerSubmit'/></p>");
                $('#contentbox').append(loginbox);
                $('#registerSubmit').click(function(){ register();return false; });
            }
    }
};

function updateSettings(){
    var settings = JSON.stringify(webx_data);
    var newParams = { 
    	"fb_uid": <?=$uid?>,
    	"settings": settings
    };
    var ajax = new Ajax();
    ajax.responseType = Ajax.RAW;
    ajax.ondone = function(){
        console.log('webx_fb settings updated');
    }
    ajax.onerror = function() { console.log("update settings ERROR!!"); };
    ajax.post("<?=base_url().'user/updateSettings'?>", newParams);
}

function getSettings(){
    var newParams = { 
    	"fb_uid": <?=$uid?>
    };
    var ajax = new Ajax();
    ajax.responseType = Ajax.JSON;
    ajax.ondone = function(data){
        // console.log(data.content);
        var newData = data.content;
        newData = JSON.parse(newData);
        console.log(newData);
    }
    ajax.onerror = function() { console.log("get settings ERROR!!"); };
    ajax.post("<?=base_url().'user/getSettings'?>", newParams);
}

function check(){
    var json = JSON.stringify(webx_data);
    console.log(json);
    var jsoned = JSON.parse(json);
    console.log(jsoned);
}

function register(){
	var params = { 
		"facebook_uid": <?=$uid?>,
		"first_name": "<?=$userInfo['first_name']?>",
		"last_name": "<?=$userInfo['last_name']?>",
		"image_url": "<?=$userInfo['pic_square']?>",
		"user_nick": $("#nickname_input").val()
	};
	var ajax = new Ajax();
	ajax.requireLogin = true;
	ajax.responseType = Ajax.RAW;
	ajax.ondone = function(){
	    console.log("new user : "+params.user_nick+" created.");
        // updateSettings();
        $('#loginbox').fadeOut().remove();
	};
	ajax.onerror = function() { console.log("create user ERROR!!"); };
	ajax.post("<?=base_url().'user/newUser'?>", params);
}

function login(){
	var params = { 
		"fb_uid": <?=$uid?>
	};
	var ajax = new Ajax();
	ajax.requireLogin = true;
	ajax.responseType = Ajax.JSON;
	ajax.ondone = function(data){
	    var user_settings = JSON.parse(data.content);
		console.log(user_settings);
		$('#loginbox').fadeOut().remove();
	};
	ajax.onerror = function() { console.log("LOGIN ERROR!!"); };
	ajax.post("<?=base_url().'user/getSettings'?>", params);
}

function getUserId(){
    var params = { 
    	"fb_uid": <?=$uid?>
    };
    var ajax = new Ajax();
    ajax.responseType = Ajax.RAW;
    ajax.ondone = function(data){
    	console.log(data);
    };
    ajax.onerror = function() { console.log("LOGIN ERROR!!"); };
    ajax.post("<?=base_url().'user/getUserId'?>", params);
}
//-->
</script>

 <? if ($me): ?>
<a href="<?php echo $logoutUrl; ?>">
<img src="http://static.ak.fbcdn.net/rsrc.php/z2Y31/hash/cxrz4k7j.gif">
</a>
<? endif; ?>

<a href="#" onclick="doSomething();return false;" id="starter">click me to do something</a>
<div id="contentbox">
<!-- <a href="#" onclick="check();return false;" id="starter">click me to do something</a> -->
<?
// print(sizeof($userInfo["friends"]['data'])."<br>");
// for($i = 0; $i < sizeof($userInfo["friends"]['data']); $i++ ) {
//   print_r($userInfo["friends"]['data'][$i]['name']." ,");
// }
// 
// print(sizeof($userInfo["pic_albums"]['data'])."<br>");
// for($i = 0; $i < sizeof($userInfo["pic_albums"]['data']); $i++ ) {
//   print_r($userInfo["pic_albums"]['data'][$i]['name']." ,");
// }
?>
</div>

<div id="fb-root"></div>
<script src="http://connect.facebook.net/en_US/all.js"></script>