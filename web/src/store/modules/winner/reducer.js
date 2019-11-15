const INITIAL_STATE = {
  hasWinner: false,
};

export default function winner(state = INITIAL_STATE, action) {
  switch (action.type) {
    case '@winner/WINNER_REQUEST':
      return {
        ...state,
        ...action.payload.characterWinner,
      };
    case '@winner/WINNER_SUCCESS':
      return {
        ...state,
        ...action.payload.characterWinner,
        hasWinner: true,
      };
    case '@round/FINISH_ROUND':
      state = INITIAL_STATE;
      return state;
    default:
      return state;
  }
}
