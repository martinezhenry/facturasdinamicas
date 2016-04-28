
$(document).ready(function(){
	$('#getCustomers').on('click', function(){

		getCustomersQBO();

	});
});


function getCustomersQBO(){

	console.log('getCustomersDBO');
    $.ajax({
        url: 'controller/quickbooks.php',
        data: {'method': 'getCustomersQBO' },
        method: 'post',
        dataType: 'json',
        success: function(r){
            
        console.log(r);
		 if (r != false){
                
                var html = "<table border='1'>";
                
                $.each(r, function( key, value ) {
                    html += "<tr id=''>";
                    html += "<td>" + (key+1) + "</td>";
                    html += "<td>" + value.GivenName + "</td>";
                    html += "<td>" + value.FamilyName + "</td>";
                   
                    html += "</tr>";
                    
                  });
                html += "</table>"
              $('.data').html(html);
            }

              
            
        }
    }).fail(function(r){
        console.log(r);
            $('#msg .modal-body').html('Error consultando customer(s) QBO');
            $('#msg').addClass('success');
            $('#msg').modal('toggle');
    });


}



function getEmployeesQBO(){

	console.log('getEmployeesDBO');
    $.ajax({
        url: 'controller/companies.php',
        data: {'parameters' : {'parameters':id}, 'method': 'getCompanies' },
        method: 'post',
        dataType: 'json',
        success: function(r){
            
       console.log(r);
            if (r != false){
                
                var html = "";
                
                $.each(r, function( key, value ) {
                    html += "<tr id='"+value.id+"'>";
                    html += "<td>" + (key+1) + "</td>";
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
        console.log(r);
            $('#msg .modal-body').html('Error consultando la(s) compañia(s)');
            $('#msg').addClass('success');
            $('#msg').modal('toggle');
    });


}



function getAccountsQBO(){

	console.log('getAccountsDBO');
    $.ajax({
        url: 'controller/companies.php',
        data: {'parameters' : {'parameters':id}, 'method': 'getCompanies' },
        method: 'post',
        dataType: 'json',
        success: function(r){
            
       console.log(r);
            if (r != false){
                
                var html = "";
                
                $.each(r, function( key, value ) {
                    html += "<tr id='"+value.id+"'>";
                    html += "<td>" + (key+1) + "</td>";
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
        console.log(r);
            $('#msg .modal-body').html('Error consultando la(s) compañia(s)');
            $('#msg').addClass('success');
            $('#msg').modal('toggle');
    });


}



function getSalesReceiptQBO(){

	console.log('getSalesReceiptDBO');
    $.ajax({
        url: 'controller/companies.php',
        data: {'parameters' : {'parameters':id}, 'method': 'getCompanies' },
        method: 'post',
        dataType: 'json',
        success: function(r){
            
       console.log(r);
            if (r != false){
                
                var html = "";
                
                $.each(r, function( key, value ) {
                    html += "<tr id='"+value.id+"'>";
                    html += "<td>" + (key+1) + "</td>";
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
        console.log(r);
            $('#msg .modal-body').html('Error consultando la(s) compañia(s)');
            $('#msg').addClass('success');
            $('#msg').modal('toggle');
    });


}


