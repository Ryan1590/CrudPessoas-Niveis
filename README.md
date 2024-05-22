Funcionalidades Principais:

Listagem de Registros: Para cada entidade (Pessoas e Níveis), há uma página dedicada que exibe uma tabela com os itens cadastrados. A listagem inclui opções para adicionar, editar e remover registros.

Cadastro / Edição: O cadastro e a edição de registros podem ser realizados por meio de uma modal. Os campos são validados para garantir que informações válidas sejam inseridas.

Exclusão: Antes de excluir um registro, o sistema solicita uma confirmação para evitar exclusões acidentais. É impedida a remoção de um nível que possua desenvolvedores associados a ele.

Busca: Adicionada funcionalidade de busca utilizando query para filtrar os resultados na listagem de níveis e pessoas.

Ordenação de Tabelas: A ordenação das tabelas é possível clicando na coluna nome da tabela, facilitando a visualização dos registros.

Função em JS para calcular a idade do Desenvolvedor mediante a data de nascimento do mesmo.

Caso não houver nenhum nivel cadastrado e nenhum Desenvolvedor, e o usuario clicar em Adicionar novo Dev, será exibido um alert com a seguinte mensagem: Por favor, certifique-se de cadastrar um nível antes de cadastrar um desenvolvedor!

Não é possivel cadastrar um Nivel e Desenvolvedor com o mesmo nome, validação feita para cadastrado e edição. exemplo: Se o nivel:Pleno já existe, não é possivel cadastrar o nivel:Pleno novamente.

Feedback ao Usuário: Mensagens de sucesso e/ou erros são exibidas para informar o usuário sobre o resultado das operações.

Tecnologias Utilizadas: 
PHP: Linguagem de programação utilizada para o desenvolvimento do backend. 
HTML/CSS/JavaScript: Utilizados para consumir as rotas e  desenvolver a interface do usuário. 
MySQL: Banco de dados utilizado para armazenar os dados das entidades Pessoas e Níveis. 
Bootstrap: Responsividade e estilo.
