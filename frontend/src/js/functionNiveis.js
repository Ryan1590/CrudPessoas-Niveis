const nivelModal = new bootstrap.Modal(
  document.getElementById("staticBackdrop"),
  {
    keyboard: false,
  }
);

function ShowEditarNivel(id, nivel) {
  ry.byID("staticBackdropLabel").innerText = "Editar Nivel";
  ry.byID("nivel").value = nivel;
  ry.byID("idnivel").value = id;
  ry.byID("btnInserir").innerText = "Editar";

  nivelModal.show();
}

function ShowInsertNivel() {
  ry.byID("staticBackdropLabel").innerText = "Adicinar Nivel";
  ry.byID("nivel").value = "";
  ry.byID("idnivel").value = "";
  ry.byID("btnInserir").innerText = "Salvar";

  nivelModal.show();
}

async function salvar() {
  let idnivel = ry.byID("idnivel").value;
  let nivel = ry.byID("nivel").value;
  let url = idnivel ? "api/niveis/" + idnivel : "/api/niveis";
  let metodo = idnivel ? "PUT" : "POST";
  let msg = idnivel
    ? "Edição realizada com sucesso!"
    : "Cadastro realizado com sucesso!";

  let req = await ry.ajax(metodo, { nivel: nivel }, url);

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

  window.carregarNiveis();
  nivelModal.hide();
}

async function deletarNivel(id) {
  const resultado = await Swal.fire({
    title: "Tem certeza?",
    text: "Você não poderá reverter isso!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sim, delete isso!",
    cancelButtonText: "Cancelar",
  });

  if (resultado.isConfirmed) {
    let req = await ry.ajax("DELETE", null, "/api/niveis/" + id);
    if (req && req.error) {
      ry.erro(req);
      return;
    }

    await Swal.fire("Deletado!", "O nível foi deletado.", "success");

    window.carregarNiveis();
  }
}

async function buscarNiveis() {
  const termoBusca = ry.byID("campoBusca").value;
  if (!termoBusca) {
    window.carregarNiveis();
    return;
  }
  try {
    const req = await ry.ajax(
      "GET",
      null,
      "/api/niveis/buscarTermo/" + termoBusca
    );
    if (req.error) {
      let errorMessage = req.result || "Erro desconhecido";
      Swal.fire({
        title: "Erro",
        text: errorMessage,
        icon: "error",
      });
      window.carregarNiveis();
      return;
    }
    window.carregarNiveis(req.result);
  } catch (error) {
    ry.erro(error);
  }
}

function ordenarNiveis() {
  const tabela = document.getElementById("tabelaNiveis");
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
    "#tabelaNiveis thead th:nth-child(2)"
  );
  colunaNivel.addEventListener("click", ordenarNiveis);

  if (!niveis) {
    await carregarNiveis();
  }
};
