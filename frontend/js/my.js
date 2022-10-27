$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})


//Редактирование списков меню
jQuery(document).on('click', '.menu_save',function (){
	//console.log(1);
	var items = jQuery(this).closest('.box').find('li');
	var data = {};
	data['items'] = {};
	var menu_id = jQuery(this).closest('.box').data('menu_type');
	data['menu_type'] = menu_id;
	items.each(function () {
		//console.log(jQuery(this).text());
		data['items'][jQuery(this).data('item_id')] = {};
		data['items'][jQuery(this).data('item_id')]['type'] = jQuery(this).data('type');
		data['items'][jQuery(this).data('item_id')]['text'] = jQuery(this).text();
	});
	var that = jQuery(this);
	var url = '/?ajax_action=menu_save';
	console.log(data);
	__post(url, data, function (res) {
		//console.log('Пришло');
		if (res) {
			
				console.log('Пришло');
				console.log(res);
				//that.removeClass('btn-info');
				//that.removeClass('plan_income_to_body');
				//that.addClass(res.action_class);
				//that.html(res.action_result);
				if(res.action_descr){
					that.closest('.action_wrapper').append(res.action_descr);
				}
		}	
	});
});



//Фнукция вывода для админа

jQuery(document).on('click', '.admin_wthdraw_do',function (){
	//console.log(1);
	var flag = true;
	var modal_body = jQuery(this).closest('.modal-content').find('.modal-body');
	var admin_profit_wallet = modal_body.find('#admin_profit_wallet').val();
	var admin_profit_amount = modal_body.find('#admin_profit_amount').val();
	modal_body.find('.has-error').removeClass('has-error');
	hideError(modal_body.find('#admin_profit_wallet'));
	if(!admin_profit_wallet){
		//modal_body.find('#admin_profit_wallet').closest('.form-group').addClass('has-error');
		showError(modal_body.find('#admin_profit_wallet'));
		flag = false;
	}
	if(parseFloat(admin_profit_amount) < 0 || parseFloat(admin_profit_amount) == 0){
		modal_body.find('#admin_profit_amount').closest('.form-group').addClass('has-error');
		flag = false;
	}
	if(flag){
		var data = {};
		data['admin_profit_wallet'] = admin_profit_wallet;
		data['admin_profit_amount'] = admin_profit_amount;
		console.log(data);
		var that = jQuery(this);
		var url = '/?ajax_action=admin_wthdraw_profit';
		__post(url, data, function (res) {
			//console.log('Пришло');
			if (res) {
				console.log('Пришло');
				console.log(res);
				if(res.action_descr){
					that.closest('.action_wrapper').append(res.action_descr);
				}
			}	
		});
	}
});

//Функции для планов

var plan_time_days = jQuery('.plan_options .plan_time_days').html();

jQuery(document).on('change', '.percent_min',function (){
	console.log('123');//indexOf
	//console.log(jQuery(this).val().indexOf('%'));
	if(jQuery(this).val().indexOf('%') > 0){
		console.log('Percent');
		jQuery(this).closest('.form-group').find('.min_input_div').show();
	}else{
		//jQuery(this).closest('.form-group').find('.min_input_div').val('');
		jQuery(this).closest('.form-group').find('.min_input_div').hide();
	}
	
});
jQuery(document).on('change', '#plan_type',function (){
	console.log(jQuery(this).val());
	if(jQuery(this).val() == 4){
		jQuery('.plan_options .plan_time_days').remove();
	}else{
		jQuery('.plan_options').append('<div class="form-group plan_time_days">'+plan_time_days+'</div>');
	}
	
});


//Реинвестирование процентов в body
jQuery(document).on('click', '.plan_income_to_body',function (){
	var data = {};
	data['uid'] = jQuery(this).data('uid');
	data['nid'] = jQuery(this).data('nid');
	data['pt'] = jQuery(this).data('pt');
	data['tid'] = jQuery(this).data('tid');
	console.log(data);
	var that = jQuery(this);
	var url = '/?ajax_action=plan_reinvest_income';
	__post(url, data, function (res) {
		//console.log('Пришло');
		if (res) {
			
				console.log('Пришло');
				console.log(res);
				//that.removeClass('btn-info');
				//that.removeClass('plan_income_to_body');
				//that.addClass(res.action_class);
				//that.html(res.action_result);
				if(res.action_descr){
					that.closest('.action_wrapper').append(res.action_descr);
				}
		}	
	});
	
	
});

