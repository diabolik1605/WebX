WebX.Dock = function () {};
WebX.Dock.prototype.create = function () {
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
    WebX.dock.create_icon(webx_data.dock[item]);
  }

  // make sortable
  $(dock_content).sortable({
    opacity: 0.80,
    helper: 'clone',
    revert: true,
    tolerance: 'pointer',
    start: function (event, ui) {
      $(ui.helper[0]).find('.wxTip').hide();
    },
    stop: function (event, ui) {
      // $("#" + ui.item[0].id).find('.wxTip').removeClass('moving');
    }
  }).disableSelection();
};

WebX.Dock.prototype.create_icon = function (item) {
  var dock_item = $('<li>', {
    className: 'wxDock_item',
    id: 'wxDock_item_' + item.name.replace(' ', '_')
  }).appendTo('#wxDock_ul');

  var icon_div = $('<div/>', {
    className: 'iIcon dockIcon',
    id: 'dock_' + item.name
  }).appendTo(dock_item);

  $('<div/>', {
    className: "iGloss"
  }).appendTo(icon_div);

  WebX.dock.create_icon_tip(dock_item, item.name);

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
  
  // if (item === "dashboard") {
  //   icon_div.bind('click', function () {
  //     wxDashInit();
  //     return false;
  //   });
  // } else if (item === "settings") {
  //   icon_div.bind('click', function () {
  //     WebX.window.toggle('#wxWindow_Settings');
  //     return false;
  //   });
  // } else if (item === "browser") {
  //   icon_div.bind('click', function () {
  //     WebX.browser.create();
  //     WebX.menubar.switch_to('browser');
  //     return false;
  //   });
  // }
  WebX.dock.center_dock();
};

WebX.Dock.prototype.create_icon_tip = function (icon, text) {
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
};

WebX.Dock.prototype.center_dock = function () {
  var dockWidth = getDimensions($('#wxDock')).width;
  $('#wxDock').css({
    "marginLeft": -(dockWidth / 2) + "px"
  });
};

WebX.Dock.prototype.hide = function () {
  $('#wxDock').animate({
    'margin-bottom': '-58px'
  }, 420, 'easeOutExpo', function () {
    $('#wxDock').data('state', 'closed');
  });
}

WebX.Dock.prototype.show = function () {
  $('#wxDock').animate({
    'margin-bottom': '0px'
  }, 420, 'easeOutExpo', function () {
    $('#wxDock').data('state', 'open');
  });
}

WebX.Dock.prototype.toggle = function () {
  if ($('#wxDock').css('margin-bottom') === '0px') {
    WebX.dock.hide();
  } else {
    WebX.dock.show();
  }
}