<div class="container-seletor-mes-ano">
  <div class="seletor-mes-ano" id="seletor-mes-ano">
    <form id="for-mes-ano" class="form-mes-ano" action="" method="POST">
      <input id="seletor-campo-mes" class="form-mes-ano-campo-mes" type="number" name="mes" min="1" max="12" value=<?php echo $mes ?> required> / <input class="form-mes-ano-campo-ano" type="number" name="ano" min="1900" value=<?php echo $ano ?> required></input>
      <button class="botao-acao-secundario" type="submit">Selecionar</button>
    </form>

    <div class="seletor-mes" id="seletor-mes">
      <button class="botao-seletor-mes" value="01">01</button>
      <button class="botao-seletor-mes" value="02">02</button>
      <button class="botao-seletor-mes" value="03">03</button>
      <button class="botao-seletor-mes" value="04">04</button>
      <button class="botao-seletor-mes" value="05">05</button>
      <button class="botao-seletor-mes" value="06">06</button>
      <button class="botao-seletor-mes" value="07">07</button>
      <button class="botao-seletor-mes" value="08">08</button>
      <button class="botao-seletor-mes" value="09">09</button>
      <button class="botao-seletor-mes" value="10">10</button>
      <button class="botao-seletor-mes" value="11">11</button>
      <button class="botao-seletor-mes" value="12">12</button>
    </div>
  </div>
</div>

<script type="text/javascript">
  var FormMesAno = document.getElementById('for-mes-ano');
  var seletorMes = document.getElementById('seletor-mes');
  var campoMes = document.getElementById('seletor-campo-mes');

  botoes = document.getElementsByClassName('botao-seletor-mes');

  function selecionarMesEIr(botao) {
    campoMes.value = botao.value;
    campoMes.innerText = botao.value;
    FormMesAno.submit();
  };

  botoes[0].addEventListener('click', function() {
    selecionarMesEIr(botoes[0])
  });
  botoes[1].addEventListener('click', function() {
    selecionarMesEIr(botoes[1])
  });
  botoes[2].addEventListener('click', function() {
    selecionarMesEIr(botoes[2])
  });
  botoes[3].addEventListener('click', function() {
    selecionarMesEIr(botoes[3])
  });
  botoes[4].addEventListener('click', function() {
    selecionarMesEIr(botoes[4])
  });
  botoes[5].addEventListener('click', function() {
    selecionarMesEIr(botoes[5])
  });
  botoes[6].addEventListener('click', function() {
    selecionarMesEIr(botoes[6])
  });
  botoes[7].addEventListener('click', function() {
    selecionarMesEIr(botoes[7])
  });
  botoes[8].addEventListener('click', function() {
    selecionarMesEIr(botoes[8])
  });
  botoes[9].addEventListener('click', function() {
    selecionarMesEIr(botoes[9])
  });
  botoes[10].addEventListener('click', function() {
    selecionarMesEIr(botoes[10])
  });
  botoes[11].addEventListener('click', function() {
    selecionarMesEIr(botoes[11])
  });

  // ABRIR E FECHAR O SELETOR DE MÊS E ANO AO CLICAR NO BOTÃO

  botaoAbrirMesAno = document.getElementById('selecionar-mes-ano')
  seletorMesAno = document.getElementById('seletor-mes-ano')

  botaoAbrirMesAno.addEventListener('click', function() {
    if (seletorMesAno.classList.contains('show')) {
      seletorMesAno.classList.remove('show');
      seletorMesAno.classList.add('hide');
      botaoAbrirMesAno.classList.remove('botao-sair');
      botaoAbrirMesAno.classList.add('botao-mes-ano');
    } else {
      seletorMesAno.classList.add('show');
      seletorMesAno.classList.remove('hide');
      botaoAbrirMesAno.classList.remove('botao-mes-ano');
      botaoAbrirMesAno.classList.add('botao-sair');
    }
  });

  // FECHAR COM ESC

  document.querySelector('body').addEventListener('keydown', function(event) {

    if (event.key === 'Escape') {
      seletorMesAno.classList.remove('exibir');
      botaoAbrirMesAno.classList.remove('botao-sair');
      botaoAbrirMesAno.classList.add('botao-mes-ano');
    }
  });
</script>