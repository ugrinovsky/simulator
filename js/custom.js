var data;
$(function()
{
	 var wrapper = $( ".file_upload" ),
	        inp = wrapper.find( "input" ),
	        btn = wrapper.find( "button" ),
	        lbl = wrapper.find( "div" );

	    btn.focus(function(){
	        wrapper.addClass( "focus" );
	    }).blur(function(){
	        wrapper.removeClass( "focus" );
	    });

	    btn.add( lbl ).click(function(){
	        inp.click();
	    });

	    var file_api = ( window.File && window.FileReader && window.FileList && window.Blob ) ? true : false;

	    inp.change(function(){

	        var file_name;
	        if( file_api && inp[ 0 ].files[ 0 ] )
	            file_name = inp[ 0 ].files[ 0 ].name;
	        else
	            file_name = inp.val().replace( "C:\\fakepath\\", '' );
	        if( ! file_name.length )
	            return;

	        if( lbl.is( ":visible" ) ){
	            lbl.text( file_name );
	            btn.text( "Выбрать" );
	        }else
	            btn.text( file_name );
	    }).change();
	$('.spinner .btn:first-of-type').on('click', function() {
	   $('.spinner input').val( parseInt($('.spinner input').val(), 10) + 1);
	 });
	 $('.spinner .btn:last-of-type').on('click', function() {
	   $('.spinner input').val( parseInt($('.spinner input').val(), 10) - 1);
	 });

	$('.modal').on('shown.bs.modal', function () 
	{
		$(".form-group:nth-of-type(1) input", this).focus();
	})
	$('.btn-fine-edit').click(function()
	{
		$('#editFine input[name="fine_id"]').val($(this).data('id'))
		$('#editFine input[name="fine_name"]').val($(this).closest('tr').find('.fine-name').text())
		$('#editFine input[name="fine_price"]').val($(this).closest('tr').find('.fine-price').text())
		$('#title-fine-id').text('#'+$(this).closest('tr').find('.fine-key').text())
	})
	$('.btn-fine-delete').click(function()
	{
		if (!confirm("Вы уверены?")) {
		 	return false 
		}
	})

	$('.btn-sell-part').click(function()
	{
		$('#sellPart input[name=team_id]').val($(this).data('team-id'))
	})

	$('.btn-cost-edit').click(function()
	{
		$('#editCost input[name="cost_id"]').val($(this).data('id'))
		$('#editCost input[name="cost_name"]').val($(this).closest('tr').find('.cost-name').text())
		$('#editCost input[name="cost_price"]').val($(this).closest('tr').find('.cost-price').text())
		$('#title-cost-id').text('#'+$(this).closest('tr').find('.cost-key').text())
	})
	$('.btn-cost-delete').click(function()
	{
		if (!confirm("Вы уверены?")) {
		 	return false 
		}
	})

	$('.btn-cost-delete').click(function()
	{
		if (!confirm("Вы уверены?")) {
		 	return false 
		}
	})

	$('.btn-team-delete').click(function()
	{
		if (!confirm("Вы уверены?")) {
		 	return false 
		}
	})

	$('.clear-periods').click(function()
	{
		if (!confirm("Вы уверены?")) {
		 	return false 
		}
	})
	
	$('.btn-staff-delete').click(function()
	{
		if (!confirm("Вы уверены?")) {
		 	return false 
		}
		var staff_id = $(this).data('staff-id')

		$.ajax({
			url: '/admin/delete_staff',
			type: 'post',
			data: {
				staff_id: staff_id
			},
			success: function(result)
			{
				if (result) 
					location.reload()
			},
			error: function()
			{

			}
		})
	})

	$('.btn-prom-edit').click(function()
	{
		$('#editProm input[name="prom_id"]').val($(this).data('id'))
		$('#editProm input[name="prom_name"]').val($(this).closest('tr').find('.prom-name').text())
		$('#editProm input[name="prom_price"]').val($(this).closest('tr').find('.prom-price').text())
		$('#title-prom-id').text('#'+$(this).closest('tr').find('.prom-key').text())
	})
	$('.btn-prom-delete').click(function()
	{
		if (!confirm("Вы уверены?")) {
		 	return false 
		}
	})

	$('.btn-order-edit').click(function()
	{
		$('#editOrder input[name="order_id"]').val($(this).data('id'))
		$('#editOrder input[name="order_name"]').val($(this).closest('tr').find('.order-name').text())
		$('#editOrder input[name="order_price"]').val($(this).closest('tr').find('.order-price').text())
		$('#editOrder textarea[name="order_comment"]').val($(this).closest('tr').find('.order-comment').text())
		$('#title-order-id').text('#'+$(this).closest('tr').find('.order-key').text())
	})
	$('.btn-order-delete').click(function()
	{
		if (!confirm("Вы уверены?")) {
		 	return false 
		}
	})

	$('.btn-part-edit').click(function()
	{
		$('#editPart input[name="part_id"]').val($(this).data('id'))
		$('#editPart input[name="part_name"]').val($(this).closest('tr').find('.part-name').text())
		$('#editPart input[name="part_price"]').val($(this).closest('tr').find('.part-price').text())
		$('#title-part-id').text('#'+$(this).closest('tr').find('.part-key').text())
	})
	$('.btn-part-delete').click(function()
	{
		if (!confirm("Вы уверены?")) {
		 	return false 
		}
	})

	$('.btn-cust-fine-edit').click(function()
	{
		$('#editCustFine input[name="cust_fine_id"]').val($(this).data('id'))
		$('#editCustFine input[name="cust_fine_name"]').val($(this).closest('tr').find('.cust-fine-name').text())
		$('#editCustFine input[name="cust_fine_price"]').val($(this).closest('tr').find('.cust-fine-price').text())
		$('#title-cust-fine-id').text('#'+$(this).closest('tr').find('.cust-fine-key').text())
	})
	$('.btn-cust-fine-delete').click(function()
	{
		if (!confirm("Вы уверены?")) {
		 	return false 
		}
	})

	$('#select-elements').change(function() {
		if($('#select-elements option:selected').val() == 'cost')
		{
			$('.select-element').slideUp()
			$('.select-cost').slideDown()
			$('.select-btn').removeAttr('disabled')
		}
		else if($('#select-elements option:selected').val() == 'fine')
		{
			$('.select-element').slideUp()
			$('.select-fine').slideDown()
			$('.select-btn').removeAttr('disabled')
		}
		else
		{
			$('.select-btn').attr('disabled', 'disabled')
		}
	})
	$('.btn-add-cost').click(function()
	{
		$('input[name="team_cost_id"]').val($(this).data('id'))
	})
	$('#form-team-cost').submit(function()
	{
		$('input[name="team_element"]').val($('.select-element select:visible').val())
	})

	$('.btn-add-fine-prom').click(function()
	{
		$('input[name="team_id"]').val($(this).data('team-id'))
		$('input[name="order_id"]').val($(this).data('order-id'));
	})
	$('.btn-add-order-team').click(function()
	{
		$('input[name="team_id"]').val($(this).data('team-id'))
	})
	$('#form-team-fine-prom').submit(function()
	{
		$('input[name="team_element"]').val($('.select-element select:visible').val())
	})

	$.ajax(
	{
		url: '/admin/get_stat_data',
		type: 'post',
		dataType: 'json',
		async: false,
		success: function(result)
		{
			data = result
			for(var i = 0; i < data.length; i++)
			{
				data[i].name = 'Завод '+data[i].id
			}
		},
		// error: function(xhr)
		// {
		// 	console.log(xhr)
		// }
	})

	var period_result;
	$.ajax(
	{
		url: '/get_periods',
		type: 'post',
		async: false,
		dataType: 'json',
		success: function(result)
		{
			period_result = result
			end = new Date(result.end)
		},
		error: function(xhr)
		{
			console.log(xhr)
		}
	})




   // ================== СТАТИСТИКА ПО КОМАНДАМ ====================== //
	plot();
	function plot() {

		var mid = []
		for(var i = 0; i < data.length; i++)
		{
			var el = {}
			el.label = data[i].name
			el.data = []
			var c = 0
			for(var j = 0; j < data[i].operations.length; j++)
			{
				c++
				var d = new Date(data[i].operations[j].date_time)
				var m = d.getMinutes()
				el.data.push([c, data[i].operations[j].residue])
			}
			mid.push(el)
		}

		var options = {
		  	series: {
		      lines: {
		         show: true
		      },
		      points: {
		         show: true,
					radius: 0,
		      },
		  		bars: {
		  		   zero: true
		  		},
		  },
		  grid: {
		      hoverable: true //IMPORTANT! this is needed for tooltip to work
		  },
		  // xaxis: {
		  // 		from: 1,
		  // 		to: 2
		  // },
		  xaxis: {
			  	// tickFormatter: function(val, axis) { 
			  	// 	var l = new Date(val)
			  	// 	return l.toLocaleString();
			  	// },
		      // min: chart_end.subHours(3),
		      // max: chart_end.addHours(1),
		      mode: "time",
            timeformat: "%h:%M:%S",
            // minTickSize: [1, "day"]
		  },
		  colors: [
		  	'red',
		  	'blue',
		  	'green',
		  	'yellow',
		  	'cyan',
		  	'black'
			// '#'+(0x1000000+(Math.random())*0xffffff).toString(16).substr(1,6), 
			// '#'+(0x1000000+(Math.random())*0xffffff).toString(16).substr(1,6),
			],
			// grid: {
		   //   minBorderMargin: 20,
		   //   labelMargin: 10,
		   //   borderWidth: 1			
			// }
		};

	   function showTooltip(x, y, contents) {
	      $('<div id="flot_chart_tooltip">' + contents + '</div>').css( {
	        	top: y + 5,
	        	left: x + 5,
	      }).appendTo("body").fadeIn(200);
	    }

	    $("#flot-line-chart").bind("plothover", function (event, pos, item) {
	      if (item) {
	        	$("#flot_chart_tooltip").remove();
	        	showTooltip(
	        		item.pageX, 
	        		item.pageY, 
	        		item.series.label+"<br>Остаток: "+item.datapoint[1]
	        	);
	      } else {
				$("#flot_chart_tooltip").remove();
	      }
	   });

	   var yaxisLabel = $("<div class='axisLabel yaxisLabel'></div>")
	    	.text("asdad")
	    	.appendTo($("#flot-line-chart"));

	   var plotObj = $.plot($("#flot-line-chart"), mid, options);
	}
})

function getRandomArbitary(min, max)
{
  return Math.random() * (max - min) + min;
}

Date.prototype.addHours = function(h){
    this.setHours(this.getHours()+h);
    return this;
}

Date.prototype.subHours = function(h){
    this.setHours(this.getHours()-h);
    return this;
}

$(function() {

	var bar = []
	for(var i = 0; i < data.length; i++)
	{
		var el = {}
		el.team = data[i].name
		el.price = 0
		el.price2 = 0
		for(var j = 0; j < data[i].operations.length; j++)
		{
			if (data[i].operations[j].type == 9 || data[i].operations[j].type == 5 || data[i].operations[j].type == -1 || data[i].operations[j].type == 2)
			{
				el.price2 += parseFloat(data[i].operations[j].price)
			}
			else
				el.price += parseFloat(data[i].operations[j].price)
		}
		console.log(el)
		bar.push(el)
	}

	Morris.Bar({
	    element: 'morris-bar-chart',
	    data: bar,
	    xkey: 'team',
	    ykeys: ['price', 'price2'],
	    labels: ['Расходы', 'Доходы'],
	    barRatio: 0.9,
	    xLabelAngle: 35,
	    hideHover: 'auto',
	    resize: true,
	    lineColors:['gray','red']
	});

});