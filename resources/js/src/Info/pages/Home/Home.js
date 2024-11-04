import React, { useEffect, Fragment, useState } from "react";
import { Link, useHistory } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
import useForm from "react-hook-form";
// import Slider from "react-slick";
import { Accordion, Button } from "react-bootstrap";
import { useAccordionToggle } from "react-bootstrap/AccordionToggle";

// import "particles.js";

import { feeddataActions } from "../../actions";
import Slide from "./Slide";
import Block1 from "./Block1";
import Block2 from "./Block2";
import Block3 from "./Block3";
import Block4 from "./Block4";
import Block5 from "./Block5";
import RightBar from "./RightBar";
import HomeSkeleton from "../Skeleton/Home";
import ReportCoop from "./ReportCoop";

const Home = () => {
    const dispatch = useDispatch();
    const feedData = useSelector(state => state.feedData);
    let history = useHistory();
    // const { register, handleSubmit } = useForm();

    const [loading, setLoading] = useState(true);

    useEffect(() => {
        async function feedData() {
            await dispatch(feeddataActions.feedData(`/api/info/home`));
        }

        feedData();
    }, []);

    useEffect(() => {
        if (feedData.fetchSuccess) {
            setLoading(false);
        }
        return async function cleanup() {
            await setLoading(true);
        };
    }, [feedData.fetchSuccess]);

    const onSubmit = async (data, e) => {
        e.preventDefault();

        await setTimeout(
            history.push("/list/search", { search: data.search }),
            100
        );

        e.target.reset();
    };

    return (
        <Fragment>
            {loading && <HomeSkeleton />}
            {!loading && (
                <>
                    <div className="content-inner container">
                        <Slide slide={feedData.data.slider_banner} />
                        <div className="row">
                            <div className="col-md-9">
                                <ReportCoop data={feedData.data && feedData.data}/>
                                <Block1
                                    data={feedData.data && feedData.data}
                                    slide={
                                        feedData.datafeed &&
                                        Data.data.slider_banner
                                    }
                                />
                                <Block2 data={feedData.data && feedData.data} />
                                {/* <Block3 data={feedData.data && feedData.data} /> */}
                                {/*===== ปฏิทิน ======*/}
                                <Block4 data={feedData.data.calendar && feedData.data.calendar} />
                                <Block5 data={feedData.data && feedData.data} />
                            </div>
                            <RightBar data={feedData.data && feedData.data} feedData={feedData && feedData}/>
                        </div>
                    </div>
                </>
            )}
        </Fragment>
    );
};

export default Home;
