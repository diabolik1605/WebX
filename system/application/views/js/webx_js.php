<script type="text/javascript">
/*--- PRELOADER ---*/
(function($) {
	var imgList = [];
	$.extend({
		preload: function(imgArr, option) {
			var setting = $.extend({
				init: function(loaded, total) {},
				loaded: function(img, loaded, total) {},
				loaded_all: function(loaded, total) {}
			}, option);
			var total = imgArr.length;
			var loaded = 0;
			
			setting.init(0, total);
			for(var i in imgArr) {
				imgList.push($("<img />")
					.attr("src", imgArr[i])
					.load(function() {
						loaded++;
						setting.loaded(this, loaded, total);
						if(loaded == total) {
							setting.loaded_all(loaded, total);
						}
					})
				);
			}
			
		}
	});
})(jQuery);
</script>
<script type="text/javascript">
  function getDimensions(ele) {
      var display = $(ele).css('display');
      
      // All *Width and *Height properties give 0 on elements with display none,
      // so enable the element temporarily
      var originalVisibility = $(ele).css("visibility");
      var originalDisplay = $(ele).css("display");
      var originalPosition = $(ele).css("position");
      
      $(ele).css('visibility','hidden');
      $(ele).css('display','block');
      $(ele).css('position','absolute');
      
      var newWidth = $(ele).width();     
      var newHeight = $(ele).height();
      
      $(ele).css('visibility',originalVisibility);
      $(ele).css('display',originalDisplay);
      $(ele).css('position',originalPosition);

      return {
          width: newWidth,
          height: newHeight
      };
  }
  
  function getComputedStyleValue(element, style) {
      return window.getComputedStyle(element, null).getPropertyValue(style);
  }
  
  function parentOffsets(obj) {
    var curleft = 0;
      var curtop = 0;
      if (obj.offsetParent) {
        do {
          curleft += obj.offsetLeft;
          curtop += obj.offsetTop;
        } while (obj = obj.offsetParent);
      }
    return {
      left: curleft,
      top: curtop
    }
  }
</script>
<script type="text/javascript">
var webx_data;
var dashboardStatus = 0;
var widgetDrawerStatus = 0;

var dock_created = false;

/*
  * method $ce(element)
  *	shortcut for document.createElement(element)
  */

function $ce(ele) {
  return document.createElement(ele);
}
/*
  * method stCap(string)
  *	returns a string with first letter capitalized
  *	and the rest of the string in lowercase
  */

function stCap(str) {
  return (str.charAt(0).toUpperCase() + str.substr(1).toLowerCase());
}
/*
  * method canvasLeft(string)
  *	returns absoluteLeft() of the canvas to the browser
  */

function canvasLeft() {
  return document.getRootElement().getAbsoluteLeft();
}

/*--- WEBX OBJECT ---*/
var WebX = {};
WebX.init = function () {
  this.create = new WebX.Create();
  this.clock = new WebX.Clock();
  this.menubar = new WebX.Menubar();
  this.window = new WebX.Window();
  //windowResize();
};

WebX.Create = function () {};

WebX.Clock = function () {};
WebX.Clock.prototype.create = function(ele_id, target_id) {
  $('<div>', {
    id: ele_id
  }).appendTo('#' + target_id);
  WebX.clock.update('#' + ele_id);
};

WebX.Clock.prototype.update = function(ele_id) {
  var now = new Date();
  var hours = now.getHours();
  var mins = now.getMinutes();
  var secn = now.getSeconds();
  var day = now.getDay();
  var theDay = now.getDate();
  var month = now.getMonth();
  var year = now.getFullYear();
  var dayList = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
  var monthList = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
  if (hours >= 12) { AorP = "PM"; } else { AorP = "AM"; }
  if (hours >= 13) { hours -= 12; }
  if (hours === 0) { hours = 12; }
  if (secn < 10) { secn = "0" + secn; }
  if (mins < 10) { mins = "0" + mins; }
  $(ele_id).html(dayList[day] + ",&nbsp;" + monthList[month] + "&nbsp;" + theDay + ",&nbsp;" + year + "&nbsp;&nbsp;|&nbsp;&nbsp;" + hours + ":" + mins + "&nbsp;" + AorP);
  setTimeout(function () {
    WebX.clock.update(ele_id);
  }, 1000);
};

