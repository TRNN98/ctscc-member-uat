import React from "react";
import { Link } from "react-router-dom";
import { convert_to_Thaidate } from "../../../helpers";

function Block4({data}) {
    return (
        <div className="row Block4">
            <h2 className="header-title">ปฏิทินกิจกรรม</h2>
            <hr/>
            <div className="news-tab">
                <div className="row">
                    <div className="col-lg-12">
                        <div className="steps-section">
                            <div id="timeline1" className="steps-timeline">
                                {data &&
                                    data.map((val, i) => (
                                        <div
                                            className={`steps-${i + 1}`}
                                            key={i}
                                        >
                                            <div className="steps-time">
                                                {convert_to_Thaidate(
                                                    val.ReplayDate,
                                                    "ll",
                                                    "DD/MM/YYYY",
                                                    false
                                                )}
                                            </div>
                                            <div className="steps-icon">
                                                {/* <i className="glyphicon glyphicon-time" /> */}
                                                <img
                                                    src={`info/assets/index/time.png`}
                                                    style={{
                                                        width: 35,
                                                        background: "#d4d4d4",
                                                        borderRadius: "50%"
                                                    }}
                                                />
                                            </div>
                                            <h3 className="steps-name">
                                                <Link to={`show/${val.No}`}>
                                                    {val.Question}
                                                </Link>
                                            </h3>
                                            <p
                                                className="steps-description"
                                                style={{
                                                    wordWrap: "break-word"
                                                }}
                                            >
                                                {data.Note}
                                            </p>
                                        </div>
                                    ))}
                            </div>
                        </div>
                        {/* <h4 className="text-center header-title">
                                            <strong>
                                                $calendar-&gt;Question
                                            </strong>
                                        </h4>
                                        $calendar-&gt;Note */}
                    </div>
                    <div className="col-sm-12">
                        <Link
                            className="news-view-all pull-right"
                            to={`list/calender`}
                            style={{
                                margin: "25px 10px 25px 10px"
                            }}
                        >
                            <b>+ ดูปฏิทินทั้งหมด</b>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Block4;
