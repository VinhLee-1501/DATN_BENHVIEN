$(document).ready(function(){

    new WOW().init();

	action_page();

	$(window).scroll(function() {
		action_page();
	});

	$(document).on("click",'a', function (e) {
    if ("" !== this.hash) {
      e.preventDefault();
      var i = this.hash;
      $("html, body").animate({ scrollTop: $(i).offset().top - 100 }, 1e3, function () {});
    }
  });

	$('button.toggle').click(function(event) {
		$(this).toggleClass("active");
		$( ".rd-menu" ).toggleClass('active', $(this).hasClass('active'));
	});

	$(".scroll-to-target").on('click', function() {
		var target = $(this).attr('data-target');
		$('html, body').animate({
			scrollTop: $(target).offset().top
		}, 1500);
	});

	var $tab = $('.tab__list .tab');
	var $pane = $('.pane__list .pane');

	$tab.on('click', function() {
		var idPane = $(this).data('pane');
		$(this).closest('.nav-tabs-custom').find('.tab, .pane').removeClass('active');
		$(this).addClass('active');
		$(idPane).addClass('active');
	});

	var $itemTab = $('.list__tab .item');
	$itemTab.on('click', function() {
		$itemTab.removeClass('active');
		$(this).addClass('active');
	});

	$('.gallery__album .item').on('click', function() {
		var idType = $(this).data('id');
		filterGallery(idType);
	});



    var $popupPromotion = $('.popup.promotion');
    $popupPromotion.find('.popup__frame').on('click', function () {
        $popupPromotion.removeClass('active');
        removeScrollbar();
    });




	$('.item-video').on('click', async function(e) {
		e.preventDefault();
    const url = $(this).attr("rel");
    const data = await loadDataFromURL(url);
    $(".popup.video").find(".video").html(data.html);
    removeScrollbar();
	});

  $(".form.contact .btn-send").click(function() {
    var form  = $(this).closest('.form.contact');
    var param = new Object();
        param.service_name  = $(form).find('#select-service option:selected').html().replace(/&nbsp;/g, "");
        param.fullname      = $(form).find('#fullname').val();
        param.phone         = $(form).find('#phone').val();
        param.email         = $(form).find('#email').val();
        param.content       = $(form).find('#content').val();
        param.website       = $(form).find('#webiste').val();
        send_contact(form, param);
  });

  loadImageFormData();

	$(".select2").select2({});

	$('.news__slider').slick({
		slidesToShow: 3,
		slidesToScroll: 3,
		autoplay: true,
		infinite: true,
		arrows: true,
		dots: false,
		responsive: [
			{
				breakpoint: 1023,
				settings: {
slidesToShow: 2,
					slidesToScroll: 2,
					dots: false,
				}
			},
			{
				breakpoint: 576,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					dots: false,
				}
			}
		]
	});
});

