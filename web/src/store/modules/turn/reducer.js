const INITIAL_STATE = {
  step: null,
  round: {},
  turnRound: {},
  hasTurnRound: false,
};

export default function turnRound(state = INITIAL_STATE, action) {
  switch (action.type) {
    case '@turn/INITIATE_REQUEST':
      return {
        ...state,
        step: action.payload.step,
        round: action.payload.round,
        turnRound: action.payload.turnRound,
      };
    case '@turn/INITIATE_SUCCESS':
      return {
        ...state,
        hasTurnRound: true,
        step: action.payload.step,
        turnRound: action.payload.turnRound,
      };
    default:
      return state;
  }
}
