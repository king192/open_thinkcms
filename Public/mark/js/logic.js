$(function(){
	$(".nav_btn #classAdd").click(function(){
		var ul = $("#list_1");
		var sort = ul.children().length+1; 
		console.log('class',sort);
		var T_show = $("#loader");
		var act = 'classAdd';
		$.ajax({
			type: "get",
			url: 'source/plugin/king1992_mark/class/update.class.php',
			data: { act: act,sort: sort },   
			beforeSend: function() {
			T_show.html("<span><img src='source/plugin/king1992_mark/image/load.gif' /> 正在更新</span>");
			},
			error: function(err) {
				T_show.html(err);
			},
			success: function(msg) {
				T_show.html("<span>添加成功</span>");console.log('msg:',msg);
				setTimeout(function(){T_show.html("");},2500);
				if(msg){
					var html = '<div id="sortable_'+msg+'" class="classSort">'+
									'<div class="edit head">'+
										'<div class="classTitle">'+
											'<span id="share_'+msg+'" class="delRecIcon" title="删除"></span>'+
											'<span id="edit_'+msg+'" class="modRecIcon" title="编辑"></span>'+
											'<span id="attrState_'+msg+'" class="upIcon" title="收起"></span>'+
											'<h3 class="ui-state-header Drop">默认分类</h3>'+
										'</div>'+
									'</div>'+
									'<div class="marksbox" id="marksbox_'+msg+'">'+
										'<ul class="connectedSortable ui-sortable">'+
										'<li class="empty"></li>'+ 
										'</ul>'+
										'<span class="allBmBbtn iconBgImages add-form"></span>'+
									'</div>'+
								'</div>';
					ul.prepend(html);
				}
			}
		});
	});
});
$(function(){
	$(".head .delRecIcon").live('click',function(){
		var delClass = confirm("确定要删除吗?");
		if(delClass){
			var parent = $(this).parents(".classSort");
			var id = parent.attr("id").substr(9);
			var act = 'delClass';
			var T_show = $("#loader");
			$.ajax({
				type: "get",
				url: 'source/plugin/king1992_mark/class/update.class.php',
				data: { id: id,act: act },   
				beforeSend: function() {
				T_show.html("<span><img src='source/plugin/king1992_mark/image/load.gif' /> 正在更新</span>");
				},
				error: function(err) {
					T_show.html(err);
				},
				success: function(msg) {
					T_show.html("<span>删除成功</span>");
				setTimeout(function(){T_show.html("");},2500);
					if(msg){
						parent.remove();
					}
				}
			});
		}
	});
});
$(function(){
	$(".head .modRecIcon").live('click',function(){
		$(".classTitle").removeClass("hidden");
		$(this).parent().addClass("hidden");
		$(".innerLabelHeadeModify").remove();
		var html = '<div class="innerLabelHeadeModify">'+
						'<span class="cannelBtn iconBgImages" title="取消" id="editGroupClose"></span>'+
						'<span class="rightBtn iconBgImages" title="确定" id="editGroupBtn"></span>'+
						'<input class="headMod" id="groupValue" type="text">'+
					'</div>';
		$(this).parents(".head").append(html);
		var heading = $("#groupValue");
		var h = $(this).parents(".head").find("h3").text();
		heading.val(h);
		heading.focus();
	});
	$(".cannelBtn").live('click',function(){
		$(".innerLabelHeadeModify").remove();
		$(".classTitle").removeClass("hidden");
	});
	$(".rightBtn").live('click',function(){
		var headTitle = $.trim($("#groupValue").val());
		var parent = $(this).parents(".classSort");
		var id = parent.attr("id").substr(9);
		var act = 'headMod';
		var T_show = $("#loader");
		var headTitle = $.trim($("#groupValue").val());
		if(headTitle=="") {
		T_show.html("<span>标题不能为空</span>");
		setTimeout(function(){T_show.html("");},2500);
		return false;
		}
		$.ajax({
			type: "get",
			url: 'source/plugin/king1992_mark/class/update.class.php',
			data: { id: id,act: act,headTitle: headTitle },   
			beforeSend: function() {
			T_show.html("<span><img src='source/plugin/king1992_mark/image/load.gif' /> 正在更新</span>");
			},
			error: function(err) {
				T_show.html(err);
			},
			success: function(msg) {
				T_show.html(msg);console.log('msg',msg);
				if(msg){
					$(".classTitle").removeClass("hidden");
					parent.removeClass("mHover");
					$(".innerLabelHeadeModify").remove();
					var a = parent.find("h3");
					a.text(headTitle);
				}else{
					T_show.html("<span>您没有更改或分类已存在</span>");
					setTimeout(function(){T_show.html("");},2500);

				}

			}
		});
	});
});
$(function(){
	$(".ui-state-list").live('mouseover mouseout',function(){
		$(this).toggleClass("mHover");
	});
	var formhtml = 	//'<li class="addbox">'+
						'<div class="form-group" id="addform_">'+
							'<p class="input-txt">'+
								'<label class="label-control hidden" for="website">网址</label>'+
								'<input id="wangZhi" type="text" name="website" class="input-control" placeholder="http://" maxlength="150" />'+
							'</p>'+
							'<p class="input-txt">'+
								'<label class="label-control hidden" for="web">网站名称</label>'+
								'<input id="siteName"type="text" name="web" class="input-control" placeholder="名称" maxlength="50" />'+
							'</p>'+
							'<p class="input-txt">'+
								'<label class="label-control hidden" for="remark">备注</label>'+
								'<input id="beiZhu" type="text" name="remark" class="input-control" placeholder="备注(最多50个字)" maxlength="50" />'+
							'</p>'+
								'<span onclick="addMark(this)" class="addSub addCancal" id="addsub_">添加</span><span onclick="rmForm(this)" class="addCancal cancal" id="cancal_">取消</span>'+
						'</div>';
					//'</li>';
	$(".add-form").live('click',function(){
		$(".form-group").remove();
		$(this).prev().append(formhtml);
		$("#wangZhi").focus();
		$(".add-form").css("display","block");
		$(this).css("display","none");
	});
});
	function rmForm(a){
		$(".shareLabel").remove();
		$(a).parents(".connectedSortable").next().css("display","block");//removeClass("hidden");
		$(a).parents(".ui-state-list").removeClass("mHover");
		$(a).parent().prev().removeClass("hidden");
		$(a).parent().remove();
	}

 $(function() {
	$(".upIcon,.downIcon").live('click',function() {
		 T_show = $("#loader");
         $(this).toggleClass("upIcon downIcon");
		 var attr = $(this).attr("title");
		 attr=attr=="收起"?"展开":"收起";
		 attrState = attr=="收起"?0:1;console.log('state',attrState);
		 $(this).attr("title",attr);
		 $(this).parents(".head").next().toggle(300);
		 var act = 'attrState';
		 var id = $(this).attr("id").substr(10);
		 console.log('id',id);
		 $.ajax({
            type: "get",
            url: 'source/plugin/king1992_mark/class/update.class.php',
            data: { id: id,attrState: attrState,act: act },   
            beforeSend: function() {
                T_show.html("<span><img src='source/plugin/king1992_mark/image/load.gif' /> 正在更新</span>");
            },
			error: function(err) {
				T_show.html(err);
			},
            success: function(msg) {
				T_show.html("");
            }
        });
	});
 });
 $(function(){
	$(".ui-state-list .delRecIcon").live("click",function() {
		var id = $(this).attr("id").substr(6);
		var pid = $(this).parents(".classSort").attr("id").substr(9);
		var remove = $(this).parents(".ui-state-list");
		var act = "drop";
		var T_show = $("#loader");
		$.ajax({
			type: "get",
			url: 'source/plugin/king1992_mark/class/update.class.php',
			data: { id: id,act: act,pid: pid },   
			beforeSend: function() {
			T_show.html("<span><img src='source/plugin/king1992_mark/image/load.gif' /> 正在更新</span>");
			},
			error: function(err) {
				T_show.html(err);
			},
			success: function(msg) {
				T_show.html("<span>删除成功</span>");
				setTimeout(function(){T_show.html("");},2500);
				//var a = $(this).parents(".ui-state-list");
				remove.css("display","none");
			}
		});
	});
	$(".ui-state-list .modRecIcon").live("click",function() {
		var id = $(this).attr("id").substr(5);
		var pid = $(this).parents(".classSort").attr("id").substr(9);
		var edit = $(this).parents(".ui-state-list");
		var message = $(this).parent().find("a");
		var link = message.attr("href");
		var word = message.text();
		$(".shareLabel").remove();
		$(".editBox").removeClass("hidden");
		$(this).parents(".editBox").addClass("hidden");
		$(".form-group").remove();
		var editHtml = '<div class="form-group" id="addform_">'+
							'<p class="input-txt">'+
								'<label class="label-control hidden" for="website">网址</label>'+
								'<input id="wangZhi" type="text" name="website" class="input-control" placeholder="http://" maxlength="150"/>'+
							'</p>'+
							'<p class="input-txt">'+
								'<label class="label-control hidden" for="web">网站名称</label>'+
								'<input id="siteName"type="text" name="web" class="input-control" placeholder="名称" maxlength="50" />'+
							'</p>'+
							'<p class="input-txt">'+
								'<label class="label-control hidden" for="remark">备注</label>'+
								'<input id="beiZhu" type="text" name="remark" class="input-control" placeholder="备注(最多50个字)" maxlength="50" />'+
							'</p>'+
								'<span onclick="editMark(this)" class="addSub addCancal" id="addsub_">确定</span><span onclick="rmForm(this)" class="addCancal cancal" id="cancal_">取消</span>'+
						'</div>';
		edit.append(editHtml);
		$("#wangZhi").val(link);
		$("#siteName").val(word);
		$("#wangZhi").focus();
		$(".add-form").css("display","block");
	});
	$(".shareRecIcon").live("click",function() {
		$(".shareLabel").remove();
		$(".form-group").remove();
		var html = '<div id="shareDiv" class="shareLabel hidden">'+
									'<div class="bg-arrow"></div>'+
									'<div class="area-share"><span>分享到</span><a href="#" title="新浪微博" class="btn-sina btn-sina2" _hover-ignore="1"></a><a href="#" title="腾讯微博" class="btn-t-qq btn-t-qq2"></a><a href="#" title="qq空间" class="btn-qzone btn-qzone2"></a></div>'+
								'</div>';
		$(this).parents(".ui-state-list").append(html);
		$(".shareLabel").toggleClass("hidden");
	});
});
function addMark(e){
	var id = $(e).parents(".classSort").attr("id").substr(9);
	var sort = $(e).parents(".form-group").index();
	console.log('classSort',id);
	var act = 'add';
	var T_show = $("#loader");
	var wangZhi = $.trim($("#wangZhi").val());
	var siteName = $.trim($("#siteName").val());
	var beiZhu = $.trim($("#beiZhu").val());
	if(wangZhi=="") {
		T_show.html("<span>网址不能为空</span>");
		return false;
	}
	if(siteName=="") {
		T_show.html("<span>网站名不能为空</span>");
		return false;
	}
	var wangZhi = /http:\/\//.test(wangZhi)?wangZhi:"http://"+wangZhi;
	console.log('wangZhi:',wangZhi);
	$.ajax({
        type: "get",
        url: 'source/plugin/king1992_mark/class/update.class.php',
		timeout:30000,
        data: { id: id,act: act,wangZhi: wangZhi,siteName: siteName,beiZhu: beiZhu,sort: sort },   
        beforeSend: function() {
        T_show.html("<span><img src='source/plugin/king1992_mark/image/load.gif' /> 正在更新</span>");
        },
		error: function(err) {
			T_show.html(err);
		},
        success: function(msg) {
			if(!/^[0-9]{1,}$/.test(msg)){
				T_show.html("<span>"+msg+"</span>");
				setTimeout(function(){T_show.html("");},2500);
				return false;
			}
			if(msg){
				listHtml = '<li class="ui-state-list" id="a_'+msg+'">'+
								'<div class="edit">'+
									'<span id="share_'+msg+'" class="delRecIcon" title="删除"></span>'+
									'<span id="edit_'+msg+'" class="modRecIcon" title="编辑"></span>'+
									'<span id="rm_'+msg+'" class="shareRecIcon" title="分享"></span>'+	
									'<span id="ico_'+msg+'" class="favIcon defaultIcon"></span>'+
									'<div class="bookmark">'+
										'<a href="'+wangZhi+'" target="_blank"><em class="link-word">'+siteName+'</em></a>'+
									'</div>'+
								'</div>'+
							'</li>';
				$(e).parents(".connectedSortable").append(listHtml);
				$(".form-group").remove();
				$(".add-form").css("display","block");
				T_show.html("<span>添加成功!</span>");console.log("hello");
				setTimeout(function(){T_show.html("");},2500);
			}
        }
    });
}
function editMark(e){
	var parent = $(e).parents(".ui-state-list");
	var id = parent.attr("id").substr(2);
	var act = 'edit';
	var T_show = $("#loader");
	var wangZhi = $.trim($("#wangZhi").val());
	var siteName = $.trim($("#siteName").val());
	var beiZhu = $.trim($("#beiZhu").val());
	if(wangZhi=="") {
		T_show.html("<span>网址不能为空</span>");
		return false;
	}
	if(siteName=="") {
		T_show.html("<span>网站名不能为空</span>");
		return false;
	}
	$.ajax({
        type: "get",
        url: 'source/plugin/king1992_mark/class/update.class.php',
        data: { id: id,act: act,wangZhi: wangZhi,siteName: siteName,beiZhu: beiZhu },   
        beforeSend: function() {
        T_show.html("<span><img src='source/plugin/king1992_mark/image/load.gif' /> 正在更新</span>");
        },
		error: function(err) {
			T_show.html(err);
		},
        success: function(msg) {
			T_show.html("<span>更新成功</span>");
			setTimeout(function(){T_show.html("");},2500);
			if(msg){
				$(".editBox").removeClass("hidden");
				parent.removeClass("mHover");
				$(".form-group").remove();
				var a = parent.find("a");
				a.attr("href",wangZhi);
				a.attr("title",beiZhu);
				a.text(siteName);
			}
        }
    });
}
  $(function() {
	$( ".P_connectedSortable" ).sortable({
		connectWith: ".P_connectedSortable",
		placeholder: "placeholder",
		handle:".Drop",
		update: function(){
			T_show = $("#loader");
			pid = $(this).attr('id');console.log('tid',pid);
			act = 'parentSort';
			  new_order = $(this).sortable("serialize");console.log('new_order:',new_order);
			  T_url = "source/plugin/king1992_mark/class/update.class.php";
			$.ajax({
                type: "get",
                url: T_url,
                data: { id: new_order,pid: pid,act: act },   
                beforeSend: function() {
                    T_show.html("<span><img src='source/plugin/king1992_mark/image/load.gif' /> 正在更新</span>");console.log(T_url);
                },
				error: function(err) {
					T_show.html(err);
				},
                success: function(msg) {
                	T_show.html("");
                }
            });
		}
			
	}).disableSelection();
    $( ".connectedSortable" ).sortable({
      connectWith: ".connectedSortable",
	  items: "li:not(.form-group)",
		update: function(){
			T_show = $("#loader");
			pid = $(this).parent().attr('id');console.log('tid',pid);
			act = 'listSort';
			  new_order = $(this).sortable("serialize");console.log('new_order:',new_order);
			  T_url = "source/plugin/king1992_mark/class/update.class.php";
			$.ajax({
                type: "get",
                url: T_url,
                data: { id: new_order,pid: pid,act: act },   
                beforeSend: function() {
                    T_show.html("<span><img src='source/plugin/king1992_mark/image/load.gif' /> 正在更新</span>");console.log(T_url);
                },
				error: function(err) {
					T_show.html(err);
				},
                success: function(msg) {
                	T_show.html("");
                }
            });
		}
    }).disableSelection();
  });