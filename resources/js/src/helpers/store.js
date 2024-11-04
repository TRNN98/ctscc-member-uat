import { createStore, applyMiddleware } from 'redux';
import thunkMiddleware from 'redux-thunk';
import { composeWithDevTools } from "redux-devtools-extension";
import { combineReducers } from 'redux';
import { memberReducers } from '../Member/reducers';
import { infoReducers } from '../Info/reducers';

// import reducers from '../reducers';

const reducers = combineReducers({
    ...infoReducers,
    ...memberReducers,
});

const createStoreWithMiddleware = applyMiddleware(thunkMiddleware);

export const store = createStore(reducers ,composeWithDevTools(createStoreWithMiddleware));