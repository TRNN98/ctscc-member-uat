import React, { Fragment, useEffect } from "react";
import { Link, useParams, useLocation } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
import { feeddataActions } from "../../actions";
import { convert_to_Thaidatetime } from "../../../helpers";

const ListDownload = () => {
    const dispatch = useDispatch();
    const feedData = useSelector(state => state.feedData);
    let { state } = useLocation();

    // let { topicId } = useParams();
    useEffect(() => {
        async function feedData() {
            await dispatch(feeddataActions.feedData(`/api/info/download`));
        }

        feedData();
    }, [state]);

    if (feedData.fetchSuccess && feedData.data) {
        return (
            <Fragment>
                <div
                    className="list-type"
                    style={{ backgroundColor: "#f9f9f9" }}
                >
                    <div className="container">
                        <div className="row">
                            <div className="col-md-12">
                                <h2 className="title">
                                    {feedData.fetchSuccess &&
                                        feedData.data.types &&
                                        feedData.data.types}
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="container">
                    <div className="row">
                        <div className="col-md-12">
                            <div className="page-breadcrumb">
                                <ol
                                    className="breadcrumb"
                                    style={{
                                        margin: "10px 0",
                                        backgroundColor: "#FFF",
                                        padding: "8px 0",
                                        color: "#838384"
                                    }}
                                >
                                    <li>
                                        <Link to="/home">หน้าแรก</Link>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="content-inner container">
                    <div className="row">
                        <div className="col-md-8">
                            <div className="news-list">
                                {feedData.data.list_data &&
                                    feedData.data.list_data.data.map(
                                        (val, i) => (
                                            <div
                                                className="col-sm-12 group-detail download-list"
                                                key={i}
                                            >
                                                <div className="auther">
                                                    โดย {val.Name}
                                                    &nbsp;
                                                    <i className="fa fa-clock-o" />
                                                    &nbsp;{val.Date}
                                                </div>
                                                <h2 className="title">
                                                    <a
                                                        href={`/mediafiles/${val.ndata}`}
                                                        style={{
                                                            color: "#337ab7"
                                                        }}
                                                    >
                                                        {val.Question}
                                                    </a>
                                                </h2>
                                                <div className="detail">
                                                    <p></p>
                                                </div>
                                                <hr />
                                            </div>
                                        )
                                    )}
                            </div>
                        </div>
                        <div className="col-md-4">
                            <div className="wdgt style2">
                                <h2 itemProp="headline">ข่าวล่าสุด</h2>
                                <div className="mini-pst-wrp">
                                    {feedData.data.news_last &&
                                        feedData.data.news_last.map((val, i) => (
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
                                                            src="/mediafiles/images/news1.png"
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
                                                            {val.Question
                                                                .length > 25
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
            </Fragment>
        );
    }
    return (
        <div className="container">
            <div className="row">
                <div className="col-md-12">
                    <center>
                        <h3>Loading ...</h3>
                    </center>
                </div>
            </div>
        </div>
    );
};

export default ListDownload;