WebX.Menubar = function() {};
WebX.Menubar.prototype.create = function() {
  var menubar = $('<div>', {
    id: "menubar"
  }).appendTo('#webxWrapper');

  var menubar_ul = $('<ul>', {id: "menubar_ul"}).appendTo(menubar);

  var user_area = $('<li>', {
    id: 'mb_user_area',
    css: {
      'float': 'right',
      'margin': '2px 16px 0px 8px'
    }
  }).appendTo(menubar_ul);
  
  WebX.clock.create('wx_mb_clock','mb_user_area');
  
  $('<div>', {
    id: 'wx_mb_user_name',
    text: 'Default User'
  }).prependTo(user_area);
  
  $('<div>', {
    id: 'wx_mb_user_pic'
  }).prependTo(user_area);

  for (var this_item in webx_data.menubar.items ) {
    WebX.menubar.create_link(webx_data.menubar.items[this_item],menubar_ul);
  }
  
  for (var panel in webx_data.menubar.panels) {
    if(panel !== 'login') {
      var thisLeft = parentOffsets($('#mb_'+ panel)[0]).left;
      webx_data.menubar.panels[panel].offsetLeft = (thisLeft) + "px";
      WebX.menubar.create_panel(panel, '#webx_wrapper'); 
    }
  }
};

WebX.Menubar.prototype.create_link = function(obj,target) {
  $('<li>', {
    className: "mb_item",
    id: 'mb_' + obj,
    text: stCap(obj),
    click: function (e) {
      e.preventDefault();
      var panel_name = "#" + obj + "_panel";
      $('div.mbWindow').not(panel_name).slideUp(210);
      $(panel_name).slideToggle();
      return false;
    },
    mouseover: function (e) {
      var panel_name = "#" + obj + "_panel";
      if ($('div.mbWindow').not(panel_name).is(':visible')) {
        $('div.mbWindow').not(panel_name).slideUp(210);
        $(panel_name).slideToggle();
      } else {
        e.preventDefault();
        return false;
      }
    }
  }).appendTo(target);
};

WebX.Menubar.prototype.create_panel = function(panel, target) {
  // console.log(panel+" panel: "+webx_data.menubar.panels[panel]+" - left: "+webx_data.menubar.panels[panel].styles.left);
  var panel_name = panel + '_panel';
  var mb_panel = $('<div>', {
    id: panel_name,
    className: "mbWindow",
    css: {
      'position': 'absolute',
      'top': getDimensions('#menubar').height + 'px',
      'left': webx_data.menubar.panels[panel].offsetLeft
    }
  }).appendTo('#webxWrapper');
  
  var mb_link_ul = $('<ul>').appendTo(mb_panel);

  for (var o = 0; o < webx_data.menubar.panels[panel].length; o++) {
    WebX.menubar.create_panel_link(panel, webx_data.menubar.panels[panel][o], mb_link_ul);
  }
  
  mb_panel.slideUp();
};

WebX.Menubar.prototype.create_panel_link = function(panel, link_name, target) {
  var mb_link_li = $('<li>', {
    text: stCap(link_name),
    click: function (e) {
      e.preventDefault();
      return false;
    }
  }).appendTo(target);
  
  switch (panel) {
  case "dock":
    if(link_name === "toggle") {
      $(mb_link_li).bind('click', function () {
        wxDockToggle();
        return false;
      });
    }
    break;
  case "login":
    switch (link_name) {
    case "register":
      $(mb_link_li).bind('click', function () {
        WebX.create.login();
        return false;
      });
      break;
    case "login":
      $(mb_link_li).bind('click', function () {
        login();
        return false;
      });
      break;
    }
    break;
  }
};

WebX.Window = function () {};
WebX.Window.prototype.maximize = function (ele) {
  var width_modifier;
  var height_modifier;
  if($(ele).data('windowType') === 'finder'){
    width_modifier =136;
    height_modifier = 27;
  } else {
    width_modifier = 0;
    height_modifier = 0;
  }
  var browser_size = getDimensions(document.getElementsByTagName('body')[0]);
  if (!$(ele).data('sizeState') || $(ele).data('sizeState') !== "max") {
    var eleSize = getDimensions($(ele));
    $(ele).data({
      "originalLeft": $(ele).css("left"),
      "originalTop": $(ele).css("top"),
      "originalHeight": eleSize.height,
      "originalWidth": eleSize.width,
      "sizeState": "min"
    });
  }
  if ($(ele).data('sizeState') === "min") {
    $(ele).css({
      "width": browser_size.width + "px",
      "height": browser_size.height - $('#menubar').outerHeight(true) + "px",
      "top": $('#menubar').outerHeight(true) + "px",
      "left": width_modifier + "px"
    });
    $(ele).find('.wxWindow_body').css({
      "width": "100%",
      "height": ($(ele).outerHeight(false) - 60 - height_modifier) + "px"
    });
    $(ele).find('.wxWindow_body_content').css({
      "width": ($(ele).find('.wxWindow_body_wrapper').outerWidth(false) - width_modifier) + "px",
      "height": "100%",
      "left": width_modifier + "px"
    });
    $(ele).data('sizeState', "max");
  } else {
    $(ele).css({
      "width": $(ele).data('originalWidth') + "px",
      "height": $(ele).data('originalHeight') + "px",
      "top": $(ele).data('originalTop'),
      "left": $(ele).data('originalLeft')
    });
    $(ele).find('.wxWindow_body').css({
      "width": "100%",
      "height": ($(ele).data('originalHeight') - 60 - (($(ele).data('windowType') === 'finder') ? height_modifier - 2 : height_modifier)) + "px"
    });
    $(ele).find('.wxWindow_body_content').css({
      "width": ($(ele).find('.wxWindow_body_wrapper').outerWidth(false) - width_modifier) + "px",
      "height": "100%",
      "left": width_modifier + "px"
    });
    $(ele).data('sizeState', "min");
  }
};

