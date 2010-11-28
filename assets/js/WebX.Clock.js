WebX.Clock = {
  create: function (ele_id, target) {
    $('<div>', {
      id: ele_id
    }).appendTo(target);
    WebX.Clock.update('#' + ele_id);
  },
  update: function (ele_id) {
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
    if (hours >= 12) {
      AorP = "PM";
    } else {
      AorP = "AM";
    }
    if (hours >= 13) {
      hours -= 12;
    }
    if (hours === 0) {
      hours = 12;
    }
    if (secn < 10) {
      secn = "0" + secn;
    }
    if (mins < 10) {
      mins = "0" + mins;
    }
    $(ele_id).html(dayList[day] + ",&nbsp;" + monthList[month] + "&nbsp;" + theDay + ",&nbsp;" + year + "&nbsp;&nbsp;|&nbsp;&nbsp;" + hours + ":" + mins + "&nbsp;" + AorP);
    setTimeout(function () {
      WebX.Clock.update(ele_id);
    }, 1000);
  }
};