function filterGallery(idType) {
	var $resultContainer = $('.gallery__result');
	var uri = url + "/loc-thu-vien";
	var params = {};
			params.idGallery = idType;

	$.post(uri, params, (data) => {
		if (data && data.status === true) {
			if (data.result) {
				$resultContainer.html(data.result);
			} else {
				$resultContainer.html('<h3 class="no-data">Hình ảnh chưa được cập nhật!</h3>');
			}
		}
	}, 'json');
}
function filterType(idType) {
	var $resultContainer = $('.service__result');
	var uri = url + "/loc-dich-vu";
	var params = {};
			params.idType = idType;

	$('.service__list #loading').fadeIn('fast');
	$.post(uri, params, (data) => {
		$('.service__list #loading').fadeOut('fast');
		if (data && data.status === true) {
			if (data.result) {
				$resultContainer.html(data.result);
			} else {
				$resultContainer.html('<h3 class="no-data">Bệnh điều trị chưa được cập nhật!</h3>');
			}
		}
	}, 'json');
}
function action_page() {
	// $top_height = $('.header').height();
	$top_height = 0;
	if($(window).scrollTop() > $top_height){
		$('header').addClass('stick');
		$('.main_menu').addClass('stick');
	}else{
		$('header').removeClass('stick');
		$('.main_menu').removeClass('stick');
	}

	if($(this).scrollTop() >= 200){
		$('.scroll-to-target').addClass('active');
	}else{
		$('.scroll-to-target').removeClass('active');
	}
}
function removeScrollbar() {
  if ($(".popup").hasClass("active")) {
    $("body").addClass("removeScrollbar");
  } else {
    $("body").removeClass("removeScrollbar");
  }
}
function addStyles(element,styles){
  for(id in styles){
    element.style[id] = styles[id];
  }
}
function send_contact(form, param) {
	var uri = url + "/gui-lien-he";
	var email_regex = /^([a-zA-Z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;

	if(param.service_name == "") {
		$(form).find('.select2-selection.select2-selection--single').addClass('error');
		$(form).find('.select2-selection.select2-selection--single').focus();
		return false;
	}else{
		$(form).find('.select2-selection.select2-selection--single').removeClass('error');
	}

	if(param.fullname == "") {
		$(form).find('input[name="fullname"]').addClass('error');
		$(form).find('input[name="fullname"]').focus();
		return false;
	}else{
		$(form).find('input[name="fullname"]').removeClass('error');
	}

	if (!param.phone.match(/(03|05|07|08|09|01[2|6|8|9])+([0-9]{8})\b/)) {
		$(form).find('#phone').addClass('error');
		$(form).find('#phone').focus();
		notifyOptions.status  = "error";
		notifyOptions.title   = "Thất bại";
		notifyOptions.text    = 'Số điện thoại trống hoặc không đúng!'
		new Notify(notifyOptions);
		return false;
	} else{
		$(form).find('#phone').removeClass('error');
	}

	if(!email_regex.test(param.email) && param.email != "") {
$(form).find('input[name="email"]').addClass('error');
		$(form).find('input[name="email"]').focus();
		notifyOptions.status  = "error";
		notifyOptions.title   = "Thất bại";
		notifyOptions.text    = 'Vui lòng nhập đúng định dạng email.'
		new Notify(notifyOptions);
		return false;
	}else{
		$(form).find('input[name="email"]').removeClass('error');
	}

	$(form).find('#loading').fadeIn('fast');
	$.post(uri, param, function(data){
		$(form).find('#loading').fadeOut('fast');
		if(data.status == true) {
			console.log(data);
			$(".popup.success").addClass('active');
			setTimeout(function() {
				$(".popup.success").removeClass('active');
				removeScrollbar();
			}, 4000);
			clear_form(form);
		} else {
			notifyOptions.status  = "error";
			notifyOptions.title   = "Thất bại";
			notifyOptions.text    = 'Lỗi! Không gửi được thông tin!'
			new Notify(notifyOptions);
		}
	}, 'json');
}
function send_booking(form, param) {

	var uri = url + "/dat-lich-hen";
	var email_regex = /^([a-zA-Z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;
	var minTime = "08:30";
	var maxTime = "17:00";

	if(param.branch_name == "" || param.branch_name == null) {
		$(form + ' .select2-selection.select2-selection--single').addClass('error');
		$(form + ' .select2-selection.select2-selection--single').focus();
		return false;
	}else{
		$(form + ' .select2-selection.select2-selection--single').removeClass('error');
	}

	if(param.date == "") {
		$(form + ' input[name="date"]').addClass('error');
		$(form + ' input[name="date"]').focus();
		return false;
	}else{
		$(form + ' input[name="date"]').removeClass('error');
	}

	if(param.time == "") {
		$(form + ' input[name="time"]').addClass('error');
		$(form + ' input[name="time"]').focus();
		return false;
	}else{
		$(form + ' input[name="time"]').removeClass('error');
	}

	if(param.time != "" && param.time < minTime || param.time > maxTime ) {
		$(form + ' input[name="time"]').addClass('error');
		$(form + ' input[name="time"]').focus();
		notifyOptions.status  = "error";
		notifyOptions.title   = "Thất bại";
		notifyOptions.text    = 'Giờ làm việc 08:30 đến 17:00.'
		new Notify(notifyOptions);
		return false;
	}else{
		$(form + ' input[name="time"]').removeClass('error');
	}

	if(param.fullname == "") {
		$(form + ' input[name="fullname"]').addClass('error');
		$(form + ' input[name="fullname"]').focus();
		return false;
	}else{
		$(form + ' input[name="fullname"]').removeClass('error');
	}

	if (!param.phone.match(/(03|05|07|08|09|01[2|6|8|9])+([0-9]{8})\b/)) {
		$(form  + ' #phone').addClass('error');
		$(form  + ' #phone').focus();
		notifyOptions.status  = "error";
		notifyOptions.title   = "Thất bại";
		notifyOptions.text    = 'Số điện thoại trống hoặc không đúng!'
		new Notify(notifyOptions);
		return false;
	} else{
		$(form  + ' #phone').removeClass('error');
	}

	if(!email_regex.test(param.email) && param.email != "") {
		$(form + ' input[name="email"]').addClass('error');
$(form + ' input[name="email"]').focus();
		notifyOptions.status  = "error";
		notifyOptions.title   = "Thất bại";
		notifyOptions.text    = 'Vui lòng nhập đúng định dạng email.'
		new Notify(notifyOptions);
		return false;
	}else{
		$(form + ' input[name="email"]').removeClass('error');
	}

	$(form + ' #loading').fadeIn('fast');
	$.post(uri, param, function(data){
		$(form + ' #loading').fadeOut('fast');
		if(data.status == true) {
			$(".popup.booking").removeClass('active');
			$(".popup.success").addClass('active');
			setTimeout(function() {
				$(".popup.success").removeClass('active');
				removeScrollbar();
			}, 4000);
			clear_form(form);
		} else {
			notifyOptions.status  = "error";
			notifyOptions.title   = "Thất bại";
			notifyOptions.text    = 'Lỗi! Không gửi được thông tin!'
			new Notify(notifyOptions);
		}
	}, 'json');
}


function hidePast() {
	var dtToday = new Date();
	var month = dtToday.getMonth() + 1;
	var day = dtToday.getDate();
	var year = dtToday.getFullYear();
	if(month < 10)
			month = '0' + month.toString();
	if(day < 10)
			day = '0' + day.toString();

	var minDate= year + '-' + month + '-' + day;

	$('input#date').attr('min', minDate);
}

async function loadImageFormData() {
  $(".item-video").each(async function () {
    const url = $(this).attr("rel");
    const data = await loadDataFromURL(url);

		var title = data.title;
    var videoTitle = title.replace(/#\w+/g, '');
		var $thumbVideo = $(this).find(".item-video__image img");

    $(this).find(".item-video__title").html(videoTitle);
    $(this).find(".item-video__author").html(data.author_name);
    $thumbVideo.attr("src", data.thumbnail_url);
    $thumbVideo.find(".item-video__image img").attr("alt", videoTitle);
  });
}
async function loadDataFromURL(url) {
  let oembed = `https://www.tiktok.com/oembed?url=${url}`;

  let dataFromOembed = await $.ajax({
    url: oembed,
    dataType: "json",
  });

  if (dataFromOembed === undefined) {
    throw Error("No data received from oembed");
  }

  return dataFromOembed;
}
var notifyOptions = {
  effect: "fade",
  speed: 300,
  showCloseButton: true,
  autoclose: true,
  autotimeout: 5000,
  gap: 20,
  distance: 20,
  position: "right top",
};

// $(window).on("load", function () {
// 	setTimeout(function() {
// 			$('#popupPromotion').addClass('active');
// 			removeScrollbar();
// 	}, 3000);
// });

function openTab(evt, tabId) {
    var i, tabcontent, tablinks;

    // Hide all tabs
    tabcontent = document.getElementsByClassName("tab");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Remove active class from buttons
    tablinks = document.getElementsByClassName("tab-btn");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab and add an "active" class to the clicked button
    document.getElementById(tabId).style.display = "block";
    evt.currentTarget.className += " active";
}

// Show default tab on page load
document.getElementById("history").style.display = "block";


function toggleMenu() {
    var menu = document.getElementById('dropdownMenu');
    menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
}

// Đóng menu khi nhấp ra ngoài
window.onclick = function(event) {
    if (!event.target.matches('.header__login img')) {
        var dropdowns = document.getElementsByClassName("dropdown-menu");
        for (var i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.style.display === 'block') {
                openDropdown.style.display = 'none';
            }
        }
    }
}