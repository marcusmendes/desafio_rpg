import { takeLatest, all, put, call } from 'redux-saga/effects';
import api from '~/services/api';

import { isEmpty } from '~/utils';

import { initiateTurnSuccess } from './actions';
import { startSuccess } from '../round/actions';

export function* initiateTurn({ payload }) {
  const { step, round, turn } = payload;

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
      striker_uniqueId: !isEmpty(turn) ? turn.strikerUniqueId : null,
      defender_uniqueId: !isEmpty(turn) ? turn.defenderUniqueId : null,
    },
  };

  const response = yield call(api.post, 'turn', requestBody);

  const turnData = response.data;
  const lastTurn = turnData.turnRounds[turnData.turnRounds.length - 1];
  const roundData = round;

  if (
    roundData.characters.human.uniqueId === lastTurn.characterStriker.uniqueId
  ) {
    roundData.characters.human.amountLife = lastTurn.amountLifeStriker;
    roundData.characters.orc.amountLife = lastTurn.amountLifeDefender;
  } else {
    roundData.characters.orc = lastTurn.amountLifeStriker;
    roundData.characters.human = lastTurn.amountLifeDefender;
  }

  yield put(startSuccess(roundData));
  yield put(initiateTurnSuccess(turnData.nextStep, turnData));
}

export default all([takeLatest('@turn/INITIATE_REQUEST', initiateTurn)]);
