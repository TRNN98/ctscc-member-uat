import React from "react";

import { createMarkup } from "../../../../helpers";

function Headname({ I: i, Val: val }) {
    let res = "";

    switch (i) {
        case 0:
            res = (
                <div
                    className="wrimagecard-topimage_header"
                    style={{ backgroundColor: "rgba(51, 105, 232, 0.1)" }}
                >
                    <center>
                        <i
                            style={{ color: "#3369e8", fontSize: 40 }}
                            dangerouslySetInnerHTML={createMarkup(
                                val.receive_month_fp
                            )}
                        ></i>
                    </center>
                </div>
            );
            break;
        case 1:
            res = (
                <div
                    className="wrimagecard-topimage_header"
                    style={{ backgroundColor: "rgba(22, 160, 133, 0.1)" }}
                >
                    <center>
                        <i
                            style={{ color: "#16A085", fontSize: 40 }}
                            dangerouslySetInnerHTML={createMarkup(
                                val.receive_month_fp
                            )}
                        ></i>
                    </center>
                </div>
            );
            break;
        case 2:
            res = (
                <div
                    className="wrimagecard-topimage_header"
                    style={{ backgroundColor: "rgba(187, 120, 36, 0.1)" }}
                >
                    <center>
                        <i
                            style={{ color: "#BB7824", fontSize: 40 }}
                            dangerouslySetInnerHTML={createMarkup(
                                val.receive_month_fp
                            )}
                        ></i>
                    </center>
                </div>
            );
            break;
        case 3:
            res = (
                <div
                    className="wrimagecard-topimage_header"
                    style={{ backgroundColor: "rgba(213, 15, 37, 0.1)" }}
                >
                    <center>
                        <i
                            style={{ color: "#d50f25", fontSize: 40 }}
                            dangerouslySetInnerHTML={createMarkup(
                                val.receive_month_fp
                            )}
                        ></i>
                    </center>
                </div>
            );
            break;
        case 4:
            res = (
                <div
                    className="wrimagecard-topimage_header"
                    style={{ backgroundColor: "rgba(51, 105, 232, 0.1)" }}
                >
                    <center>
                        <i
                            style={{ color: "#3369e8", fontSize: 40 }}
                            dangerouslySetInnerHTML={createMarkup(
                                val.receive_month_fp
                            )}
                        ></i>
                    </center>
                </div>
            );
            break;
        default:
            res = (
                <div
                    className="wrimagecard-topimage_header"
                    style={{ backgroundColor: "rgba(22, 160, 133, 0.1)" }}
                >
                    <center>
                        <i
                            style={{ color: "#16A085", fontSize: 40 }}
                            dangerouslySetInnerHTML={createMarkup(
                                val.receive_month_fp
                            )}
                        ></i>
                    </center>
                </div>
            );
            break;
    }

    return res;
}

export default Headname;
