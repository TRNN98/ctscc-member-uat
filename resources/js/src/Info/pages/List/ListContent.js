import React from "react";
import Pagination from "rc-pagination";
import { Link } from "react-router-dom";
import { convert_to_Thaidatetime } from "../../../helpers";

function ListContent({ data, pagination }) {
    return (
        <div className="content-inner container">
            <div className="row">
                <div className="col-md-8">
                    <div className="news-list">
                        {data.list_data &&
                            data.list_data.data &&
                            data.list_data.data.map((val, i) => (
                                <div
                                    className="row item"
                                    key={i}
                                    style={{
                                        "border-bottom": "1px solid #BDBDBD",
                                        "padding-bottom": "10px"
                                    }}
                                >
                                    <div className="col-sm-4">
                                        <div className="image">
                                            {val.Category == "rules" ? (
                                                <a
                                                    href={`/mediafiles/${val.ndata}`}
                                                    target="_blank"
                                                >
                                                    <img
                                                        className="img-responsive s1"
                                                        src={
                                                            val.nphoto == "" ||
                                                            val.nphoto == null
                                                                ? `mediafiles/images/news1.png`
                                                                : `mediafiles/${val.nphoto}`
                                                        }
                                                    />
                                                </a>
                                            ) : (
                                                <Link to={`/show/${val.No}`}>
                                                    <img
                                                        className="img-responsive s1"
                                                        src={
                                                            val.nphoto == "" ||
                                                            val.nphoto == null
                                                                ? `mediafiles/images/news1.png`
                                                                : `mediafiles/${val.nphoto}`
                                                        }
                                                    />
                                                </Link>
                                            )}
                                        </div>
                                    </div>

                                    <div className="col-sm-8 group-detail">
                                        <div className="auther">
                                            โดย {val.Name}
                                            &nbsp;
                                            <i className="fa fa-clock-o" />
                                            &nbsp;{val.Date}
                                        </div>
                                        <h2 className="title">
                                            {val.Category == "rules" ? (
                                                <a href={`/mediafiles/${val.ndata}`} target="_blank">
                                                    {val.Question}
                                                </a>
                                            ) : (
                                                <Link to={`/show/${val.No}`}>
                                                    {val.Question}
                                                </Link>
                                            )}
                                        </h2>
                                        <div className="detail">
                                            <p></p>
                                        </div>
                                    </div>
                                </div>
                            ))}

                        <div>
                            {data.list_data &&
                                data.list_data.data &&
                                data.list_data.data.length > 0 && (
                                    <Pagination
                                        defaultPageSize={6}
                                        className="pagination"
                                        locale={{
                                            // Options.jsx
                                            items_per_page: "/ หน้า",
                                            jump_to: "ไปยัง",
                                            jump_to_confirm: "ยืนยัน",
                                            page: "",

                                            // Pagination.jsx
                                            prev_page: "หน้าก่อนหน้า",
                                            next_page: "หน้าถัดไป",
                                            prev_5: "ย้อนกลับ 5 หน้า",
                                            next_5: "ถัดไป 5 หน้า",
                                            prev_3: "ย้อนกลับ 3 หน้า",
                                            next_3: "ถัดไป 3 หน้า"
                                        }}
                                        onChange={pagination}
                                        current={data.list_data.current_page}
                                        total={data.list_data.total}
                                        prevIcon={
                                            <a
                                                className="page-link"
                                                itemProp="url"
                                            >
                                                <i className="fa fa-angle-left" />{" "}
                                                PREVIOUS
                                            </a>
                                        }
                                        nextIcon={
                                            <a
                                                className="page-link"
                                                itemProp="url"
                                            >
                                                NEXT{" "}
                                                <i className="fa fa-angle-right" />
                                            </a>
                                        }
                                        jumpNextIcon="..."
                                        jumpPrevIcon="..."
                                    />
                                )}
                            {/* <ul className="pagination">
                                <li className="active">
                                    <a href="#">1</a>
                                </li>
                            </ul> */}
                        </div>
                    </div>
                </div>
                <div className="col-md-4">
                    <div className="right-panel">
                        <div className="wdgt style2">
                            <h2 itemProp="headline">ข่าวล่าสุด</h2>
                            <div className="mini-pst-wrp">
                                {data.news_last &&
                                    data.news_last.map((val, i) => (
                                        <div className="mini-pst-bx">
                                            <Link
                                                to={`/show/${val.No}`}
                                                title
                                                itemProp="url"
                                            >
                                                {val.nphoto != "" ? (
                                                    <img
                                                        className="img-responsive"
                                                        width={100}
                                                        itemProp="image"
                                                        src={`/mediafiles/${val.nphoto}`}
                                                    />
                                                ) : (
                                                    <img
                                                        className="img-responsive"
                                                        width={100}
                                                        itemProp="image"
                                                        src="/mediafiles/285 239.jpg"
                                                    />
                                                )}
                                            </Link>
                                            <div className="mini-pst-inf">
                                                <span className="pst-dat">
                                                    {convert_to_Thaidatetime(
                                                        val.Date
                                                    )}
                                                </span>
                                                <h4 itemProp="headline">
                                                    <Link
                                                        to={`/show/${val.No}`}
                                                        title
                                                        itemProp="url"
                                                    >
                                                        {val.Question.length >
                                                        25
                                                            ? val.Question.substring(
                                                                  0,
                                                                  25
                                                              ) + "..."
                                                            : val.Question}
                                                    </Link>
                                                </h4>
                                                <span className="pst-athr">
                                                    โดย {val.Name}
                                                </span>
                                            </div>
                                        </div>
                                    ))}
                                <Link
                                    className="thm-btn"
                                    to={`/list/news_relations`}
                                    title
                                    itemProp="url"
                                >
                                    ดูทั้งหมด
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default ListContent;
