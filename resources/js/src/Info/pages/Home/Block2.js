import React from "react";
import { Link } from "react-router-dom";
import PanelCustom from "../Component/PanelCustom";

import { convert_to_Thaidate } from "../../../helpers";
import TabDetailPic from "../Component/TabDetailPic";
import TabDetailPic2 from "../Component/TabDetailPic2";
import TabList from "../Component/TabList";
import OwlCarousel from "react-owl-carousel";

function Block2({ data }) {
    // ============ Detail Block 2 ================ //
    // ============ ============== ================ //
    const DetailBlock2 = () => {
        return (
            <div className="row">
                <div className="col-sm-12">
                    <div className="news-tab">
                        <ul className="nav nav-tabs" role="tablist" id="mytab">
                            <li role="presentation" className="active">
                                <a
                                    href="#t2"
                                    aria-controls="settings"
                                    role="tab"
                                    data-toggle="tab"
                                >
                                    ข่าวกิจกรรม/อัลบั้มภาพ
                                </a>
                            </li>
                            <li role="presentation">
                                <a
                                    href="#t3"
                                    aria-controls="settings"
                                    role="tab"
                                    data-toggle="tab"
                                >
                                    ข่าวฌาปนกิจ
                                </a>
                            </li>
                            <li role="presentation">
                                <a
                                    href="#t4"
                                    aria-controls="settings"
                                    role="tab"
                                    data-toggle="tab"
                                >
                                    จัดซื้อจัดจ้าง
                                </a>
                            </li>
                            <li role="presentation">
                                <a
                                    href="#t5"
                                    aria-controls="settings"
                                    role="tab"
                                    data-toggle="tab"
                                >
                                    สาระน่ารู้
                                </a>
                            </li>
                        </ul>
                        <div className="tab-content">
                            <TabDetailPic
                                id="t2"
                                detail={data.pic_activity}
                                category="pic_activity"
                                active="true"
                                imageEmtry={`mediafiles/images/pic.png?${Math.random() *
                                    100}`}
                            />
                            <TabDetailPic
                                id="t3"
                                detail={data.cremation_news}
                                category="cremation_news"
                                imageEmtry={`mediafiles/images/newetc.png?${Math.random() *
                                    100}`}
                            />
                            <TabDetailPic
                                id="t4"
                                detail={data.news_purchase}
                                category="news_purchase"
                                imageEmtry={`mediafiles/images/newetc.png?${Math.random() *
                                    100}`}
                            />
                            <TabDetailPic
                                id="t5"
                                detail={data.news_substance}
                                category="news_substance"
                                imageEmtry={`mediafiles/images/newetc.png?${Math.random() *
                                    100}`}
                            />
                        </div>
                    </div>
                    <div style={{ clear: "both" }} />
                    <div className="panel-notify"></div>
                </div>
            </div>
        );
    };

    // =================== Render ================ //
    // =================== ====== ================ //
    return <div className="row Block2">{DetailBlock2()}</div>;
}

export default Block2;
