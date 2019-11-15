import storage from 'redux-persist/lib/storage';
import { persistReducer } from 'redux-persist';

export default reducers => {
  const persistedReducer = persistReducer(
    {
      key: 'rpg',
      storage,
      whitelist: ['round', 'turn', 'winner'],
    },
    reducers
  );

  return persistedReducer;
};
