import {
    MemLoanStatementConstant
} from '../constants';

const initialState = {
    fetching: false,
    fetchSuccess: false,
    fetchFailure: false,
    data: [],
};

export function feedMemLoanStatement(state = initialState, action) {
    const {
        type,
        payload
    } = action;

    switch (type) {
        case MemLoanStatementConstant.FEED_REQUEST:
            return {
                fetching: true,
                    fetchSuccess: false,
                    fetchFailure: false,
            };
        case MemLoanStatementConstant.FEED_SUCCESS:
            return {
                fetchSuccess: true,
                    fetching: false,
                    fetchFailure: false,
                    data: payload
            };
        case MemLoanStatementConstant.FEED_FAILURE:
            return {
                fetching: false,
                    fetchSuccess: false,
                    fetchFailure: true,
            };
        default:
            return state
    }
}
