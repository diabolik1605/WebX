var WebX = {};
WebX.init = function () {
  this.create = new WebX.Create();
  this.clock = new WebX.Clock();
  this.menubar = new WebX.Menubar();
  this.window = new WebX.Window();
  this.dock = new WebX.Dock();
  this.browser = new WebX.Browser();
  
  // <div id="webxWrapper">
  //   <div id="starter" style="width:250px;height:100px;position:absolute;left:50%;margin-left:-125px;top:50%;margin-top:-50px;z-index:10;background:#cccccc;text-align:center;color:#333333;">
  //     <p  style="margin-top:35px;cursor:default;">Click Me to start</p>
  //   </div>
  //   <div>
  //    <img id="wallpaper" src="<?=base_url()?>assets/imgs/wallpaper/Vitrieth_by_iumazark.jpg" alt="" title="" />
  //   </div>
  // </div>
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