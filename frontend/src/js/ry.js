
var ry = {
    formataDinheiroBR: function (val) {
      return val.toLocaleString('pt-BR', { minimumFractionDigits: 2 });
    },
  
    formataDinheiroUSA: function (val) {
      if (val === 0) {
        return val;
      }
      return parseFloat(val.split(".").join("").replace(",", "."));
    },
  
    injecthtml: function (html, el) {
      document.getElementById(el).innerHTML = html;
    },
  
    byID: function (parms) {
      return document.getElementById(parms);
    },
  
    qs2: function (parms) {
      return document.getElementById(parms).value;
    },

    qs: function (parms) {
      return document.querySelector(parms);
    },
  
    formData: function (args) { //recebe json
      var data = new FormData();
  
      for (let x in args) {
        if (args.hasOwnProperty(x)) {
          data.append(x, args[x]);
        } else {
          data.append(x, args[x]);
        }
      }
      return data;
    },
    erro: function(erro) {
      Swal.fire({
        title: "Ops!",
        text: erro.result,
        icon: "error"
      });
      return;
    },
    formataDataBR: function (data) {
      const d = new Date(data);
      const dia = d.getDate().toString().padStart(2, '0');
      const mes = (d.getMonth() + 1).toString().padStart(2, '0');
      const ano = d.getFullYear();
      return `${dia}/${mes}/${ano}`;
    },
    ajax: async function (method, params, url) { 
        let options = {
            method: method,
            headers: new Headers({'Content-Type': 'application/json'})
        };

        if (['POST', 'PUT', 'PATCH'].includes(method) && params) {
            // Para métodos que enviam dados no corpo da requisição, stringify o JSON.
            options.body = JSON.stringify(params);
        } else if (params && (method === 'GET' || method === 'DELETE')) {
            // Para GET e DELETE, adicione params como query string
            url += '?' + new URLSearchParams(params).toString();
        }

        const response = await fetch(BASE_URL + url, options);
        if (response.status === 204) {
          return null; 
        }
        return  response.json();  // Resposta JSON 
        
    }
  }  