//Вывод денег с плана на депозит (пока только body) не даем выводить если есть запрос на реинвестирование #todo
jQuery(document).on('click', '.withdrawal_do',function (){
	var amount = jQuery(this).closest('.modal-dialog').find('.p_Amount').val();
	var data = {};
	data['uid'] = jQuery(this).data('uid');
	data['nid'] = jQuery(this).data('nid');
	data['pt'] = jQuery(this).data('pt');
	data['tid'] = jQuery(this).data('tid');
	data['amount'] = amount;
	console.log(data);
	
	var that = jQuery(this);
	var url = '/?ajax_action=plan_withdrawal';
	__post(url, data, function (res) {
		//console.log('Пришло');
		if (res) {
			
				console.log('Пришло');
				console.log(res)
				if(res.action_descr){
					that.closest('.action_wrapper').find('.alert').remove();
					that.closest('.action_wrapper').append(res.action_descr);
				}
		}	
	});
	
	
});

jQuery(document).on('change', '.p_Amount',function (){
	console.log(jQuery(this).val());
	var amount = jQuery(this).val();
	var modal = jQuery(this).closest('.modal-content');
	var fee_per = parseFloat(modal.find('.percents').text());
	var fee_min = parseFloat(modal.find('.min').text());
	console.log('fee_per - '+fee_per+' ; fee_min - '+fee_min);
	
	//Установим процент и минимум в 0, и потом будем смотреть по значениям в модале
	var per_result = 0;
	var min_result = 0;
	
	var fee_result = 0;
	
	if(fee_per){
		//console.log('fee_per');
		per_result = amount*fee_per/100;
	}
	if(fee_min){
		min_result = fee_min;
		//console.log('fee_min');
		if(min_result > per_result){
			fee_result = min_result;
		}else{
			fee_result = per_result;
		}
	}else{
		fee_result = per_result;
	}
	modal.find('.current_com_result').text(fee_result+' btc');
	console.log('fee_result - '+fee_result+' ; min_result - '+min_result+' ; per_result - '+per_result);
});


jQuery('.add_new_field').on('click',function (){
	var current_elem = jQuery(this).closest('.repeater_field').find('.repeat_field').clone().removeClass('repeat_field').append('<div class="col-sm-3 delete_row"><button type="button" class="btn btn-block btn-danger btn-flat">Delete</button></div>')
	
	current_elem.find('input').val('');
	current_elem.insertBefore('.add_new_field_col');
});
jQuery(document).on('click', '.delete_row', function() {
  //console.log('123');
  jQuery(this).closest('.form-group').addClass('234').remove();
});


//Инвестирование в план
jQuery(document).on('click', '.invest_do', function() {
 // console.log('123');
 
	var uid = jQuery(this).data('userid');
	var nid = jQuery(this).data('nid');
	var amount = jQuery(this).closest('.modal-content').find('input.p_Amount').val();
 
	var url = '/?ajax_action=plan_invest';
	var that = jQuery(this);
	var data = {};
	data['uid'] = uid;
	data['nid'] = nid;
	data['amount'] = amount;
	//data['test'] = '123';
	console.log(data);
	__post(url, data, function (res) {
		//console.log('Пришло');
		if (res) {
				console.log('Пришло');
				console.log(res);
				
				if(res.action_descr){
					that.closest('.action_wrapper').find('.alert').remove();
					that.closest('.action_wrapper').append(res.action_descr);
				}
		}	
	});
});


//Отказ в пополнении плана
jQuery(document).on('click', '.reject_do', function() {
 // console.log('123');
	jQuery(this).closest('.modal-content').find('.modal_error').hide();
	var nid = jQuery(this).data('nid');
	var reason = jQuery(this).closest('.modal-content').find('input.reason').val();
	if(reason){
		var url = '/?ajax_action=plan_reject';
		var that = jQuery(this);
		var data = {};
		data['nid'] = nid;
		data['reason'] = reason;
		//data['test'] = '123';
		console.log(data);
		__post(url, data, function (res) {
			//console.log('Пришло');
			if (res) {
					console.log('Пришло');
					console.log(res);
					if(res.action_descr){
						that.closest('.action_wrapper').find('.alert').remove();
						that.closest('.action_wrapper').append(res.action_descr);
					}
			}	
		});
	}else{
		jQuery(this).closest('.modal-content').find('.modal_error').show();
	}
});


