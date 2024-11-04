import { MemCollConstant } from '../constants';
import { feedmemdataService } from '../services';
import { NotificationManager } from 'react-notifications';

function feedDataGet(url) {
    return (dispatch) => {
        dispatch(fetching(true));

        feedmemdataService.feedDataGet(url)
            .then(
                data => dispatch(fetchSuccess(data)),
                err => dispatch(fetchFailure(true))
            );
    }
}

function feedDataPost(url, body = {}) {
    return (dispatch) => {
        dispatch(fetching(true));

        feedmemdataService.feedDataPost(url, body)
            .then(
                data => dispatch(fetchSuccess(data)),
                err => dispatch(fetchFailure(true))
            );
    }
}


const fetching = (bool) => {
    return {
        type: MemCollConstant.FEED_REQUEST,
        fetching: bool
    }
};

const fetchSuccess = (data) => {
    return {
        type: MemCollConstant.FEED_SUCCESS,
        payload: data
    }
}

const fetchFailure = (bool) => {
    NotificationManager.error('ไม่สามารถเชื่อมต่อได้', 'Error', 5000);
    return {
        type: MemCollConstant.FEED_FAILURE
    }
}

export const feedMemCollActions = {
    feedDataGet,
    feedDataPost
}
