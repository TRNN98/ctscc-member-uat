import {
    FeeddataConstants
} from '../constants';

const initialState = {
    fetching: false,
    fetchSuccess: false,
    fetchFailure: false,
    data: [],
};

export function feedData(state = initialState, action) {
    const { type, payload } = action;

    switch (type) {
        case FeeddataConstants.FEED_REQUEST:
            return {
                fetching: action.fetching,
                fetchSuccess: false,
                fetchFailure: false,
                data: []
            };
        case FeeddataConstants.FEED_SUCCESS:
            return {
                fetchSuccess: true,
                fetching: false,
                fetchFailure: false,
                data: payload
            };
        case FeeddataConstants.FEED_FAILURE:
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
