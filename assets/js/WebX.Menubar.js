WebX.Menubar = function () {};
WebX.Menubar.prototype.create = function () {
  var menubar = $('<div>', {
    id: "wxMenubar"
  }).appendTo('#webxWrapper');

  var user_area = $('<div>', {
    id: 'mb_user_area'
  }).appendTo(menubar);

  WebX.clock.create('wx_mb_clock', user_area);

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
      WebX.menubar.create_link(item+"_"+link, menubar_ul);
    }
    // 
  }
  // make finder menubar show
  $(menubar).find('ul').not('#menubar_ul_finder').each(function(){
    $(this).hide();
  });
};

WebX.Menubar.prototype.create_link = function (obj, target) {
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
  WebX.menubar.create_panel(obj,webx_data.menubar[names[0]][names[1]],menubar_li);
};

WebX.Menubar.prototype.create_panel = function (panel, contents, target) {
  // console.log(panel+" panel: "+webx_data.menubar.panels[panel]+" - left: "+webx_data.menubar.panels[panel].styles.left);
  var panel_name = panel + '_panel';
  
  var mb_panel = $('<div>', {
    id: panel_name,
    className: "mbWindow"
  }).appendTo(target);

  var mb_link_ul = $('<ul>').appendTo(mb_panel);

  for (var panel_link in contents) {
    WebX.menubar.create_panel_link(panel, panel_link, mb_link_ul);
  }
};

WebX.Menubar.prototype.create_panel_link = function (panel, link_name, target) {
  var mb_link_li = $('<li>', {
    text: link_name
  }).appendTo(target);

  // console.log(panel);
  // console.log(link_name)

  switch (panel) {
  case "finder_Dock":
    if (link_name === "Toggle") {
      $(mb_link_li).bind('click', function () {
        WebX.dock.toggle();
        return false;
      });
    }
    break;
  case "browser_File":
    switch (link_name) {
    case "New Window":
      $(mb_link_li).bind('click', function () {
        WebX.browser.create();
        return false;
      });
      break;
    case "New Tab":
      $(mb_link_li).bind('click', function () {
        console.log("New Tab Clicked");
        return false;
      });
      break;
    }
    break;
  }
};

WebX.Menubar.prototype.switch_to = function(menubar) {
  $('.menubar_ul').not('#menubar_ul_'+menubar).each(function(){ $(this).hide(); });
  $('#menubar_ul_'+menubar).show();
};