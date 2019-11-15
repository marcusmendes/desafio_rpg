import { combineReducers } from 'redux';

import round from './round/reducer';
import turn from './turn/reducer';

export default combineReducers({ round, turn });
