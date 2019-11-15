import styled from 'styled-components';
import { darken } from 'polished';

export const Section = styled.section`
  max-width: 1024px;
  padding: 0;
  margin: auto;

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
    padding: 10px;

    button {
      width: 150px;
      margin: 0;
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
  width: 100%;
  margin-top: 20px;

  > th {
    text-align: center;
    padding: 10px;
  }

  > tbody {
    td {
      text-align: center;
      padding: 10px;
    }
  }
`;

export const Winner = styled.div`
  width: 100%;
  padding: 20px;
  background: #f4efd3;

  h3 {
    font-size: 18px;
    color: #da2d2d;
    text-align: center;

    span {
      font-size: 24px;
      color: #10316b;
    }
  }

  > p {
    display: block;
    text-align: center;
    margin-top: 20px;

    button {
      width: 150px;
      margin: 0;
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