WebX.Window.prototype.close = function (ele) {
  if (!$(ele).data('viewState')) {
    $(ele).data({
      "viewState": ""
    });
  }
  if ($(ele).data('viewState') !== "closed") {
    $(ele).fadeOut(420);
    $(ele).data('viewState', "closed");
  }
};

WebX.Window.prototype.open = function (ele, opt) {
  if (!$(ele).data('viewState')) {
    $(ele).data({
      "viewState": ""
    });
  }
  if ($(ele).data('viewState') !== "open") {
    $(ele).fadeIn(420);
    $(ele).data('viewState', "open");
  }
};

WebX.Window.prototype.toggle = function (ele) {
  if ($(ele).length === 0) {
    var window_title;
    var window_content;
    var window_type;
    switch (ele.replace('#wxWindow_', '')) {
    case 'Settings':
      window_title = 'Settings';
      window_content = 'Settings will go here.';
      window_type = 'finder';
      break;
    default:
      window_title = 'Title';
      window_content = '';
      window_type = 'finder';
      break;
    }
    WebX.create.window(window_type, 357, 287, ele.replace('#', ''), window_title, window_content);
    $(ele).fadeIn(420);
  } else if ($(ele).is(':visible')) {
    WebX.window.close(ele);
  } else if (!$(ele).is(':visible')) {
    WebX.window.open(ele);
  }
};

WebX.Create.prototype.dock = function () {

  var theDock = $('<div/>', { id: "wxDock" }).appendTo('#webxWrapper');
  var theDock_wrapper = $('<div/>', { id: "wxDock_wrapper" }).appendTo(theDock);
  
  $('<div/>', { id: "wxDock_left" }).appendTo(theDock_wrapper);
  var dock_content = $('<ul/>', { id: "wxDock_ul" }).appendTo(theDock_wrapper);
  $('<div/>', { id: "wxDock_right" }).appendTo(theDock_wrapper);

  webx_data.dock.items.forEach(function (obj) {
  
    var dock_item = $('<li>', {
      className: 'wxDock_item',
      id: 'wxDock_item_' + webx_data.dock[obj].name,
      data: {
        "name": webx_data.dock[obj].name
      }
    }).appendTo(dock_content);
    
    var icon_div = $('<div/>', {
      className: 'iIcon dockIcon',
      id: 'dock_' + webx_data.dock[obj].name
    }).appendTo(dock_item);

    $('<div/>', {
      className: "iGloss"
    }).appendTo(icon_div);

    if (webx_data.dock[obj].name === "Dashboard") {
      WebX.create.dashboard();
      $(icon_div).bind('click', function () {
        wxDashInit();
        return false;
      });
    } else if (webx_data.dock[obj].name === "Settings") {
      $(icon_div).bind('click', function () {
        WebX.window.toggle('#wxWindow_Settings');
        return false;
      });
    }
  });

  // center the dock in the middle of the browser
  var dockWidth = getDimensions($('#wxDock')).width;
  $('#wxDock').css({
    "marginLeft": -(dockWidth / 2) + "px"
  });

  // build a title tip for each link in dock
  $(".wxDock_item").each(function () {
    var icon_name = $(this).data('name');
    var tip_id = 'wxDock_tip_' + icon_name;
    var theTip = WebX.create.dockTip(tip_id, icon_name);
    
    $(this).append(theTip);

    var tipWidth = $("div#" + tip_id).width();
    var tipPos = (tipWidth / 2);
    
    $("div#" + tip_id).css({
      "margin-left": '-' + tipPos + "px"
    });
    
    // $(this).bind("mouseover", function () {
    //   $('div#' + tip_id).show();
    // }).bind("mouseout", function () {
    //   $('div#' + tip_id).fadeOut('210');
    // });
    
  }); // end a each function

  // make sortable
  $(dock_content).sortable({
    opacity: 0.80,
    helper: 'clone',
    revert: true,
    tolerance: 'pointer',
    start: function(event, ui) {
      $("#" + ui.item[0].id).find('.wxTip').addClass('moving');
    },
    stop: function(event, ui) {
      $("#" + ui.item[0].id).find('.wxTip').removeClass('moving');
    }
  });
  $(dock_content).disableSelection();
};

