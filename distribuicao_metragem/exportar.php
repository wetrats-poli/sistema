<?php
// Exporta para Excel (.xlsx) a metragem por zona de cada semana, para o Grupo 1 e o Grupo 2.
session_start();

// Verifica se existe ID da sessão
if(!isset($_SESSION['ID'])){
    session_destroy();
    header("Location: ../index.php"); exit;
}

include '../preparacao_fisica/prog_semanas.php';
require_once '../db_con.php';
require_once '../treinos/grupos.php';

date_default_timezone_set('America/Sao_Paulo');
$semana_atual = acha_semana(date("Y-m-d"));

$grupos = array(1 => zonas_por_semana($con, $semana_atual, 1), 2 => zonas_por_semana($con, $semana_atual, 2));

// Uma linha por semana e grupo; semanas sem nenhum treino (nos dois grupos) ficam de fora
$linhas = array(array('Semana', 'Grupo', 'Z1 (m)', 'Z2 (m)', 'Z3 (m)', 'Z4 (m)', 'Z5 (m)', 'Total (m)'));
for ($sem = 1; $sem <= $semana_atual; $sem++) {
    $i = $sem - 1;
    $total_semana = 0;
    foreach ($grupos as $z) {
        $total_semana += $z['A1'][$i] + $z['A2'][$i] + $z['A3'][$i] + $z['AN'][$i] + $z['FO'][$i];
    }
    if ($total_semana == 0) continue;
    foreach ($grupos as $g => $z) {
        $linhas[] = array('S'.$sem, 'Grupo '.$g, $z['A1'][$i], $z['A2'][$i], $z['A3'][$i], $z['AN'][$i], $z['FO'][$i],
                          $z['A1'][$i] + $z['A2'][$i] + $z['A3'][$i] + $z['AN'][$i] + $z['FO'][$i]);
    }
}

$nome_arquivo = 'distribuicao_metragem_grupos_'.date('Y-m-d');

// Letra da coluna (A, B, C...) para o índice 0, 1, 2...
function coluna_xlsx($n){
    return chr(ord('A') + $n);
}

function texto_xml($t){
    return htmlspecialchars($t, ENT_XML1 | ENT_QUOTES, 'UTF-8');
}

// Monta o conteúdo da planilha (sheet1.xml); a primeira linha usa o estilo 1 (negrito)
function planilha_xml($linhas){
    $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
         . '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
         . '<cols><col min="1" max="2" width="12" customWidth="1"/><col min="3" max="8" width="12" customWidth="1"/></cols>'
         . '<sheetData>';
    foreach ($linhas as $r => $linha) {
        $xml .= '<row r="'.($r + 1).'">';
        foreach ($linha as $c => $valor) {
            $ref = coluna_xlsx($c).($r + 1);
            $estilo = $r == 0 ? ' s="1"' : '';
            if (is_int($valor)) $xml .= '<c r="'.$ref.'"'.$estilo.'><v>'.$valor.'</v></c>';
            else $xml .= '<c r="'.$ref.'"'.$estilo.' t="inlineStr"><is><t>'.texto_xml($valor).'</t></is></c>';
        }
        $xml .= '</row>';
    }
    return $xml . '</sheetData></worksheet>';
}

if (class_exists('ZipArchive')) {
    $arquivo = tempnam(sys_get_temp_dir(), 'xlsx');
    $zip = new ZipArchive();
    $zip->open($arquivo, ZipArchive::OVERWRITE);
    $zip->addFromString('[Content_Types].xml', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
        . '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
        . '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
        . '<Default Extension="xml" ContentType="application/xml"/>'
        . '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
        . '<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'
        . '<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>'
        . '</Types>');
    $zip->addFromString('_rels/.rels', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
        . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
        . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>'
        . '</Relationships>');
    $zip->addFromString('xl/workbook.xml', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
        . '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
        . '<sheets><sheet name="Distribuição" sheetId="1" r:id="rId1"/></sheets></workbook>');
    $zip->addFromString('xl/_rels/workbook.xml.rels', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
        . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
        . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>'
        . '<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>'
        . '</Relationships>');
    $zip->addFromString('xl/styles.xml', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
        . '<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
        . '<fonts count="2"><font><sz val="11"/><name val="Calibri"/></font><font><b/><sz val="11"/><name val="Calibri"/></font></fonts>'
        . '<fills count="2"><fill><patternFill patternType="none"/></fill><fill><patternFill patternType="gray125"/></fill></fills>'
        . '<borders count="1"><border><left/><right/><top/><bottom/><diagonal/></border></borders>'
        . '<cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>'
        . '<cellXfs count="2"><xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/><xf numFmtId="0" fontId="1" fillId="0" borderId="0" xfId="0" applyFont="1"/></cellXfs>'
        . '</styleSheet>');
    $zip->addFromString('xl/worksheets/sheet1.xml', planilha_xml($linhas));
    $zip->close();

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="'.$nome_arquivo.'.xlsx"');
    header('Content-Length: '.filesize($arquivo));
    readfile($arquivo);
    unlink($arquivo);
} else {
    // Sem suporte a zip no servidor: CSV com ; e BOM UTF-8, que o Excel em português abre direto
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="'.$nome_arquivo.'.csv"');
    echo "\xEF\xBB\xBF";
    $saida = fopen('php://output', 'w');
    foreach ($linhas as $linha) fputcsv($saida, $linha, ';');
    fclose($saida);
}
exit;
