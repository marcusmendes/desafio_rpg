
#### Requisitos

- Ubuntu 18.04.3 LTS
- Docker e docker-compose
    - Caso não tenha o Docker instaladao no sistema, baixe esse [script](https://raw.githubusercontent.com/marcusmendes/linux_scripts/master/install_docker.sh)
- PHP 7.2
    - Caso não tenha o PHP instalado, baixe esse [script](https://raw.githubusercontent.com/marcusmendes/linux_scripts/master/install_php7.2.sh)
- PostgreSQL
- Composer
    - Veja como instalar [aqui](https://getcomposer.org/download/)

### Como inicializar o projeto

Todas as dependências necessarias para executar os projetos já estão devidamente instaladas nos containers.

Para inicializar o backend e frontend, execute os seguites comandos:

Caso queira ver os logs de execução:
> docker-compose up   

Caso queira rodar em segundo plano:
> docker-compose up -d