WebX.Create.prototype.dockTip = function (tipID, tipText) {
  var table = $('<div/>', {
    className: "wxTip",
    id: tipID
  });
  $('<div/>', {
    className: "wxTipText",
    text: tipText
  }).appendTo(table);

  return table;
};

WebX.Create.prototype.dashboard = function () {
  $('<div>', {
    id: "dashboardPanel"
  }).appendTo(document.getElementsByTagName('body')[0]);

  var dbOverlay = $('<div>', {
    id: "dbOverlay",
    click: function () {
      wxDashInit();
      return false;
    }
  }).appendTo('div#webxWrapper');
  $('<div>', {
    id: "dbDrawerButton",
    click: function () {
      wxDashDrawer();
      return false;
    }
  }).appendTo(dbOverlay);
  $('<div>', {
    id: "dbManageButton"
  }).appendTo(dbOverlay);
};

WebX.Create.prototype.window = function (type, width, height, id, title, content) {
  var wx_window = $('<div/>', {
    className: "wxWindow wxWindow_" + type,
    id: id,
    css: {
      "width": width + "px",
      "height": height + "px",
      "display": "none"
    }
  }).appendTo("#webxWrapper");
  
  $(wx_window).data('windowType',type);
  $(wx_window).data('windowState','expanded');
  switch(type){
    case "finder":
      break;
    case "settings":
      break;
    case "utility":
      break;
    case "app":
      break;
    default:
      break;
  }

  // top bar
  var wx_window_top = $('<div/>', {
    className: "wxWindow_top"
  }).appendTo(wx_window);

  var wx_window_top_wrapper = $('<div/>', {
    className: "wxWindow_top_wrapper"
  }).appendTo(wx_window_top);

  $('<div/>', {
    className: "wxWindow_top_title",
    html: title
  }).appendTo(wx_window_top_wrapper);
  
  var window_buttons_box = $('<div/>', {
    className: "wxWindow_top_buttons"
  }).appendTo(wx_window_top_wrapper);

  // Close Button
  $('<div/>', {
    className: "button close",
    click: function() {
      WebX.window.close(wx_window);
      return false;
    },
    mouseover: function () {
      $(this).html("x");
    },
    mouseout: function () {
      $(this).html("");
    }
  }).appendTo(window_buttons_box);

  // Minimize Button
  $('<div/>', {
    className: "button minimize",
    click: function () {
      return false;
    },
    mouseover: function () {
      $(this).html("-");
    },
    mouseout: function () {
      $(this).html("");
    }
  }).appendTo(window_buttons_box);
  
  // Maximize Button
  $('<div/>', {
    className: "button maximize",
    click: function() {
      WebX.window.maximize(wx_window);
      return false;
    },
    mouseover: function () {
      $(this).html("+");
    },
    mouseout: function () {
      $(this).html("");
    }
  }).appendTo(window_buttons_box);
  
  // Pill button
  $('<div/>', {
    className: "wxWindow_top_pill",
    click: function () {
      var pill_ele = $(this).parent().parent().parent();
      wxWindowPillToggle(pill_ele);
      return false;
    },
    mouseover: function () {
      $(this).html("-");
    },
    mouseout: function () {
      $(this).html("");
    }
  }).appendTo(wx_window_top_wrapper);
  
  $('<div/>', {
    className: "wxWindow_top_toolbar"
  }).appendTo(wx_window_top_wrapper);
  
  // bottom bar
  if(type !== 'app') {
   var wx_window_bottom = $('<div/>', {
     className: "wxWindow_footer"
   }).appendTo(wx_window);
   
   $('<div/>', {
     className: "wxWindow_footer_wrapper"
   }).appendTo(wx_window_bottom); 
  }

  // middle content
  var wx_window_content = $('<div/>', {
    className: "wxWindow_body resize_me",
    css: {
      "height": ($(wx_window).outerHeight(false) - 60 - ((type !== 'app') ? 27 : 3)) + "px"
    }
  }).appendTo(wx_window);
  
  var wx_window_body_wrapper = $('<div/>', {
    className: "wxWindow_body_wrapper",
    css: {
      "width": "100%",
      "height": "100%"
    }
  }).appendTo(wx_window_content);
  
  // Sidebar
  if(type === 'finder') {
    $('<div/>', {
      className: "wxWindow_body_sidebar",
      css: {
        "height": "100%"
      }
    }).appendTo(wx_window_body_wrapper);
  }
  
  // Body Content
  var window_body_width_modifier;
  if(type === 'finder') {
    window_body_width_modifier = 136;
  } else {
    window_body_width_modifier = 0;
  }
  $('<div/>', {
    className: "wxWindow_body_content",
    css: {
      "width": (width - window_body_width_modifier) + "px",
      "height": "100%",
      "left": window_body_width_modifier + "px"
    },
    html: content
  }).appendTo(wx_window_body_wrapper);

  // make draggable
  $(wx_window).draggable({
    containment: document.getElementsByTagName('body')[0],
    stack: ".wx_window",
    handle: wx_window_top,
    zIndex: 10
  });

 // make resizeable
//  $(wxWindow_body_sidebar).resizable({
//    resize: function(event, ui) {
//      $(ui.element).parent().find('.wxWindow_body_content').css({
//        "width": ($(ui.element).outerWidth(false) + $(ui.element).parent().find('.wxWindow_body_content').outerWidth(false)) + "px",
//        "left": $(ui.element).outerWidth(false)
//      });
//    }
//  });
  
  $(wx_window).resizable({
    alsoResize: $(wx_window).find('.resize_me'),
    minHeight: 135,
    minWidth: 250,
    handles: "se",
    resize: function(event, ui) {
      $(ui.element).find('.wxWindow_body_content').css({
        "width": ($(ui.element).outerWidth(false) - (($(ui.element).find('.wxWindow_body_sidebar').length !== 0) ? $(ui.element).find('.wxWindow_body_sidebar').outerWidth(false)+1 : 0)) + "px"
      });
    }
  });

  // position resizer for the right position
  $(wx_window).find('.ui-icon-gripsmall-diagonal-se').css({
    "position": "absolute",
    "bottom": "0px",
    "right": "0px",
    "width": "10px",
    "height": "10px"
  });

  return wx_window;
};

