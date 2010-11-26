var WebX = {};
WebX.init = function () {
  this.create = new WebX.Create();
  this.clock = new WebX.Clock();
  this.menubar = new WebX.Menubar();
  this.window = new WebX.Window();
  this.dock = new WebX.Dock();
  this.browser = new WebX.Browser();
  //windowResize();
};