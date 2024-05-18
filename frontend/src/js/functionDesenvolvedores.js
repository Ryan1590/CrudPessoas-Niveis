const modalDev = new bootstrap.Modal(document.getElementById("modalDev"), {
  keyboard: false,
});

let desenvolvedores = [];

async function fetchDesenvolvedores() {
  try {
    let reqDevs = await ry.ajax("GET", null, "/api/desenvolvedores");
    if (reqDevs.error) {
      Swal.fire({
        title: "Ops!",
        text: "Algo deu errado. Tente novamente!",
        icon: "error",
      });
      return;
    }
    desenvolvedores = reqDevs.result;
  } catch (error) {
    Swal.fire({
      title: "Ops!",
      text: "Erro ao buscar desenvolvedores. Tente novamente!",
      icon: "error",
    });
    console.error(error);
  }
}

async function ShowEditarDev(id) {
  let desenvolvedor = desenvolvedores.find(
    (dev) => dev.id === id || dev.id === String(id) || String(dev.id) === id
  );
  if (!desenvolvedor) {
    Swal.fire({
      title: "Ops!",
      text: "Desenvolvedor não encontrado!",
      icon: "error",
    });
    return;
  }

  ry.byID("iddev").value = desenvolvedor.id;
  ry.byID("modalDevLabel").innerText = "Editar Desenvolvedor";
  ry.byID("nome").value = desenvolvedor.nome;
  ry.byID("sexo").value = desenvolvedor.sexo;
  ry.byID("data_nascimento").value = desenvolvedor.data_nascimento;
  ry.byID("idade").value = desenvolvedor.idade;
  ry.byID("hobby").value = desenvolvedor.hobby;

  try {
    let reqNiveis = await ry.ajax("GET", null, "/api/niveis");
    if (reqNiveis.error) {
      Swal.fire({
        title: "Ops!",
        text: "Erro ao buscar níveis. Tente novamente!",
        icon: "error",
      });
      return;
    }

    let niveis = reqNiveis.result;
    let nivelSelect = document.getElementById("nivelselect");
    nivelSelect.innerHTML = "";
    let nivelDesenvolvedor = niveis.find(
      (nivel) => nivel.nivel === desenvolvedor.nivel.nivel
    );
    if (nivelDesenvolvedor) {
      niveis.forEach((nivel) => {
        let option = document.createElement("option");
        option.value = nivel.id;
        option.text = nivel.nivel;
        if (nivel.nivel === nivelDesenvolvedor.nivel) {
          option.selected = true;
        }

        nivelSelect.appendChild(option);
      });
    } else {
      console.error(
        "Nível do desenvolvedor não encontrado:",
        desenvolvedor.nivel.nivel
      );
    }
  } catch (error) {
    Swal.fire({
      title: "Ops!",
      text: "Erro ao buscar níveis. Tente novamente!",
      icon: "error",
    });
    console.error(error);
  }

  modalDev.show();
}
fetchDesenvolvedores();

document.getElementById("data_nascimento").addEventListener("change", function () {
    const dataNascimento = new Date(this.value);
    const hoje = new Date();
    let idade = hoje.getFullYear() - dataNascimento.getFullYear();
    const mes = hoje.getMonth() - dataNascimento.getMonth();
    if (mes < 0 || (mes === 0 && hoje.getDate() < dataNascimento.getDate())) {
      idade--;
    }
    document.getElementById("idade").value = idade;
  });

async function salvarDev() {
  let iddev = ry.byID("iddev").value;
  let nome = ry.byID("nome").value;
  let sexo = ry.byID("sexo").value;
  let dataNascimento = ry.byID("data_nascimento").value;
  let idade = ry.byID("idade").value;
  let hobby = ry.byID("hobby").value;
  let nivel = ry.byID("nivelselect").value;

  let url = iddev ? "/api/desenvolvedores/" + iddev : "/api/desenvolvedores";
  let metodo = iddev ? "PUT" : "POST";
  let msg = iddev
    ? "Edição realizada com sucesso!"
    : "Cadastro realizado com sucesso!";

  let req = await ry.ajax(
    metodo,
    {
      nome: nome,
      sexo: sexo,
      data_nascimento: dataNascimento,
      idade: idade,
      hobby: hobby,
      nivel_id: nivel,
    },
    url
  );

  if (req.error) {
    let errorMessage = req.result.result || "Erro desconhecido";
    Swal.fire({
      title: "Atenção!",
      text: errorMessage,
      icon: "warning",
    });
    return;
  }

  Swal.fire({
    title: "Sucesso!",
    text: msg,
    icon: "success",
  });

  window.carregarDesenvolvedores();
  modalDev.hide();
  fetchDesenvolvedores(); 
}

