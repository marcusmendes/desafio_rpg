import { combineReducers } from 'redux';

import round from './round/reducer';
import turn from './turn/reducer';
import winner from './winner/reducer';

export default combineReducers({ round, turn, winner });
