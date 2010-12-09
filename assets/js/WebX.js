var WebX = {
  init: function () {
    this.create = new WebX.Create();
    this.window = new WebX.Window();
    this.browser = new WebX.Browser();
    this.finder = new WebX.Finder();

    var webx_wrapper = $('<div/>', {
      id: "webxWrapper"
    }).appendTo(document.getElementsByTagName('body')[0]);
    $('<div/>', {
      innerHTML: '<img id="wallpaper" src="assets/imgs/wallpaper/smhomerpollack2010.jpg" alt="" title="" />'
    }).appendTo(webx_wrapper);
    $('#starter').hide();
    WebX.Menubar.init();
    WebX.Dock.init();
    WebX.Dashboard.init();
    
    //windowResize();
  },
  Clock: {
    create: function (ele_id, target) {
      $('<div>', {
        id: ele_id
      }).appendTo(target);
      WebX.Clock.update('#' + ele_id);
    },
    update: function (ele_id) {
      var now = new Date();
      now.hours = now.getHours();
      now.mins = now.getMinutes();
      now.secn = now.getSeconds();
      now.day = now.getDay();
      now.theDay = now.getDate();
      now.month = now.getMonth();
      now.year = now.getFullYear();
      var dayList = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
      var monthList = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
      if (now.hours >= 12) {
        now.AorP = "PM";
      } else {
        now.AorP = "AM";
      }
      if (now.hours >= 13) {
        now.hours -= 12;
      }
      if (now.hours === 0) {
        now.hours = 12;
      }
      if (now.secn < 10) {
        now.secn = "0" + now.secn;
      }
      if (now.mins < 10) {
        now.mins = "0" + now.mins;
      }
      $(ele_id).html(dayList[now.day] + ",&nbsp;" + monthList[now.month] + "&nbsp;" + now.theDay + ",&nbsp;" + now.year + "&nbsp;&nbsp;|&nbsp;&nbsp;" + now.hours + ":" + now.mins + "&nbsp;" + now.AorP);
      setTimeout(function () {
        WebX.Clock.update(ele_id);
      }, 1000);
    }
  },
  Menubar: {
    init: function () {
      var menubar = $('<div>', {
        id: "wxMenubar"
      }).appendTo('#webxWrapper');

      var user_area = $('<div>', {
        id: 'mb_user_area'
      }).appendTo(menubar);

      WebX.Clock.create('wx_mb_clock', user_area);

      $('<div>', {
        id: 'wx_mb_user_name',
        text: 'Default User'
      }).prependTo(user_area);

      $('<div>', {
        id: 'wx_mb_user_pic'
      }).prependTo(user_area);

      // for (var item in webx_data.menubar) {
      //   WebX.menubar.create_link(webx_data.menubar.items[this_item], menubar_ul);
      // }

      for (var item in webx_data.menubar) {
        var menubar_ul = $('<ul>', {
          className: "menubar_ul",
          id: "menubar_ul_" + item
        }).appendTo(menubar);
        for (var link in webx_data.menubar[item]) {
          WebX.Menubar.create_link(item+"_"+link, menubar_ul);
        }
        // 
      }
      // make finder menubar show
      $(menubar).find('ul.menubar_ul').not('#menubar_ul_finder').each(function(){
        $(this).hide();
      });
    },
    create_link: function (obj, target) {
      var names = obj.split("_");
      var menubar_li = $('<li>', {
        className: "mb_item disabled",
        id: 'mb_' + obj,
        text: names[1],
        click: function(e) {
          e.preventDefault();
          $(this).toggleClass('disabled').toggleClass('enabled');
          $(target).find('li.enabled').not(this).each(function(){
            $(this).toggleClass('enabled').toggleClass('disabled');
          });
          return false;
        },
        mouseover: function(e) {
          if($(target).find('li.enabled').not(this).length === 1) {
            $(target).find('li.enabled').not(this).each(function(){
              $(this).toggleClass('enabled').toggleClass('disabled');
            });
            $(this).toggleClass('enabled').toggleClass('disabled');
          }
          return false;
        }
      }).appendTo(target);
      WebX.Menubar.create_panel(obj,webx_data.menubar[names[0]][names[1]],menubar_li);
    },
    create_panel: function (panel, contents, target) {
      // console.log(panel+" panel: "+webx_data.menubar.panels[panel]+" - left: "+webx_data.menubar.panels[panel].styles.left);
      var panel_name = panel + '_panel';

      var mb_panel = $('<div>', {
        id: panel_name,
        className: "mbWindow"
      }).appendTo(target);

      var mb_link_ul = $('<ul>').appendTo(mb_panel);

      for (var panel_link in contents) {
        WebX.Menubar.create_panel_link(panel_link, contents[panel_link], mb_link_ul);
      }
    },
    create_sub_panel: function (panel, contents, target) {
      // console.log(panel+" panel: "+webx_data.menubar.panels[panel]+" - left: "+webx_data.menubar.panels[panel].styles.left);
      var panel_name = panel + '_sub_panel';

      var mb_panel = $('<div>', {
        id: panel_name,
        className: "mbSubWindow"
      }).appendTo(target);

      var mb_link_ul = $('<ul>').appendTo(mb_panel);

      for (var panel_link in contents) {
        WebX.Menubar.create_panel_link(panel_link, contents[panel_link], mb_link_ul);
      }
    },
    create_panel_link: function (link_name, link_funcs, target) {
      var mb_link_li = $('<li>', {
        text: link_name
      }).appendTo(target);

      if(link_funcs.click !== 'false') {
        var func = eval( "(" + link_funcs.click + ")" );
        mb_link_li.bind('click', function(){
          func();
          return false;
        });
      } else {
        mb_link_li.bind('click', function(){
          return false;
        });
      }
      if(link_funcs.list) {
        WebX.Menubar.create_sub_panel(link_name,link_funcs.list,mb_link_li);
      }
    },
    switch_to: function(menubar) {
      $('.menubar_ul').not('#menubar_ul_'+menubar).each(function(){ $(this).hide(); });
      $('#menubar_ul_'+menubar).show();
    }
  },
  Dock: {
    init: function () {
      var theDock = $('<div/>', {
        id: "wxDock"
      }).appendTo('#webxWrapper');
      var theDock_wrapper = $('<div/>', {
        id: "wxDock_wrapper"
      }).appendTo(theDock);

      $('<div/>', {
        id: "wxDock_left"
      }).appendTo(theDock_wrapper);
      var dock_content = $('<ul/>', {
        id: "wxDock_ul"
      }).appendTo(theDock_wrapper);
      $('<div/>', {
        id: "wxDock_right"
      }).appendTo(theDock_wrapper);

      for (var item in webx_data.dock) {
        if(item !== "separator") {
          WebX.Dock.create_icon(webx_data.dock[item]);
        } else {
          WebX.Dock.create_separator();
        }
      }

      // make sortable
      $(dock_content).sortable({
        opacity: 0.80,
        helper: 'clone',
        revert: true,
        tolerance: 'pointer',
        cancel: '.wxDock_no_sort',
        start: function (event, ui) {
          $(ui.helper[0]).find('.wxTip').hide();
        }
      }).disableSelection();
    },
    create_icon: function (item) {
      var dock_item = $('<li>', {
        className: 'wxDock_item',
        id: 'wxDock_item_' + item.name.replace(' ', '_')
      }).appendTo('#wxDock_ul');
      
      if(item.name === "Trash") {
        dock_item.addClass('wxDock_no_sort');
      }

      var icon_div = $('<div/>', {
        className: 'iIcon dockIcon',
        id: 'dock_' + item.name
      }).appendTo(dock_item);

      $('<div/>', {
        className: "iGloss"
      }).appendTo(icon_div);

      WebX.Dock.create_icon_tip(dock_item, item.name);

      if(item.click !== 'false') {
        var func = eval( "(" + item.click + ")" );
        icon_div.bind('click', function(){
          func();
          return false;
        });
      } else {
        icon_div.bind('click', function(){
          return false;
        });
      }

      WebX.Dock.center();
    },
    create_icon_tip: function (icon, text) {
      var tip_id = 'wxDock_tip_' + text;
      var theTip = $('<div/>', {
        className: "wxTip",
        id: tip_id
      });
      $('<div/>', {
        className: "wxTipText",
        text: text
      }).appendTo(theTip);

      $(icon).append(theTip);

      var tipPos = $("div#" + tip_id).width() / 2;

      $("div#" + tip_id).css({
        "margin-left": '-' + tipPos + "px"
      });
    },
    create_separator: function () {
      var dock_item = $('<li>', {
        className: 'wxDock_separator wxDock_no_sort'
      }).appendTo('#wxDock_ul');

      var separator_div = $('<div/>', {
        className: 'dock_separator'
      }).appendTo(dock_item);

      WebX.Dock.center();
    },
    center: function () {
      var dockWidth = getDimensions($('#wxDock')).width;
      $('#wxDock').css({
        "marginLeft": -(dockWidth / 2) + "px"
      });
    },
    hide: function () {
      $('#wxDock').animate({
        'margin-bottom': '-58px'
      }, 420, 'easeOutExpo', function () {
        $('#wxDock').data('state', 'closed');
      });
    },
    show: function () {
      $('#wxDock').animate({
        'margin-bottom': '0px'
      }, 420, 'easeOutExpo', function () {
        $('#wxDock').data('state', 'open');
      });
    },
    toggle: function () {
      if ($('#wxDock').css('margin-bottom') === '0px') {
        WebX.Dock.hide();
      } else {
        WebX.Dock.show();
      }
    }
  },
  Dashboard: {
  	init: function () {
  		$('<div>', {
        id: "dashboardPanel"
      }).data({
        "dashboard_status": 0,
        "widget_drawer_status": 0
      }).appendTo(document.getElementsByTagName('body')[0]);

      var dbOverlay = $('<div>', {
        id: "dbOverlay",
        click: function () {
          WebX.Dashboard.start();
          return false;
        }
      }).appendTo('div#webxWrapper');

      $('<div>', {
        id: "dbDrawerButton",
        click: function () {
          WebX.Dashboard.drawer();
          return false;
        }
      }).appendTo(dbOverlay);
      $('<div>', {
        id: "dbManageButton"
      }).appendTo(dbOverlay);
  	},
  	start: function () {
  	  if ($('#dashboardPanel').data('dashboard_status') === 0) {
        $("div#dbManageButton").hide();
        $('div#dbOverlay').animate({
          opacity: "toggle"
        }, 420);
        $('#dashboardPanel').data('dashboard_status', 1);
      } else if ($('#dashboardPanel').data('dashboard_status') === 1 && $('#dashboardPanel').data('widget_drawer_status') === 1) {
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
        $('#dashboardPanel').data('widget_drawer_status', 0);
        $('#dashboardPanel').data('dashboard_status', 0);
      } else if ($('#dashboardPanel').data('dashboard_status') === 1) {
        $("div#dbOverlay").fadeOut(420);
        $('#dashboardPanel').data('dashboard_status', 0);
      }
  	},
  	drawer: function () {
  	  if ($('#dashboardPanel').data('widget_drawer_status') === 0) {
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
        $('#dashboardPanel').data('widget_drawer_status', 1);
      } else if ($('#dashboardPanel').data('widget_drawer_status') === 1) {
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
        $('#dashboardPanel').data('widget_drawer_status', 0);
      }
  	}
  }
};