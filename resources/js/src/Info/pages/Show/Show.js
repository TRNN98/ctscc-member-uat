import React, { useEffect, Fragment } from "react";
import { Link } from "react-router-dom";
import { useParams } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";

import { feeddataActions } from "../../actions";

import ShowPhoto from "./ShowPhoto";
import ShowContent from "./ShowContent";

function Show() {
    const dispatch = useDispatch();
    const feedData = useSelector(state => state.feedData);
    let { topicId } = useParams();

    var CategoryNoList = ['history', 'rules','regularity'];

    useEffect(() => {
        if (topicId != "") {
            async function feedData() {
                await dispatch(
                    feeddataActions.feedData(`/api/info/show/${topicId}`)
                );
            }
            feedData();
        }
    }, [topicId]);

    if (feedData.fetchSuccess && feedData.data) {
        return (
            <Fragment>
                <div className="list-type">
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
                    <div className="container">
                        <div className="row">
                            <div className="col-md-12">
                                <div className="page-breadcrumb">
                                    <ol
                                        className="breadcrumb"
                                        style={{
                                            margin: "10px 0",
                                            padding: "8px 0",
                                            color: "#838384"
                                        }}
                                    >
                                        <li>
                                            <Link to="/home">หน้าแรก</Link>
                                        </li>
                                        {feedData.fetchSuccess &&
                                            feedData.data.show &&
                                            CategoryNoList.includes(feedData.data.show.Category) ? (
                                                ''
                                            ) : (
                                                <li>

                                                    <Link
                                                        to={`/list/${feedData.fetchSuccess &&
                                                            feedData.data.show &&
                                                            feedData.data.show.Category}`}
                                                    >
                                                        {feedData.fetchSuccess &&
                                                            feedData.data.types &&
                                                            feedData.data.types}
                                                    </Link>
                                                </li>
                                            )
                                        }
                                        <li>
                                            <Link
                                                to={`/show/${feedData.fetchSuccess &&
                                                    feedData.data.show &&
                                                    feedData.data.show.No}`}
                                                className="active"
                                            >
                                                {feedData.fetchSuccess &&
                                                    feedData.data.show &&
                                                    feedData.data.show.Question}
                                            </Link>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {feedData.data.gtype == "G" ? (
                    <ShowPhoto data={feedData.data} />
                ) : (
                        <ShowContent data={feedData.data} />
                    )}
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
}

export default Show;
