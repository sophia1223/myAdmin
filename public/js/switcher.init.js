var green = "#00acac",
    red = "#ff5b57",
    blue = "#348fe2",
    purple = "#727cb6",
    orange = "#f59c1a",
    black = "#2d353c";

var renderSwitcher = function () {
    var $switchery = $("[data-render=switchery]");
    if ($switchery.length !== 0) {
        $switchery.each(
            function () {
                var e = green;
                if ($(this).attr("data-theme")) {
                    switch ($(this).attr("data-theme")) {
                        case "red": e = red; break;
                        case "blue": e = blue; break;
                        case "purple": e = purple; break;
                        case "orange": e = orange; break;
                        case "black": e = black; break
                    }
                }
                var t = {};
                t.color = e;
                t.secondaryColor = $(this).attr("data-secondary-color") ?
                    $(this).attr("data-secondary-color") : "#dfdfdf";
                t.className = $(this).attr("data-classname") ?
                    $(this).attr("data-classname") : "switchery";
                t.disabled = !!$(this).attr("data-disabled");
                t.disabledOpacity = $(this).attr("data-disabled-opacity") ?
                    $(this).attr("data-disabled-opacity") : .5;
                t.speed = $(this).attr("data-speed") ? $(this).attr("data-speed") : "0.5s";
                var n = new Switchery(this, t)
            }
        )
    }
};

var Switcher = function () {
    "use strict";
    return { init: function () {renderSwitcher(); } }
}();