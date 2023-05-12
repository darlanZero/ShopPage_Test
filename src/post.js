const form = document.querySelector('#product-form');
form.addEventListener('submit', function(e) {
  e.preventDefault(); // Evita o comportamento padrão de submissão do formulário
  
  // Obtém os dados do formulário
  const formData = new FormData(this);
  
  // Cria o objeto XMLHttpRequest
  const xhr = new XMLHttpRequest();
  
  // Configura a requisição
  xhr.open('POST', './formProcessor.php');
  
  // Define o tipo de conteúdo a ser enviado
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  
  // Define o callback para a resposta da requisição
  xhr.onload = function() {
    if (xhr.status === 200) {
      console.log(xhr.responseText); // Mostra a resposta do servidor
    } else {
      console.log('Erro ' + xhr.status); // Mostra o código de erro caso ocorra algum problema
    }
  };
  
  // Envia a requisição
  xhr.send(formData);
});
