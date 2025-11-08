/* ===========================
   sistema SPA - troca de telas
   =========================== */

function mostrarPagina(idPagina) {
    // pega todas as seções (home, países e cidades)
    document.querySelectorAll(".pagina").forEach(secao => {
        secao.classList.remove("ativa");
    });

    // ativa apenas a página desejada
    document.getElementById(idPagina).classList.add("ativa");

    atualizarTabelas(); // sempre atualiza a tela quando muda de página
}


/* ===========================
   armazenamento no localStorage
   =========================== */

let paises = JSON.parse(localStorage.getItem("paises")) || [];
let cidades = JSON.parse(localStorage.getItem("cidades")) || [];

// salva no localStorage
function salvarLocal() {
    localStorage.setItem("paises", JSON.stringify(paises));
    localStorage.setItem("cidades", JSON.stringify(cidades));
}


/* ===========================
   CRUD DE PAÍSES
   =========================== */

function salvarPais(event) {
    event.preventDefault(); // impede recarregar página

    const id = document.getElementById("idPais").value;
    const nome = document.getElementById("nomePais").value;
    const continente = document.getElementById("continentePais").value;
    const populacao = document.getElementById("populacaoPais").value;
    const idioma = document.getElementById("idiomaPais").value;

    if (id) {
        // edição
        const pais = paises.find(p => p.id == id);
        pais.nome = nome;
        pais.continente = continente;
        pais.populacao = populacao;
        pais.idioma = idioma;
    } else {
        // cadastro novo
        paises.push({
            id: Date.now(),
            nome,
            continente,
            populacao,
            idioma
        });
    }

    salvarLocal();
    atualizarTabelas();
    cancelarEdicaoPais();
}

// preenche o formulário para editar
function editarPais(id) {
    const pais = paises.find(p => p.id === id);

    document.getElementById("idPais").value = pais.id;
    document.getElementById("nomePais").value = pais.nome;
    document.getElementById("continentePais").value = pais.continente;
    document.getElementById("populacaoPais").value = pais.populacao;
    document.getElementById("idiomaPais").value = pais.idioma;

    document.getElementById("botaoSalvarPais").textContent = "Atualizar";
    document.getElementById("botaoCancelarPais").classList.remove("oculto");
}

// cancelar edição
function cancelarEdicaoPais() {
    document.getElementById("formPais").reset();
    document.getElementById("idPais").value = "";
    document.getElementById("botaoSalvarPais").textContent = "Salvar";
    document.getElementById("botaoCancelarPais").classList.add("oculto");
}

// excluir país
function excluirPais(id) {
    // verifica se o país tem cidades
    const temCidade = cidades.some(c => c.idPais === id);

    if (temCidade && !confirm("Este país tem cidades associadas. Deseja excluir mesmo assim?")) {
        return;
    }

    cidades = cidades.filter(c => c.idPais !== id); // apaga cidades vinculadas
    paises = paises.filter(p => p.id !== id);

    salvarLocal();
    atualizarTabelas();
}


/* ===========================
   CRUD DE CIDADES
   =========================== */

function salvarCidade(event) {
    event.preventDefault();

    const id = document.getElementById("idCidade").value;
    const nome = document.getElementById("nomeCidade").value;
    const populacao = document.getElementById("populacaoCidade").value;
    const idPais = document.getElementById("paisCidade").value;

    if (id) {
        const cidade = cidades.find(c => c.id == id);
        cidade.nome = nome;
        cidade.populacao = populacao;
        cidade.idPais = idPais;
    } else {
        cidades.push({
            id: Date.now(),
            nome,
            populacao,
            idPais
        });
    }

    salvarLocal();
    atualizarTabelas();
    cancelarEdicaoCidade();
}

function editarCidade(id) {
    const cidade = cidades.find(c => c.id === id);

    document.getElementById("idCidade").value = cidade.id;
    document.getElementById("nomeCidade").value = cidade.nome;
    document.getElementById("populacaoCidade").value = cidade.populacao;
    document.getElementById("paisCidade").value = cidade.idPais;

    document.getElementById("botaoSalvarCidade").textContent = "Atualizar";
    document.getElementById("botaoCancelarCidade").classList.remove("oculto");
}

// cancelar edição
function cancelarEdicaoCidade() {
    document.getElementById("formCidade").reset();
    document.getElementById("idCidade").value = "";
    document.getElementById("botaoSalvarCidade").textContent = "Salvar";
    document.getElementById("botaoCancelarCidade").classList.add("oculto");
}

// excluir cidade
function excluirCidade(id) {
    cidades = cidades.filter(c => c.id !== id);
    salvarLocal();
    atualizarTabelas();
}


/* ===========================
   ATUALIZAR TABELAS
   =========================== */

function atualizarTabelas() {
    atualizarTabelaPaises();
    atualizarTabelaCidades();
    atualizarSelectPaises();
}

// renderizar tabela de países
function atualizarTabelaPaises() {
    const tabela = document.getElementById("listaPaises");
    tabela.innerHTML = "";

    paises.forEach(pais => {
        tabela.innerHTML += `
            <tr>
                <td>${pais.nome}</td>
                <td>${pais.continente}</td>
                <td>${pais.populacao}</td>
                <td>${pais.idioma}</td>
                <td>
                    <button onclick="editarPais(${pais.id})">✏ Editar</button>
                    <button onclick="excluirPais(${pais.id})">🗑 Excluir</button>
                </td>
            </tr>
        `;
    });
}

// preencher select de países em "cidades"
function atualizarSelectPaises() {
    const select = document.getElementById("paisCidade");
    select.innerHTML = '<option value="">Selecione</option>';

    paises.forEach(pais => {
        select.innerHTML += `<option value="${pais.id}">${pais.nome}</option>`;
    });
}

// renderizar tabela de cidades
function atualizarTabelaCidades() {
    const tabela = document.getElementById("listaCidades");
    tabela.innerHTML = "";

    cidades.forEach(cidade => {
        const pais = paises.find(p => p.id == cidade.idPais);

        tabela.innerHTML += `
            <tr>
                <td>${cidade.nome}</td>
                <td>${cidade.populacao}</td>
                <td>${pais ? pais.nome : "País apagado"}</td>
                <td>
                    <button onclick="editarCidade(${cidade.id})">✏ Editar</button>
                    <button onclick="excluirCidade(${cidade.id})">🗑 Excluir</button>
                </td>
            </tr>
        `;
    });
}

/* inicia o sistema na página home */
mostrarPagina("home");
