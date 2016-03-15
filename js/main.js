/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function getListCompanies(){
        $.ajax({
        url: 'controller/companies.php',
        data: {'method': 'getCompanies' },
        method: 'post',
        dataType:'json',
        success: function(r){
            console.log(r);
            
            if (r != false){
                
                var html = "";
                
                $.each(r, function( key, value ) {
                    html += "<option value='"+value.rif+"'>";
                    html += value.razon;
                    html += "</<option>";
                    
                  });
                $('#emp-box').append(html);
            }
        }
    }).fail(function(r){
        $('#msg').html('Error getting companies');
    });
}


function refreshProducts() {
    console.log('resfresh');
    
    $.ajax({
         url: 'readExcel.php',
        type: 'POST',
        data: {},
        dataType: 'json',
        success: function(r){
              console.log(r);
            if (r != false){
                
                var html = "";
                var count=0;
                var subTotal=0.0;
                var total = 0.0;
                var impuesto = parseInt($('#impuesto-txt').val());
                var descuento = parseFloat($('#descuento-txt').val());
                console.log(descuento);
                console.log(impuesto);
                var montoDescuento=0.0;
                
                $.each(r, function( key, value ) {
                    count = count + 1;
                    subTotal = (parseFloat(subTotal) + parseFloat((value.total).replace(',','')));
                    console.log(subTotal);
                    html += "<tr >";
                    html += "<td>" + (key+1) + "</td>";
                    html += "<td>" + value.cant + "</td>";
                    html += "<td>" + value.desc + "</td>";
                    html += "<td>" + value.prec + "</td>";
                    html += "<td>" + value.total + "</td>";
                  // html += "<td><a class='edit icon'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a><a class='delete'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a></td>";
                    html += "</tr>";
                    
                  });
                $('#products tbody').html(html);
                $('#details-products').val(count);
                $('#sub-total-txt').val(subTotal.formatMoney(2, '.', ','));
                montoDescuento = parseFloat(subTotal - descuento);
                console.log(montoDescuento);
                $('#total-txt').val((montoDescuento + parseFloat((montoDescuento * impuesto)/100)).formatMoney(2, '.', ','));
            }
        }
        
        
    });
    
}


Number.prototype.formatMoney = function(c, d, t){
var n = this, 
    c = isNaN(c = Math.abs(c)) ? 2 : c, 
    d = d == undefined ? "." : d, 
    t = t == undefined ? "," : t, 
    s = n < 0 ? "-" : "", 
    i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", 
    j = (j = i.length) > 3 ? j % 3 : 0;
   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
 };

/**
 * Comment
 */
function loadFile(event) {
    var files = event.target.files;
  
    // Create a formdata object and add the files
    var data = new FormData();
    $.each(files, function(key, value)
    {
        data.append(key, value);
    });
    $.ajax({
        url: 'uploadFile.php?files',
        type: 'POST',
        data: data,
        cache: false,
        dataType: 'json',
        processData: false, // Don't process the files
        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
        success: function(data, textStatus, jqXHR)
        {
            if(typeof data.error === 'undefined')
            {
                // Success so call function to process the form
                $('#infile').filestyle('clear');
                refreshProducts();
            }
            else
            {
                // Handle errors here
                console.log('ERRORS: ' + data.error);
            }
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            // Handle errors here
            console.log('ERRORS: ' + textStatus);
            // STOP LOADING SPINNER
        }
    });
    
}


