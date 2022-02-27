var selectInput = null;
var controller = null;
var URL = window.location.href;
var urlParts = URL.split("/");
if (urlParts[3] == "gestaobit") {
  URL = "http://localhost/gestaobit/";
  urlParts.splice(3, 1);
} else {
  URL = "https://gestaobit.herokuapp.com/";
}

$("#filhoActive").parent().parent().show();
$("#filhoActive").parent().parent().parent().find(".caret").addClass("rotate");

function delete_cookie(name, path, domain) {
  if (getCookie(name)) {
    document.cookie =
      name +
      "=" +
      (path ? ";path=" + path : "") +
      (domain ? ";domain=" + domain : "") +
      ";expires=Thu, 01 Jan 1970 00:00:01 GMT";
  }
}

function getCookie(cname) {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(";");
  for (let i = 0; i < ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == " ") {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}
if (window.screen.availWidth <= "767" && urlParts[3] != "login") {
  /* SIDEBAR MOBILE */
  $("#btn").click(function () {
    delete_cookie("sidebar");
    document.cookie = "sidebar=show";
    $(".content").hide();
    $(".sidebar").show();
    $("#btn").hide();
  });
  $("#btnSidebar").click(function () {
    delete_cookie("sidebar");
    document.cookie = "sidebar=hide";
    $(".content").attr("style", "left:0px; width: 100%;");
    $(".content").show();
    $(".sidebar").hide();
    $("#btn").show();
  });

  $(".content").hide();
  $(".sidebar").show();
  $(".sidebar").attr("style", "width:100%");
  $("#btnSidebar").show();
  $("#btn").hide();
  $(".content header").show();
  if (getCookie("sidebar") == "hide") {
    $(".content").attr("style", "left:0px; width: 100%;");
    $(".content").show();
    $(".sidebar").hide();
    $("#btn").show();
    delete_cookie("page");
  }

  $(".main ul li ul li").click(function () {
    delete_cookie("sidebar");
    document.cookie = "sidebar=hide";
  });
} else {
  /* SIDEBAR PC */
  if (getCookie("sidebar") == "show") {
    $(".sidebar").show();
    $(".content").attr("style", "calc(100% - 240px);");
  } else if(getCookie("sidebar") == "hide") {
    $(".content").attr("style", "left:0px; width: 100%;");
    $(".sidebar").hide();
  }
  $("#btn").click(function () {
    if ($(".sidebar").is(":hidden")) {
      delete_cookie("sidebar");
      document.cookie = "sidebar=show";
      $(".sidebar").show();
      $(".content").attr("style", "calc(100% - 240px);");
    } else {
      delete_cookie("sidebar");
      document.cookie = "sidebar=hide";
      $(".content").attr("style", "left:0px; width: 100%;");
      $(".sidebar").hide();
    }
  });
}

$(".menuPaiBtn").click(function () {
  $(this).parent().find(".filhos").slideToggle();
  $(this).find(".caret").toggleClass("rotate");
});

$(document).mouseup(function (e) {
  var container = $(".select");
  if (
    !$(".selectInput").is(":focus") &&
    !container.is(e.target) &&
    container.has(e.target).length === 0
  ) {
    $(".select").hide();
    if (selectInput) {
      if (!selectInput.is(":disabled")) {
        $("#" + controller).val("");
        $(selectInput).val("");
      }
    }
  }
});

$(".selectInput").focus(function () {
  selectInput = $(this);
  if (!selectInput.val()) {
    var inputGroup = selectInput.parent().position();
    $(".select").show();
    $(".select").css({
      top: inputGroup.top + 40,
      left: inputGroup.left,
      height: "auto",
      overflow: "hidden",
      width: selectInput.parent().width(),
    });
    $(".select table").empty();
    $(".select table").append(
      '<p style="padding: 6px;margin: 0;">Buscando...</p>'
    );
    controller = $(this).parent().find("input[type=hidden]").attr("controller");
    var currentController = controller;
    $.ajax({
      type: "GET",
      url: URL + controller.replace("_id", "") + "/get",
      dataType: "json",
      success: function (data) {
        if (currentController != controller) {
          return;
        }
        var result = Object.keys(data);
        $(".select table").empty();
        if (result.length > 4) {
          $(".select").css({ height: "130px", "overflow-y": "scroll" });
        }
        var field = data.field;
        var cadastrarNovo = data.cadastrarNovo;
        result.pop();
        if (cadastrarNovo != null) {
          result.pop();
        }
        result.forEach((element) => {
          $(".select table").append(
            "<tr id=" +
            data[element].id +
            "><th>" +
            data[element][field] +
            "</th></tr>"
          );
        });
        if (cadastrarNovo !== false) {
          $(".select table").append(
            '<tr><td class="cadastrarNovo"><i class="fa fa-plus-circle" aria-hidden="true"></i> Cadastrar novo</td></tr>'
          );
        }
      },
    });
  }
});

$(".selectInput").keyup(
  delay(function (e) {
    $(".select").show();
    $(".select table").empty();
    $(".select").css({ height: "auto", overflow: "hidden" });
    $(".select table").append(
      '<p style="padding: 6px;margin: 0;">Buscando...</p>'
    );
    $.ajax({
      type: "POST",
      url: URL + controller.replace("_id", "") + "/get",
      data: {
        query: selectInput
          .val(),
      },
      dataType: "json",
      success: function (data) {
        var result = Object.keys(data);
        $(".select table").empty();
        if (result.length > 4) {
          $(".select").css({ height: "130px", "overflow-y": "scroll" });
        }
        var field = data.field;
        var cadastrarNovo = data.cadastrarNovo;
        result.pop();
        if (cadastrarNovo != null) {
          result.pop();
        }
        result.forEach((element) => {
          $(".select table").append(
            "<tr id=" +
            data[element].id +
            "><th>" +
            data[element][field] +
            "</th></tr>"
          );
        });
        if (result.length == 0) {
          $(".select table").append(
            "<tr><td>Nenhum resultado encontrado</td></tr>"
          );
        }
        if (cadastrarNovo !== false) {
          $(".select table").append(
            '<tr><td class="cadastrarNovo"><i class="fa fa-plus-circle" aria-hidden="true"></i> Cadastrar novo</td></tr>'
          );
        }
      },
    });
  }, 500)
);

$(document).on("click", ".select table tr th", function () {
  var id = $(this).parent().attr("id");
  selectInput.parent().find("input[type=hidden]").val(id);
  selectInput.val($(this).parent().find("th").text());
  selectInput.prop("disabled", true);
  $(".select").hide();
  selectInput.parent().find(".input-group-addon").show();
});

$(document).on("click", ".removeOption", function () {
  $(this).parent().hide();
  selectInput = $(this).parent().parent().find(".selectInput");
  selectInput.val("");
  selectInput.prop("disabled", false);
  controller = $(this)
    .parent()
    .parent()
    .find("input[type=hidden]")
    .attr("controller");
  selectInput.parent().find("input[type=hidden]").val("");
});

function delay(callback, ms) {
  var timer = 0;
  return function () {
    var context = this,
      args = arguments;
    clearTimeout(timer);
    timer = setTimeout(function () {
      callback.apply(context, args);
    }, ms || 0);
  };
}

$(document).on("click", ".btnExcluir", function () {
  $("#confirmSim").attr(
    "href",
    URL + $(this).data("controller") + "/delete/" + $(this).data("id")
  );
});
