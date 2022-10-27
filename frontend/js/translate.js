//Функции перевода


//Скрипты для страницы переводов в админке

//Вставка контента в редактор, при клике по tinyMCE типу
jQuery(document).on('click', '.modal_tinymce_action',function (){
	//console.log(1);
	var content = jQuery(this).closest('td').find('div').html();
	//console.log(content);
	jQuery('#modal-tinymce').data('tkey',jQuery(this).data('tkey'));
	jQuery('#modal-tinymce').data('lang',jQuery(this).data('lang'));
	jQuery('#modal-tinymce .tname').text(jQuery(this).data('tkey'));
	tinyMCE.activeEditor.setContent(content);
});

//Сохранение контента, при клике по tinyMCE типу
jQuery(document).on('click', '.translate_do_admin',function (){
	console.log('lang - '+jQuery('#modal-tinymce').data('lang'));
	console.log('tkey - '+jQuery('#modal-tinymce').data('tkey'));
	var data = {};
	data['lid'] = jQuery('#modal-tinymce').data('tkey');
	var url = '/?ajax_action=translate_set';
	var that = jQuery(this);
	data['lang'] = jQuery('#modal-tinymce').data('lang');
	var new_value = tinyMCE.activeEditor.getContent();
	data['new_value'] = new_value;
	console.log('Отбивка');
	console.log(data);
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
});


//Сохранение контента, при клике по input типу
jQuery(document).on('click', '.translate_do_admin_input',function (){
	var tkey = jQuery(this).closest('tr').find('.tkey').text();
	var url = '/?ajax_action=translate_set';
	var data = {};
	
	data['lid'] = tkey;
	console.log('tkey - '+tkey);
	jQuery(jQuery(this).closest('tr').find('.l_text')).each(function (){
		data['lang'] = jQuery(this).data('lang');
		data['new_value'] = jQuery(this).val();
		console.log('l_text - '+jQuery(this).val()+' , lang - '+jQuery(this).data('lang'));
		//jQuery(this).closest('.form-group').addClass('has-success').find('.help-block').show();
		var that = jQuery(this);
		__post(url, data, function (res) {
			if (res) {
				console.log('Пришло');
				console.log(res);
				if(res.form_class && res.action_result){
					//that.closest('.action_wrapper').append(res.form_class);
					that.closest('.form-group').addClass(res.form_class).find('.help-block').html(res.action_result).show();
				}
			}	
		});
	});
});




//Для общих переводов в в годмод
jQuery(document).on('click', '.translate_lnk',function (){
	jQuery('#modal-translate .action_wrapper .alert').remove();
	var current_lid = jQuery(this).data('lid');
	jQuery('#modal-translate .tname').text(current_lid);
	console.log(current_lid);
	var data = {};
	data['lid'] = current_lid;
	if(jQuery(this).data('type')){
		data['type'] = jQuery(this).data('type');
	}
	if(jQuery(this).data('eddtype')){
		data['eddtype'] = jQuery(this).data('eddtype');
	}
	data['basedir'] = jQuery(this).data('basedir');
	var url = '/?ajax_action=translate_get';
	__post(url, data, function (res) {
		//console.log('Пришло');
		if (res) {
			
				console.log('Пришло');
				console.log(res);
				//that.removeClass('btn-info');
				//that.removeClass('plan_income_to_body');
				//that.addClass(res.action_class);
				//that.html(res.action_result);
				jQuery('#modal-translate .lang_form').html(res.form_inner);
		}	
	});
	event.preventDefault();
});

jQuery(document).on('click', '.translate_do',function (){
	jQuery('#modal-translate .action_wrapper .alert').remove();
	var current_lid = jQuery('#modal-translate .tname').text();
	var data = {};
	data['lid'] = current_lid;
	var url = '/?ajax_action=translate_set';
	var that = jQuery(this);
	jQuery('.l_text').each(function (){
		
		var lang = jQuery(this).closest('.form-group').find('.trans_lang b').text();
		data['lang'] = lang;

		if(jQuery(this).attr('id')){
			console.log(jQuery(this).attr('id'));
			var new_value = tinyMCE.get(jQuery(this).attr('id')).getContent();;
		}else{
			var new_value = jQuery(this).val();
		}
		data['new_value'] = new_value;
		//var test = tinyMCE.get('txtarea1').getContent();
		//var test =  $("#txtarea1").tinymce().selection.select($("#txtarea1").tinymce().getBody(), true);
		console.log('Отбивка');
		console.log(data);
		//console.log(tinymce.get('t1').getContent());
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
	});

});