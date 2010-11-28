WebX.Finder = function () {};
WebX.Finder.prototype.create = function () {
  WebX.Menubar.switch_to('finder');
  console.log($('.wxFinder').length);
  var this_id = $('.wxFinder').length;
  var finder = $('<div/>', {
    className: "wx_window wxFinder",
    id: "wxFinder_" + this_id
  }).appendTo('#webxWrapper');
  
  var finder_top = $('<div/>', {
    className: "wxFinder_top"
  }).appendTo(finder);
  
  var finder_top_perms = $('<div/>', {
    className: "wxFinder_top_permanents"
  }).appendTo(finder_top);
  
  var finder_top_button_box = $('<div/>', {
    className: "wxFinder_buttons"
  }).appendTo(finder_top_perms);
  
  $('<div/>', {
    className: "button close"
  }).appendTo(finder_top_button_box).bind('click', function(){
    console.log('close button clicked');
    WebX.finder.toggle(finder);
  });
  
  $('<div/>', {
    className: "button minimize"
  }).appendTo(finder_top_button_box);
  
  $('<div/>', {
    className: "button maximize"
  }).appendTo(finder_top_button_box).bind('click', function(){
    console.log('maximize button clicked');
    WebX.Finder.maximize(finder);
  });
  
  var finder_title = $('<div/>', {
    className: "wxFinder_title",
    text: "Finder"
  }).appendTo(finder_top_perms);
  
  var finder_nav = $('<div/>', {
    className: "wxFinder_nav"
  }).appendTo(finder_top);
  
  // Forward Button
  $('<div/>',{
    className: "wxFinder_button_forward"
  }).appendTo(finder_nav).bind('click', function(){
    console.log('forward button clicked');
		return false;
  });
  
  // Back Button
  $('<div/>',{
    className: "wxFinder_button_back"
  }).appendTo(finder_nav).bind('click', function(){
    console.log('back button clicked');
		return false;
  });
  
  // Views Nav
  $('<ul/>',{
    className: "wxFinder_views"
  }).appendTo(finder_nav);
  
  // Quicklook Button
  $('<div/>',{
    className: "wxFinder_button_quicklook"
  }).appendTo(finder_nav).bind('click', function(){
    console.log('quicklook button clicked');
		return false;
  });
  
  // Content
  var finder_content = $('<div/>', {
    className: "wxFinder_content finder_resize",
    id: "wxFinder_content_" + this_id
  }).appendTo(finder);
  
  // Footer
  var finder_footer = $('<div/>', {
    className: "wxFinder_footer"
  }).appendTo(finder);

	finder_content.css({
		"height": (finder.height() - (finder_top.height() + finder_footer.height() + 2)) + "px"
	});
  
  finder.draggable({
		containment: '#webxWrapper',
    stack: ".wx_window",
    handle: finder_top,
    zIndex: 10
	}).resizable({
	  alsoResize: "#wxFinder_" + this_id + " .finder_resize",
    minHeight: 135,
    minWidth: 250,
    handles: "se"
	}).find('.ui-icon-gripsmall-diagonal-se').css({
    "position": "absolute",
    "bottom": "0px",
    "right": "0px",
    "width": "15px",
    "height": "20px",
    "z-index": 11
  });
};

WebX.Finder.prototype.maximize = function (ele) {
  var width_modifier = 0;
  var height_modifier = 0;
  var Finder_size = getDimensions(document.getElementsByTagName('body')[0]);
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
      "width": Finder_size.width + "px",
      "height": Finder_size.height - $('#menubar').outerHeight(true) + "px",
      "top": $('#menubar').outerHeight(true) + "px",
      "left": width_modifier + "px"
    });
    $(ele).find('.wxFinder_iframe').css({
      "width": "100%",
      "height": ($(ele).outerHeight(false) - 60 - height_modifier) + "px"
    });
    $(ele).data('sizeState', "max");
  } else {
    $(ele).css({
      "width": $(ele).data('originalWidth') + "px",
      "height": $(ele).data('originalHeight') + "px",
      "top": $(ele).data('originalTop'),
      "left": $(ele).data('originalLeft')
    });
    $(ele).find('.wxFinder_iframe').css({
      "width": "100%",
      "height": ($(ele).data('originalHeight') - 60 - (($(ele).data('windowType') === 'finder') ? height_modifier - 2 : height_modifier)) + "px"
    });
    $(ele).data('sizeState', "min");
  }
};

WebX.Finder.prototype.close = function (ele) {
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

WebX.Finder.prototype.open = function (ele, opt) {
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

WebX.Finder.prototype.toggle = function (ele) {
  if ($(ele).is(':visible')) {
    WebX.finder.close(ele);
  } else if (!$(ele).is(':visible')) {
    WebX.finder.open(ele);
  }
};