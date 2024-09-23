// <!-- Google Tag Manager -->
(function (w, d, s, l, i) {
    w[l] = w[l] || [];
    w[l].push({"gtm.start": new Date().getTime(), event: "gtm.js"});
    var f = d.getElementsByTagName(s)[0],
        j = d.createElement(s),
        dl = l != "dataLayer" ? "&l=" + l : "";
    j.async = true;
    j.src = "https://www.googletagmanager.com/gtm.js?id=" + i + dl;
    f.parentNode.insertBefore(j, f);
})(window, document, "script", "dataLayer", "GTM-NGGBBXWB");

// <!-- End Google Tag Manager -->


$(document).ready(function () {
    let a = 0;
    const boxNumberWrap = $(".box-count .item__number");
    let boxNumberWrapCount = boxNumberWrap.length;
    const oTop =
        $(".box-count").offset().top - window.innerHeight;
    let animationFinished = false;

    function animateNumbers() {
        boxNumberWrap.each(function () {
            const $this = $(this);
            const countTo = $this.attr("data-count");

            $({
                countNum: $this.find("span").text(),
            }).animate(
                {
                    countNum: countTo,
                },
                {
                    duration: 2000,
                    easing: "swing",
                    step: function () {
                        $this
                            .find("span")
                            .text(
                                Math.floor(
                                    this.countNum
                                ).toLocaleString("vi-VN")
                            );
                    },
                    complete: function () {
                        $this
                            .find("span")
                            .text(
                                this.countNum.toLocaleString("vi-VN")
                            );

                        if (--boxNumberWrapCount === 0) {
                            animationFinished = true;
                        }
                    },
                }
            );
        });
    }

    $(window).scroll(function () {
        if (animationFinished) {
            return;
        }

        if (a === 0 && $(window).scrollTop() > oTop) {
            a = 1;
            requestAnimationFrame(animateNumbers);
        }
    });
});


$(".form.booking .btn-booking").click(function () {
    var form = ".form.booking";
    var param = new Object();
    param.branch_name = $(form + " #select2-select-branch-container").attr(
        "title"
    );
    param.time = $(form + " #time").val();
    param.date = $(form + " #date").val();
    param.fullname = $(form + " #fullname").val();
    param.phone = $(form + " #phone").val();
    param.email = $(form + " #email").val();
    param.content = $(form + " #content").val();
    param.website = $(form + " #webiste").val();
    send_booking(form, param);
});


(function (d, s, id) {
    var js,
        fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.7";
    fjs.parentNode.insertBefore(js, fjs);
})(document, "script", "facebook-jssdk");


$(document).ready(function () {
    let a = 0;
    const boxNumberWrap = $(".box-count .item__number");
    let boxNumberWrapCount = boxNumberWrap.length;
    const oTop =
        $(".box-count").offset().top - window.innerHeight;
    let animationFinished = false;

    function animateNumbers() {
        boxNumberWrap.each(function () {
            const $this = $(this);
            const countTo = $this.attr("data-count");

            $({
                countNum: $this.find("span").text(),
            }).animate({
                countNum: countTo,
            }, {
                duration: 2000,
                easing: "swing",
                step: function () {
                    $this
                        .find("span")
                        .text(
                            Math.floor(
                                this.countNum
                            ).toLocaleString(
                                "vi-VN")
                        );
                },
                complete: function () {
                    $this
                        .find("span")
                        .text(
                            this.countNum
                                .toLocaleString("vi-VN")
                        );

                    if (--boxNumberWrapCount ===
                        0) {
                        animationFinished = true;
                    }
                },
            });
        });
    }

    $(window).scroll(function () {
        if (animationFinished) {
            return;
        }

        if (a === 0 && $(window).scrollTop() > oTop) {
            a = 1;
            requestAnimationFrame(animateNumbers);
        }
    });
});

