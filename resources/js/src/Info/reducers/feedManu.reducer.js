import {
    FeedmanuConstants
} from '../constants';

const initialState = {
    fetching: false,
    fetchSuccess: false,
    fetchFailure: false,
    data: [],
};

export function feedManu(state = initialState, action) {
    const { type, payload } = action;

    switch (type) {
        case FeedmanuConstants.FEED_REQUEST:
            return {
                fetching: action.fetching,
                fetchSuccess: false,
                fetchFailure: false,
                data: []
            };
        case FeedmanuConstants.FEED_SUCCESS:
            return {
                fetchSuccess: true,
                fetching: false,
                fetchFailure: false,
                data: payload
            };
        case FeedmanuConstants.FEED_FAILURE:
            return {
                fetching: false,
                fetchSuccess: false,
                fetchFailure: true,
                data: []
            };
        default:
            return state
    }
}
