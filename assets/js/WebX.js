var WebX = {};
WebX.init = function () {
  this.create = new WebX.Create();
  this.clock = new WebX.Clock();
  this.menubar = new WebX.Menubar();
  this.window = new WebX.Window();
  this.dock = new WebX.Dock();
  this.browser = new WebX.Browser();
  
  var webx_wrapper = $('<div/>', {
    id: "webxWrapper"
  }).appendTo(document.getElementsByTagName('body')[0]);
  $('<div/>', {
    innerHTML: '<img id="wallpaper" src="assets/imgs/wallpaper/Vitrieth_by_iumazark.jpg" alt="" title="" />'
  }).appendTo(webx_wrapper);
  
  $('#starter').hide();
  WebX.menubar.create();
  WebX.dock.create();
  WebX.create.dashboard();
  //windowResize();
};