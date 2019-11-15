import styled from 'styled-components';

export const NavBar = styled.nav`
  max-width: 100vw;
  background: #0597f2;
  padding: 15px 10px;
  display: flex;
  align-items: center;

  img {
    max-height: 50px;
  }

  ul {
    display: flex;
    flex-direction: row;
    justify-content: flex-start;
    margin-left: 20px;

    li {
      & + li {
        margin-left: 15px;
      }

      a {
        color: #fff;
        font-size: 20px;

        &:hover {
          color: #f2e205;
        }
      }
    }
  }
`;
