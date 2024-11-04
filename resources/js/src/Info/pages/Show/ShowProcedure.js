import React, { useEffect } from "react";
import { useDispatch, useSelector } from "react-redux";
import Block3 from "../Home/Block3";
import { feeddataActions } from "../../actions";

export default function ShowProcedure() {
    const dispatch = useDispatch();
    const feedData = useSelector(state => state.feedData);
    useEffect(() => {
        async function feedData() {
            await dispatch(feeddataActions.feedData(`/api/info/home`));
        }

        feedData();
    }, []);
    return (
        <div className="container">
            <Block3 data={feedData.data && feedData.data} />
        </div>
    );
}
