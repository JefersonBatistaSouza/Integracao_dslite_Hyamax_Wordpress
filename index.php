<?php
//Voce deve ter o token de acesso fornecido pela Hyamax
$url = "https://app.dslite.com.br/modules/admin/Empresa/getXMLCrossdocking/2/token_de_acesso";
$docXML = simplexml_load_file($url);

if (!$docXML) {
   $timestamp = strtotime(date('H:i:s')) + 60*30;
    $dataHora = strftime('%d-%m-%Y, às %H:%M', $timestamp);
    echo "A próxima requisição so poderá ser feita em {$dataHora}";
    //print_r($docXML);
    exit;
}

$xml = '<?xml version="1.0" encoding="UTF-8"?>';
$xml .= '<productlist>';
foreach ($docXML->product as $product) {
    // A raiz do meu documento XML
    $xml .= '<product attr-id="' . $product->prod_id . '">';
    $xml .= '<product_id><![CDATA[' . $product->prod_id . ']]></product_id>';
    $xml .= '<brand><![CDATA[' . $product->brand . ']]></brand>';
    $xml .= '<model><![CDATA[' . $product->model . ']]></model>';
    $xml .= '<prod_name><![CDATA[' . $product->prod_name . ']]></prod_name>';
    $xml .= '<seg_name><![CDATA[' . $product->seg_name . ']]></seg_name>';
    $xml .= '<NBM><![CDATA[' . $product->NBM . ']]></NBM>';
    $xml .= '<weightValue><![CDATA[' . $product->weightValue . ']]></weightValue>';
    $xml .= '<shortname><![CDATA[' . $product->shortname . ']]></shortname>';
    $xml .= '<EAN><![CDATA[' . $product->EAN . ']]></EAN>';
    $xml .= '<width><![CDATA[' . $product->width . ']]></width>';
    $xml .= '<height><![CDATA[' . $product->height . ']]></height>';
    $xml .= '<depth><![CDATA[' . $product->depth . ']]></depth>';
    $xml .= '<youtube><![CDATA[' . $product->youtube . ']]></youtube>';
    $xml .= '<warrantyDays><![CDATA[' . $product->warrantyDays . ']]></warrantyDays>';
    $xml .= '<price><![CDATA[' . $product->price . ']]></price>';
    $xml .= '<stock><![CDATA[' . $product->stock . ']]></stock>';
    foreach ($product->images as $product_image) {
        $xml .= '<image><![CDATA[' . $product_image->image . ']]></image>';
    }
    foreach ($product->information as $product_info) {
        $xml .= '<description><![CDATA[' . $product_info->description . ']]></description>';
        $xml .= '<characteristics><![CDATA[' . $product_info->characteristics . ']]></characteristics>';
        $xml .= '<info><![CDATA[' . $product_info->info . ']]></info>';
    }
    $xml .= '<price_crossdocking><![CDATA[' . $product->price_crossdocking . ']]></price_crossdocking>';
    $xml .= '<price_dropshipping><![CDATA[' . $product->price_dropshipping . ']]></price_dropshipping>';
    $xml .= '</product>';
}
$xml .= '</productlist>';
// Escreve o arquivo
$fp = fopen('./XML/ProdutosHyamax.xml', 'w+');
fwrite($fp, $xml);
fclose($fp);
echo '<h1>Arquivo pronto para importação!! Redirecionando...</h1>';
?>
<script>
    setTimeout(function () {
        window.location.replace("https://sitewordpress.com.br/wp-admin/admin.php?page=pmxi-admin-manage");
    }, 3000);
</script>