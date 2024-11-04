import React from "react";
import { Link } from "react-router-dom";

export default function TabDetailPic2({
    id,
    detail,
    imageEmtry = "mediafiles/images/news1.png",
    active = false,
    category
}) {
    return (
        // <div
        //     role="tabpanel"
        //     className={`tab-pane ${active ? "active" : ""}`}
        //     id={id}
        // >
        <div className="news-group-block">
            <div className="list">
                <div className="row news-2-list">
                    {detail &&
                        detail.map((val, i) => (
                            <div className="col-md-12">
                                <div className="row">
                                    <div className="item2">
                                        <div className="col-md-4">
                                            <Link to={`/show/${val.No}`}>
                                                <img
                                                    className="img-responsive s1"
                                                    style={{
                                                        margin: "auto",
                                                        width: "100%"
                                                    }}
                                                    src={
                                                        val.nphoto != ""
                                                            ? `mediafiles/${val.nphoto}`
                                                            : imageEmtry
                                                    }
                                                />
                                            </Link>
                                        </div>
                                        <div className="col-md-8">
                                            <h5
                                                className="title"
                                                style={{ lineHeight: "30px" }}
                                            >
                                                <Link
                                                    to={`/show/${val.No}`}
                                                    className="colorBlue"
                                                >
                                                    {/* {val.Question.length} */}
                                                    {val.Question &&
                                                    val.Question.length > 30
                                                        ? `${val.Question.substr(
                                                              0,
                                                              25
                                                          )} ...`
                                                        : val.Question}
                                                </Link>
                                            </h5>
                                            <h6>
                                                <Link
                                                    to={`/show/${val.No}`}
                                                    className="text-danger fb"
                                                    style={{
                                                        color: "#ff6358"
                                                    }}
                                                >
                                                    อ่านต่อ
                                                </Link>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            // <div className="col-md-6" key={i}>
                            //     <div className="item">
                            //         <div className="item-image">
                            //             {val.nphoto != "" ? (
                            //                 <Link to={`/show/${val.No}`}>
                            //                     <img
                            //                         className="img-responsive s1"
                            //                         style={{
                            //                             margin: "auto",
                            //                             width: "100%"
                            //                         }}
                            //                         src={`mediafiles/${val.nphoto}`}
                            //                     />
                            //                     {/* </a> */}
                            //                 </Link>
                            //             ) : (
                            //                 <Link to={`/show/${val.No}`}>
                            //                     <img
                            //                         className="img-responsive s1"
                            //                         style={{
                            //                             margin: "auto",
                            //                             width: "100%"
                            //                         }}
                            //                         src={imageEmtry}
                            //                     />
                            //                 </Link>
                            //             )}
                            //         </div>
                            //         <div className="item-detail">
                            //             <h5 className="title">
                            //                 <Link
                            //                     to={`/show/${val.No}`}
                            //                     className="colorBlue"
                            //                 >
                            //                     {/* {val.Question.length} */}
                            //                     {val.Question &&
                            //                     val.Question.length > 50
                            //                         ? `${val.Question.substr(
                            //                               0,
                            //                               45
                            //                           )} ...`
                            //                         : val.Question}
                            //                 </Link>
                            //             </h5>
                            //             <p className="detail"></p>
                            //         </div>
                            //     </div>
                            // </div>
                        ))}
                </div>
                <Link
                    className="news-view-all pull-right"
                    to={`/list/${category}`}
                >
                    <b>+ ดูทั้งหมด</b>
                </Link>
            </div>
        </div>
        // </div>
    );
}
