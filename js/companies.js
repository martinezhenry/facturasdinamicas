/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function getCompanies(id) {
    console.log('getCompanies');
    $.ajax({
        url: 'controller/companies.php',
        data: {'parameters' : {'id':id}, 'method': 'getCompanies' },
        method: 'post',
        dataType: 'json',
        success: function(r){
            
       
            if (r != false){
                
                var html = "";
                
                $.each(r, function( key, value ) {
                    html += "<tr id='"+value.id+"'>";
                    html += "<td>" + value.num + "</td>";
                    html += "<td>" + value.rif + "</td>";
                    html += "<td>" + value.razon + "</td>";
                    html += "<td>" + value.dir + "</td>";
                    html += "<td>" + value.tlf + "</td>";
                    html += "<td><a class='edit icon'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a><a class='delete'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a></td>";
                    html += "</tr>";
                    
                  });
                $('#companies tbody').html(html);
            }
        }
    }).fail(function(r){
            $('#msg .modal-body').html('Error consultando la(s) compañia(s)');
            $('#msg').addClass('success');
            $('#msg').modal();
    });
}



function putCompany() {
    
    
    var company = new Object();
    company.razon = $('#razon-txt').val();
    company.dir = $('#dir-txt').val();
    company.tlf = $('#tlf-txt').val();
    company.rif = $('#rif-txt').val();
    
    
    company = JSON.stringify(company);
    
    
    
    $.ajax({
        url: 'controller/companies.php',
        data: {'parameters' : {'company':company}, 'method': 'putCompany' },
        method: 'post',
        dataType: 'json',
        success: function(r){

            if (r != false){
                
              
                $('#msg .modal-body').html('Compañia Creada.');
                $('#msg').addClass('success');
                $('#msg').modal();
                $('#form-company')[0].reset();
            }
        }
    }).fail(function(r){
        $('#msg').html('Error getting companies');
        $('#msg').addClass('error');
    });
}




function editCompany() {
        var company = new Object();
    company.razon = $('#razon-txt').val();
    company.dir = $('#dir-txt').val();
    company.tlf = $('#tlf-txt').val();
    company.rif = $('#rif-txt').val();
    company.id = $('#id-txt').val();
    
    company = JSON.stringify(company);
    $.ajax({
        url: 'controller/companies.php',
        data: {'parameters' : {'company':company}, 'method': 'editCompany' },
        method: 'post',
        dataType:'json',
        success: function(r){
            
            
            if (r != false){

                
            $('#msg .modal-body').html('Compañia Actualizada.');
                $('#msg').addClass('success');
                $('#msg').modal();
                $('.edi-company').removeClass('edi-company').addClass('cre-company');
                $('#form-company')[0].reset();
                getCompanies();
            }
        }
    }).fail(function(r){
        console.log(r);
        $('#msg .modal-body').html('Error editing Company.');
                $('#msg').addClass('error');
                $('#msg').modal();
    });
}

/**
 * Comment
 */
function loadDataEditCompany(id) {
   
    var datas = $('#'+id+' td');
    
    $('#id-txt').val(id);
    $('#razon-txt').val(datas.eq(2).text());
    $('#dir-txt').val(datas.eq(3).text());
    $('#tlf-txt').val(datas.eq(4).text());
    $('#rif-txt').val(datas.eq(1).text());
   $('.cre-company').removeClass('cre-company').addClass('edi-company');
    
}


function deleteCompany(id) {
    console.log('getCompanies');
    $.ajax({
        url: 'controller/companies.php',
        data: {'parameters' : {'id':id}, 'method': 'deleteCompany' },
        method: 'post',
        dataType: 'json',
        success: function(r){
            
       
              if (r != false){

                
            $('#msg .modal-body').html('Compañia Eliminada.');
                $('#msg').addClass('success');
                $('#msg').modal();
                $('.edi-company').removeClass('edi-company').addClass('cre-company');
              
                getCompanies();
            }
        }
    }).fail(function(r){
            $('#msg .modal-body').html('Error consultando la(s) compañia(s)');
            $('#msg').addClass('success');
            $('#msg').modal();
    });
}

$(document).ready(function(){

    $('body').on('click', '.edit', function(){
        loadDataEditCompany($(this).parent().parent().attr('id'));
    });
    
     $('body').on('click', '.delete', function(){
        loadDataEditCompany($(this).parent().parent().attr('id'));
    });
    
    
    $('body').on('click', '.cre-company', function(){
        putCompany();
    });
    
      $('body').on('click', '.edi-company', function(){
        editCompany();
    });
    
    
    
    getCompanies();
           
});