import {
    MemCremConstant
} from '../constants';

const initialState = {
    fetching: false,
    fetchSuccess: false,
    fetchFailure: false,
    data: [],
};

export function feedMemCrem(state = initialState, action) {
    const {
        type,
        payload
    } = action;

    switch (type) {
        case MemCremConstant.FEED_REQUEST:
            return {
                fetching: true,
                    fetchSuccess: false,
                    fetchFailure: false,
            };
        case MemCremConstant.FEED_SUCCESS:
            return {
                fetchSuccess: true,
                    fetching: false,
                    fetchFailure: false,
                    data: payload
            };
        case MemCremConstant.FEED_FAILURE:
            return {
                fetching: false,
                    fetchSuccess: false,
                    fetchFailure: true,
            };
        default:
            return state
    }
}
