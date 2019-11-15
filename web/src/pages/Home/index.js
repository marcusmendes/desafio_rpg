import React, { useState, useEffect } from 'react';
import { useDispatch, useSelector } from 'react-redux';

import { Section, Characters, TurnRound } from './styles';

import { startRequest } from '../../store/modules/round/actions';
import { initiateTurnRequest } from '../../store/modules/turn/actions';

import { isEmpty } from '~/utils';

export default function Home() {
  const dispatch = useDispatch();

  const [turns, setTurns] = useState([]);

  const round = useSelector(state => {
    return state.round;
  });

  const turn = useSelector(state => {
    return state.turn;
  });

  useEffect(() => {
    if (!isEmpty(turn.turnRound)) {
      setTurns([turn.turnRound]);
    }
  }, [turn.turnRound]);

  function handleStartRound() {
    dispatch(startRequest());
  }

  function handleTurn(roundData, turnData) {
    dispatch(initiateTurnRequest(turnData.step, roundData, turnData.turnRound));
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
          {!turn.hasTurnRound ? (
            <p>
              <button type="button" onClick={() => handleTurn(round, turn)}>
                Iniciar Turno
              </button>
            </p>
          ) : (
            <>
              <TurnRound>
                <thead>
                  <tr>
                    <th>Atacante</th>
                    <th>Qtd. Vida</th>
                    <th>Defensor</th>
                    <th>Qtd. Vida</th>
                    <th>Dano Sofrido</th>
                  </tr>
                </thead>
                <tbody>
                  {console.tron.debug(turns)}
                  {turns.map(turnRound => (
                    <tr key={turnRound.round.id}>
                      <td>{turnRound.characterStriker.name}</td>
                      <td>{turnRound.characterStriker.amountLife}</td>
                      <td>{turnRound.characterDefender.name}</td>
                      <td>{turnRound.characterDefender.amountLife}</td>
                      <td>{turnRound.damage || '-'}</td>
                    </tr>
                  ))}
                </tbody>
              </TurnRound>
              <p>
                <button type="button" onClick={() => handleTurn(round, turn)}>
                  Próximo Turno
                </button>
              </p>
            </>
          )}
        </>
      )}
    </Section>
  );
}
