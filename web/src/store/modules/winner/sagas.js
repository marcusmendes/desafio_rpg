import { takeLatest, all, put } from 'redux-saga/effects';

import { winnerSuccess } from './actions';

export function* winnerRound({ payload }) {
  const { characterWinner } = payload;

  console.tron.error(payload);

  yield put(winnerSuccess(characterWinner));
}

export default all([takeLatest('@winner/WINNER_REQUEST', winnerRound)]);
