import { takeLatest, all, put, call } from 'redux-saga/effects';
import api from '~/services/api';

import { startSuccess } from './actions';

export function* startRound() {
  const response = yield call(api.get, 'start');

  console.tron.debug(response);

  yield put(startSuccess(response.data));
}

export default all([takeLatest('@round/START_REQUEST', startRound)]);
