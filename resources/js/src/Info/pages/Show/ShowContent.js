import React from "react";
import {
    convert_to_Thaidatetime,
    createMarkup
} from "../../../helpers/functions";
import { Link } from "react-router-dom";
import ShowFileDowload from "./ShowFileDowload";

function ShowContent({ data }) {
    return (
        <div className="content-inner container">
            <div className="row">
                <div className="col-md-8">
                    <h2 className="news-title">
                        {data.show && data.show.Question}
                    </h2>
                    <div className="news-header-line">
                        <div className="item">
                            โดย&nbsp;
                            {data.show && data.show.Name}
                        </div>
                        <div className="item">
                            <i className="fa fa-clock-o" />
                            &nbsp;{data.show && data.show.Date}
                        </div>
                        <div className="item">
                            <i className="fa fa-eye" />
                            &nbsp;{data.show && data.show.pageview}
                        </div>
                    </div>
                    <div
                        className="news-header-detail"
                        dangerouslySetInnerHTML={createMarkup(
                            data.show && data.show.Note
                        )}
                        style={
                            data.show && data.show.Note == ""
                                ? { padding: 0 }
                                : {}
                        }
                    ></div>
                    <div className="news-footer">
                        <div className="row">
                            <div className="col-md-12">
                                {data.show && data.show.ndata && (
                                    <ShowFileDowload data={data.show.ndata} nlink={data.show.nlink}/>
                                )}

                                <div className="news-picture-item">
                                    <div style={{ clear: "both" }} />
                                </div>
                            </div>
                        </div>
                        <div className="row">
                            <div className="col-xs-12 text-left"></div>
                        </div>
                    </div>
                </div>
                <div className="col-md-4">
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
                                            {val.nphoto != '' ? (
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
                                                    src="/mediafiles/picture/3.jpg"
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
                                                    {val.Question.length > 25
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
    );
}

export default ShowContent;
