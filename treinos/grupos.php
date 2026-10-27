<?php
// Funções compartilhadas para o treino do Grupo 2 (tabela treinos_grupo2).
// O Grupo 1 continua sendo o treino da tabela treinos, como sempre foi.

// Executa uma consulta que pode falhar (ex.: tabela treinos_grupo2 ainda não criada) sem derrubar a página.
function consulta_segura($con, $sql){
    try {
        return mysqli_query($con, $sql);
    } catch (Throwable $e) {
        return false;
    }
}

// Carrega o treino do Grupo 2 de um treino. Retorna array ou null se não existir.
function carrega_grupo2($con, $id_treino){
    $res = consulta_segura($con, "SELECT * FROM treinos_grupo2 WHERE id_treino=".(int)$id_treino);
    if (!$res) return null;
    $row = mysqli_fetch_assoc($res);
    return $row ? $row : null;
}

// Salva a foto enviada no campo $campo. Retorna o nome do arquivo gravado ou null.
function salva_foto_treino($campo, $data, $sufixo){
    if (!isset($_FILES[$campo]) || strlen($_FILES[$campo]['name']) == 0) return null;
    $extensao = strtolower(pathinfo($_FILES[$campo]['name'], PATHINFO_EXTENSION));
    if (!in_array($extensao, array('jpg', 'jpeg', 'png', 'gif', 'webp'))) return null;
    $novo_nome = "treino".$data.$sufixo.".".$extensao;
    move_uploaded_file($_FILES[$campo]['tmp_name'], "../common/uploads/treinos/".$novo_nome);
    return $novo_nome;
}

// Mesmo tratamento de aspas que o treino do Grupo 1 recebe.
function limpa_texto_treino($texto){
    $texto = str_replace('"', 's', $texto);
    return str_replace("'", "min", $texto);
}

// Diz se o bloco do Grupo 2 foi preenchido no formulário.
function grupo2_preenchido($foto_existente = ''){
    if (trim($_POST['treino_g2']) != '' || trim($_POST['serie_controle_g2']) != '') return true;
    if ((int)$_POST['total_g2'] > 0) return true;
    foreach (array('A1', 'A2', 'A3', 'AN', 'FO') as $z) {
        if ((int)$_POST[$z.'_g2'] > 0) return true;
    }
    if (isset($_FILES['foto_g2']) && strlen($_FILES['foto_g2']['name']) > 0) return true;
    return strlen($foto_existente) > 3;
}

// Grava (insere ou atualiza) o treino do Grupo 2. Retorna true se deu certo.
function salva_grupo2($con, $id_treino, $data){
    $existente = carrega_grupo2($con, $id_treino);
    $foto = salva_foto_treino('foto_g2', $data, '_g2');
    if ($foto === null) $foto = $existente ? $existente['nome_foto'] : '';

    $treino = limpa_texto_treino($_POST['treino_g2']);
    $serie = $_POST['serie_controle_g2'];
    $tipo = isset($_POST['tipo_g2']) ? $_POST['tipo_g2'] : '';
    $total = (int)$_POST['total_g2'];
    $a1 = (int)$_POST['A1_g2'];
    $a2 = (int)$_POST['A2_g2'];
    $a3 = (int)$_POST['A3_g2'];
    $an = (int)$_POST['AN_g2'];
    $fo = (int)$_POST['FO_g2'];

    $sql = "INSERT INTO treinos_grupo2 (id_treino, nome_foto, treino, serie_controle, tipo, total, A1, A2, A3, AN, FO)
            VALUES (?,?,?,?,?,?,?,?,?,?,?)
            ON DUPLICATE KEY UPDATE nome_foto=VALUES(nome_foto), treino=VALUES(treino), serie_controle=VALUES(serie_controle),
            tipo=VALUES(tipo), total=VALUES(total), A1=VALUES(A1), A2=VALUES(A2), A3=VALUES(A3), AN=VALUES(AN), FO=VALUES(FO)";
    try {
        $stmt = mysqli_prepare($con, $sql);
        if (!$stmt) return false;
        mysqli_stmt_bind_param($stmt, "issssiiiiii", $id_treino, $foto, $treino, $serie, $tipo, $total, $a1, $a2, $a3, $an, $fo);
        $ok = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $ok;
    } catch (Throwable $e) {
        return false;
    }
}

