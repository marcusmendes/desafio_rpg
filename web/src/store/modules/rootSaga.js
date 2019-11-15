import { all } from 'redux-saga/effects';

import round from './round/sagas';
import turn from './turn/sagas';
import winner from './winner/sagas';

export default function* rootSaga() {
  return yield all([round, turn, winner]);
}