async function ShowInsertDev() {
  ry.byID("modalDevLabel").innerText = "Inserir Desenvolvedor";
  ry.byID("nome").value = "";
  ry.byID("sexo").value = "";
  ry.byID("data_nascimento").value = "";
  ry.byID("idade").value = "";
  ry.byID("hobby").value = "";
  ry.byID("nivelselect").value = "";
  ry.byID("iddev").value = "";

  let req = await ry.ajax("GET", null, "api/niveis");
  if (req.error) {
    Swal.fire({
      title: "Ops!",
      text: "Por favor, certifique-se de cadastrar um nível antes de cadastrar um desenvolvedor!",
      icon: "warning",
    });
    return;
  }

  let nivelSelect = document.getElementById("nivelselect");
  nivelSelect.innerHTML =
    '<option value="" selected disabled>Selecione o nível</option>';
  req.result.forEach((nivel) => {
    let option = document.createElement("option");
    option.value = nivel.id;
    option.text = nivel.nivel;
    nivelSelect.appendChild(option);
  });

  modalDev.show();
}

async function deletarDev(id) {
  const result = await Swal.fire({
    title: "Tem certeza?",
    text: "Você não poderá reverter isso!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sim, delete isso!",
    cancelButtonText: "Cancelar",
  });

  if (result.isConfirmed) {
    await ry.ajax("DELETE", null, "api/desenvolvedores/" + id);
    Swal.fire("Deletado!", "O dev foi deletado.", "success");
    window.carregarDesenvolvedores();
  }
}

async function buscarDevs() {
  let termoBusca = ry.byID("campoBuscar").value;
  if (!termoBusca) {
    window.carregarDesenvolvedores();
    return;
  }

  try {
    let req = await ry.ajax(
      "GET",
      null,
      "api/desenvolvedores/buscarTermo/" + termoBusca
    );
    if (req.error) {
      let errorMessage = req.result || "Erro desconhecido";
      Swal.fire({
        title: "Erro",
        text: errorMessage,
        icon: "error",
      });
      window.carregarDesenvolvedores();
      return;
    }
    window.carregarDesenvolvedores(req.result);
  } catch (error) {
    ry.erro(error);
  }
}

function ordenarNome() {
  const tabela = document.getElementById("tabelaDev");
  const linhas = Array.from(tabela.querySelectorAll("tbody tr"));

  const colunaNivel = tabela.querySelector("thead th:nth-child(2)");
  const ordenadoAsc = colunaNivel.classList.contains("ordenado-asc");

  tabela.querySelectorAll("thead th").forEach((th) => {
    th.classList.remove("ordenado-asc", "ordenado-desc");
  });

  colunaNivel.classList.add(ordenadoAsc ? "ordenado-desc" : "ordenado-asc");

  linhas.sort((a, b) => {
    const valorA = a.querySelector("td:nth-child(2)").textContent.trim();
    const valorB = b.querySelector("td:nth-child(2)").textContent.trim();

    return ordenadoAsc
      ? valorA.localeCompare(valorB)
      : valorB.localeCompare(valorA);
  });

  linhas.forEach((linha) => tabela.querySelector("tbody").appendChild(linha));
}

window.carregarNiveis = async (niveis = null) => {
  const colunaNivel = document.querySelector(
    "#tabelaDev thead th:nth-child(2)"
  );
  colunaNivel.addEventListener("click", ordenarNiveis);

  if (!niveis) {
    await carregarNiveis();
  }
};
