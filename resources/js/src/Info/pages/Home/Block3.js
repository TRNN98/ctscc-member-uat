import React from "react";
import { Link } from "react-router-dom";
import PanelCustom from "../Component/PanelCustom";

import { convert_to_Thaidate } from "../../../helpers";
import TabList from "../Component/TabList";

function Block3({ data }) {
    // ============ Detail Block 3 ================ //
    // ============ ============== ================ //
    const DetailProcedure = () => {
        return (
            <div className="row">
                <div className="col-sm-12">
                    <div className="news-tab">
                        <ul className="nav nav-tabs" role="tablist" id="mytab">
                            <li role="presentation" class="active" style={{borderBottom:"1px solid #33333338"}}>
                                <a
                                    href="#t2_1"
                                    aria-controls="settings"
                                    role="tab"
                                    data-toggle="tab"
                                >
                                    ระเบียบ63
                                </a>
                            </li>

                            <li role="presentation" style={{borderBottom:"1px solid #33333338"}}>
                                <a
                                    href="#t2_2"
                                    aria-controls="settings"
                                    role="tab"
                                    data-toggle="tab"
                                >
                                    ระเบียบสมาชิก
                                </a>
                            </li>

                            <li role="presentation" style={{borderBottom:"1px solid #33333338"}}>
                                <a
                                    href="#t2_3"
                                    aria-controls="settings"
                                    role="tab"
                                    data-toggle="tab"
                                >
                                    ระเบียบเงินกู้
                                </a>
                            </li>
                            <li role="presentation" style={{borderBottom:"1px solid #33333338"}}>
                                <a
                                    href="#t2_4"
                                    aria-controls="settings"
                                    role="tab"
                                    data-toggle="tab"
                                >
                                    ระเบียบเงินฝาก
                                </a>
                            </li>
                            <li role="presentation" style={{borderBottom:"1px solid #33333338"}}>
                                <a
                                    href="#t2_5"
                                    aria-controls="settings"
                                    role="tab"
                                    data-toggle="tab"
                                >
                                    ระเบียบสวัสดิการ
                                </a>
                            </li>
                            <li role="presentation" style={{borderBottom:"1px solid #33333338"}}>
                                <a
                                    href="#t2_6"
                                    aria-controls="settings"
                                    role="tab"
                                    data-toggle="tab"
                                >
                                    ระเบียบการทำงาน
                                </a>
                            </li>
                            <li role="presentation" style={{borderBottom:"1px solid #33333338"}}>
                                <a
                                    href="#t2_7"
                                    aria-controls="settings"
                                    role="tab"
                                    data-toggle="tab"
                                >
                                    ข้อบังคับ
                                </a>
                            </li>
                        </ul>
                        <div className="tab-content">
                            <TabList
                                id="t2_1"
                                detail={data.procedure}
                                category="procedure"
                                active="true"
                            />
                            <TabList
                                id="t2_2"
                                detail={data.procedure_member}
                                category="procedure_member"
                            />
                            <TabList
                                id="t2_3"
                                detail={data.procedure_loan}
                                category="procedure_loan"
                            />
                            <TabList
                                id="t2_4"
                                detail={data.procedure_deposit}
                                category="procedure_deposit"
                            />
                            <TabList
                                id="t2_5"
                                detail={data.procedure_welfare}
                                category="procedure_welfare"
                            />
                            <TabList
                                id="t2_6"
                                detail={data.procedure_work}
                                category="procedure_work"
                            />
                            <TabList
                                id="t2_7"
                                detail={data.rules}
                                category="rules"
                            />
                        </div>
                    </div>
                    <div style={{ clear: "both" }} />
                    <div className="panel-notify"></div>
                </div>
            </div>
        );
    };

    // ============= Set option ================//
    // =========================================//
    const option = {
        title: "ระเบียบของสหกรณ์",
        detail: DetailProcedure()
    };

    // =================== Render ================ //
    // =================== ====== ================ //
    return (
        <div className="row Block3">
            <div className="col-sm-12">
                <h2 className="header-title">ระเบียบของสหกรณ์</h2>
            <hr/>
                {DetailProcedure()}
            </div>
        </div>
    );
}

export default Block3;
