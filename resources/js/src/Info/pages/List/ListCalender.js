import React from "react";
// import Pagination from "rc-pagination";
import { Link } from "react-router-dom";
import { convert_to_Thaidate } from "../../../helpers";

function ListCalender({ data }) {
    return (
        <div className="content-inner container">
            <div className="row">
                <div className="col-md-12">
                    <div className="detail">
                        {/*start TimeLine*/}
                        <div className="right-panel">
                            <ul className="timeline">
                                {data.list_data &&
                                    data.list_data.map((val, i) => (
                                        <li key={i}>
                                            {/*Time Line Element */}
                                            <div className="timeline-badge">
                                                <span className="fa fa-clock-o" />
                                            </div>
                                            <div className="timeline-time f-s-13">
                                                {convert_to_Thaidate(
                                                    val.ReplayDate,
                                                    "ll",
                                                    "DD/MM/YYYY",
                                                    false
                                                )}
                                            </div>
                                            <div className="timeline-panel">
                                                <div className="timeline-heading">
                                                    <div className="timeline-title f-s-12 f-green">
                                                        <Link
                                                            to={`/show/${val.No}`}
                                                        >
                                                            {val.Question}
                                                        </Link>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    ))}
                            </ul>
                        </div>
                        {/*end TimeLine*/}
                    </div>
                    <div className="page-footer"></div>
                </div>
            </div>
        </div>
    );
}

export default ListCalender;
