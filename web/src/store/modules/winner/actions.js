export function winnerRequest(characterWinner) {
  return {
    type: '@winner/WINNER_REQUEST',
    payload: {
      characterWinner,
    },
  };
}

export function winnerSuccess(characterWinner) {
  return {
    type: '@winner/WINNER_SUCCESS',
    payload: {
      characterWinner,
    },
  };
}
