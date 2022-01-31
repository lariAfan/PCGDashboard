<?php 
    session_start();
    $_SESSION['pokemonAnterior'] = "";
?>
<html>
    <head>
        <script src="//www.devmedia.com.br/js/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </head>
    <style>
        body {
            background-color:#121212;
            color: #828282;
        }
        .card {
            border: 1px solid #1E1E1E;
            background-color:#121212;
        }
        .card .card-header {
            background-color:#3a3939;
            color:#c9b552;
            font-weight:bold;
        }
        .card .card-body {
            background-color: #1E1E1E;
        }
        #original div {
            margin:auto;
        }
        #pokemao {
            font-style: italic;
        }
        #btnFizTroca, #btnConsultar {
            background: #c9b552;
            border: #c9b552;
        }
        .form-control-plaintext {
            border: 1px solid #DADADB;
            color: #dadada;
            padding: 0.375rem;
            border-radius: 5px;
        }

        #countDown {
            font-size: 25px;
            font-weight: bold;
            margin: 0 auto;
            display: table;
            color: #c9b552;
        }

        #listaPokemons {
            float: right;
            width: 100%;
        }

        .nomeStatus {
            width:50px
        }

        .normal {
            background-color: #A8A878;
            color: black;
        }
        .fire {
            background-color: #F08030;
            color: black;
        }
        .water {
            background-color: #6890F0;
        }
        .grass {
            background-color: #78C850;
        }
        .electric {
            background-color: #F8D030;
            color:black;
        }
        .ice {
            background-color: #98D8D8;
            color:black;
        }
        .fighting {
            background-color: #C03028;
        }
        .poison {
            background-color: #A040A0;
        }
        .ground {
            background-color: #E0C068;
            color:black;
        }
        .flying {
            background-color:#A890F0;
            color: black;
        }
        .psychic {
            background-color:#F85888;
        }
        .bug {
            background-color:#A8B820;
            color: black;
        }
        .rock {
            background-color:#B8A038;
        }
        .ghost {
            background-color:#705898;
        }
        .dragon {
            background-color:#7038F8;
        }
        .dark {
            background-color:#705848;
        }
        .steel {
            background-color:#B8B8D0;
            color:black;
        }
        .fairy {
            background-color:#FF9BE1;
            color:black;
        }

    </style>
    <body>
        <div class="container">
            <div class="row justify-content-around mt-3">
                <div class="col-5">
                    <div class="card">                    
                        <div class="card-header">WHO'S THAT POKEMON</div>
                        <div class="card-body text-center">                       
                            <div class="card-text">
                                <div id="original"></div>
                                <span id="pokemao"></span>                    
                            </div>
                        </div>
                    </div>
                    <div class="card mt-4">                    
                        <div class="card-header">HORA DE TROCA \O/</div>
                        <div class="card-body">                       
                            <div class="card-text">                                         
                                <?php include_once("contador_troca.php"); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-5">
                    <div class="card">     
                        <div class="card-header">Pokemons que apareceram (e só você não viu)</div>              
                        <div class="card-body">
                            <div class="card-text">
                                <button class="btn btn-link btn-sm" id="btnLimparLista" style="float: right;"type="button">Limpar Lista</button>
                                <ul class="d-block" id="listaPokemons"></ul>
                            </div>
                        </div>
                    </div> 
                    
                    
                </div> 
                
                    
                
            </div> 
            
            <div id="sons" style="width:100%; float:left">
                <hr></hr>
                <video id="myVideo" width="200" height="150" controls >
                    <source src="videoplayback.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>            
                <video id="myVideo2" width="200" height="150" controls>
                    <source src="atier_sound.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>  
                <video id="myVideo3" width="200" height="150" controls>
                    <source src="mission_alert.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>                  
            </div>
        </div>

    </body>

    <script>
        var pokemonAnterior = "";
        var spawn = "";
        var tipoMissaoSemanal = "Fire";        
        const tiposPokemon = ['Normal','Fire', 'Water', 'Grass', 
        'Electric', 'Ice', 'Fighting', 'Poison', 'Ground', 
        'Flying', 'Psychic', 'Bug', 'Rock', 'Ghost', 'Dragon',
        'Dark', 'Steel', 'Fairy']
        
        $(document).ready(function(){
            consultaValorPCG()   
                    
            $('#btnLimparLista').click(function(){
                $('#listaPokemons').html('')
            })

            $('#btnConsultar').click(function(){
                if ($('#txtConsulta').val() != "") {
                    consultar = $('#txtConsulta').val();
                    console.log($('.tipoOpcoes:checked').val())
                    consultaDadosPokemon(consultar, $('.tipoOpcoes:checked').val())
                } 
            })
        })

        function tocaMusica(tier) {
            if(tier == 1) {
                var audio = document.getElementById('myVideo2')
            } else if (tier == 2){
                var audio = document.getElementById('myVideo3')
            } else {
                var audio = document.getElementById('myVideo')
            }
            audio.play();           
        }

        function veSeTemPokemon() {
            var src = $('#sprite-image').attr('src'); //"https://poketwitch.bframework.de/static/pokedex/sprites/front/10.gif"
            if (spawn != src) {
                if (src.includes('gif')) { 
                    spawn = src;               
                    console.log(src)
                    $.ajax({
                        url: "functions.php",
                        type: "POST",
                        data: "acao=consultaPokemon&src="+src,
                        dataType: "html"

                    }).done(function(resposta) {
                        console.log(resposta)                        
                        if (pokemonAnterior != resposta && resposta != " () ") {  
                            pokemonAnterior = resposta
                            $('#pokemao').html(resposta)   
                            $('#listaPokemons').append('<li>'+resposta+'</li>')

                            if (resposta.includes('A TIER') || resposta.includes('S TIER')) {
                                tocaMusica(1)                        
                            } else {
                                if ((tipoMissaoSemanal && resposta.includes(tipoMissaoSemanal) || resposta.includes('WANTED'))) {
                                    tocaMusica(2)
                                } else {
                                    tocaMusica(0)                                    
                                } 
                            }
                        } else if (resposta == ' () ') {
                            $('#pokemao').html(src)   
                            $('#listaPokemons').append('<li>'+src+'</li>')
                            tocaMusica(2)
                        }
                                                                                                    

                    }).fail(function(jqXHR, textStatus ) {
                        console.log("Request failed: " + textStatus);

                    }).always(function() {
                        console.log("completou");
                    });  
                } else {
                    $('#pokemao').html('Não tem pokemão :( ');
                }       
            } 
            //document.getElementById('pokemao').textContent = time;
            
        }

        function consultaValorPCG() {
            $.ajax({
                url: "functions.php",
                type: "POST",
                data: "acao=pegaPokemao",
                dataType: "html"

            }).done(function(resposta) {
                let date = new Date();
                let time = date.toLocaleTimeString();
                $('#original').html(resposta)  
                veSeTemPokemon()   
                

            }).fail(function(jqXHR, textStatus ) {
                console.log("Request failed: " + textStatus);

            }).always(function() {
                console.log("completou");
            });
            
        }

        function adaptaNome(nome) {
            var retorno = nome.replace(" ", "-")
            retorno = retorno.replace(".", "-")
            retorno = retorno.replace("'", "")
            return retorno;
        }

        function adaptaNome2(nome) {
            var retorno = nome.replace("-", " ")
            
            return retorno;
        }

        function montaTituloPokemon(id, nome) {
            nomeMaiusculo = nome.toUpperCase()
            return "<h3 class='text-center'> #"+id+" - "+ nomeMaiusculo +"</h3>"
        }

        function montaImagemPokemon(url, urlShiny) {
            var div = "";
            div += "<div class='d-block text-center'>";
                div += "<span style='width: 100px; display:inline-block'><img src='"+url+"' style='width:100px; margin: 0 auto' /><i>Normal Form</i></span>&nbsp;&nbsp;"
                div += "<span style='width: 100px; display:inline-block'><img src='"+urlShiny+"' style='width:100px; margin: 0 auto' /><i>Shiny Form</i></span>"
            div += "</div>";
            return div;
        }

        function montaStatusPokemon(s) {
            var status = "<div class='valoresStatus mt-2'>";
            var totalStatus = 0;
            for (i in s) { 
                tipoStatus = adaptaNome2(s[i]['stat']['name']);
                valorStatus = s[i]['base_stat'];
                totalStatus += valorStatus;
                status += "<span class='nomeStatus'>"+tipoStatus.toUpperCase() +":</span> "+valorStatus+"<br>"
            }
            status += "<strong>TOTAL STATUS: "+totalStatus+"</strong></div>"
            return status
        }

        function montaTiposPokemon(tipos, pArray) {
            var htmlTipo = "<div class='tiposP text-center mt-2'>"

            for (t in pArray) {
                nomeTipo = pArray[t]['type']['name'].toUpperCase();
                for (tipo in tipos) {
                    if (nomeTipo == tipos[tipo].toUpperCase()) {
                        htmlTipo += "<span class='badge col-5 "+tipos[tipo]+"'>"+nomeTipo+"</span>&nbsp;&nbsp;"
                        break;
                    }
                }                
            }

            htmlTipo += "</div>";
            return htmlTipo;

        }

        function consultaDadosPokemon(consulta, tipo) {
            consulta = adaptaNome(consulta)
            if (tipo == 'pok'){ 
                $.ajax({
                    url: "functions.php",
                    type: "GET",
                    contentType: "application/json",
                    data: "acao=consultaDadosPokemon&pokemon="+consulta,
                    dataType: "json"

                }).done(function(resposta) {
                    console.log(resposta)
                    if (resposta) {                    
                        var html = "";

                        html += montaTituloPokemon(resposta['id'], resposta['name'])
                        html += montaImagemPokemon(resposta['sprites']['front_default'], resposta['sprites']['front_shiny'])
                        html += montaTiposPokemon(tiposPokemon, resposta['types'])
                        html += montaStatusPokemon(resposta['stats'])

                        $('#divResultadoConsulta').html(html)
                    } else {
                        alert ("nao encontramos esse pokemao")
                    } 
                    

                }).fail(function(jqXHR, textStatus ) {
                    console.log("Request failed: " + textStatus);

                }).always(function(d) {
                    console.log("completou");
                });
            } else if (tipo == 'move') {
                $.ajax({
                    url: "functions.php",
                    type: "GET",
                    contentType: "application/json",
                    data: "acao=consultaMove&move="+consulta,
                    dataType: "json"

                }).done(function(resposta) {
                    if (resposta) {  
                        console.log(resposta)                  
                        var html = "";

                        $('#divResultadoConsulta').html(html)
                    } else {
                        alert ("nao encontramos esse pokemao")
                    } 
                    

                }).fail(function(jqXHR, textStatus ) {
                    console.log("Request failed: " + textStatus);

                }).always(function(d) {
                    console.log("completou");
                });
            }
        }

        const createClock = setInterval(veSeTemPokemon, 30000); 
        

    </script>

</html>