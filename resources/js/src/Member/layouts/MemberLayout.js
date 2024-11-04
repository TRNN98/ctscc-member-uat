//import libs
import React, { useEffect } from "react";
import PropTypes from "prop-types";
import { useSelector } from "react-redux";
// import LoadingOverlay from "react-loading-overlay";

// import components
import Header from "./Header";
// import Footer from './Footer';
import Sidebar from "./Sidebar";

function MemberLayout({ children }) {
    const state = useSelector(state => state);

    useEffect(() => {
        $("body").css("overflow-x", "unset");
    }, []);

    const goBack = () => {
        window.history.back();
    };
    // $(function() {
    //     $("body").css("overflow-x", "hidden");

    //     // $("#menu-toggle").click(function(e) {
    //     //     e.preventDefault();
    //     //     $('body').css('overflow-x','unset');

    //     //     if ($("#wrapper").toggleClass("toggled")) {
    //     //     }else{
    //     //         $('body').css('overflow-x','hidden');
    //     //     }

    //     //     console.log($('#wrapper').is(":visible"));

    //     // });

    //     // console.log($('#wrapper').is(":visible"));

    //     // $('[data-toggle="tooltip"]').tooltip();
    // });

    return (
        <>
            <Header />
            <div id="wrapper">
                <Sidebar />
                <div id="page-content-wrapper">
                    <div className="container-fluid">
                        <div className="row">
                            <main
                                id="page-content-wrapper"
                                role="main"
                                style={{ left: 0 }}
                            >
                                <div className="row header-coop">
                                    {/* <div
                                        className="col-xs-2 col-md-1 no-s "
                                        id="header-effect"
                                    >
                                        <div className="logo">
                                            <i />
                                        </div>
                                    </div> */}
                                    <div className="col-xs-12 col-md-2 no-s">
                                        <div className="logoMem">
                                            <img
                                                src={
                                                    "info/assets/index/logo.jpg"
                                                }
                                                style={{
                                                    width: 150
                                                }}
                                            />
                                            <i />
                                        </div>
                                    </div>
                                    <div
                                        className="col-xs-12 col-md-9"
                                        id="namecoop"
                                    >
                                        <p
                                            className="no-m m-t-xs"
                                            style={{
                                                overflow: "hidden",
                                                textOverflow: "ellipsis",
                                                fontWeight: "bold",
                                                color: "rgb(39 38 38)",
                                                fontSize: "26px",
                                                marginTop: 10
                                            }}
                                        >
                                            สหกรณ์ออมทรัพย์ครูชุมพร จำกัด
                                        </p>
                                        <p
                                            className="no-m"
                                            style={{
                                                overflow: "hidden",
                                                textOverflow: "ellipsis",
                                                color: "rgb(39 38 38)",
                                                fontWeight: "bold",
                                                fontSize: "23px"
                                            }}
                                        >
                                            Chumphon Teacher's Saving and Credit Cooperative Ltd.
                                        </p>
                                    </div>
                                </div>
                                <br />
                                <hr />
                                <style
                                    dangerouslySetInnerHTML={{
                                        __html: "a:hover{cursor: pointer;}"
                                    }}
                                />
                                <a onClick={goBack}>
                                    <span>
                                        <i className="fa fa-fast-backward fa-2x" />
                                    </span>
                                    &nbsp;กลับ
                                </a>
                                <div className="row">
                                    <div id="coop-content">{children}</div>
                                </div>
                            </main>
                        </div>
                    </div>
                </div>
            </div>
            <div id="toTop" className="btn-totop text-center">
                <span>
                    <i
                        className="glyphicon glyphicon-chevron-up"
                        style={{
                            right: 1,
                            top: "-15px",
                            position: "relative",
                            color: "white"
                        }}
                    />
                </span>
            </div>
        </>
    );
}

const displayName = "Member Layout";
const propTypes = {
    children: PropTypes.node.isRequired
};

MemberLayout.dispatch = displayName;
MemberLayout.propTypes = propTypes;

export default MemberLayout;
