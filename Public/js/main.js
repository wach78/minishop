/**
 * 
 */
$(document).ready(function() {
	
	(function($){

		(function($){

			$.log = function(value) {
				if (console)
					console.log(value);
			};

			$.log.group = function(value) {
				if (console && console.group)
					console.group(value);
			}; 

			$.log.groupEnd = function(){
				if (console && console.group)
					console.groupEnd();
			};
		}(jQuery));
		
		$.ajaxError = function(jqXHR,textStatus,errorThrown) {
			$.log.group('ajax errors');
			$.log(jqXHR.responseText);
			$.log('jqXHR.status: ' + jqXHR.status);
			$.log('textStatus: ' + textStatus);
			$.log('readyState: ' + jqXHR.readyState);
			$.log('error Thrown: ' + errorThrown);

			$.log.group('parseJSON(jqXHR.responseText)');
			var r = jQuery.parseJSON(jqXHR.responseText);
			$.log("Message: " + r.Message);
			$.log("StackTrace: " + r.StackTrace);
			$.log.groupEnd();
			$.log("ExceptionType: " + r.ExceptionType);
			$.log.groupEnd();
		};
	}(jQuery));

	$('body').on('click','.toggleshow',function(e){

			var input = $(this).closest('.form-group').find('input');
			
			var id =  input.attr('id');
			var type = input.attr('type');
			
			if (type == 'password')
			{
				$('#'+id).prop('type','text');
				$('#eye').attr('class','fa fa-eye-slash');
				$('#eye').attr('title','Dölj');
			}
			else
			{
				$('#'+id).prop('type','password');
				$('#eye').attr('title','Visa');
			}	
		});
	
	$('#tblproducts').DataTable({
		 "language": {
				 "sEmptyTable": "Tabellen innehåller ingen data",
				 "sInfo": "Visar _START_ till _END_ av totalt _TOTAL_ rader",
				 "sInfoEmpty": "Visar 0 till 0 av totalt 0 rader",
				 "sInfoFiltered": "(filtrerade från totalt _MAX_ rader)",
				 "sInfoPostFix": "",
				 "sInfoThousands": " ",
				 "sLengthMenu": "Visa _MENU_ rader",
				 "sLoadingRecords": "Laddar...",
				 "sProcessing": "Bearbetar...",
				 "sSearch": "Sök:",
				 "sZeroRecords": "Hittade inga matchande resultat",
				 "oPaginate": {
					 "sFirst": "Första",
					 "sLast": "Sista",
					 "sNext": "Nästa",
					 "sPrevious": "Föregående"
				 },
				 "oAria": {
					 "sSortAscending": ": aktivera för att sortera kolumnen i stigande ordning",
					 "sSortDescending": ": aktivera för att sortera kolumnen i fallande ordning"
				 }
	        },
	  
	        "order": [[1, "desc"]], 
	        "columnDefs": [
	        { 
	        	"targets": [0], 
	        	"searchable": false, 
	        	"orderable": false, 
	        	"visible": true 
	        },
	        { 
	        	"targets": [1,2,3,4,5], 
	        	"searchable": true, 
	        	"orderable": true, 
	        	"visible": true 
	        },
	        ]
	        
		 
	 });
	
	 $('body').on('click','.delbtn',function(){
			 
			 return ConfirmDelete();     
	 });
	 
	 $(".frmaddtocart").submit(function(e){
         e.preventDefault(e);
     });
	 
	 
	 $('body').on('click','.btnaddproduct',function(){
		 
		// var input = $(this).closest('.card').find('input');
		 //var id =  input.attr('id');
		
		 var input = $(this).closest('.frmaddtocart').find('input[name="PID"]');
		 var id =  input.val();
		
		 var csrfToken = $('.frmaddtocart input[name="csrf_token"]').val();
		 
		 
		 $.ajax({
				url: 'Shops/ajaxgetoneproduct',
				type: "post",
				data:{
					PID : id,
					csrf_token : csrfToken
				},
				datatype: 'json',
				success:function(data){
				
					var d = JSON.parse(data);
				
					
					var totalsum = 0;
					var price = 0;
					var num = 1;
					var sum = 0;
					
					var rows = $('#shoppingCartModal').find('.row').not('#firstrow');
				
					if (rows.length == 0)
					{
						$('#shoppingCartModal #firstrow').after(cartRow(d));
						price = $('#pr'+id).text();

						num = $('input[name="quant['+id +']"]').val();
						if (typeof num === "undefined")
						{
							num = 1;
						}
						var x = parseInt(price);
						var y = parseInt(num);
						sum = x * y;
					
						$('#sum'+id).text(sum)
						totalsum = parseInt(totalsum) + parseInt(sum);

						

					}
					else
					{
						
						var append = true;
						var ID;
						
						$.each(rows, function( index, value ) {
							ID = $(this).attr('id');
							
							if (ID == id)
							{
								append  = false;
							}
						});
						
						if (append == true)
						{
							$('#shoppingCartModal #firstrow').after(cartRow(d));
						}
						else
						{
							var oldvalue = $('input[name="quant['+id +']"]').val();
							oldvalue++;
							var newvalue = oldvalue;
							$('input[name="quant['+id +']"]').val(newvalue);
						}
						rows = $('#shoppingCartModal').find('.row').not('#firstrow');
						$.each(rows, function( index, value ) {
							// Bättre att hämta pris från databas
							ID = $(this).attr('id');
	
							if (ID == id)
							{
								price = $('#pr'+ID).text();

								num = $('input[name="quant['+ID +']"]').val();
								if (typeof num === "undefined")
								{
									num = 1;
								}
								
								var x = parseInt(price);
								var y = parseInt(num);
								sum = x * y;
							
								$('#sum'+ID).text(sum)
								totalsum = parseInt(totalsum) + parseInt(sum);
							
							}
							else
							{
								price = $('#pr'+ID).text();
								
								num = $('input[name="quant['+ID +']"]').val();
								if (typeof num === "undefined")
								{
									num = 1;
								}
								
								sum = parseInt(price) * parseInt(num);
								totalsum = parseInt(totalsum) + parseInt(sum);
								
							}
	
						});
					}
			
					$('#totsum').text(totalsum);
					

				},
				error:function(jqXHR,textStatus,errorThrown){
					$.ajaxError(jqXHR,textStatus,errorThrown);
	
				}  
			}); // ajax  
			
			
	 });
	 
	
	 $('body').on('click','.removerow',function(e){
	
		 var row = $(this).closest('.row');
		 var id = row.attr('id');
		 $('#'+id).remove();
		 countsum(id);
	 });
	 
	 
	 //$('.btn-number').click(function(e){
	 $('body').on('click','.btn-number',function(e){
		    e.preventDefault();
		    
		    var fieldName = $(this).attr('data-field');
		    var type      = $(this).attr('data-type');
		    var input = $("input[name='"+fieldName+"']");
		    var currentVal = parseInt(input.val());
		    if (!isNaN(currentVal)) 
		    {
		        if(type == 'minus') 
		        {
		            if(currentVal > input.attr('min')) {
		                input.val(currentVal - 1).change();
		            } 
		            if(parseInt(input.val()) == input.attr('min')) {
		                $(this).attr('disabled', true);
		            }
		            
	
		           var len = fieldName.length;
		           var id = fieldName[len-2];

		           countsum(id)
		        
		        } else if(type == 'plus') 
		        {
		            if(currentVal < input.attr('max')) {
		                input.val(currentVal + 1).change();
		            }
		            if(parseInt(input.val()) == input.attr('max')) {
		                $(this).attr('disabled', true);
		            }
		          
		            
		            var len = fieldName.length;
			        var id = fieldName[len-2];
		            
			        countsum(id)
			        

		        }
		    } else {
		        input.val(0);
		    }
		});
	 
	 
		//$('.input-number').focusin(function(){
	    $('body').on('focusin','.input-number',function(){
		   $(this).data('oldValue', $(this).val());
		   
		});
	    
		//$('.input-number').change(function() {
	    $('body').on('change','.input-number',function(){   
		    var minValue =  parseInt($(this).attr('min'));
		    var maxValue =  parseInt($(this).attr('max'));
		    var valueCurrent = parseInt($(this).val());
		    
		    var name = $(this).attr('name');
		    if(valueCurrent >= minValue) {
		        $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
		    } else {
		        alert('Sorry, the minimum value was reached');
		        $(this).val($(this).data('oldValue'));
		    }
		    if(valueCurrent <= maxValue) {
		        $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
		    } else {
		        alert('Sorry, the maximum value was reached');
		        $(this).val($(this).data('oldValue'));
		    }
		    
		    
		});
		//$(".input-number").keydown(function () {
	    $('body').on('keydown','.input-number',function(e){        
		        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 || (e.keyCode == 65 && e.ctrlKey === true) ||  (e.keyCode >= 35 && e.keyCode <= 39)) {
		                
		        	var name = $(this).attr('name');
				    var len = name.length;
			        var id = name[len-2];
			        countsum(id)
		            
			        return;
		        }
		     
		        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
		            e.preventDefault();
		        }
		    });
	 
});

