var selectInput = null;
var controller = null;
var URL = window.location.href;
var urlParts = URL.split("/");
if (urlParts[3] == "gestaobit") {
  URL = "http://localhost/gestaobit/";
} else {
  URL = "https://gestaobit.herokuapp.com/";
}

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
    controller = $(this).parent().find("input[type=hidden]").attr("name");
    var currentController = controller;
    $.ajax({
      type: "GET",
      url: URL + controller + "/get",
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
        result.pop();
        result.forEach((element) => {
          $(".select table").append(
            "<tr id=" +
              data[element].id +
              "><th>" +
              data[element][field] +
              "</th></tr>"
          );
        });
        $(".select table").append(
          '<tr><td class="cadastrarNovo"><i class="fa fa-plus-circle" aria-hidden="true"></i> Cadastrar novo</td></tr>'
        );
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
      url: URL + controller + "/get",
      data: {
        query: $("#" + controller)
          .parent()
          .find(".selectInput")
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
        result.pop();
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
        $(".select table").append(
          '<tr><td class="cadastrarNovo"><i class="fa fa-plus-circle" aria-hidden="true"></i> Cadastrar novo</td></tr>'
        );
      },
    });
  }, 500)
);

$(document).on("click", ".select table tr th", function () {
  var id = $(this).parent().attr("id");
  $("#" + controller).val(id);
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
    .attr("name");
  $("#" + controller).val("");
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
