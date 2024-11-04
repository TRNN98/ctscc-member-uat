import { userConstants } from "../constants";

const initialState = {
    fetching: false,
    fetchSuccess: false,
    fetchFailure: false,
    data: []
};

export function MemForget(state = initialState, action) {
    const { type, payload } = action;

    switch (type) {
        case userConstants.FORGET_REQUEST:
            return {
                fetching: true,
                fetchSuccess: false,
                fetchFailure: false
            };
        case userConstants.FORGET_SUCCESS:
            return {
                fetchSuccess: true,
                fetching: false,
                fetchFailure: false,
                data: payload
            };
        case userConstants.FORGET_FAILURE:
            return {
                fetching: false,
                fetchSuccess: false,
                fetchFailure: true
            };
        default:
            return state;
    }
}
