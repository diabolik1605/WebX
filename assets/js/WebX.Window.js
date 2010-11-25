WebX.Window = function () {};
WebX.Window.prototype.maximize = function (ele) {
  var width_modifier;
  var height_modifier;
  if ($(ele).data('windowType') === 'finder') {
    width_modifier = 136;
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