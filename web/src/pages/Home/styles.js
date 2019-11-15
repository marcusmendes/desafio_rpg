import styled from 'styled-components';
import { darken } from 'polished';

export const Section = styled.section`
  max-width: 100%;
  padding: 0;
  margin-bottom: 15px;

  > h2 {
    font-size: 26px;
    font-family: 'Roboto', sans-serif;
    color: #333;
    margin-bottom: 10px;
    text-align: center;
  }

  > p {
    display: block;
    text-align: center;

    button {
      width: 150px;
      margin: 5px 0 0;
      height: 44px;
      background: #3b9eff;
      font-weight: bold;
      color: #fff;
      border: 0;
      border-radius: 4px;
      font-size: 16px;
      transition: background 0.2s;

      &:hover {
        background: ${darken(0.03, '#3b9eff')};
      }
    }
  }
`;

export const Characters = styled.div`
  width: 100%;
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  margin-top: 30px;

  > div {
    text-align: center;
    padding: 10px 0;
    > h4 {
      margin-bottom: 10px;
      font-size: 18px;
      color: #000;
    }

    > p {
      line-height: 20px;
      font-size: 14px;
    }
  }
`;

export const TurnRound = styled.table`
  margin-top: 30px;
  width: 100%;
`;