function putPedido() {
    
    var pedido = new Object();
    pedido.num_invoice = $('#invoice-box').val();
    pedido.num_orden = $('#order-box').val();
    pedido.fecha_emision = $('#fecha-box').val();
    pedido.cliente_rif = $('#rif-txt').val();
    pedido.empresa_rif = $('#emp-box').val();
    pedido.sub_total = $('#sub-total-txt').val();
    pedido.sale_tax = $('#impuesto-txt').val();
    pedido.discount = $('#descuento-txt').val();
    pedido.freight = $('#carga-txt').val();
    pedido.handling = $('#entrega-txt').val();
    pedido.restocking = $('#repo-txt').val();
    pedido.total_sale = $('#total-txt').val();
    pedido.detalle = [];
    var detalle = new Object();
    
    $('#products tbody tr').each(function(k,v) {
        
        detalle.num_invoice = $('#invoice-box').val(),
        detalle.qty = $(v).find("td").eq(1).html(),
        detalle.descripcion = $(v).find("td").eq(2).html(),
        detalle.precio_unit = $(v).find("td").eq(3).html(),
        detalle.sub_total = $(v).find("td").eq(4).html();
        
        (pedido.detalle).push(detalle);
        detalle = new Object();
    });
   
    
    //pedido = JSON.stringify(pedido);
    
console.log(pedido);
    
     $.ajax({
        url: 'controller/pedidos.php',
        data: {'method': 'putPedido', 'parameters' : { 'pedido': pedido  } },
        method: 'post',
        dataType:'json',
        success: function(r){
            console.log(r);
            
            if (r != false && r.error == 'undefined'){
                
                $('#msg .modal-body').html('Pedido Creada.');
                $('#msg').addClass('success');
                $('#msg').modal('toggle');
     
            } else {
                $('#msg .modal-body').html(r.error);
                $('#msg').addClass('error');
                $('#msg').modal('toggle');
            }
        }
    }).fail(function(r){
        $('#msg').html('Error getting companies');
        console.log('error: ' + r);
    });
    
}



function callReport(){
    
    
    
}


function uploadLogo(){
    
    var files = event.target.files;
    console.log(files);
    // Create a formdata object and add the files
    var data = new FormData();
    $.each(files, function(key, value)
    {
        data.append(key, value);
    });
    
    console.log(data);
    
   
    $.ajax({
        url: 'uploadFile.php?lg',
        type: 'POST',
        data: data,
        cache: false,
        dataType: 'json',
        processData: false, // Don't process the files
        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
        success: function(data, textStatus, jqXHR)
        {
            if(typeof data.error === 'undefined')
            {
                // Success so call function to process the form
                $('#file-logo').filestyle('clear');
              //  refreshProducts();
            }
            else
            {
                // Handle errors here
                console.log('ERRORS: ' + data.error);
            }
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            // Handle errors here
            console.log('ERRORS: ' + textStatus);
            // STOP LOADING SPINNER
        }
    });
    
}

/**
 * Comment
 */
function findCustomer() {
    
    var rif = $('#rif-txt').val();
    var cliente = new Object();
    console.log('rif: '+ rif);
    cliente.rif = rif;
    
        $.ajax({
        url: 'controller/crud.php',
        data: {'functionname': 'buscar_cliente', 'arguments': cliente },
        method: 'post',
        dataType:'json',
        success: function(r){
            console.log(r);

                
                var html = "";
                
                 if(!('error' in r)){
                
                $('#msg .modal-body').html(r.result['TELEFONO']);
                $('#msg').addClass('success');
                $('#msg').modal('toggle');
     
            } else {
                $('#msg .modal-body').html(r.error);
                $('#msg').addClass('error');
                $('#msg').modal('toggle');
            }
            
        }
    }).fail(function(r){
        console.log('Error find customer:' + r);
        $('#msg').html('Error getting companies');
    });
    
}


$(document).ready(function(){

//$(":file").filestyle();



    $('body').on('click', '.edit', function(){
        editCompany(this).parent().parent().attr('id');
    });
    
        $('body').on('click', '#find-custumer', function(){
        findCustomer();
    });
    
    
    
    
    getListCompanies();
    
    $('#infile').change(loadFile);
    
    $('#file-logo').change(uploadLogo);
    
    
    
     $('#fec-box').datepicker({dateFormat: 'dd/mm/yy'});
     
     $('#generar-pedido').on('click', function(){
        putPedido();
    });
    
    
    
});