function ConfirmDelete()
{
  return  confirm("Är du säker på att du vill tabort?");
}

function countsum(id)
{
	var totalsum = 0;
	var price = 0;
	var num = 1;
	var sum = 0;
	
	var rows = $('#shoppingCartModal').find('.row').not('#firstrow');
	
	var ID;
		
	$.each(rows, function( index, value ) {
		// Bättre att hämta pris från databas
		ID = $(this).attr('id');
		
		if (ID == id)
		{
			price = $('#pr'+ID).text();

			num = $('input[name="quant['+ID +']"]').val();
			if (typeof num === "undefined")
			{
				num = 1;
			}
			
			sum = parseInt(price) * parseInt(num);
		
			$('#sum'+ID).text(sum)
			totalsum = parseInt(totalsum) + parseInt(sum);
		}
		else
		{
		
			price = $('#pr'+ID).text();
			
			num = $('input[name="quant['+ID +']"]').val();
			if (typeof num === "undefined")
			{
				num = 1;
			}
			
			sum = parseInt(price) * parseInt(num);
			totalsum = parseInt(totalsum) + parseInt(sum);
		}
	});
	

	$('#totsum').text(totalsum);
	
}


function cartRow(d)
{
	
	var str = '<div class="row mb-3" id="' +d['ID'] +     '">';
	
	str += '<div class="col">';
	str += d['Name'];
	str += '</div>';
	
	str += '<div class="col">';
	str += d['Productumber'];
	str += '</div>';
	
	str += '<div class="col">';
	str += '<span id="pr'+d['ID'] +'" >'+ d['Price']+ '</span>';
	str += '</div>'
	
	str += '<div class="col">';
	str += quantity(d['ID']);
	str += '</div>';
	
		
	str += '<div class="col">';
	str +='<span id="sum'+d['ID'] +'" >'+ d['Price']+ '</span>';
	str += '<button class="btn btn-lg transparent"><i class="fa fa-times text-danger float-right removerow"></i></button>';
	str += '</div>';
	

	
	   
	str += '</div>';
	return str;
}