WebX.Create.prototype.login = function () {
  var loginbox = $ce('div');
  $(loginbox).attr('id', 'loginbox').css({
    "width": "100%",
    "height": "100%",
    "background": "#737373",
    "color": "#000",
    "zIndex": "20"
  }).html("<label for='user_nick'>Choose a Nickname</label><br /><input type='text' name='user_nick' id='nickname_input' /><br /><p><input type='button' value='Create User' id='registerSubmit'/></p>");
  $('#webxWrapper').append(loginbox);
  $('#registerSubmit').click(function () {
    register();
    return false;
  });
};

function wxDockClose() {
  $('#wxDock').animate({
    'margin-bottom': '-58px'
  }, 420, 'easeOutExpo', function () {
    $('#wxDock').data('state', 'closed');
  });
}

function wxDockOpen() {
  $('#wxDock').animate({
    'margin-bottom': '0px'
  }, 420, 'easeOutExpo', function () {
    $('#wxDock').data('state', 'open');
  });
}

function wxDockToggle() {
  if ($('#wxDock').css('margin-bottom') === '0px') {
    wxDockClose();
  } else {
    wxDockOpen();
  }
}

function wxWindowPillExpand(ele) {
var elements;
switch($(ele).data('windowType')) {
  case "finder":
    elements = [
      $(ele),
      $(ele).find('.wxWindow_top'),
      $(ele).find('.wxWindow_footer'),
      $(ele).find('.wxWindow_body_sidebar'),
      $(ele).find('.wxWindow_body_content'),
      $(ele).find('.wxWindow_body')
    ];
    
    var tool_bar_size = elements[0].data('originalStyles').tool_bar_size;
    var footer_size = elements[0].data('originalStyles').footer_size;
    var sidebar_size = elements[0].data('originalStyles').sidebar_size;
    
    elements[0].animate({
        "height": '+=' + (39 + 23),
        "width": '+=' + 135,
        "left": '-=' + 135,
        "-webkit-border-radius": "4px 4px 4px 4px",
        "-moz-border-radius": "4px 4px 4px 4px",
        "border-radius": "4px 4px 4px 4px",
        "border-bottom": "1px solid rgba(155,155,155,1)"
      }, {
        queue: false,
        duration: 420,
        easing: "linear"
      });
      elements[1].animate({
          height: '+=' + 39
        }, {
          queue: false,
          duration: 420,
          easing: "linear"
        });
      elements[2].animate({
          height: '23px'
        }, {
          queue: false,
          duration: 420,
          easing: "linear"
        });
      elements[3].animate({
          width: '135px'
        }, {
          queue: false,
          duration: 420,
          easing: "linear"
        });
      elements[4].animate({
          left: '135px'
        }, {
          queue: false,
          duration: 420,
          easing: "linear"
        });
      elements[5].animate({
          width: elements[5].outerWidth(false) + 135 + "px"
        }, {
          queue: false,
          duration: 420,
          easing: "linear"
        });
      break;
    case "settings":
      break;
    case "utility":
      break;
    case "app":
      break;
    default:
      break;
  }
  $(ele).data('windowState', 'expanded');
}

