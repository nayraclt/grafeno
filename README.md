# Grafeno Test

Projeto Laravel 5.3, para teste.


## Endpoints API

 1. [GET Licitações CNPQ](#get-licitacoes-cnpq)

# GET Licitações CNPQ

> ```GET api/lista-licitacao-cnpq```

## Return

```json
{
        "objeto": "CONCORRÊNCIA N° 01/2017",
        "abertura": ": Cessão administrativa de uso, onerosa, de espaço físico privativo de 43,00 m²...",
        "publicacoes": ": 27/04/2018 às 10h "
},
```

## Return format

Um json com os seguintes índices

-   **titulo**  — Titulo da licitação
-   **conteudo**  — Conteúdo da licitação
-   **publicacoes**  — Datas da publicação

## Parameters

 - **busca-licitacoes** - Retorna Licitações de acordo com os termos pesquisados.
 - **filtro-ano** - Retorna Licitações com o ano relacionado ao buscado
 - **filtro-categoria** - Retorna licitações de acordo com a categoria pesquisada.