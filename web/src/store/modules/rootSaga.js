import { all } from 'redux-saga/effects';

import round from './round/sagas';

export default function* rootSaga() {
  return yield all([round]);
}
