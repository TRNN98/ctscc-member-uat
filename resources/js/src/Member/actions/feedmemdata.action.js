import { FeedMemConstants } from '../constants';
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

function fileUpload(body = {}) {
    return new Promise((resolve, reject) => {
        const datasend = {
            'image':body.image,
            'name':body.name,
            'croppedArea':body.croppedArea,
            'croppedAreaPixels':body.croppedAreaPixels,
        }
        feedmemdataService
            .fileUploadPost(`/api/member/wwwupload`, datasend)
            .then(
                data => {
                    resolve(data);
                },
                err => {
                    reject(err);
                }
            );
    });
}

const fetching = (bool) => {
    return {
        type: FeedMemConstants.FEED_REQUEST,
        fetching: bool
    }
};

const fetchSuccess = (data) => {
    return {
        type: FeedMemConstants.FEED_SUCCESS,
        payload: data
    }
}

const fetchFailure = (bool) => {
    NotificationManager.error('ไม่สามารถเชื่อมต่อได้', 'Error', 5000);
    return {
        type: FeedMemConstants.FEED_FAILURE
    }
}

export const feedmemdataActions = {
    feedDataGet,
    feedDataPost,
    fileUpload
    // feedHomepage,
}
