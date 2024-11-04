import React, { useEffect, Fragment } from "react";
import { Link, useParams, useLocation } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";

// import Pagination from "rc-pagination";
// import { createMarkup } from '../../../helpers';
import { feeddataActions } from "../../actions";

import ListContent from "./ListContent";
import ListPhoto from "./ListPhoto";
import ListCalender from "./ListCalender";
import ListPesonnel from "./ListPersonnel";
// import ListDownload from "./ListDownload";

function List() {
    const dispatch = useDispatch();
    const feedData = useSelector(state => state.feedData);

    let { topicId } = useParams();
    let { state } = useLocation();

    useEffect(() => {
        if (topicId != "" && topicId != "search") {
            async function feedData() {
                await dispatch(
                    feeddataActions.feedData(`/api/info/list/${topicId}`)
                );
            }

            feedData();
        }
        if (topicId != "" && topicId == "search") {
            async function feedData() {
                await dispatch(
                    feeddataActions.feedDataPost("/api/info/list/search", {
                        search: state.search,
                        type: "search"
                    })
                );
            }

            feedData();
        }
    }, [topicId, state]);

    const OnchangePagination = async (currentPage, pageSize) => {
        if (topicId == "search") {
            await dispatch(
                feeddataActions.feedDataPost("/api/info/list/search", {
                    search: state.search,
                    type: "search",
                    page: currentPage
                })
            );
        } else {
            await dispatch(
                feeddataActions.feedData(
                    `/api/info/list/${topicId}?page=${currentPage}`
                )
            );
        }
    };

    if (feedData.fetchSuccess && feedData.data) {
        // console.log('oi',feedData.data.list_data.data[0].Category);
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
                                    <li>
                                        <Link
                                            to={`/list/${topicId}`}
                                            className="active"
                                        >
                                            {feedData.fetchSuccess &&
                                                feedData.data.types &&
                                                feedData.data.types}
                                        </Link>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                {feedData.data.content_type == "photo" ? (
                    <ListPhoto
                        data={feedData.data}
                        pagination={OnchangePagination}
                    />
                ) : feedData.data.content_type == "calender" ? (
                    <ListCalender data={feedData.data} />
                ) : feedData.data.content_type == "personnel" ? (
                    <ListPesonnel data={feedData.data} />
                ) 
                // : topicId == "download" ? (
                //     <ListDownload data={feedData.data} />
                // ) 
                : (
                    <ListContent
                        data={feedData.data}
                        pagination={OnchangePagination}
                    />
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

export default List;
