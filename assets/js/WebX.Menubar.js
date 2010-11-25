WebX.Menubar = function () {};
WebX.Menubar.prototype.create = function () {
  var menubar = $('<div>', {
    id: "menubar"
  }).appendTo('#webxWrapper');

  var menubar_ul = $('<ul>', {
    id: "menubar_ul"
  }).appendTo(menubar);

  var user_area = $('<li>', {
    id: 'mb_user_area',
    css: {
      'float': 'right',
      'margin': '2px 16px 0px 8px'
    }
  }).appendTo(menubar_ul);

  WebX.clock.create('wx_mb_clock', 'mb_user_area');

  $('<div>', {
    id: 'wx_mb_user_name',
    text: 'Default User'
  }).prependTo(user_area);

  $('<div>', {
    id: 'wx_mb_user_pic'
  }).prependTo(user_area);

  for (var this_item in webx_data.menubar.items) {
    WebX.menubar.create_link(webx_data.menubar.items[this_item], menubar_ul);
  }

  for (var panel in webx_data.menubar.panels) {
    if (panel !== 'login') {
      var thisLeft = parentOffsets($('#mb_' + panel)[0]).left;
      webx_data.menubar.panels[panel].offsetLeft = (thisLeft) + "px";
      WebX.menubar.create_panel(panel, '#webx_wrapper');
    }
  }
};

WebX.Menubar.prototype.create_link = function (obj, target) {
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

WebX.Menubar.prototype.create_panel = function (panel, target) {
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

WebX.Menubar.prototype.create_panel_link = function (panel, link_name, target) {
  var mb_link_li = $('<li>', {
    text: stCap(link_name),
    click: function (e) {
      e.preventDefault();
      return false;
    }
  }).appendTo(target);

  switch (panel) {
  case "dock":
    if (link_name === "toggle") {
      $(mb_link_li).bind('click', function () {
        WebX.dock.toggle();
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