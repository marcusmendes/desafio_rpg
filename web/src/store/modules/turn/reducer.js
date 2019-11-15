const INITIAL_STATE = {
  step: null,
  round: {},
  turn: {},
  hasTurnRound: false,
};

export default function turnRound(state = INITIAL_STATE, action) {
  switch (action.type) {
    case '@turn/INITIATE_REQUEST':
      return {
        ...state,
        step: action.payload.step || null,
        round: action.payload.round,
        turn: action.payload.turn,
      };
    case '@turn/INITIATE_SUCCESS':
      return {
        ...state,
        hasTurnRound: true,
        step: action.payload.turn.nextStep,
        turn: action.payload.turn,
      };
    case '@round/FINISH_ROUND':
      state = INITIAL_STATE;
      return state;
    default:
      return state;
  }
}
