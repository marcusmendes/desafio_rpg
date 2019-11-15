const INITIAL_STATE = {
  characters: {},
  startRound: false,
};

export default function round(state = INITIAL_STATE, action) {
  switch (action.type) {
    case '@round/START_SUCCESS':
      return {
        ...state,
        ...action.payload.roundData.round,
        characters: action.payload.roundData.characters,
        startRound: true,
      };
    case '@round/FINISH_ROUND':
      state = INITIAL_STATE;
      return state;
    default:
      return state;
  }
}
