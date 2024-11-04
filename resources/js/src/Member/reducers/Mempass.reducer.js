import {
    userConstants
} from '../constants';

const initialState = {
    loading: false,
    changed: false,
    error: false,
    data: []
};

export function Mempass(state = initialState, action) {
    switch (action.type) {
        case userConstants.PASS_REQUEST:
            return {
                loading: true,
                    changed: false
            };
        case userConstants.PASS_SUCCESS:
            return {
                loading: false,
                    changed: true,
                    error: false,
                    data: action.data
            };
        case userConstants.PASS_FAILURE:
            return {
                loading: false,
                    changed: false,
                    error: true,
                    data: action.data
            };
        default:
            return state
    }
}
