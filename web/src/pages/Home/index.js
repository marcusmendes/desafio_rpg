import React from 'react';
import { useDispatch, useSelector } from 'react-redux';

import { Section, Characters, TurnRound } from './styles';

import { startRequest } from '../../store/modules/round/actions';

export default function Home() {
  const dispatch = useDispatch();

  const round = useSelector(state => {
    return state.round;
  });

  function handleStartRound() {
    dispatch(startRequest());
  }

  function handleStartTurn() {}

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
          <TurnRound>
            <li>
              <p>
                Atacante: <br />
                Defensor: <br />
              </p>
              <button type="button" onClick={handleStartTurn}>
                Turno
              </button>
            </li>
          </TurnRound>
        </>
      )}
    </Section>
  );
}