// Desenha o bloco de campos de um treino.
// $sufixo: "" para o Grupo 1 e "_g2" para o Grupo 2 (vai no final do name de cada campo).
// $v: valores atuais (chaves: treino, serie_controle, tipo, total, A1, A2, A3, AN, FO).
function bloco_treino_grupo($sufixo, $titulo, $v = array(), $obrigatorio = true){
    $req = $obrigatorio ? 'required' : '';
    $val = function($k, $padrao = '') use ($v){
        return isset($v[$k]) && $v[$k] !== '' ? htmlspecialchars($v[$k]) : $padrao;
    };
    $tipo = isset($v['tipo']) ? $v['tipo'] : '';
    $sel = function($op) use ($tipo){ return $tipo == $op ? 'selected' : ''; };
    $zonas = array('A1' => 'Z1', 'A2' => 'Z2', 'A3' => 'Z3', 'AN' => 'Z4', 'FO' => 'Z5');
    ?>
        <div class="row" style="padding-left:20px;">
            <h2><?php echo $titulo ?></h2>
        </div>

        <div class="row form-group">
        <div class="col-6">
                <label for="foto<?php echo $sufixo ?>"><b>Treino:</b></label>
                <input class="form-control" type="file" placeholder="Selecione uma foto" name="foto<?php echo $sufixo ?>" accept="image/*" >
                <textarea class="form-control" type="text" rows="5" placeholder="Ou digite aqui..." name="treino<?php echo $sufixo ?>"><?php echo $val('treino') ?></textarea>
        </div>

        <div class="col-6">
          <div class="row form-group">
          <?php foreach ($zonas as $campo => $nome) { ?>
              <div class="col-2">
                <label for="<?php echo $campo.$sufixo ?>"><b><?php echo $nome ?>:</b></label>
                <input class="form-control" type="number" placeholder="<?php echo $nome ?>..." name="<?php echo $campo.$sufixo ?>" value="<?php echo $val($campo, 0) ?>" <?php echo $req ?>>
              </div>
          <?php } ?>
          </div>

                <label for="total<?php echo $sufixo ?>"><b>Metragem total:</b></label>
                <input class="form-control" type="number" placeholder="Metragem..." name="total<?php echo $sufixo ?>" value="<?php echo $val('total') ?>" <?php echo $req ?>>
        </div>
        </div>

        <div class="row" style="padding-left:20px;padding-top:20px;">
            <h2>Série controle</h2>
            <hr>
        </div>

        <div class="row form-group">
            <div class="col-sm-6 col-md-6">
                <label for="serie_controle<?php echo $sufixo ?>"><b>Descrição:</b></label>
                <input class="form-control" type="text" placeholder="Insira uma descrição para a série ..." name="serie_controle<?php echo $sufixo ?>" value="<?php echo $val('serie_controle') ?>">
            </div>

            <div class="col-sm-6 col-md-6">
                <label for="tipo<?php echo $sufixo ?>"><b>Tipo:</b></label>
                <select class="form-control" name="tipo<?php echo $sufixo ?>">
                    <option value=" " <?php echo $sel(' ') ?>> </option>
                    <option value="BT" <?php echo $sel('BT') ?>>BT</option>
                    <option value="Tiro" <?php echo $sel('Tiro') ?>>Tiro</option>
                    <option value="Melhor media" <?php echo $sel('Melhor media') ?>>Melhor média</option>
                </select>
            </div>
        </div>
    <?php
}

// Conteúdo (botão ou links) de um treino na lista de treinos. $rotulo é "Grupo 1"/"Grupo 2" ou vazio (treino único).
// $i é o contador de ids dos botões da página.
function celula_treino_html($nome_foto, $descricao, $metragem, $date, &$i, $rotulo = ''){
    $dia = date_format($date, "d/m/Y");
    $prefixo = $rotulo != '' ? '<b>'.$rotulo.':</b> ' : '';
    //caso o treino seja enviado por foto
    if (strlen($nome_foto) > 3) {
        return '<div>'.$prefixo.'<a href="../common/uploads/treinos/'.$nome_foto.'"><u>Visualizar</u></a> <a href="../common/uploads/treinos/'.$nome_foto.'" download="treino'.$dia.'"><u>Baixar</u></a></div>';
    }
    //caso o treino seja digitado
    $titulo = $rotulo != '' ? ' - '.$rotulo : '';
    $html = '<div><button style="color:#000000;" id="'.$i.'" class="treino" onclick="exibe(this.id)" value="Treino do dia: '.$dia.$titulo.'<br>'.$descricao.'<br>TOTAL: '.$metragem.'" type="button" href="#">'.($rotulo != '' ? $rotulo : 'Visualizar').'</button></div>';
    $i += 1;
    return $html;
}
?>
