import {
    MemDivConstant
} from '../constants';

const initialState = {
    fetching: false,
    fetchSuccess: false,
    fetchFailure: false,
    data: [],
};

export function feedMemDiv(state = initialState, action) {
    const {
        type,
        payload
    } = action;

    switch (type) {
        case MemDivConstant.FEED_REQUEST:
            return {
                fetching: true,
                    fetchSuccess: false,
                    fetchFailure: false,
            };
        case MemDivConstant.FEED_SUCCESS:
            return {
                fetchSuccess: true,
                    fetching: false,
                    fetchFailure: false,
                    data: payload
            };
        case MemDivConstant.FEED_FAILURE:
            return {
                fetching: false,
                    fetchSuccess: false,
                    fetchFailure: true,
            };
        default:
            return state
    }
}
