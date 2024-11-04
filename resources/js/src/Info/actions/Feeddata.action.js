import { FeeddataConstants } from '../constants';
import { feeddataService } from '../services';

function feedData(url) {
    return (dispatch) => {
        dispatch(fetching(true));

        feeddataService.feedData(url)
            .then(
                data => dispatch(fetchSuccess(data)),
                err => dispatch(fetchFailure(true))
            );
    }
}

function feedDataPost(url, body = {}) {
    return (dispatch) => {
        dispatch(fetching(true));

        feeddataService.feedDataPost(url, body)
            .then(
                data => dispatch(fetchSuccess(data)),
                err => dispatch(fetchFailure(err))
            )
    }
}


const fetching = (bool) => {
    return {
        type: FeeddataConstants.FEED_REQUEST,
        fetching: bool
    }
};

const fetchSuccess = (data) => {
    return {
        type: FeeddataConstants.FEED_SUCCESS,
        payload: data
    }
}

const fetchFailure = (bool) => {
    return {
        type: FeeddataConstants.FEED_FAILURE
    }
}

export const feeddataActions = {
    feedData,
    feedDataPost
    // feedHomepage,
}
