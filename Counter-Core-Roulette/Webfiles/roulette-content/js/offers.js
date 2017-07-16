function showConfirm() {
    $("#confirmModal").modal("show");
}

function cmd() {
    var t = parseInt($("#cmd").html());
    if (t > 0) {
        $("#cmd").html(t - 1);
        setTimeout(cmd, 1000);
    }
}

function cmdm() {
    var t = parseInt($("#cmdm").html());
    if (t > 0) {
        $("#cmdm").html(t - 1);
        setTimeout(cmdm, 1000);
    }
}


function addPadding(lr, across) {
    var MIN = 2;
    var count = $(lr + " .reals>.placeholder:not(.hidden)").length;
    var needed = 0;
    if (count <= across * MIN) {
        needed = across * MIN - count;
    } else {
        needed = (across - (count % across)) % across;
    }
    $(lr + " .bricks>.placeholder").addClass("hidden").slice(0, needed).removeClass("hidden");
}

function addUp() {
    var creds = 0;
    var count = 0;
    $("#right .slot").each(function(i, e) {
        creds += $(this).data("price");
        count++;
    });
    if (!DEPOSIT) {
        creds = -creds;
    }
    $("#sum").html(formatNum(creds));
    if (count == 0) {
        $("#botFilter .btn").removeClass("disabled");
    }
}

function doFilter() {
    var b = $("#botFilter .btn.active").data("bot") || 0;
    var t = $("#filter").val().toLowerCase();
    var total = $("#left .reals>.placeholder").length;
    var n = $("#left .reals>.placeholder").addClass("hidden").filter(function(i, e) {
        var bx = $(this).data("bot") || "";
        var tx = $(this).data("name") || "";
        var px = $(this).data("price") || 0;
        if (b == 0 || b == bx) {
            if (tx.toLowerCase().indexOf(t) >= 0) {
                return true;
            } else if (t.charAt(0) == ">") {
                return px > parseInt(t.substr(1));
            } else if (t.charAt(0) == ">") {
                return px < parseInt(t.substr(1));
            }
        }
    }).removeClass("hidden").length;
    if (t === "" && b == 0) {
        $("#left_number").html(total);
    } else {
        $("#left_number").html(n + "/" + total);
    }
    addPadding("#left", 6);
}
$(document).ready(function() {
    if (DEPOSIT) {
        loadLeft();
    }
    $(document).on("click", "#right .slot", function() {
        $(this).parent().remove();
        $(this).appendTo(".placeholder[data-pos='" + $(this).data("pos") + "']");
        addPadding("#right", 4);
        addUp();
    });
    $(document).on("click", "#left .slot:not(.reject)", function() {
        var b = $(this).data("bot") || null;
        if (b != null) {
            $("#botFilter .btn").removeClass("active").addClass("disabled");
            $("#botFilter .btn[data-bot='" + b + "']").addClass("active").removeClass("disabled");
            doFilter();
        }
        var c = $("#right .slot").length;
        if (c < 32) {
            $("#right .reals").append("<div class='placeholder'></div>");
            $(this).appendTo($("#right .reals .placeholder:empty").first());
            addPadding("#right", 4);
            addUp();
        }
    });
    $("#filter").on("keyup", function() {
        doFilter();
    });
    $("#orderBy").on("change", function() {
        var o = $(this).val();
        if (o == 1) {
            tinysort("#left .reals>.placeholder", {
                data: "price",
                order: "desc"
            });
        } else if (o == 2) {
            tinysort("#left .reals>.placeholder", {
                data: "price",
                order: "asc"
            });
        } else if (o == 3) {
            tinysort("#left .reals>.placeholder", {
                data: "name",
                order: "asc"
            });
        } else {
            tinysort("#left .reals>.placeholder", {
                data: "price",
                order: "desc"
            });
        }
    });
    $("#botFilter .btn").on("click", function() {
        if ($(this).hasClass("disabled")) {
            return;
        }
        $("#botFilter .btn").removeClass("active");
        $(this).addClass("active");
        doFilter();
    });
    $("#confirmButton").on("click", function() {
        inlineAlert("", "Confirming trade offer - please wait...");
        $this = $(this);
        $this.prop("disabled", true);
        var tid = $this.data("tid");
        $.ajax({
            url: "/confirm",
            type: "GET",
            data: {
                "tid": tid
            },
            success: function(data) {
            	console.log(data);
                try {
                    data = JSON.parse(data);
                    if (data.success) {
                        if (data.action == "accept") {
                            inlineAlert("success", data.result);
                        } else {
                            inlineAlert("cross", data.result);
                        }
                        $("#offerPanel").slideUp();
                    } else {
                        inlineAlert("error", data.error);
                        if (data.count > 0) {
                            cmdm();
                        }
                    }
                } catch (err) {
                    inlineAlert("error", "Javascript error: " + err);
                }
            },
            error: function(err) {
                inlineAlert("error", "AJAX error: " + err.statusText);
            },
            complete: function() {
                $this.prop("disabled", false);
            }
        });
        return false;
    });
    $(document).on("contextmenu", ".slot", function(e) {
        if (e.ctrlKey) return;
        e.preventDefault();
        var view = $(this).data("view");
        if (view == "none") {
            return;
        }
        $("#contextMenu [data-act=0]").attr("href", view);
        var $menu = $("#contextMenu");
        $menu.show().css({
            position: "absolute",
            left: getMenuPosition(e.clientX, 'width', 'scrollLeft'),
            top: getMenuPosition(e.clientY, 'height', 'scrollTop')
        }).off("click").on("click", "a", function(e) {});
    });
    $(document).on("click", function() {
        $("#contextMenu").hide();
    });
});

