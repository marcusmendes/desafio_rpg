export function initiateTurnRequest(step, round, turnRound) {
  return {
    type: '@turn/INITIATE_REQUEST',
    payload: {
      step,
      round,
      turnRound,
    },
  };
}

export function initiateTurnSuccess(step, turnRound) {
  return {
    type: '@turn/INITIATE_SUCCESS',
    payload: {
      step,
      turnRound,
    },
  };
}