//Подтверждение пополнения плана
jQuery(document).on('click', '.submit_do', function() {
 // console.log('123');
	jQuery(this).closest('.modal-content').find('.modal_error').hide();
	var nid = jQuery(this).data('nid');
	var wto = jQuery(this).closest('.modal-content').find('input.addr_to').val();
	if(wto){
		var url = '/?ajax_action=plan_submit';
		var that = jQuery(this);
		var data = {};
		data['nid'] = nid;
		data['wto'] = wto;
		//data['test'] = '123';
		console.log(data);
		__post(url, data, function (res) {
			//console.log('Пришло');
			if (res) {
					console.log('Пришло');
					console.log(res);
					if(res.action_descr){
						that.closest('.action_wrapper').find('.alert').remove();
						that.closest('.action_wrapper').append(res.action_descr);
					}
			}	
		});
	}else{
		jQuery(this).closest('.modal-content').find('.modal_error').show();
	}
});

//Функция проверяющая сумму для подтверждения транзакций на вывод  или реинвестирование
jQuery(document).on('change', '.to_apply', function() {
  //console.log('123');
  
  jQuery(this).closest('.plans_wrapper').find('.nedd_topopup').text('');
  jQuery(this).closest('.plans_wrapper').find('.withdrawal_alert').hide();
  
  var tx_current = jQuery(this).data('tid');
  var admin_balanse = parseFloat(jQuery('.sidebar .admin_balance').text());
  //console.log(tx_current);
  var amount_all = 0;
  jQuery(this).closest('.plans_wrapper').find('input.to_apply:checked').each(function () {
	  console.log(jQuery(this).data('tid'));
	  var amount_current = parseFloat(jQuery(this).closest('.tx_row').find('.tx_amount').text());
	  amount_all = amount_all + amount_current;
	  console.log('amount_current - '+amount_current);
  });
  jQuery(this).closest('.plans_wrapper').find('.withdrawal_amount').text(amount_all+' btc');
  console.log('admin_balanse - '+admin_balanse);
  if(admin_balanse < amount_all){
	  var need_btc = amount_all - admin_balanse;
	  jQuery(this).closest('.plans_wrapper').find('.nedd_topopup').text(need_btc+' btc');
	  jQuery(this).closest('.plans_wrapper').find('.withdrawal_alert').show();
  }
});
//Отказ в транзакции вывода-реинвестировани  или реинвестирование
jQuery(document).on('click', '.reject_do_usertx', function() {
 // console.log('123');
	jQuery(this).closest('.modal-content').find('.modal_error').hide();
	var tid = jQuery(this).data('tid');
	var reason = jQuery(this).closest('.modal-content').find('input.reason').val();
	var url = '/?ajax_action=admin_tx_reject';
	  
	var data = {};
	data['tid'] = tid;
	data['reason'] = reason;
	//data['test'] = '123';
	console.log(data);
	var that = jQuery(this);
	__post(url, data, function (res) {
		//console.log('Пришло');
		if (res) {
			
				console.log('Пришло');
				console.log(res);
				if(res.action_descr){
					that.closest('.action_wrapper').find('.alert').remove();
					that.closest('.action_wrapper').append(res.action_descr);
				}
		}
	});
});


//Подтверждение транзакций на вывод или реинвестирование
jQuery(document).on('click', '.withdrawal_apply', function() {
 // console.log('123');
	jQuery(this).closest('.modal-content').find('.modal_error').hide();
	var tid = jQuery(this).data('tid');
	var reason = jQuery(this).closest('.modal-content').find('input.reason').val();
	
	
	
	var url = '/?ajax_action=admin_tx_apply';
	var that = jQuery(this);
	jQuery('input.to_apply:checked').each(function () {
			var data = {};
			data['tid'] = jQuery(this).data('tid');
			//data['test'] = '123';
			console.log(data);
			
			__post(url, data, function (res) {
				//console.log('Пришло');
				if (res) {
						console.log('Пришло');
						console.log(res);
						if(res.action_descr){
							//that.closest('.action_wrapper').find('.alert').remove();
							that.closest('.action_wrapper').append(res.action_descr);
						}
				}
			});
	}); 
	 
	

});


//Функции js общие

