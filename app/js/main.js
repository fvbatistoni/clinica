$(function(){
    "use strict";

    // Show/Hide Adult/Child Inputs
    // if ($("#type").val() == "adult") {
     
    //     $(".child").hide();
    //     $(".adult").show();
    
    // } else {
    
    //     $(".adult").hide();
    //     $(".child").show();
    
    // }

    // Show/Hide Adult/Child Inputs
    $('#adultType').on("click", function(){
        $(".adult").show();
        $(".adolescent").hide();
    });

    $('#adolescentType').on("click", function(){
        $(".adult").hide();
        $(".adolescent").show();
    });


    // Form Submission    
    $("#calculadora_calorias").submit(function(e) {

        // Initialize Variables
        var zmi, bmi, bmiZScore, bmiPercentile, metsZScore, metsPercentile;

        // Prevent Post
        e.preventDefault();
        
        // Validate Input
        var input = $(this).validate(); 
        
        // If Input Is Valid
        if(input.valid()) {

            // Store Data & Create Object
            var userData = $("#calculadora_calorias").serializeObject();
            zmi = new ZMI(userData);

            // Determine If Child Or Adult
            if (userData.type == "adolescent") {

                bmi = Math.round(zmi.bmi()*100)/100;
                bmiZScore = Math.round(zmi.bmiZScore()*100)/100;
                bmiPercentile = Math.round(zmi.bmiPercentile()*10)/10;
                metsZScore = Math.round(zmi.metsZScore()*100)/100;
                metsPercentile = Math.round(zmi.metsPercentile()*10)/10;

                var hoje = moment();
                var nascimento = moment(userData.birthdate);
                var idade = moment.duration(hoje.diff(nascimento));
                var idade_em_meses = hoje.diff(nascimento, "months");

                var weight = userData.weight;
                var height = userData.height;
                var gender = Math.abs(userData.gender);
                var sobrepeso = Math.abs(userData.sobrepeso);
                var atividade = Math.abs(userData.atividade);
                var emagrece = Math.abs(userData.emagrece);
                var engorda = Math.abs(userData.engorda);
                var total_c = userData.total_c;
                var total_p = userData.total_p;
                var total_l = userData.total_l;
              
                // Identifica o paciente no cabeçalho do formulário após submeter
                if(gender==1){
                    $('#identificacao').show().html('<strong>Menino</strong>, ' + idade.years() + ' anos, ' + idade.months() + ' meses');
                } else {
                    $('#identificacao').show().html('<strong>Menina</strong>, ' + idade.years() + ' anos, ' + idade.months() + ' meses');
                }
            
                // Exibe o percentil do peso no campo de IMC
                $('#result').show().html(
                    bmi + 'kg/m&sup2; (' + bmiPercentile + '%)'
                );

                // Define a variável 'sobrepeso' para depois fazer os cálculos
                if(bmiPercentile>85){
                    var sobrepeso = 1;
                    $('input:radio[name=sobrepeso][value=1]').prop('checked', true);
                } else {
                    var sobrepeso = 2;
                    $('input:radio[name=sobrepeso][value=2]').prop('checked', true);
                }

    // Começa a mágica dos cálculos:
    // Define variável 'af'
    // $af = atividade física
    if ((gender == 1) && (atividade == 1)) {
        var af = 1.0;
    } else if ((gender == 1) && (atividade == 2)) {
        var af = 1.13;
    } else if ((gender == 1) && (atividade == 3)) {
        var af = 1.26;
    } else if ((gender == 1) && (atividade == 4)) {
        var af = 1.42;
    } else if ((gender == 2) && (atividade == 1)) {
        var af = 1.0;
    } else if ((gender == 2) && (atividade == 2)) {
        var af = 1.16;
    } else if ((gender == 2) && (atividade == 3)) {
        var af = 1.31;
    } else if ((gender == 2) && (atividade == 4)) {
        var af = 1.56;
    }


    // Fórmulas por FAIXA ETÁRIA e SEXO   
    // Define variável EER = Estimated Enery Requirements
    switch (true) {
        case (idade_em_meses <= 3): 
        var EER = ((weight*89)-100)+175; 
        break;
        case (4 <= idade_em_meses &&  idade_em_meses <= 6): 
        var EER = ((weight*89)-100)+56; 
        break;
        case (7 <= idade_em_meses &&  idade_em_meses <= 12): 
        var EER = ((weight*89)-100)+22; 
        break;
        case (13 <= idade_em_meses &&  idade_em_meses <= 35): 
        var EER = ((weight*89)-100)+20; 
        break;
        // 3-18 anos SEM sobrepeso
        case (36 <= idade_em_meses &&  idade_em_meses <= 95 && gender == 1 && sobrepeso == 2): 
        var EER = Math.round(88.5-(61.9*idade.years())+(af*((26.7*weight)+(903*height/100)))+20); 
        break;
        case (36 <= idade_em_meses &&  idade_em_meses <= 95 && gender == 2 && sobrepeso == 2): 
        var EER = Math.round(135.3-(30.8*idade.years())+(af*((10*weight)+(934*height/100)))+20); 
        break;
        case (96 <= idade_em_meses &&  idade_em_meses <= 215 && gender == 1 && sobrepeso == 2): 
        var EER = Math.round(88.5-(61.9*idade.years())+(af*((26.7*weight)+(903*height/100)))+25); 
        break;
        case (96 <= idade_em_meses &&  idade_em_meses <= 215 && gender == 2 && sobrepeso == 2): 
        var EER = Math.round(135.3-(30.8*idade.years())+(af*((10*weight)+(934*height/100)))+25); 
        break;
        // 3-18 anos COM sobrepeso
        case (36 <= idade_em_meses &&  idade_em_meses <= 215 && gender == 1 && sobrepeso == 1): 
        var EER = Math.round(114-(50.9*idade.years())+(af*((19.5*weight)+(1161.4*height/100)))); 
        break;
        case (36 <= idade_em_meses &&  idade_em_meses <= 215 && gender == 2 && sobrepeso == 1): 
        var EER = Math.round(389-(41.2*idade.years())+(af*((15*weight)+(701.6*height/100)))); 
        break;
        // Adultos >18anos SEM sobrepeso
        case (idade_em_meses >= 216 && gender == 1 && sobrepeso == 2): 
        var EER = Math.round(662-(9.53*idade.years())+(af*((15.91*weight)+(539.6*height/100)))); 
        break;
        case (idade_em_meses >= 216 && gender == 2 && sobrepeso == 2): 
        var EER = Math.round(354-(6.91*idade.years())+(af*((9.36*weight)+(726*height/100)))); 
        break;
        // Adultos >18anos COM sobrepeso
        case (idade_em_meses >= 216 && gender == 1 && sobrepeso == 1): 
        var EER = Math.round(1086-(10.1*idade.years())+(af*((13.7*weight)+(416*height/100)))); 
        break;
        case (idade_em_meses >= 216 && gender == 2 && sobrepeso == 1): 
        var EER = Math.round(448-(7.95*idade.years())+(af*((11.4*weight)+(619*height/100)))); 
        break;
    }

    // Cálculo de Manutenção / Perda / Ganho
    switch (true) {
        case (atividade == 1):
        var FatorEF = 1.2;
        break;
        case (atividade == 2):
        var FatorEF = 1.375;
        break;        
        case (atividade == 3):
        var FatorEF = 1.55;
        break;
        case (atividade == 4):
        var FatorEF = 1.725;
        break;
        case (atividade == 5):
        var FatorEF = 1.9;
        break;
    }

    var metabolismo = Math.round(EER*FatorEF);
    var para_perder = Math.round(metabolismo-(500*emagrece*2.2));
    var para_ganhar = Math.round(metabolismo-(500*engorda*2.2));

    var box_manter = '<div class="alert alert-info" style="padding:7px;"><small><strong>Para manter</strong> o peso atual<br>é preciso consumir <strong>' + metabolismo +'</strong>kcal/dia</small><br>'+
                    '<table width="100%">'+
                    '<tr><td></td><td></td><td class="alinha_a_direita"><i class="fas fa-utensils"></i></td></tr>'+
                            '<tr>'+
                                '<td>Carbohidratos (55%)</td>'+
                                '<td class="alinha_a_direita">'+Math.round((metabolismo*0.55)/4)+'</td>'+
                                '<td class="alinha_a_direita">'+Math.round(((metabolismo*0.55)/4)/total_c)+'%</td>'+
                            '</tr>'+
                            '<tr>'+
                                '<td>Proteínas (15%)</td>'+
                                '<td class="alinha_a_direita">'+Math.round((metabolismo*0.15)/4)+'</td>'+
                                '<td class="alinha_a_direita">'+Math.round(((metabolismo*0.15)/4)/total_p)+'%</td>'+
                            '</tr>'+
                            '<tr>'+
                                '<td>Gorduras (30%)</td>'+
                                '<td class="alinha_a_direita">'+Math.round((metabolismo*0.3)/9)+'</td>'+
                                '<td class="alinha_a_direita">'+Math.round(((metabolismo*0.3)/9)/total_l)+'%</td>'+
                            '</tr>'+
                        '</table></div>';
    var box_emagrecer = '<div class="alert alert-success" style="padding:7px;"><small><strong>Para perder '+ emagrece +'</strong>kg por semana<br>é preciso consumir <strong>' + para_perder +'</strong>kcal/dia</small><br>'+
                    '<table width="100%">'+
                    '<tr><td></td><td></td><td class="alinha_a_direita"><i class="fas fa-utensils"></i></td></tr>'+
                            '<tr>'+
                                '<td>Carbohidratos (55%)</td>'+
                                '<td class="alinha_a_direita">'+Math.round((para_perder*0.55)/4)+'</td>'+
                                '<td class="alinha_a_direita">'+Math.round(((para_perder*0.55)/4)/total_c)+'%</td>'+
                            '</tr>'+
                            '<tr>'+
                                '<td>Proteínas (15%)</td>'+
                                '<td class="alinha_a_direita">'+Math.round((para_perder*0.15)/4)+'</td>'+
                                '<td class="alinha_a_direita">'+Math.round(((para_perder*0.15)/4)/total_p)+'%</td>'+
                            '</tr>'+
                            '<tr>'+
                                '<td>Gorduras (30%)</td>'+
                                '<td class="alinha_a_direita">'+Math.round((para_perder*0.3)/9)+'</td>'+
                                '<td class="alinha_a_direita">'+Math.round(((para_perder*0.3)/9)/total_l)+'%</td>'+
                            '</tr>'+
                        '</table></div>';
    var box_engordar = '<div class="alert alert-warning" style="padding:7px;"><small><strong>Para ganhar '+ engorda +'</strong>kg por semana<br>é preciso consumir <strong>' + para_ganhar +'</strong>kcal/dia</small><br>'+
                    '<table width="100%">'+
                    '<tr><td></td><td></td><td class="alinha_a_direita"><i class="fas fa-utensils"></i></td></tr>'+
                            '<tr>'+
                                '<td>Carbohidratos (55%)</td>'+
                                '<td class="alinha_a_direita">'+Math.round((para_ganhar*0.55)/4)+'</td>'+
                                '<td class="alinha_a_direita">'+Math.round(((para_ganhar*0.55)/4)/total_c)+'%</td>'+
                            '</tr>'+
                            '<tr>'+
                                '<td>Proteínas (15%)</td>'+
                                '<td class="alinha_a_direita">'+Math.round((para_ganhar*0.15)/4)+'</td>'+
                                '<td class="alinha_a_direita">'+Math.round(((para_ganhar*0.15)/4)/total_p)+'%</td>'+
                            '</tr>'+
                            '<tr>'+
                                '<td>Gorduras (30%)</td>'+
                                '<td class="alinha_a_direita">'+Math.round((para_ganhar*0.3)/9)+'</td>'+
                                '<td class="alinha_a_direita">'+Math.round(((para_ganhar*0.3)/9)/total_l)+'%</td>'+
                            '</tr>'+
                        '</table></div>';

    // Envia as Análises para os campos
    switch (true) {
        case (emagrece > 0 && engorda == 0):
        $('#analise').show().html('<div class="row"><div class="col-md-6">'+box_manter+'</div><div class="col-md-6">'+box_emagrecer+'</div></div>');
        $('#card_cardapio').addClass('collapsed-card');
        $('#card_analise').removeClass('collapsed-card');
        break;
        case (emagrece == 0 && engorda > 0):
        $('#analise').show().html('<div class="row"><div class="col-md-6">'+box_manter+'</div><div class="col-md-6">'+box_engordar+'</div></div>');
        $('#card_cardapio').addClass('collapsed-card');
        $('#card_analise').removeClass('collapsed-card');
        break;
        case (emagrece > 0 && engorda > 0):
        $('#analise').show().html('<div class="row"><div class="col-md-4">'+box_manter+'</div><div class="col-md-4">'+box_emagrecer+'</div><div class="col-md-4">'+box_engordar+'</div></div>');
        $('#card_cardapio').addClass('collapsed-card');
        $('#card_analise').removeClass('collapsed-card');
        break;
    }

  

    console.log(emagrece);
        
            } else if (userData.type == "adult") {

                metsZScore = Math.round(zmi.metsZScore()*100)/100;
                metsPercentile = Math.round(zmi.metsPercentile()*10)/10;

                // Display Adult Data On Page
                $('#result').show().html(
                    '<table><tr><td>MetS Z-Score<br /><span class="resultNum"> ' + metsZScore + '</span></td><td>MetS Percentile<br /><span class="resultNum">' + metsPercentile + "%</span></td></tr></table>"
                );

            }


        } else {
            
            // Return False & Validation Kicks In
            return false;

        }
    
    });
    
    // Log Calculations
    // console.log("BMI: " + zmi.bmi());
    // console.log("BMI Z-Score: " + zmi.bmiZScore());
    // console.log("BMI Percentile: " + zmi.bmiPercentile());
    // console.log("MetS Z-Score: " + zmi.metsZScore());
    // console.log("MetS Percentile: " + zmi.metsPercentile());

});