function getMenuPosition(mouse, direction, scrollDir) {
    var win = $(window)[direction](),
        scroll = $(window)[scrollDir](),
        menu = $("#contextMenu")[direction](),
        position = mouse + scroll;
    if (mouse + menu > win && menu < mouse)
        position -= menu;
    return position;

}

function showPending(data) {
    var content = "<b>Trade with " + data.bot + " ";
    content += "- The secret code is: " + data.code + " and you will get " + data.amount + " coins.";
    content += " Click <a href='https://steamcommunity.com/tradeoffer/" + data.tid + "' target='_blank' >here</a> to accept trade offer";
    if (data.amount > 0) {
        content += " and get coins.";
    } else {
        content += ".";
    }
    $("#offerContent").html(content);
    $("#confirmButton").data("tid", data.tid);
    if (data.amount < 0) {
        if (data.state == 2 || data.state == 3 || data.state == 4 || data.state == 9) {
            $("#confirmButton").html("Confirm");
        } else {
            $("#confirmButton").html("Confirmed");
        }
    }
    $("#offerPanel").slideDown();
}

function loadLeft(opts) {

    inlineAlert("", "Loading your inventory - please wait...");
    var DIV = "<div class='placeholder matched' data-name='{0}' data-pos='{1}' data-price='{2}' data-bot='{3}'>";
    DIV += "<div class='slot {13}' data-view='{15}' data-name='{4}' data-pos='{5}' data-price='{6}' data-bot='{7}' data-id='{8}' style='background-image:url(\"{9}\")'>";
    DIV += "<div class='name'>{10}</div>";
    DIV += "<div class='price {11}'>{12}</div>";
    DIV += "<div class='bot'>{14}</div>";
    DIV += "</div></div>";
    var IMG = "{0}/{1}fx{2}f";
    var url = "";
    if (DEPOSIT) {
        url = "/get_inv?" + opts;
    } else {
        var g = grecaptcha.getResponse();
        url = "/get_bank_safe?g-recaptcha-response=" + g;
    }
    $.ajax({
        "url": url,
        success: function(data) {
            try {
                data = JSON.parse(data);
                if (data.success) {
                    console.log(data);
                    
                    $("#left .reals").empty();
                    $("#right .reals").empty();
                    $("#right .bricks").removeClass("hidden");
                    $("#avail").html(formatNum(data.balance));
                    var count = data.items.length;
                    var eleA = [];
                    for (var i = 0; i < count; i++) {
                        var item = data.items[i];
                        var url = IMG.format(item.img, 110, 50);
                        var price_class = "ball-1";
                        if (DEPOSIT) {
                            price_class = "ball-0";
                        }
                        var slot_class = "";
                        var price_content = item.price;
                        if (price_content == 0) {
                            price_content = item.reject;
                            slot_class = "reject";
                        } else {
                            price_content = formatNum(price_content);
                        }
                        bot = 0;
                        if (item.botid) {
                            bot = item.botid;
                        }
                        var botLabel = "";
                        if (!DEPOSIT) {
                  
                            botLabel = "Bot " + bot;
                        }
                        var ele = DIV.format(item.name, i, item.price, bot, item.name, i, item.price, bot, item.assetid, url, item.name, price_class, price_content, slot_class, botLabel, item.view);
                        eleA.push(ele);
                    }
                    $("#left_number").html(count);
                    document.getElementById("left").getElementsByClassName("reals")[0].innerHTML = eleA.join('');
                    addPadding("#left", 6);
                    if (data.fromcache) {
                        inlineAlert("success", "Loaded " + count + " items from cache - <a href=\"javascript:loadLeft('nocache')\">reload inventory</a>");
                    } else {
                        inlineAlert("success", "Loaded " + count + " items.");
                    }
                } else {
                    inlineAlert("error", data.error);
                    if (data.count > 0) {
                        cmd();
                    }
                }
                if (data.tid) {
                    showPending(data);
                }
            } catch (err) {
                inlineAlert("error", "Javascript error: " + err);
                console.log(err.stack);
            }
        },
        error: function(err) {
            inlineAlert("error", "AJAX error: " + err.statusText);
        },
    });
}

function offer() {
    inlineAlert("", "Processing trade offer - please wait...");
    $("#confirmModal").modal("hide");
    var csv = "";
    var sum = 0;
    $("#right .slot").each(function(i, e) {
        csv += $(this).data("id") + ",";
        sum += $(this).data("price");
    });
    var turl = $("#tradeurl").val();
    var remember = $("#remember").is(":checked") ? "on" : "off";
    var url = "/withdraw_js";
    if (DEPOSIT) {
        url = "/deposit_js";
    }
    $.ajax({
        "url": url,
        type: "GET",
        data: {
            "assetids": csv,
            "tradeurl": turl,
            "checksum": sum,
            "remember": remember
        },
        success: function(data) {
        	console.log(data);
            try {
                data = JSON.parse(data);
                if (data.success) {
                    inlineAlert("success", "New trade offer!");
                    showPending(data);
                } else {
                    inlineAlert("error", data.error);
                }
            } catch (err) {
                inlineAlert("error", "Javascript error: " + err);
            }
        },
        error: function(err) {
            inlineAlert("error", "AJAX error: " + err.statusText);
        },
    });
}