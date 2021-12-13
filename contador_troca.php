

<span id="countDown" class="mb-3" style="display:none;"></span>

<label class="d-block" style="text-style:italic">Tipo de horário</label>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" checked=checked>
  <label class="form-check-label" for="inlineRadio1">Acabei de trocar</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
  <label class="form-check-label" for="inlineRadio2">Tempo Exato para terminar</label>
</div>

<div class="mb-3 mt-3 row divHorario" style="display:none">
    <label for="horarioExato" class="col-sm-6 col-form-label">Horário para Acabar</label>
    <div class="col-sm-6">
        <input type="time" class="form-control-plaintext" id="horarioExato" name="horarioExato" min="00:00" max="03:00">
    </div>
</div>

<div class="text-center">
    <button class="btn btn-light mt-3" type="button" id="btnFizTroca">Ativa Contador Troca PCG</button>
    <button class="btn btn-link mt-3" type="button" id="btnReseta">Resetar Contador</button>
</div>


<script>

    Date.prototype.addHours = function(h) {
        this.setTime(this.getTime() + (h*60*60*1000));
        return this;
    }

    function timeToMins(time) {
        var b = time.split(':');
        return b[0]*60 + +b[1];
    }

    // Convert minutes to a time in format hh:mm
    // Returned value is in range 00  to 24 hrs
    function timeFromMins(mins) {
        function z(n){return (n<10? '0':'') + n;}
        var h = (mins/60 |0) % 24;
        var m = mins % 60;
        return z(h) + ':' + z(m);
    }

    // Add two times in hh:mm format
    function addTimes(t0, t1) {
        return timeFromMins(timeToMins(t0) + timeToMins(t1));
    }


    $('#inlineRadio2').click(function(){
        $('.divHorario').show();
        $('#horarioExato').html('');
    })
    $('#inlineRadio1').click(function(){
        $('.divHorario').hide();
    })

    $('#btnFizTroca').click(function(){
        $('#countDown').show()
        clearInterval(x);
        if ($('#inlineRadio1').prop('checked')) {
            countDownDate = new Date().addHours(3);
        } else {
            date = new Date();            
            horario = addTimes($('#horarioExato').val(), date.getHours() + ":" + date.getMinutes())
            countDownDate = new Date (new Date().toDateString() + ' ' + (horario+':00'))
        }

        // Update the count down every 1 second
        var x = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for hours, minutes and seconds
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the element with id="demo"
            document.getElementById("countDown").innerHTML = hours + "h "+ minutes + "m " + seconds + "s ";

            // If the count down is finished, write some text
            if (distance < 0) {
                clearInterval(x);
                tocaMusica(0)
                $('#countDown').html('HORA DE FAZER TROCA');
            }

            $('#btnReseta').click(function(){
                clearInterval(x);
                $('#countDown').html('')
            })
        }, 1000);

        
    })
    
</script>