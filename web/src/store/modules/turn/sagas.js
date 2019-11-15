import { takeLatest, all, put, call } from 'redux-saga/effects';
import api from '~/services/api';

import { isEmpty } from '~/utils';

import { initiateTurnSuccess } from './actions';

export function* initiateTurn({ payload }) {
  console.tron.debug(payload);
  const { step, round, turnRound } = payload;

  const requestBody = {
    round: {
      idRound: round.id,
      number: round.roundNumber,
      characters: {
        human: {
          uniqueId: round.characters.human.uniqueId,
        },
        orc: {
          uniqueId: round.characters.orc.uniqueId,
        },
      },
    },
    turn: {
      step: step || 'INIATIVE',
      striker_uniqueId: !isEmpty(turnRound)
        ? turnRound.characterStriker.uniqueId
        : null,
      defender_uniqueId: !isEmpty(turnRound)
        ? turnRound.characterDefender.uniqueId
        : null,
    },
  };

  const response = yield call(api.post, 'turn', requestBody);

  const { step: nextStep, turnRound: turnRoundData } = response.data;

  yield put(initiateTurnSuccess(nextStep, turnRoundData));
}

export default all([takeLatest('@turn/INITIATE_REQUEST', initiateTurn)]);
