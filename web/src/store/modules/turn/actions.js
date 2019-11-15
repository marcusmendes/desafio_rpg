export function initiateTurnRequest(step, round, turn) {
  return {
    type: '@turn/INITIATE_REQUEST',
    payload: {
      step,
      round,
      turn,
    },
  };
}

export function initiateTurnSuccess(step, turn) {
  return {
    type: '@turn/INITIATE_SUCCESS',
    payload: {
      step,
      turn,
    },
  };
}
