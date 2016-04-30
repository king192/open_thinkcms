function showlog(msg,type){
		noty({
            text: msg,
            type:type || 'alert',
            layout:"center",
            timeout: 2000,
            modal: true,
        });
}
function show(msg){
	head.js("/Public/js/noty.js",function(){
		showlog(msg);
	})
}
function warning(msg){
	head.js("/Public/js/noty.js",function(){
		showlog(msg,'warning');
	})
}
function error(msg){
	head.js("/Public/js/noty.js",function(){
		showlog(msg,'error');
	})
}
(function(){
	$(document).on('click','button.J_ajax_submit_btn',function(e){
		e.preventDefault();
		// var this = $(this);
		var btn = $(this),
	        form = btn.parents('form.J_ajaxForm');
	    var url = btn.data('action') ? btn.data('action') : form.attr('action');
	    console.log('url',form);
	        // console.log('ss',form.serializeArray());//form.serialize
	        // return false;
		$.ajax({
			url:url, //按钮上是否自定义提交地址(多按钮情况)
			dataType:'JSON',
			type:'POST',
			data:form.serializeArray(),
			beforeSend:function(){
	            var text = btn.text();
	            //按钮文案、状态修改
	            btn.text(text + '中...').prop('disabled', true).addClass('disabled');
			},
			success:function(data){
				console.log('s',data);
	            var text = btn.text();
	            //按钮文案、状态修改
	            btn.removeClass('disabled').text(text.replace('中...', ''));
	            btn.removeAttr('disabled').removeClass('disabled');
	            if(data.rtn > 0){
	            	show(data.msg);
	            	if(typeof after_success_post !== 'undefined'){
	            		after_success_post(data);
	            	}
	            }else{
	            	warning(data.msg);
	            }
			},
			error:function(e){
				console.log('e',e);
			}

		})
		return false;
	})
	$(document).on('click','a.a_ajax_submit',function(e){
		e.preventDefault();
		$.ajax({
			url:$(this).attr('href'),
			dataType:"JSON",
			type:"GET",
			success:function(data){
	            if(data.rtn > 0){
	            	show(data.msg);
	            	if(typeof after_success_post !== 'undefined'){
	            		after_success_post1(data);
	            	}
	            }else{
	            	warning(data.msg);
	            }
			}
		})
	})
})()