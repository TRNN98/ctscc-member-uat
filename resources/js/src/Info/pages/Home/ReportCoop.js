import React from "react";
import { Link } from "react-router-dom";
import TabDetailPic2 from "../Component/TabDetailPic2";

const ReportCoop = ({ data }) => {
    return (
        <div className="row Report-Box">
            {/*======== รายงานกิจการประจำปี =======*/}
            <div className="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <ul
                    style={{
                        listStyle: "none",
                        padding: 0,
                        backgroundColor: "#eee",
                        padding: "12px 22px 15px"
                    }}
                >
                    <li>
                        {" "}
                        <h2 className="header-title">รายงานกิจการประจำปี</h2>
                    </li>
                    <li>
                        <TabDetailPic2
                            id=""
                            detail={data.report_coop && data.report_coop}
                            category={
                                data.report_coop && data.report_coop[0].Category
                            }
                            active="true"
                            imageEmtry={`mediafiles/images/newetc.png?${Math.random() *
                                100}`}
                        />
                    </li>
                    {/* {data.report_coop &&
                        data.report_coop.map((val, i) =>
                            val.nlink == "uselink" ? (
                                <li style={{ padding: "5px 0px" }} key={i}>
                                    <a
                                        href={`${val.ndata}`}
                                        target="_blank"
                                        className="underline"
                                    >
                                        <i
                                            className="fa fa-arrow-right"
                                            style={{ fontSize: 16 }}
                                        />{" "}
                                        {val.Question}
                                    </a>
                                </li>
                            ) : (
                                <li style={{ padding: "12px 0px" }} key={i}>
                                    <a
                                        href={`/mediafiles/${val.ndata}`}
                                        target="_blank"
                                        className="underline"
                                    >
                                        <i
                                            className="fa fa-arrow-right"
                                            style={{ fontSize: 16 }}
                                        />{" "}
                                        {val.Question}
                                    </a>
                                </li>
                            )
                        )} */}
                    {/* <li className="text-right" style={{ paddingTop: 15 }}>
                        <Link to={`/list/report_coop`}>
                            <b>+ ดูทั้งหมด</b>
                        </Link>
                    </li> */}
                </ul>
            </div>
            {/*======== รายงานการตรวจสอบบัญชี =======*/}
            <div className="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                <ul
                    style={{
                        listStyle: "none",
                        padding: 0,
                        backgroundColor: "#eee",
                        padding: "12px 22px 15px"
                    }}
                >
                    <li>
                        {" "}
                        <h2 className="header-title">รายงานการตรวจสอบบัญชี</h2>
                    </li>
                    <li>
                        <TabDetailPic2
                            id="t2"
                            detail={data.audit_report && data.audit_report}
                            category={
                                data.audit_report && data.audit_report[0].Category
                            }
                            active="true"
                            imageEmtry={`mediafiles/images/newetc.png?${Math.random() *
                                100}`}
                        />
                    </li>
                    {/* {data.audit_report &&
                        data.audit_report.map((val, i) =>
                            val.nlink == "uselink" ? (
                                <li style={{ padding: "5px 0px" }} key={i}>
                                    <a
                                        href={`${val.ndata}`}
                                        target="_blank"
                                        className="underline"
                                    >
                                        <i
                                            className="fa fa-arrow-right"
                                            style={{ fontSize: 16 }}
                                        />{" "}
                                        {val.Question}
                                    </a>
                                </li>
                            ) : (
                                <li style={{ padding: "12px 0px" }} key={i}>
                                    <a
                                        href={`/mediafiles/${val.ndata}`}
                                        target="_blank"
                                        className="underline"
                                    >
                                        <i
                                            className="fa fa-arrow-right"
                                            style={{ fontSize: 16 }}
                                        />{" "}
                                        {val.Question}
                                    </a>
                                </li>
                            )
                        )} */}
                </ul>
            </div>
        </div>
    );
};

export default ReportCoop;
