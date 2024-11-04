import React from "react";

const Committee = ({ detail }) => {
    return (
        <div style={{ padding: " 0 90px", textAlign: "center" }} className="box-committee-info">
            {/* ================================  คณะกรรมการดำเนินการ ชุดที่ 35==================================== */}
            <h2
                style={{
                    fontSize: 30,
                    fontWeight: "bold",
                    color: "orangered"
                }}
            >
                คณะกรรมการดำเนินการ ชุดที่ 35
            </h2>
            <div
                className="col-md-4 col-sm-12 col-xs-12"
                style={{ padding: 0 }}
            >
                {detail &&
                    detail.map(
                        (val, i) =>
                            i + 1 <= 5 && (
                                <div
                                    className={`col-md-6 ${i + 1 == 1 &&
                                        `col-md-offset-3`} col-sm-12 col-xs-12`}
                                >
                                    <div
                                        className="card"
                                        style={{ marginBottom: 35 }}
                                    >
                                        <div className="card-imgbox">
                                            <img
                                                src={`mediafiles/${val.nphoto}`}
                                                className="img-responsive img-circle img-per"
                                                style={{ padding: 13 }}
                                            />
                                        </div>
                                        <div
                                            className="card-text"
                                            style={{
                                                padding: "2px 16px"
                                            }}
                                        >
                                            <h5>
                                                <b>{val.Question}</b>
                                            </h5>
                                            <hr
                                                style={{
                                                    borderTop:
                                                        "1px solid #9e9e9e6b"
                                                }}
                                            />
                                            <h4>{val.Note}</h4>
                                        </div>
                                    </div>
                                </div>
                            )
                    )}
            </div>
            <div
                className="col-md-8 col-sm-12 col-xs-12"
                style={{ padding: 0 }}
            >
                {detail &&
                    detail.map((val, i) => {
                        if (i + 1 > 5 && i + 1 < 14) {
                            return (
                                <div className={`col-md-3 col-sm-4 col-xs-12`}>
                                    <div
                                        className="card"
                                        style={{ marginBottom: 35 }}
                                    >
                                        <div className="card-imgbox">
                                            <img
                                                src={`mediafiles/${val.nphoto}`}
                                                className="img-responsive img-circle img-per"
                                                style={{ padding: 13 }}
                                            />
                                        </div>
                                        <div
                                            className="card-text"
                                            style={{
                                                padding: "2px 16px"
                                            }}
                                        >
                                            <h5>
                                                <b>{val.Question}</b>
                                            </h5>
                                            <hr
                                                style={{
                                                    borderTop:
                                                        "1px solid #9e9e9e6b"
                                                }}
                                            />
                                            <h4>{val.Note}</h4>
                                        </div>
                                    </div>
                                </div>
                            );
                        } else if (i + 1 >= 14) {
                            if (i + 1 == 14) {
                                return (
                                    <>
                                        <div
                                            className={`col-md-3 col-sm-12 col-xs-12`}
                                        />
                                        <div
                                            className={`col-md-3 col-sm-4 col-xs-12`}
                                        >
                                            <div
                                                className="card"
                                                style={{ marginBottom: 35 }}
                                            >
                                                <div className="card-imgbox">
                                                    <img
                                                        src={`mediafiles/${val.nphoto}`}
                                                        className="img-responsive img-circle img-per"
                                                        style={{ padding: 13 }}
                                                    />
                                                </div>
                                                <div
                                                    className="card-text"
                                                    style={{
                                                        padding: "2px 16px"
                                                    }}
                                                >
                                                    <h5>
                                                        <b>{val.Question}</b>
                                                    </h5>
                                                    <hr
                                                        style={{
                                                            borderTop:
                                                                "1px solid #9e9e9e6b"
                                                        }}
                                                    />
                                                    <h4>{val.Note}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </>
                                );
                            }
                            return (
                                <div className={`col-md-3 col-sm-4 col-xs-12`}>
                                    <div
                                        className="card"
                                        style={{ marginBottom: 35 }}
                                    >
                                        <div className="card-imgbox">
                                            <img
                                                src={`mediafiles/${val.nphoto}`}
                                                className="img-responsive img-circle img-per"
                                                style={{ padding: 13 }}
                                            />
                                        </div>
                                        <div
                                            className="card-text"
                                            style={{
                                                padding: "2px 16px"
                                            }}
                                        >
                                            <h5>
                                                <b>{val.Question}</b>
                                            </h5>
                                            <hr
                                                style={{
                                                    borderTop:
                                                        "1px solid #9e9e9e6b"
                                                }}
                                            />
                                            <h4>{val.Note}</h4>
                                        </div>
                                    </div>
                                </div>
                            );
                        }
                    })}
            </div>
        </div>
    );
};

export default Committee;
