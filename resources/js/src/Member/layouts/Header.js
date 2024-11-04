import React from "react";
// import { useDispatch } from "react-redux"
// import { userActions } from '../actions';
import { useStyle, useScript } from "../../helpers";

import "./Header.css";

const Header = () => {
    useScript("member/coop/dist/jquery-2.1.3.min.js");
    useStyle("member/coop/bootstrap-3.3.7-dist/css/bootstrap.css");
    // useStyle("info/assets/css/bootstrap.min.css");
    // useStyle('member/coop/bootstrap-3.3.7-dist/css/bootstrap-theme.css');
    useScript("member/coop/bootstrap-3.3.7-dist/js/bootstrap.js");
    useStyle("member/coop/dist/css/bootstrap-datepicker.css");
    useScript("member/coop/dist/js/bootstrap-datepicker-custom.js");
    useScript("member/coop/dist/locales/bootstrap-datepicker.th.min.js");
    useStyle("member/coop/librarys/member_detail/jquery.circliful.css");
    useScript("member/coop/librarys/member_detail/jquery.circliful.js");
    // useStyle('https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css');
    useStyle("member/coop/librarys/member_detail/page.css");
    useScript("member/coop/librarys/member_detail/page.js");
    // useStyle('member/coop/librarys/bootstrap/css/bootstrap.min.css');

    // useStyle("https://fonts.googleapis.com/css?family=Kanit&subset=thai");
    useStyle("member/coop/librarys/font-awesome/css/font-awesome.min.css");
    useStyle("member/coop/librarys/css/mem.css");

    // useScript('member/coop/librarys/bootstrap/js/bootstrap.min.js');
    // useScript('member/coop/librarys/bootstrap/js/bootstrap-notify.min.js');
    useScript("member/coop/librarys/js/bootbox.min.js");

    useStyle("css/member.css");

    const toggleMobile = () => {
        // console.log("toggleMobile");

        $("#sidebar-wrapper").width(250);
        // $("#wrapper").css("padding-left", "250px");
        // if (window.matchMedia('screen and (max-width: 768px)').matches) {
        //     $("#wrapper").css("padding-left", "unset");
        // }else{
        //     $("#wrapper").css("padding-left", "250px");
        // }

        $(this).css("background-color", "#7a879d");

        if ($("#sidebar-wrapper").width() > 0) {
            $("#sidebar-wrapper").width(0);
            $("#wrapper").css("padding-left", "unset");
            $(this).css("background-color", "#7a879d");
        }
    };

    const toggleDesktop = () => {
        // console.log("toggleDesktop");

        $("#sidebar-wrapper").width(250);
        $("#wrapper").css("padding-left", "250px");
        $(this).css("background-color", "#7a879d");

        if ($("#sidebar-wrapper").width() > 0) {
            $("#sidebar-wrapper").width(0);
            $("#wrapper").css("padding-left", "unset");
            $(this).css("background-color", "#7a879d");
        }
    };

    return (
        <nav className="navbar navbar-default no-margin navbar-fixed-top">
            <div className="navbar-header fixed-brand">
                <button
                    type="button"
                    className="navbar-toggle collapsed"
                    data-toggle="collapse"
                    id="menu-toggle"
                    onClick={toggleMobile}
                >
                    <span
                        className="glyphicon glyphicon-th-large"
                        aria-hidden="true"
                    />
                </button>
                <div className="navbar-brand" style={{ color: "#fff" }}>
                    <i className="fa fa-users" /> ระบบข้อมูลสมาชิก
                </div>
            </div>
            <div
                className="collapse navbar-collapse"
                id="bs-example-navbar-collapse-1"
            >
                <ul className="nav navbar-nav">
                    <li className="active">
                        <button
                            className="navbar-toggle collapse in"
                            data-toggle="collapse"
                            id="menu-toggle-2"
                            onClick={toggleDesktop}
                        >
                            <span
                                className="glyphicon glyphicon-th-large"
                                aria-hidden="true"
                            />
                        </button>
                    </li>
                </ul>
            </div>
            {/* navbar-header*/}
        </nav>
    );
};

export default Header;
