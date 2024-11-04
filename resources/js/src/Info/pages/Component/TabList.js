import React from "react";
import { Link } from "react-router-dom";
import { convert_to_Thaidate } from "../../../helpers";

export default function TabList({ id, detail, active = false, category }) {
    return (
        <div
            role="tabpanel"
            className={`tab-pane ${active ? "active" : ""}`}
            id={id}
        >
            <div className="news-group-block">
                <div className="list">
                    <div className="row news-2-list">
                        {detail &&
                            detail.map((val, i) => (
                                <div className="col-md-12" key={i}>
                                    <div className="item-detail">
                                        <div className="item-detail">
                                            <h6
                                                className="title fb"
                                                style={{ margin: "12px 0" }}
                                            >
                                                &nbsp;
                                                <i className="fa fa-hand-o-right" />
                                                &nbsp;
                                                <span className="colorBlue fb">
                                                    {convert_to_Thaidate(
                                                        val.Date,
                                                        "ll",
                                                        "YYYY-MM-DD HH:mm:ss"
                                                    )}
                                                </span>
                                                &nbsp;
                                                {val.nlink == "uselink" ? (
                                                    <a
                                                        href={`${val.ndata}`}
                                                        className="fb underline"
                                                        target="_blank"
                                                    >
                                                        {val.Question}
                                                    </a>
                                                ) : val.ndata == null ||
                                                  val.ndata == "" ? (
                                                    <Link
                                                        to={`/show/${val.No}`}
                                                        className="fb underline"
                                                    >
                                                        {val.Question}
                                                    </Link>
                                                ) : (
                                                    <a
                                                        href={`mediafiles/${val.ndata}`}
                                                        className="fb underline"
                                                        target="_blank"
                                                    >
                                                        {val.Question}
                                                    </a>
                                                )}
                                                &nbsp;
                                                <font color="tomato" class="fb">
                                                    {" "}
                                                    [อ่าน {val.pageview} คน]
                                                </font>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            ))}
                    </div>
                </div>

                <Link
                    className="news-view-all pull-left thm-btn"
                    to={`/list/${category}`}
                >
                    <b>+ ดูทั้งหมด</b>
                </Link>
            </div>
        </div>
    );
}