function quantity(num)
{
	var str = '<div class="input-group">';
	str += '<span class="input-group-btn">';
    str += '<button type="button" class="btn btn-danger btn-number" data-type="minus" data-field="quant['+num+']">';
    str += '<span class="fa fa-minus"></span>';
    str += '</button>';
    str += '</span>';
    str += '<input type="text" name="quant['+num+']" class="form-control input-number" value="1" min="1" max="100">';
    str += '<span class="input-group-btn">';
    str += '<button type="button" class="btn btn-success btn-number" data-type="plus" data-field="quant['+num+']">';
    str += '<span class="fa fa-plus"></span>';
    str += '</button></span></div>';

    return str;
}
//ID":3,"Name":"test","Price":34,"Stock":34,"Productumber":34,"Description":""

/*
 * $('.minus-btn').on('click', function(e) {
    e.preventDefault();
    var $this = $(this);
    var $input = $this.closest('div').find('input');
    var value = parseInt($input.val());
 
    if (value &amp;gt; 1) {
        value = value - 1;
    } else {
        value = 0;
    }
 
  $input.val(value);
 
});
 
$('.plus-btn').on('click', function(e) {
    e.preventDefault();
    var $this = $(this);
    var $input = $this.closest('div').find('input');
    var value = parseInt($input.val());
 
    if (value &amp;lt; 100) {
        value = value + 1;
    } else {
        value =100;
    }
 
    $input.val(value);
});
https://www.w3schools.com/html/html5_webstorage.asp
https://www.practicalecommerce.com/Build-a-Responsive-Mobile-first-Cart-Page-with-Bootstrap
https://stackoverflow.com/questions/39559006/creating-a-cart-system-with-ajax-html5-and-jquery-only
 */
