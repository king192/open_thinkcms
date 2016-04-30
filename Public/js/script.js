
	$(function(){
		window.onload = function(){
			$.ajax({
				url:'chat_ajax',
				data:{},
				type:'POST',
				dataType:'json',
				success:function(data){
					console.log('data',data);
					$('body').append(data.data);
					bg = typeof bg == "undefined"?'url('+$('.msg').attr('dataBg')+')':bg;
					$('.input input').focus(function(){
						$('.top').css({'position':'fixed','z-index':'-99999999999999'});
						$('.msg').css('background','none'); 
						$('.giftbox').hide();
					});
					$('.input input').blur(function(){
						$('.top').css('position','relative');
						$('.msg').css('background',bg); 
					});
					gift();
					// var height = $(window).height() - $('.msg').offset().top;
					// $('.msg').height(height);
				},
				error:function(e){
					console.log('e',e);
				},
				complete:function(){
					console.log('complete');
				}

			})
		}
		function gift(){
			$('.gift').click(function(){
				$('.giftbox').fadeToggle();
			})
			$('.gifts').click(function(){
				$(this).parent().hide();
				showgift();
			})
		}
		function showgift(){
			var $imgsrc = $('.gift_flowers').attr('src');
			var $img = document.createElement('img');
			$img.src = $imgsrc;
			$img.className = 'boom show';
			document.body.appendChild($img);
			setTimeout(function(){
				$img.parentNode.removeChild($img);
			},2000)
		}
	})

