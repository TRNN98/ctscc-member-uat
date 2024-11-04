import { userConstants } from "../constants";
import { feedmemdataService } from "../services";
import { NotificationManager } from "react-notifications";
// import { history } from '../../helpers';

function feedDataGet(url) {
    return dispatch => {
        dispatch(fetching(true));

        feedmemdataService.feedDataGet(url).then(
            data => dispatch(fetchSuccess(data)),
            err => dispatch(fetchFailure(data))
        );
    };
}

function feedDataPost(url, body = {}) {
    return dispatch => {
        dispatch(fetching(true));

        return new Promise((resolve, reject) => {
            feedmemdataService.feedDataPost(url, body).then(
                data => {
                    if (data.errors) {
                        dispatch(fetchFailure(data));
                        return reject(data);
                    } else {
                        dispatch(fetchSuccess(data));
                        return resolve(data);
                    }
                },
                err => {
                    dispatch(fetchFailure(err));
                    return reject(err);
                }
            );
        });
    };
}

const fetching = bool => {
    return {
        type: userConstants.REGIS_REQUEST,
        fetching: bool
    };
};

const fetchSuccess = data => {
    if (data.rc_code == "1") {
        NotificationManager.success(data.messages, "Success", 10000);
    }

    return {
        type: userConstants.REGIS_SUCCESS,
        payload: data
    };
};

const fetchFailure = data => {
    if (data.errors) {
        let result = [];
        for (let i = 0; i < data.errors.length; i++) {
            // console.log(data.errors[i]);
            NotificationManager.error(data.errors[i], "Error", 10000);
        }
    } else {
        NotificationManager.error("ไม่สามารถเชื่อมต่อได้", "Error", 5000);
    }

    // if (data.errors) {
    //     console.log(data.errors.length);

    // }else{
    //     NotificationManager.error('ไม่สามารถเชื่อมต่อได้', 'Error', 5000);
    // }

    return {
        type: userConstants.REGIS_FAILURE
    };
};

export const MemRegisActions = {
    feedDataGet,
    feedDataPost
    // feedHomepage,
};
