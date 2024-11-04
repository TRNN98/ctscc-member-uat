import React from "react";
import { Link } from "react-router-dom";

export default function TabDetailPic({
    id,
    detail,
    imageEmtry = "mediafiles/images/pic.png",
    active = false,
    category
}) {
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
                                <div className="col-md-6" key={i}>
                                    <div className="item">
                                        <div className="item-image">
                                            {val.nphoto != "" &&
                                            val.nphoto != null ? (
                                                <Link to={`/show/${val.No}`}>
                                                    <img
                                                        className="img-responsive s1"
                                                        style={{
                                                            margin: "auto",
                                                            width: "100%"
                                                        }}
                                                        src={`mediafiles/${val.nphoto}`}
                                                    />
                                                    {/* </a> */}
                                                </Link>
                                            ) : (
                                                <Link to={`/show/${val.No}`}>
                                                    <img
                                                        className="img-responsive s1"
                                                        style={{
                                                            margin: "auto",
                                                            width: "100%"
                                                        }}
                                                        src={imageEmtry}
                                                    />
                                                </Link>
                                            )}
                                        </div>
                                        <div className="item-detail">
                                            <h5 className="title">
                                                <Link
                                                    to={`/show/${val.No}`}
                                                    className="colorBlue"
                                                >
                                                    {/* {val.Question.length} */}
                                                    {val.Question &&
                                                    val.Question.length > 50
                                                        ? `${val.Question.substr(
                                                              0,
                                                              45
                                                          )} ...`
                                                        : val.Question}
                                                </Link>
                                            </h5>
                                            <p className="detail"></p>
                                        </div>
                                        <div className="item-footer">
                                            <div
                                                className="footer1"
                                                style={{ padding: 10 }}
                                            >
                                                <Link
                                                    className="link"
                                                    to={`/show/${val.No}`}
                                                >
                                                    <i className="fa fa-arrow-right" />
                                                </Link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            ))}
                    </div>
                </div>
                {/* <hr /> */}
                <Link
                    className="news-view-all pull-right"
                    to={`/list/${category}`}
                >
                    <b>+ ดูทั้งหมด</b>
                </Link>
            </div>
        </div>
    );
}
