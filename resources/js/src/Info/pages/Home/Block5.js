import React from "react";
import { Link } from "react-router-dom";
import OwlCarousel from "react-owl-carousel";
import PanelCustom from "../Component/PanelCustom";
import PanalToggle from "../Component/PanalToggle";

function Block5({ data }) {
    // ============ Detail Block 5 ================ //
    // ============ ============== ================ //
    const DetailLinkInfo = () => {
        return (
            <div className="col-sm-12">
                <div className="news-tab">
                    <div className="tab-content">
                        <div className="tab-pane active">
                            <div className="news-group-block">
                                <div className="list">
                                    <div className="row">
                                        {data.link_info &&
                                            data.link_info.map((val, i) => (
                                                <div
                                                    className="col-sm-12 col-md-12 col-lg-12 m-b-xs"
                                                    key={i}
                                                >
                                                    <a
                                                        href={val.Note}
                                                        target="_blank"
                                                    >
                                                        - {val.Question}
                                                    </a>
                                                </div>
                                            ))}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    };
    const DetailCrem = () => {
        return (
            <div className="col-sm-12">
                <div className="news-tab">
                    <div className="tab-content">
                        <div className="tab-pane active">
                            <div className="news-group-block">
                                <div className="list">
                                    <div className="row">
                                        {data.link_crem &&
                                            data.link_crem.map((val, i) => (
                                                <div
                                                    className="col-sm-12 col-md-12 col-lg-12 m-b-xs" 
                                                    key={i}
                                                >
                                                    <a
                                                        href={val.Note}
                                                        target="_blank"
                                                    >
                                                        - {val.Question}
                                                    </a>
                                                </div>
                                            ))}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    };

    // ============= Set option ================//
    // =========================================//
    const Link_option = {
            title: "Link ที่น่าสนใจ",
            detail: DetailLinkInfo()
        },
        Crem_option = {
            title: "สมาคมฌาปนกิจ",
            detail: DetailCrem()
        };

    return (
        <div className="row Block5">
            <div className="col-sm-6">
                <h2 className="header-title">Link ที่น่าสนใจ</h2>
            <hr/>
                {DetailLinkInfo()}
            </div>
            <div className="col-sm-6">
                <h2 className="header-title">สมาคมฌาปนกิจ</h2>
            <hr/>
                {DetailCrem()}
            </div>
        </div>
    );
}

export default Block5;

