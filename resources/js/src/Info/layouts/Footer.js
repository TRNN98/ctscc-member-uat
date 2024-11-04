import React from "react";
import { useScript } from "../../helpers";
import { Route, Link } from "react-router-dom";

const Footer = () => {
    // useScript("info/assets/js/jquery.min.js");
    // useScript("info/assets/js/bootstrap.min.js");
    // useScript("info/assets/js/plugins.min.js");
    // // useScript("info/assets/js/part-int.js");
    // // useScript("info/assets/js/part-int2.js");
    // // useScript("https://maps.googleapis.com/maps/api/js?key=AIzaSyDcaOOcFcQ0hoTqANKZYz-0ii-J0aUoHjk");
    // // useScript("info/assets/js/google-map-int.js");
    useScript("info/assets/js/custom-scripts.js");

    // =============================================================================

    // useScript("info/scripts/jquery-1.10.2.min.js");
    // useScript("info/scripts/jquery-migrate-1.2.1.js");
    // useScript("info/html/frontend/bootstrap3.3.5/js/bootstrap.min.js");
    useScript("info/scripts/jquery.cookies.2.2.0.min.js");
    // useScript("info/scripts/fancybox/jquery.fancybox.js?v=2.1.5");
    useScript("info/scripts/utility.js");
    useScript("info/scripts/jquery.magnific-popup.min.js");

    useScript("info/scripts/jquery.smartmenus.js");

    // useScript("info/scripts/jquery.cycle2.min.js");
    // useScript("info/scripts/owl-carousel/owl.carousel.js");
    useScript("info/scripts/fullcalendar/lib/moment.min.js");
    useScript("info/scripts/fullcalendar/fullcalendar.min.js");
    useScript("info/scripts/fullcalendar/locale/th-shot.js");

    // useScript("admin/js/Lobibox.js");
    // // <!-- data table JS ============================================ -->
    // useScript("admin/js/data-table/bootstrap-table.js");
    // useScript("admin/js/data-table/tableExport.js");
    // useScript("admin/js/data-table/data-table-active.js");
    // // {{-- useScript("admin/js/data-table/bootstrap-table-editable.js"); --}}
    // useScript("admin/js/data-table/bootstrap-editable.js");
    // useScript("admin/js/data-table/bootstrap-table-resizable.js");
    // useScript("admin/js/data-table/colResizable-1.5.source.js");
    // useScript("admin/js/data-table/bootstrap-table-export.js");

    // useScript("info/scripts/jquery.smartmenus.js");

    return (
        // ===========================================
        <div className="footer">
            <div className="container">
                <div className="row">
                    <div className="col-md-10 col-md-offset-1">
                        <div className="row">
                            <div className="col-md-4">
                                {/* <h2 className="f-cmcoop">ติดต่อสหกรณ์</h2> */}
                                <ul>
                                    <li>ที่ตั้ง</li>
                                    <li>เลขที่ 2/65-67 หมู่ 1 ตำบลไร่ส้ม</li>
                                    <li>อำเภอเมือง จ.เพชรบุรี 76000</li>
                                    <li>
                                        <a
                                            href="https://www.google.co.th/maps/place/%E0%B8%AA%E0%B8%AB%E0%B8%81%E0%B8%A3%E0%B8%93%E0%B9%8C%E0%B8%AD%E0%B8%AD%E0%B8%A1%E0%B8%97%E0%B8%A3%E0%B8%B1%E0%B8%9E%E0%B8%A2%E0%B9%8C%E0%B8%AA%E0%B8%B2%E0%B8%98%E0%B8%B2%E0%B8%A3%E0%B8%93%E0%B8%AA%E0%B8%B8%E0%B8%82%E0%B9%80%E0%B8%9E%E0%B8%8A%E0%B8%A3%E0%B8%9A%E0%B8%B8%E0%B8%A3%E0%B8%B5+%E0%B8%88%E0%B8%B3%E0%B8%81%E0%B8%B1%E0%B8%94/@13.1132667,99.9221371,16z/data=!4m8!1m2!2m1!1z4LmA4Lil4LiC4LiX4Li14LmIIDIvNjUtNjcg4Lir4Lih4Li54LmIIDEg4LiV4Liz4Lia4Lil4LmE4Lij4LmI4Liq4LmJ4LihIOC4reC4s-C5gOC4oOC4reC5gOC4oeC4t-C4reC4hyDguIgu4LmA4Lie4LiK4Lij4Lia4Li44Lij4Li1IDc2MDAw!3m4!1s0x30fd270259e5bc81:0xd234b5589fdf7dc9!8m2!3d13.112426!4d99.9330844"
                                            target="_blank"
                                        >
                                            <img
                                                src={"info/html/images/map.png"}
                                                height={60}
                                            />
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div className="col-md-4">
                                <ul>
                                    <li>ติดต่อสหกรณ์</li>
                                    <li>
                                        โทร :{" "}
                                        <a href="tel:032400212">032-400-212</a>
                                    </li>
                                    <li>
                                        โทร :{" "}
                                        <a href="tel:032400224">032-400-224</a>
                                    </li>
                                    <li>
                                        โทรสาร :{" "}
                                        <a href="tel:032400877">032-400-877 </a>
                                    </li>
                                </ul>
                            </div>
                            <div className="col-md-4">
                                {/* <h2 className="f-cmcoop">ติดตามเรา</h2> */}
                                <ul>
                                    <li style={{ margin: "15px 0px 15px 0px" }}>
                                        <a
                                            href="http://line.me/ti/p/~@healthcoop.pb"
                                            target="_blank"
                                            style={{
                                                display: "flex",
                                                alignItems: "center"
                                            }}
                                        >
                                            <img
                                                src="info/html/images/LineOA.png"
                                                alt=""
                                                height="35px"
                                            />
                                            @healthcoop.pb
                                        </a>
                                    </li>
                                    <li style={{ margin: "15px 0px 15px 0px" }}>
                                        <a
                                            href="https://www.facebook.com/healthcoop/about"
                                            target="_blank"
                                            style={{
                                                display: "flex",
                                                alignItems: "center"
                                            }}
                                        >
                                            <img
                                                src="info/html/images/facebook2.png"
                                                alt=""
                                                height="35px"
                                            />
                                            facebook.com/healthcoop
                                        </a>
                                    </li>
                                    <li style={{ margin: "15px 0px 15px 0px" }}>
                                        <a
                                            href="mailto:healthcoop.pb@gmail.com"
                                            target="_blank"
                                            style={{
                                                display: "flex",
                                                alignItems: "center"
                                            }}
                                        >
                                            <img
                                                src="info/html/images/Gmail.png"
                                                alt=""
                                                height="35px"
                                            />
                                            healthcoop.pb@gmail.com
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div
                className="container-fluid"
                style={{
                    backgroundImage:
                        "linear-gradient(to right, #e76b2e, #e87427, #e87e1e, #e78715, #e59107)",
                    "padding-top": "10px",
                    "padding-bottom": "10px",
                    borderTop: "1px solid"
                }}
            >
                <div className="row">
                    <div className="col-xs-12 text-center">
                        <a
                            href={"https://www.soatsolution.com/"}
                            style={{ textDecoration: "none" }}
                            target="_blank"
                        >
                            <h6 style={{ color: "#fff" }}>
                                Copyright ©All Right Reserved SSBD@SO-AT
                                SOLUTION COMPANY LIMITED @2020 Enhance Web
                                Application V.RANLP2020
                            </h6>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    );
};

function ListItemLink({ to, topic, ...rest }) {
    return (
        <Route
            path={to}
            children={({ match }) => (
                <li>
                    <Link className="hov" to={to} {...rest}>
                        {topic}
                    </Link>
                </li>
            )}
        />
    );
}

export default Footer;
