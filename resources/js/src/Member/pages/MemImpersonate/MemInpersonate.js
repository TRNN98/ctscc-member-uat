import React, { useEffect } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useHistory } from "react-router-dom";
import LoadingOverlay from "react-loading-overlay";

import { userActions } from "../../actions";
// import { history } from '../../../helpers';

function MemInpersonate() {

    const dispatch = useDispatch();
    const history = useHistory();

    useEffect(() => {
        dispatch(userActions.getImpersonate())
            .then(result => {
                console.log(result);

                history.push("/status");
            })
            .catch(err => {
                history.push("/logon");
            });
    }, []);

    return (
        <LoadingOverlay active={true} spinner text="Loading ...">
            <p style={{ width: "1024px", height: "1024px" }}></p>
        </LoadingOverlay>
    );
}

export default MemInpersonate;
