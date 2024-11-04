$(document).ready(function () {
    //    var urlOld = "http://localhost/member/" ;
    //   //  var urlOld  = "http://localhost/coop/member_detail.php?" ;
    //   var urlLogout = "./logout_mem.php" ;

    //  /*---------------------------START MENU-----------------------------------------*/
    //    /*ข้อมูลเกี่ยวกับสมาชิก*/
    //    $("#menu_mem").click(function(event){ window.open( urlOld+"mem","_self")});
    //   /*ทะเบียนหุ้น*/
    //   $("#menu_share").click(function(event){ window.open( urlOld+"share","_self") });
    //   /*เงินกู้*/
    //    $("#menu_loan").click(function(event){ window.open( urlOld+"loan","_self") });
    //    /*เงินฝาก*/
    //    $("#menu_dep").click(function(event){ window.open( urlOld+"dep","_self")});
    //    /*รายการเรียกเก็บประจำเดือน*/
    //    $("#menu_kep").click(function(event){ window.open( urlOld+"kep","_self") });
    //    /*ค้ำประกัน*/
    //    $("#menu_coll").click(function(event){ window.open( urlOld+"coll","_self")});
    //    /*ผู้รับโอนผลประโยชน์*/
    //    $("#menu_insurance").click(function(event){ window.open( urlOld+"insurance","_self")});
    //    /*ปันผลเฉลี่ยคืน*/
    //    $("#menu_dividend").click(function(event){ window.open( urlOld+"dividend","_self")});
    //    /*เปลี่ยนรหัสผ่าน*/
    //    $("#menu_change_password").click(function(event){ window.open( urlOld+"change_password","_self")});

    /*------------------------END MENU------------------------------------------------------*/
    //  $("#menu_logout").click(function(event){
    //      $('body').css({ opacity: 1.0, visibility: "visible" }).animate({ opacity: 0, height: 0 }, 900);
    //      setTimeout(function () {
    //          window.location = urlLogout;
    //      }, 1500);

    //  });
    /*------------------------------------------------------------------------------------------------------*/
    /*End menu*/


    /*Hover */

    $(".menu_logout").hover(function () {
            $(this).css("color", "red");
        },
        function () {
            $(this).css("color", "black");
        });

    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        todayBtn: true,
        language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
        thaiyear: true //Set เป็นปี พ.ศ.
    });

    /*Click Menu*/
    //  var urlCurMain = document.location.href ;
    //  console.log(urlCurMain);
    //  var s, myStringArray = ["loan", "mem","share","dep","coll","kep","insurance","dividend","change_password"];
    //   for (s of myStringArray) {
    //     if(urlCurMain.endsWith(s)){
    //       $("#menu_"+s).addClass('active');
    //       $("#menu_"+s).css('color',"white");
    //     }else{
    //       if(urlCurMain.endsWith('?')){
    //         $("#menu_mem").removeClass('active');
    //       }else{
    //         $("#menu_"+s).removeClass('active');
    //       };
    //     }
    //   }


    //Image thumbnail
    var vals = screen.width;
    if (vals < 800) {
        $("#user_pic").removeClass("img-thumbnail").addClass('img-thumbnail-small');
    } else {
        $("#user_pic").removeClass("img-thumbnail-small").addClass('img-thumbnail');
    }


    /**/
    // $('body').append('<div id="toTop" class="btn btn-totop text-center"><span ><i class="glyphicon glyphicon-chevron-up" style="right:1px;top:-15px;position:relative;color:white"></i></span></div>');

    $(window).scroll(function () {
        if ($(this).scrollTop() != 0) {
            $('#toTop').fadeIn();
        } else {
            $('#toTop').fadeOut();
        }
    });
    $('#toTop').click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });


});
