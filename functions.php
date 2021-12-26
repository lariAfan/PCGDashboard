<?php 
session_start();
$acao = $_REQUEST['acao'];

if ($acao == "consultaDadosPokemon") {
    $nome = $_REQUEST['pokemon'];
    echo json_encode(pegaInformacoesPokemon(strtolower($nome)));
    exit;
}

if ($acao == "consultaMove") {
    $move = $_REQUEST['move'];
    echo json_encode(pegaInformacoesMove(strtolower($move)));
    exit;
}

if ($acao == 'consultaPokemon') {
    $src = $_REQUEST['src'];
    $array = explode("/", $src);
    $nomeimagem = end($array);
    $id = explode(".", $nomeimagem);
    $tier = "";

    $dadosPokemon = pegaInformacoesPokemon($id[0]);
    $nome = ucfirst($dadosPokemon->name);

    $nome .= " (".$dadosPokemon->tipos.")";
    if ($nome != $_SESSION['pokemonAnterior']) {
        if (ATierList($id[0])) {
            $tier = "A TIER";
            //src="https://poketwitch.bframework.de/static/pokedex/sprites/front/10026.gif"
            send_whatsapp_evil("A wild ".$tier." ".$nome." appears!!");
            send_whatsapp_vinicius("A wild ".$tier." ".$nome." appears!!");
            send_whatsapp("A wild ".$tier." ".$nome." appears!!");
        } else if (wantedList($id[0])) {
            send_whatsapp("PEGA O  ".$nome." JÁ JÁ JÁ!!");
        }
        $_SESSION['pokemonAnterior'] = $nome; 
    }
    ///return $nome;
    echo $nome." ".$tier;
    exit;
}

if ($acao == 'pegaPokemao') {
    getIdSpawmPCG();
    exit;
}

function send_whatsapp($message="Test"){
    $phone="+5519988030484";  // Enter your phone number here
    $apikey="353653";       // Enter your personal apikey received in step 3 above

    $url='https://api.callmebot.com/whatsapp.php?source=php&phone='.$phone.'&text='.urlencode($message).'&apikey='.$apikey;

    if($ch = curl_init($url)) {
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $html = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // echo "Output:".$html;  // you can print the output for troubleshooting
        curl_close($ch);
        return (int) $status;
    } else {
        return false;
    }
}
function send_whatsapp_evil($message="Test"){
    $phone="+12538202117";  // Enter your phone number here
    $apikey="826227";       // Enter your personal apikey received in step 3 above

    $url='https://api.callmebot.com/whatsapp.php?source=php&phone='.$phone.'&text='.urlencode($message).'&apikey='.$apikey;

    if($ch = curl_init($url)) {
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $html = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // echo "Output:".$html;  // you can print the output for troubleshooting
        curl_close($ch);
        return (int) $status;
    } else {
        return false;
    }
}
function send_whatsapp_vinicius($message="Test"){
    $phone="+5521989561130";  // Enter your phone number here
    $apikey="958885";       // Enter your personal apikey received in step 3 above

    $url='https://api.callmebot.com/whatsapp.php?source=php&phone='.$phone.'&text='.urlencode($message).'&apikey='.$apikey;

    if($ch = curl_init($url)) {
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $html = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // echo "Output:".$html;  // you can print the output for troubleshooting
        curl_close($ch);
        return (int) $status;
    } else {
        return false;
    }
}

function pegaInformacoesPokemon($id) {    
    $arrayDados = json_decode(file_get_contents('https://pokeapi.co/api/v2/pokemon/'.$id));
    if (count($arrayDados)) {
        $arrayDados->tipos = retornaTipoPokemon($arrayDados->types);
    } 
    return $arrayDados;
}

function pegaInformacoesMove($m) {    
    return json_decode(file_get_contents('https://pokeapi.co/api/v2/move/'.$m));
}

function getIdSpawmPCG() {
    // URL DO SITE
    $url = 'https://poketwitch.bframework.de/info/events/show_current_pokemon/?gif=true';

    // PEGANDO TODO CONTEUDO
    $dadosSite = file_get_contents($url);

    echo $dadosSite;
    exit;
}

function wantedList($id) {
    $arrayW = array(
        164,
        195,
        219,               
        229,
        297,
        334,
        446,
        565,
        636,
        687
    );
    return in_array($id, $arrayW);
}

function ATierList($id) {
    $arrayT = array (
    2,
    3,
    5,
    6,
    8,
    9,
    26,
    31,
    34,
    45,
    59,
    62,
    65,
    68,
    71,
    76,
    94,
    130,
    131,
    134,
    135,
    136,
    142,
    143,
    149,
    153,
    154,
    156,
    157,
    159,
    160,
    169,
    186,
    196,
    197,
    199,
    208,
    212,
    230,
    242,
    247,
    248,
    253,
    254,
    256,
    257,
    259,
    260,
    272,
    275,
    282,
    289,
    306,
    323,
    330,
    350,
    365,
    373,
    376,
    388,
    389,
    391,
    392,
    394,
    395,
    405,
    407,
    409,
    411,
    416,
    429,
    430,
    442,
    445,
    448,
    450,
    454,
    460,
    461,
    462,
    463,
    464,
    466,
    467,
    468,
    469,
    470,
    471,
    472,
    473,
    474,
    475,
    477,
    479,
    496,
    497,
    499,
    500,
    502,
    503,
    526,
    530,
    534,
    537,
    542,
    545,
    553,
    555,
    563,
    567,
    571,
    576,
    579,
    584,
    598,
    601,
    604,
    609,
    612,
    614,
    621,
    623,
    625,
    635,
    637,
    651,
    652,
    654,
    655,
    657,
    658,
    663,
    668,
    671,
    675,
    681,
    691,
    697,
    700,
    701,
    706,
    715,
    723,
    724,
    726,
    727,
    729,
    730,
    733,
    738,
    748,
    758,
    760,
    763,
    768,
    776,
    778,
    784,
    811,
    812,
    814,
    815,
    817,
    818,
    823,
    826,
    839,
    841,
    842,
    849,
    851,
    855,
    858,
    861,
    862,
    864,
    866,
    867,
    869,
    879,
    884,
    886,
    887,
    10026);

    return in_array($id, $arrayT);
}

function retornaTipoPokemon($tipos) {

    if (count($tipos) == 2) {
        return ucfirst($tipos[0]->type->name)."/".ucfirst($tipos[1]->type->name);
    } else {
        return ucfirst($tipos[0]->type->name);
    }
}
?>