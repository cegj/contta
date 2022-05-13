<div id="container-seletor-mes-ano" class="container-seletor-mes-ano box-opcoes hide">
  <div class="seletor-mes-ano" id="seletor-mes-ano">
    <form id="month-selector" class="month-selector" action="/app/form_handler/handle_month-selector.php" method="POST">
      <input id="seletor-campo-mes" class="month-selector-campo-mes" type="number" name="mes" min="1" max="12" value=<?php echo $mes ?> required> / <input class="month-selector-campo-ano" type="number" name="ano" min="1900" value=<?php echo $ano ?> required></input>
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