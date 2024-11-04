import {
    MemLoanConstant
} from '../constants';

const initialState = {
    fetching: false,
    fetchSuccess: false,
    fetchFailure: false,
    data: [],
};

export function feedMemLoan(state = initialState, action) {
    const {
        type,
        payload
    } = action;

    switch (type) {
        case MemLoanConstant.FEED_REQUEST:
            return {
                fetching: true,
                    fetchSuccess: false,
                    fetchFailure: false,
            };
        case MemLoanConstant.FEED_SUCCESS:
            return {
                fetchSuccess: true,
                    fetching: false,
                    fetchFailure: false,
                    data: payload
            };
        case MemLoanConstant.FEED_FAILURE:
            return {
                fetching: false,
                    fetchSuccess: false,
                    fetchFailure: true,
            };
        default:
            return state
    }
}
