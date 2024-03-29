import React from 'react';
import { useDispatch, useSelector } from 'react-redux';
import uuid from 'uuid/v1';

import { Section, Characters, TurnRound, Winner } from './styles';

import { startRequest, finishRound } from '~/store/modules/round/actions';
import { initiateTurnRequest } from '~/store/modules/turn/actions';

export default function Home() {
  const dispatch = useDispatch();

  const round = useSelector(state => {
    return state.round;
  });

  const turn = useSelector(state => {
    return state.turn;
  });

  const winner = useSelector(state => {
    if (!turn.hasTurnRound) {
      return state.winner;
    }

    return {
      ...state.winner,
      totalTurns: turn.turn.turnRounds.length,
    };
  });

  const turnRounds = useSelector(state => {
    const { turn: turnData, hasTurnRound } = state.turn;

    if (!hasTurnRound) {
      return [];
    }

    return turnData.turnRounds.map(turnRound => ({
      ...turnRound,
      uuid: uuid(),
    }));
  });

  function handleStartRound() {
    dispatch(startRequest());
  }

  function handleNewRound() {
    dispatch(finishRound());
  }

  function handleTurn(roundData, turnData) {
    const { nextStep } = turnData.turn;

    if (nextStep !== 'TURN_FINISH') {
      dispatch(initiateTurnRequest(nextStep, roundData, turnData.turn));
    }
  }

  return (
    <Section>
      {!round.startRound ? (
        <>
          <h2>Bem Vindo ao Desafio RPG</h2>
          <p>
            <button type="button" onClick={handleStartRound}>
              Iniciar Rodada
            </button>
          </p>
        </>
      ) : (
        <>
          <h2>{round.name}</h2>
          <Characters>
            <div>
              <h4>{round.characters.human.name}</h4>
              <p>
                Vida: {round.characters.human.amountLife} <br />
                Força: {round.characters.human.amountStrength} <br />
                Agilidade: {round.characters.human.amountAgility} <br />
                Arma: {round.characters.human.weapon.name} <br />
                Ataque: {round.characters.human.weapon.amountAttack} <br />
                Defesa: {round.characters.human.weapon.amountDefense} <br />
                Dano: {round.characters.human.weapon.amountDamage}
              </p>
            </div>
            <div>
              <h4>{round.characters.orc.name}</h4>
              <p>
                Vida: {round.characters.orc.amountLife} <br />
                Força: {round.characters.orc.amountStrength} <br />
                Agilidade: {round.characters.orc.amountAgility} <br />
                Arma: {round.characters.orc.weapon.name} <br />
                Ataque: {round.characters.orc.weapon.amountAttack} <br />
                Defesa: {round.characters.orc.weapon.amountDefense} <br />
                Dano: {round.characters.orc.weapon.amountDamage}
              </p>
            </div>
          </Characters>

          <Winner>
            {winner.hasWinner ? (
              <>
                <h3>
                  <span>{winner.name}</span> é o vencendor da rodada{' '}
                  {round.roundNumber} após {winner.totalTurns} turnos.
                </h3>
                <p>
                  <button type="button" onClick={handleNewRound}>
                    Nova Rodada
                  </button>
                </p>
              </>
            ) : (
              <p>
                <button type="button" onClick={() => handleTurn(round, turn)}>
                  Jogar
                </button>
              </p>
            )}
          </Winner>

          {turn.hasTurnRound ? (
            <TurnRound>
              <thead>
                <tr>
                  <th>Atacante</th>
                  <th>Defensor</th>
                  <th>Dano Sofrido</th>
                  <th>Turno</th>
                </tr>
              </thead>
              <tbody>
                {turnRounds.map(turnRound => (
                  <tr key={turnRound.uuid}>
                    <td>{turnRound.characterStriker.name}</td>
                    <td>{turnRound.characterDefender.name}</td>
                    <td>
                      {turnRound.damage !== null ? turnRound.damage : '-'}
                    </td>
                    <td>{turnRound.step}</td>
                  </tr>
                ))}
              </tbody>
            </TurnRound>
          ) : (
            ''
          )}
        </>
      )}
    </Section>
  );
}
