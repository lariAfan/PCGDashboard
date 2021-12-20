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
        #btnFizTroca {
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
                <video id="myVideo4" width="200" height="150" controls>
                    <source src="xmas_sound.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>  
            </div>
        </div>

    </body>

    <script>
        var pokemonAnterior = "";
        var spawn = "";
        var tipoMissaoSemanal = "";
        
        $(document).ready(function(){
            consultaValorPCG()            

            $('#btnLimparLista').click(function(){
                $('#listaPokemons').html('')
            })
        })

        function tocaMusica(tier) {
            if(tier == 1) {
                var audio = document.getElementById('myVideo2')
            } else if (tier == 2){
                var audio = document.getElementById('myVideo3')
            } else if (tier == 3){
                var audio = document.getElementById('myVideo4')
            } else {
                var audio = document.getElementById('myVideo')
            }
            audio.play();           
        }

        function veSeTemPokemon() {
            var src = $('#sprite-image').attr('src'); //"https://poketwitch.bframework.de/static/pokedex/sprites/front/91.gif"
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
                        if (pokemonAnterior != resposta) {  
                            pokemonAnterior = resposta
                            $('#pokemao').html(resposta)   
                            $('#listaPokemons').append('<li>'+resposta+'</li>')

                            if (resposta.includes('A TIER')) {
                                tocaMusica(1)                        
                            } else {
                                if (tipoMissaoSemanal && resposta.includes(tipoMissaoSemanal)) {
                                    tocaMusica(2)
                                } else {
                                    if (resposta.includes('Eletric') || resposta.includes('Ice') || resposta.includes('Steel') ) {
                                        tocaMusica(3)
                                    }else {
                                        tocaMusica(0)
                                    } 
                                } 
                            }
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

        const createClock = setInterval(veSeTemPokemon, 30000); 
        

    </script>

</html>