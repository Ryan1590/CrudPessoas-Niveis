document.addEventListener("DOMContentLoaded", () => {
  const mainContent = document.getElementById("main-content");
  window.carregarPagina = () => {
    const hash = window.location.hash.substr(1); // Remove o '#'
    switch (hash) {
      case "niveis":
        carregarNiveis();
        break;
      case "desenvolvedores":
        carregarDesenvolvedores();
        break;
      default:
        carregarNiveis();
        break;
    }
  };

  window.carregarNiveis = async (niveis = null) => {
    let dados = niveis;
    if (!niveis) {
      let req = await ry.ajax("GET", null, "api/niveis");
      if (req.error) {
        Swal.fire({
          title: "Atenção!",
          text: req.result,
          icon: "warning",
        });
      }
      dados = req.result;
    }

    let html = `

            <div class="container mt-4">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" class="form-control" id="campoBusca" placeholder="Digite o termo de busca">
                            <button class="btn btn-primary" type="button" onclick="buscarNiveis()">Buscar</button>
                        </div>
                    </div>
                </div>
                <div id="resultadosBusca"></div>
            </div>

            <div class="container mt-4">
                <button type="button" class="btn btn-primary"  onclick="ShowInsertNivel();">
                    Inserir Novo Nível
                </button>
            </div>
            
    
            <div class="container mt-2">
                <div class="shadow p-3 mb-5 bg-white rounded">
                    <table class="table table-striped table-hover table-bordered" id="tabelaNiveis">
                        <h2>Níveis</h2>
                        <thead class="table-white">
                            <tr>
                                <th>ID</th>
                                <th class="ordenado-asc" onclick="ordenarNiveis()" style="cursor: pointer;">Nome ⭡⭣ </th>
                                <th>Ações</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
        `;

    if (Array.isArray(dados) && dados.length > 0) {
      dados.forEach((el) => {
        html += `
                    <tr>
                        <td>${el.id}</td>
                        <td>${el.nivel}</td>
                        <td>
                            <button class="btn btn-warning btn-editar" onclick="ShowEditarNivel(${el.id},'${el.nivel}');" >
                                Editar  
                            </button>
                        </td>
                        <td>
                        <button id="btn-excluir" class="btn btn-danger btn-excluir" onclick="deletarNivel(${el.id});">
                            Excluir 
                        </button>
                        </td>
                    </tr>
                `;
      });
    }

    html += `
                        </tbody>
                    </table>
                </div>
            </div>
        `;

    mainContent.innerHTML = html;
  };

  window.carregarDesenvolvedores = async (dev = null) => {
    let dados = dev;
    if (!dev) {
      let req = await ry.ajax("GET", null, "api/desenvolvedores");
      if (req.error) {
        Swal.fire({
          title: "Atenção!",
          text: req.result,
          icon: "warning",
        });
      }
      dados = req.result;
    }

    let html = `

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control" id="campoBuscar" placeholder="Digite o termo de busca">
                    <button class="btn btn-primary" type="button" onclick="buscarDevs()">Buscar</button>
                </div>
            </div>
        </div>
        <div id="resultadoBusca"></div>
    </div>

    <div class="container mt-4">
        <button type="button" class="btn btn-primary"  onclick="ShowInsertDev();">
            Inserir Novo Dev
        </button>
    </div>
    <div class="container mt-2">
        <div class="shadow p-3 mb-5 bg-white rounded">
            <table class="table table-striped table-hover table-bordered" id="tabelaDev">
                <h2>Devs</h2>
                <thead class="table-white">
                    <tr>
                        <th>ID</th>
                        <th class="ordenado-asc" onclick="ordenarNome()" style="cursor: pointer;">Nome ⭡⭣ </th>
                        <th>Sexo</th>
                        <th>Data de Nascimento</th>
                        <th>Idade</th>
                        <th>Hobby</th>
                        <th>Nivel</th>
                        <th>Ações</th>
                    </tr>
            </thead>
        <tbody>
    `;

    if (Array.isArray(dados) && dados.length > 0) {
      dados.forEach((dev) => {
        let dataformatada = ry.formataDataBR(dev.data_nascimento);
        html += `
            <tr>
                <td>${dev.id}</td>
                <td>${dev.nome}</td>
                <td>${dev.sexo}</td>
                <td>${dataformatada}</td> 
                <td>${dev.idade}</td>
                <td>${dev.hobby}</td>
                <td>${dev.nivel.nivel}</td>

                <td>
                    <button class="btn btn-warning btn-editar" onclick="ShowEditarDev(${dev.id},'${dev.nivel}');" >
                        Editar
                    </button>
                    <button id="btn-excluir" class="btn btn-danger btn-excluir" onclick="deletarDev(${dev.id});">
                         Excluir 
                    </button>
                </td>
            </tr>
            `;
      });
    }

    html += `
                        </tbody>
                    </table>
                </div>
            </div>
        `;

    mainContent.innerHTML = html;
  };

  window.addEventListener("hashchange", carregarPagina);

  window.carregarPagina();
});