function wxWindowPillContract(ele) {
  var elements;
  switch($(ele).data('windowType')) {
    case "finder":
      elements = [
        $(ele),
        $(ele).find('.wxWindow_top'),
        $(ele).find('.wxWindow_footer'),
        $(ele).find('.wxWindow_body_sidebar'),
        $(ele).find('.wxWindow_body_content'),
        $(ele).find('.wxWindow_body')
      ];
      
      var tool_bar_size = elements[0].find('.wxWindow_top_toolbar').outerHeight(false);
      var footer_size = elements[2].outerHeight(false);
      var sidebar_size = elements[3].outerWidth(false);
      
      elements[0].data('originalStyles', {
          "tool_bar_size": tool_bar_size,
          "footer_size": footer_size,
          "sidebar_size": sidebar_size
        }).animate({
          "height": '-=' + (39 + 23),
          "width": '-=' + 135,
          "left": '+=' + 135,
          "-webkit-border-radius": "4px 4px 0px 0px",
          "-moz-border-radius": "4px 4px 0px 0px",
          "border-radius": "4px 4px 0px 0px",
          "border-bottom": "1px solid rgba(155,155,155,0)"
        }, {
          queue: false,
          duration: 420,
          easing: "linear"
        });
      elements[1].animate({
          height: '-=' + 39
        }, {
          queue: false,
          duration: 420,
          easing: "linear"
        });
      elements[2].animate({
          height: '0px'
        }, {
          queue: false,
          duration: 420,
          easing: "linear"
        });
      elements[3].animate({
          width: '0px'
        }, {
          queue: false,
          duration: 420,
          easing: "linear"
        });
      elements[4].animate({
          left: '0px'
        }, {
          queue: false,
          duration: 420,
          easing: "linear"
        });
      elements[5].animate({
          width: elements[5].outerWidth(false) - 135 + "px"
        }, {
          queue: false,
          duration: 420,
          easing: "linear"
        });
      break;
    case "settings":
      break;
    case "utility":
      break;
    case "app":
      break;
    default:
      break;
  }
  $(ele).data('windowState', 'contracted');
}

function wxWindowPillToggle(ele) {
  if($(ele).data('windowState') === 'expanded'){
    wxWindowPillContract(ele);
  } else {
    wxWindowPillExpand(ele);
  }
}

function wxDashInit() {
  //loads popup only if it is disabled
  if (dashboardStatus === 0) {
    $("div#dbManageButton").hide();
    $('div#dbOverlay').animate({
      opacity: "toggle"
    }, 420);
    dashboardStatus = 1;
  } else if (dashboardStatus === 1 && widgetDrawerStatus === 1) {
    $('div#webxWrapper, div#dbOverlay').animate({
      marginTop: "0px"
    }, {
      queue: false,
      duration: 420
    });
    $("div#dbDrawerButton").animate({
      rotate: '+=135deg'
    }, {
      queue: false,
      duration: 420
    });
    $("div#dbManageButton").animate({
      opacity: 'toggle'
    }, {
      queue: false,
      duration: 420
    });
    $("div#dbOverlay").fadeOut(420);
    widgetDrawerStatus = 0;
    dashboardStatus = 0;
  } else if (dashboardStatus === 1) {
    $("div#dbOverlay").fadeOut(420);
    dashboardStatus = 0;
  }
}

function wxDashDrawer() {
  if (widgetDrawerStatus === 0) {
    $('div#webxWrapper, div#dbOverlay').animate({
      marginTop: "-118px"
    }, {
      duration: 420
    }, "linear");
    $("div#dbDrawerButton").animate({
      rotate: '-=135deg'
    }, {
      queue: false,
      duration: 420
    });
    $("div#dbManageButton").animate({
      opacity: 'toggle'
    }, {
      queue: false,
      duration: 420
    });
    widgetDrawerStatus = 1;
  } else if (widgetDrawerStatus === 1) {
    $('div#webxWrapper, div#dbOverlay').animate({
      marginTop: "0px"
    }, {
      duration: 420
    }, "linear");
    $("div#dbDrawerButton").animate({
      rotate: '+=135deg'
    }, {
      queue: false,
      duration: 420
    });
    $("div#dbManageButton").animate({
      opacity: 'toggle'
    }, {
      queue: false,
      duration: 420
    });
    widgetDrawerStatus = 0;
  }
}

