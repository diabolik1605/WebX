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
<?php require_once('assets/js/faceQuery.js') ?>
//-->
</script>
<fb:user-agent includes="firefox">
<script type="text/javascript">
<!--
var browser = "firefox";
-->
</script>
</fb:user-agent>
<fb:user-agent includes="ie">
<script type="text/javascript">
<!--
var browser = "ie";
-->
</script>
</fb:user-agent>
<fb:user-agent includes="safari">
<script type="text/javascript">
<!--
var browser = "safari";
-->
</script>
</fb:user-agent>

<script type="text/javascript">
<!--
var dock_created = false;

function doSomething(){
	// $('#contentbox').hover(function(){this.css('background','#ffffff');},function(){this.css('background','#666666');});
	$('#contentbox').empty();
	wx_create_menubar();
	// $('#contentbox').html("<a href='#' id='dynamic'>ooh dynamic!</a>");
	// $('#dynamic').click(function(){  });
	// $('#contentbox').removeChild($('#contentbox').getFirstChild());
}

function $ce(ele){
	return document.createElement(ele);
}

function wx_create_menubar(){
	var menubar_props = {
		"items": [
				"start",
				"dock"
		],
		"panels": {
			"start": [
				"about",
				"update"
			],
			"dock": [
				"create",
				"show",
				"hide"
			]
		}
	};
	var menubar = $ce('div');
	$(menubar).attr("id", "menubar")
		.css({
			"width": "100%",
			"height": "20px",
			"background": "#000000",
			"color": "#ffffff"
	});
	menubar_props.items.forEach(function(obj){
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
		$(mb_link).attr('id', 'mb_'+obj)
			.css('color','#ffffff')
			.setHref('#')
			.text(obj);
		$(mb_link).click(function(){
			var panel_name = "#"+obj+"_panel";
			console.log(panel_name);
			$(panel_name).slideToggle();
		});
		$(mb_item).append(mb_link);
		$(menubar).append(mb_item);
	});
	$('#contentbox').append(menubar);
	var kids = $(menubar).getChildNodes();
	kids.forEach(function(obj){
		var thisObj = obj.getFirstChild().getId();
		thisObj = thisObj.substring(3);
		var thisLeft = obj.getAbsoluteLeft();
	    // firefox = menubar_props.panels[thisObj].left = (thisLeft-160)+"px";
	    // safari = menubar_props.panels[thisObj].left = (thisLeft-115)+"px";
	    if(browser == "safari"){
	    	menubar_props.panels[thisObj].left = (thisLeft-115)+"px";
	    } else {
	    	menubar_props.panels[thisObj].left = (thisLeft-165)+"px";
	    }
	    
	});
	for(panel in menubar_props.panels){
		// console.log(panel+" panel: "+menubar_props.panels[panel]+" - left: "+menubar_props.panels[panel].left);
		var mb_panel = $ce('div');
		var mb_link_ul = $ce('ul');
		$(mb_link_ul).css({'listStyleType':'none'});
		var panel_name = panel+'_panel';
		$(mb_panel).attr('id',panel_name)
			.css({
				'background':'#000000',
				'width': '150px',
				'padding':'4px 6px',
				'position': 'absolute',
				'top':'20px',
				'left':menubar_props.panels[panel].left
		});
		for(var i=0;i<menubar_props.panels[panel].length;i++){
			var link_name = menubar_props.panels[panel][i];
			var mb_link_li = $ce('li');
			var mb_link_a = $ce('a');
			$(mb_link_a).attr({'href':'#'})
				.css({
					'color':'#ffffff',
					'text-decoration':'none'
			});
			$(mb_link_a).text(link_name);
			switch(panel){
				case "dock":
					switch (link_name){
						case "create":
						$(mb_link_a).click(wx_create_dock);
						break;
						case "show":
						$(mb_link_a).click(function(){
							$('#dock').show();
						});
						break;
						case "hide":
						$(mb_link_a).click(function(){
							$('#dock').hide();
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
		$(mb_panel).slideToggle();
	}
}
function wx_create_dock(){
	if(!dock_created){
		var dock_props = {
			items: [
				"home",
				"files",
				"paste"
			]
		};
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
		dock_props.items.forEach(function(obj){
			var icon = $ce('li');
			$(icon).attr("class",'dock_icon');
			$(icon).css({
				'height':'48px',
				'width':'48px',
				'background':'#ffffff',
				'margin':'8px 4px',
			});
			$(icon).hover(function(){
				this.css('background','#0000ff');
			},function(){
				this.css('background','#ffffff');
			});
			$(icon).text(obj);
			$(dock_ul).append(icon);
		});
		$(dock).append(dock_ul);
		$('#contentbox').append(dock)
		// $('#dock').hover(function(){Animation(this).to('opacity', 1).go();},function(){Animation(this).to('opacity', 0).go();});
		var dock_size = $('#dock').getDimensions();
		$('#dock').css('marginLeft','-'+parseInt(dock_size.width/2)+'px');
		dock_created = true;
//		var dock_btn = $('#mb_dock').parent();
//		$(dock_btn).remove();
	}
}
//-->
</script>

<div id="contentbox">
<a href="#" onclick="doSomething();return false;"><h2>click me to do something</h2></a>
</div>