//Проверка на мин-макс
//Подтверждение пополнения плана
jQuery(document).on('change', '.min_max', function() {
	// console.log('123');
	var current_val = jQuery(this).val();
	hideError(jQuery(this));
	jQuery(this).closest('.modal-content').find('.modal_error').hide();
	if(jQuery(this).data('max')){ //Проверка на максимальную сумму в поле
		if(parseFloat(current_val) > parseFloat(jQuery(this).data('max'))){
			jQuery(this).val(jQuery(this).data('max'));
			showError(jQuery(this));
		}else{
			jQuery(this).closest('.modal-content').find('.modal_error').show();
		}
	}	
	if(jQuery(this).data('min')){ //Проверка на минимальную сумму в поле
		if(parseFloat(current_val) < parseFloat(jQuery(this).data('min'))){
			jQuery(this).val(jQuery(this).data('min'));
		}
	}
});

//Функция показа ошибок
function showError(that){
	that.closest('.form-group').addClass('has-error');
	that.closest('.form-group').find('.help-block').show();
}

//Убираем ошибки что бы не показывались, если инпут изменили
function hideError(that){
	that.closest('.form-group').removeClass('has-error');
	that.closest('.form-group').find('.help-block').hide();
}


//Функция отправки ajax запроса
/*
Примеры вызова
__post(url, data, function (res) {
	console.log('Пришло');
	if (res) {
			console.log('Пришло2');
			console.log(res);
	}
	
});

*/
function __post( _url, _data, cb){
	//console.log('__post! post:'+_data+'  _url:'+_url+'  cb:'+cb);
    try{
		//console.log('post:'+_data+'  _url:'+_url+'  cb:'+cb);
        //mkWait('show');
        $.ajax({
            url  : _url,
            data : _data,
			dataType: 'json',
            type : 'post',
            success : function(json_t){
				// mkWait('hide');
                //console.log(json_t);
				cb(json_t);
				return json_t;
            },
            error: function(a,b, error){
                //mkWait('hide');
                // console.log( 'error:', error );
                //console.log( 'error:', error );
				cb({code: 500, 'msg': error, data:null});
            }
        });

    }catch(e){
        //console.log({code: 500, 'msg': error, data:null});
		cb({code: 500, 'msg': e, data:null});
       // mkWait('hide');

    }

}
  function drawDocSparklines() {

    // Bar + line composite charts
    $('#compositebar').sparkline('html', {type: 'bar', barColor: '#aaf'});
    $('#compositebar').sparkline([4, 1, 5, 7, 9, 9, 8, 7, 6, 6, 4, 7, 8, 4, 3, 2, 2, 5, 6, 7],
        {composite: true, fillColor: false, lineColor: 'red'});


    // Line charts taking their values from the tag
    $('.sparkline-1').sparkline();

    // Larger line charts for the docs
    $('.largeline').sparkline('html',
        {type: 'line', height: '2.5em', width: '4em'});

    // Customized line chart
    $('#linecustom').sparkline('html',
        {
          height: '50px', width: '100px', lineColor: '#ecf0f1', fillColor: 'rgba(0,0,0,0)',
          minSpotColor: true, maxSpotColor: true, spotColor: '#77f', spotRadius: 3
        });    
		
	$('#linecustom2').sparkline('html',
        {
          height: '50px', width: '150px', lineColor: '#ecf0f1', fillColor: 'rgba(0,0,0,0)',
          minSpotColor: true, maxSpotColor: true, spotColor: '#77f', spotRadius: 3
        });
	
	//Главная график в левом блоке первой секции
	$('#linecustom3').sparkline('html',
        {
          height: '80px', width: '150px', lineColor: '#ffffff',lineWidth:2, fillColor: 'rgba(0,0,0,0)',
          minSpotColor: true, maxSpotColor: true, spotColor: '#2e6da4', spotRadius: 3
        });

    // Bar charts using inline values
    $('.sparkbar').sparkline('html', {type: 'bar'});

    $('.barformat').sparkline([1, 3, 5, 3, 8], {
      type: 'bar',
      tooltipFormat: '{{value:levels}} - {{value}}',
      tooltipValueLookups: {
        levels: $.range_map({':2': 'Low', '3:6': 'Medium', '7:': 'High'})
      }
    });

    // Tri-state charts using inline values
    $('.sparktristate').sparkline('html', {type: 'tristate'});
    $('.sparktristatecols').sparkline('html',
        {type: 'tristate', colorMap: {'-2': '#fa7', '2': '#44f'}});

    // Composite line charts, the second using values supplied via javascript
    $('#compositeline').sparkline('html', {fillColor: false, changeRangeMin: 0, chartRangeMax: 10});
    $('#compositeline').sparkline([4, 1, 5, 7, 9, 9, 8, 7, 6, 6, 4, 7, 8, 4, 3, 2, 2, 5, 6, 7],
        {composite: true, fillColor: false, lineColor: 'red', changeRangeMin: 0, chartRangeMax: 10});

    // Line charts with normal range marker
    $('#normalline').sparkline('html',
        {height: '50px', width: '100%', lineColor: '#f00', fillColor: 'rgba(0,0,0,0)', normalRangeMin: 0, normalRangeMax: 1});
	$('#normalline2').sparkline('html',
        {height: '50px', width: '100%', lineColor: '#f0f', fillColor: 'rgba(0,0,0,0)', normalRangeMin: 0, normalRangeMax: 1});    
		
	
		
    $('#normalExample').sparkline('html',
        {fillColor: false, normalRangeMin: 80, normalRangeMax: 95, normalRangeColor: '#4f4'});

    // Discrete charts
    $('.discrete1').sparkline('html',
        {type: 'discrete', lineColor: 'blue', xwidth: 18});
    $('#discrete2').sparkline('html',
        {type: 'discrete', lineColor: 'blue', thresholdColor: 'red', thresholdValue: 4});

    // Bullet charts
    $('.sparkbullet').sparkline('html', {type: 'bullet'});

    // Pie charts
    $('.sparkpie').sparkline('html', {type: 'pie', height: '1.0em'});

    // Box plots
    $('.sparkboxplot').sparkline('html', {type: 'box'});
    $('.sparkboxplotraw').sparkline([1, 3, 5, 8, 10, 15, 18],
        {type: 'box', raw: true, showOutliers: true, target: 6});

    // Box plot with specific field order
    $('.boxfieldorder').sparkline('html', {
      type: 'box',
      tooltipFormatFieldlist: ['med', 'lq', 'uq'],
      tooltipFormatFieldlistKey: 'field'
    });

    // click event demo sparkline
    $('.clickdemo').sparkline();
    $('.clickdemo').bind('sparklineClick', function (ev) {
      var sparkline = ev.sparklines[0],
          region = sparkline.getCurrentRegionFields();
      value = region.y;
      alert("Clicked on x=" + region.x + " y=" + region.y);
    });

    // mouseover event demo sparkline
    $('.mouseoverdemo').sparkline();
    $('.mouseoverdemo').bind('sparklineRegionChange', function (ev) {
      var sparkline = ev.sparklines[0],
          region = sparkline.getCurrentRegionFields();
      value = region.y;
      $('.mouseoverregion').text("x=" + region.x + " y=" + region.y);
    }).bind('mouseleave', function () {
      $('.mouseoverregion').text('');
    });
  }
    /**
   ** Draw the little mouse speed animated graph
   ** This just attaches a handler to the mousemove event to see
   ** (roughly) how far the mouse has moved
   ** and then updates the display a couple of times a second via
   ** setTimeout()
   **/
  function drawMouseSpeedDemo() {
    var mrefreshinterval = 500; // update display every 500ms
    var lastmousex = -1;
    var lastmousey = -1;
    var lastmousetime;
    var mousetravel = 0;
    var mpoints = [];
    var mpoints_max = 30;
    $('html').mousemove(function (e) {
      var mousex = e.pageX;
      var mousey = e.pageY;
      if (lastmousex > -1) {
        mousetravel += Math.max(Math.abs(mousex - lastmousex), Math.abs(mousey - lastmousey));
      }
      lastmousex = mousex;
      lastmousey = mousey;
    });
    var mdraw = function () {
      var md = new Date();
      var timenow = md.getTime();
      if (lastmousetime && lastmousetime != timenow) {
        var pps = Math.round(mousetravel / (timenow - lastmousetime) * 1000);
        mpoints.push(pps);
        if (mpoints.length > mpoints_max)
          mpoints.splice(0, 1);
        mousetravel = 0;
        $('#mousespeed').sparkline(mpoints, {width: mpoints.length * 2, tooltipSuffix: ' pixels per second'});
      }
      lastmousetime = timenow;
      setTimeout(mdraw, mrefreshinterval);
    };
    // We could use setInterval instead, but I prefer to do it this way
    setTimeout(mdraw, mrefreshinterval);
  }