function updateSettings() {
  var settings = JSON.stringify(webx_data);
  var newParams = {
    "fb_uid": <?=$uid?> ,
    "settings" : settings
  };
  var ajax = new Ajax();
  ajax.responseType = Ajax.RAW;
  ajax.ondone = function () {
    console.log('webx_fb settings updated');
  }
  ajax.onerror = function () {
    console.log("update settings ERROR!!");
  };
  ajax.post("<?=base_url().'user/updateSettings'?>", newParams);
}

function getSettings() {
  var newParams = {
    "fb_uid": <?=$uid?>
  };
  var ajax = new Ajax();
  ajax.responseType = Ajax.JSON;
  ajax.ondone = function (data) {
    // console.log(data.content);
    var newData = data.content;
    newData = JSON.parse(newData);
    console.log(newData);
  }
  ajax.onerror = function () {
    console.log("get settings ERROR!!");
  };
  ajax.post("<?=base_url().'user/getSettings'?>", newParams);
}

function check() {
  var json = JSON.stringify(webx_data);
  console.log(json);
  var jsoned = JSON.parse(json);
  console.log(jsoned);
}

function register() {
  var params = {
    "facebook_uid": <?=$uid?>,
    "first_name" : "<?=$userInfo['first_name']?>",
    "last_name" : "<?=$userInfo['last_name']?>",
    "image_url": "<?=$userInfo['pic_square']?>",
    "user_nick": $("#nickname_input").val()
  };
  var ajax = new Ajax();
  ajax.requireLogin = true;
  ajax.responseType = Ajax.RAW;
  ajax.ondone = function () {
    console.log("new user : " + params.user_nick + " created.");
    // updateSettings();
    $('#loginbox').fadeOut().remove();
  };
  ajax.onerror = function () {
    console.log("create user ERROR!!");
  };
  ajax.post("<?=base_url().'user/newUser'?>", params);
}

function login() {
  var params = {
    "fb_uid": <?=$uid?>
  };
  var ajax = new Ajax();
  ajax.requireLogin = true;
  ajax.responseType = Ajax.JSON;
  ajax.ondone = function (data) {
    var user_settings = JSON.parse(data.content);
    console.log(user_settings);
    $('#loginbox').fadeOut().remove();
  };
  ajax.onerror = function () {
    console.log("LOGIN ERROR!!");
  };
  ajax.post("<?=base_url().'user/getSettings'?>", params);
}

function getUserId() {
  var params = {
    "fb_uid": <?=$uid?>
  };
  var ajax = new Ajax();
  ajax.responseType = Ajax.RAW;
  ajax.ondone = function (data) {
    console.log(data);
  };
  ajax.onerror = function () {
    console.log("LOGIN ERROR!!");
  };
  ajax.post("<?=base_url().'user/getUserId'?>", params);
}

function windowResize() {
  $('#wallpaper').parent().hide();
  var wallpaper_source = $('#wallpaper').attr('src');
  var browser_size = getDimensions(document.getElementsByTagName('body')[0]);
  var rows = 5;
  var browser_divided = browser_size.height / rows;
  $('div.split_row').remove();
  for (var i = 0; i < rows; i++) {
    var div_row = $('<div>', {
      className: 'split_row',
      id: 'split_row_num_' + i,
      css: {
        'width': browser_size.width + "px",
        'height': browser_divided + "px",
        'background': 'url("' + wallpaper_source + '") no-repeat 0 ' + -(browser_divided * i) + 'px',
        'backgroundSize': '100%',
        'position': 'absolute',
        'top': (i === 0) ? 0 : (browser_divided * i) + 'px',
        'left': 0,
        'zIndex': 2,
        'display': 'block',
        'margin': 0,
        'padding': 0
      }
    }).appendTo('#webxWrapper');
    if (i !== (rows - 1)) {
      $('<div>', {
        css: {
          'width': '45px',
          'height': '45px',
          'background': '#cccccc',
          'color': '#333333',
          'textAlign': 'center',
          'float': 'right'
        },
        text: "open #" + i,
        data: {
          "dash_number": i
        },
        click: function () {
          toggleFolderDashboard($(this).data('dash_number'));
        }
      }).appendTo(div_row);
    }
    $('<div>', {
      className: 'shades',
      css: {
        'width': '100%',
        'height': '100%',
        'background': 'url(<?=$base_url?>assets/imgs/dashboard/overlay.png) repeat',
        'zIndex': 3,
        'display': 'none'
      }
    }).appendTo(div_row);
    var row_dash = $('<div>', {
      className: 'row_dash',
      id: 'row_dash_num_' + i,
      css: {
        'width': browser_size.width + "px",
        'height': browser_divided + "px",
        'background': '#cccccc',
        'position': 'absolute',
        'top': (i === 0) ? 0 : (browser_divided * i) + 'px',
        'left': 0,
        'zIndex': 1,
        'display': 'block',
        'margin': 0,
        'padding': 0
      }
    }).appendTo('#webxWrapper');
  }
}

