import React, { useEffect } from "react";
import { createMarkup } from "../../../helpers/functions";
import ShowFileDowload from "./ShowFileDowload";

function ShowPhoto({ data }) {
    useEffect(() => {
        $(".popup").magnificPopup({
            type: "image",
            gallery: {
                enabled: true
            }
        });
    }, [data]);

    return (
        <div className="content-inner container">
            <div className="row">
                <div className="col-md-12">
                    <h2 className="album-title">
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
                        className="album-header-detail"
                        dangerouslySetInnerHTML={createMarkup(
                            data.show && data.show.Note
                        )}
                    ></div>
                    <div className="row">
                        <div className="col-md-12">
                            <div className="album-picture-item">
                                {data.pic_activity &&
                                    data.pic_activity.map((val, i) => (
                                        <div className="item" key={i}>
                                            <div style={{ padding: 10 }}>
                                                <a
                                                    href={`mediafiles/pic_activity/${val.path_img}`}
                                                    className="popup"
                                                >
                                                    <img
                                                        className="img-responsive img-thumbnail"
                                                        src={`mediafiles/pic_activity/${val.path_img}`}
                                                        alt={val.path_img}
                                                    />
                                                </a>
                                            </div>
                                        </div>
                                    ))}
                                <div style={{ clear: "both" }} />
                            </div>
                        </div>
                    </div>
                    <div className="news-footer">
                        <div className="row">
                            <div className="col-md-12">
                                {data.show && data.show.ndata && (
                                    <ShowFileDowload data={data.show.ndata} />
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
            </div>
        </div>
    );
}

export default ShowPhoto;
