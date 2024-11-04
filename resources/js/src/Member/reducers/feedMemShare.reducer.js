import {
    MemShareConstant
} from '../constants';

const initialState = {
    fetching: false,
    fetchSuccess: false,
    fetchFailure: false,
    data: [],
};

export function feedMemShare(state = initialState, action) {
    const {
        type,
        payload
    } = action;

    switch (type) {
        case MemShareConstant.FEED_REQUEST:
            return {
                fetching: true,
                    fetchSuccess: false,
                    fetchFailure: false,
            };
        case MemShareConstant.FEED_SUCCESS:
            return {
                fetchSuccess: true,
                    fetching: false,
                    fetchFailure: false,
                    data: payload
            };
        case MemShareConstant.FEED_FAILURE:
            return {
                fetching: false,
                    fetchSuccess: false,
                    fetchFailure: true,
            };
        default:
            return state
    }
}