function openFolderDashboard(val) {
  var this_name = 'div#split_row_num_' + val;
  var height = parseInt($('div.split_row').eq(val).css("height"));
  $('div.split_row').not($('div.split_row').slice(0, (val + 1))).each(function (i) {
    var this_top = parseInt($(this).css('top'));
    var this_height = parseInt($(this).css('height'));
    var new_top = this_height + this_top;
    $(this).animate({
      top: (new_top) + 'px'
    }, {
      queue: false,
      duration: 420
    }, "swing");
  });
  $(this_name).toggleClass('dash_open');
  // $('#theDock').animate({
  //     'bottom' : -(height)+"px"
  //   }, { queue:false, duration:420}, "linear");
}

function closeFolderDashboard(val) {
  var row_num = $('div.split_row').length;
  var this_name = 'div#split_row_num_' + val;
  var height = parseInt($('div.split_row').eq(val).css("height"));
  $('div.split_row').not($('div.split_row').slice(0, (val + 1))).each(function (i) {
    var this_top = parseInt($(this).css('top'));
    var this_height = parseInt($(this).css('height'));
    var new_top = this_top - this_height;
    $(this).animate({
      top: (new_top) + 'px'
    }, {
      queue: false,
      duration: 420
    }, "swing");
  });
  $(this_name).toggleClass('dash_open');
  // $('#theDock').animate({
  //     'bottom' : "0px"
  //   }, { queue:false, duration:420}, "linear");
}

function toggleFolderDashboard(val) {
  var row_num = $('div.split_row').length;
  var this_name = String('div#split_row_num_' + val);

  if ((row_num - 1) === val) {
    return false;
  }

  if ($(this_name).attr('class').match('dash_open') !== null) {
    closeFolderDashboard(val);
    $('.shades').fadeOut(420);
  } else {
    // $('div.split_row').not(this_name).each(function(i){ if($(this).attr('class').match('dash_open') !== null) {
    //   closeFolderDashboard($(this).attr('id').slice(-1));
    // } });
    openFolderDashboard(val);
    $('.shades').fadeIn(420);
  }
}

function doSomething() {
  // $('#contentbox').hover(function(){this.css('background','#ffffff');},function(){this.css('background','#666666');});
  $('#starter').hide();
  WebX.menubar.create();
  WebX.create.dock();
  // console.log(webx_data.userInfo);
  // $('#contentbox').html("<a href='#' id='dynamic'>ooh dynamic!</a>");
  // $('#dynamic').click(function(){  });
  // $('#contentbox').removeChild($('#contentbox').getFirstChild());
}
$(window).bind('resize', function () {
  //windowResize();
});

$(document).ready(function () {
  $.preload([
    '<?=base_url()?>assets/imgs/menubar/default_user.png',
    '<?=$base_url?>assets/imgs/dock/dock_ends.png',
    '<?=$base_url?>assets/imgs/dock/dock_02.png',
    '<?=base_url()?>assets/imgs/dock/dock_sprite.png',
    '<?=$base_url?>assets/imgs/dashboard/dashBack.gif',
    '<?=$base_url?>assets/imgs/dashboard/widgetDrawer.png',
    '<?=$base_url?>assets/imgs/dashboard/manage.png',
    '<?=base_url()?>assets/imgs/wallpaper/Vitrieth_by_iumazark.jpg'
    ], {
    init: function (loaded, total) {
      $("#starter").find('p').html("Loading...");
    },
    loaded: function (img, loaded, total) {
      $("#starter").find('p').html("Loading...");
    },
    loaded_all: function (loaded, total) {
      $("#starter").find('p').html("Click to Start");
      $.post('<?=base_url()?>user/getDefaultSettings', function (data) {
        webx_data = data;
        WebX.init();
        $("#starter").click(function () {
          doSomething();
          return false;
        });
      });
    }
  });
});
</script>