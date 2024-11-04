import React from "react";
import { useCookies } from "react-cookie";

export default function AcceptCookie({ isOpen, setStatusOpen = null }) {
    const [cookies, setCookie, removeCookie] = useCookies(["acceptCookie"]);
    const NotAccept = () => {
        setCookie("acceptCookie", "N", {
            // 86400 วินาที/วัน  * 2ปี
            maxAge: 86400 * (365 * 2)
        });
        $("#PolicyCookies").hide();
    };
    const Accept = () => {
        setCookie("acceptCookie", "Y", {
            // 86400 วินาที/วัน  * 2ปี
            maxAge: 86400 * (365 * 2)
        });
    };

    const bannerStyle = {
        PolicyCookies: {
            backgroundColor: "#000000",
            width: "100%",
            position: "fixed",
            bottom: "15px",
            left: "0",
            zIndex: "9",
            padding: "15px 30px",
            color: "#fff",
            opacity: 0.9,
            display: "flex",
            justifyContent: "center",
            alignItems: "center"
        },
        areaText: {
            maxWidth: "760px",
            flex: 1
        },
        areaBtn: {},
        btnNotAccept: {
            padding: "8px",
            border: "1px solid",
            borderRadius: "4px"
        },
        btnAccept: {
            padding: "8px",
            border: "1px solid",
            marginLeft: "10px",
            background: "green",
            borderRadius: "4px"
        }
    };

    return (
        <>
            <div id="PolicyCookies" style={bannerStyle.PolicyCookies}>
                <div className="area-text" style={bannerStyle.areaText}>
                    <h5>
                        {/* เปลี่ยนชื่อ สอ.เอาครับ */}
                        สหกรณ์ออมทรัพย์ครูชุมพร จำกัด
                        <br /> ใช้คุกกี้(cookies)
                        เพื่อพัฒนาประสบการณ์ของผู้ใช้ให้ดียิ่งขึ้น
                        <a
                            href="/privacy-policy/cookies-policy"
                            style={{ color: "DodgerBlue" }}
                        >
                            นโยบายการใช้คุกกี้
                        </a>
                        &nbsp;
                        <a
                            href="/privacy-policy/private-policy"
                            style={{ color: "DodgerBlue" }}
                        >
                            นโยบายความเป็นส่วนตัว
                        </a>
                    </h5>
                </div>
                <div className="area-btn">
                    <button
                        style={bannerStyle.btnAccept}
                        onClick={() => Accept()}
                    >
                        ยอมรับ
                    </button>
                    &nbsp;
                    <button
                        style={bannerStyle.btnNotAccept}
                        onClick={() => NotAccept()}
                    >
                        ปฏิเสธ
                    </button>
                </div>
            </div>
        </>
    );
}
