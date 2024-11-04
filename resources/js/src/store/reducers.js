import { combineReducers } from "redux";

import { memberReducers } from "../Member/reducers";
// import { infoReducers } from "../Info/reducers";

export default combineReducers({ ...memberReducers });
