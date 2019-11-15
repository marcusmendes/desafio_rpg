export function startRequest() {
  return {
    type: '@round/START_REQUEST',
  };
}

export function startSuccess(roundData) {
  return {
    type: '@round/START_SUCCESS',
    payload: {
      roundData,
    },
  };
}

export function finishRound() {
  return {
    type: '@round/FINISH_ROUND',
  };
}
