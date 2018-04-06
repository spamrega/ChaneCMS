<!DOCTYPE html>
<html>
<head>
	%header%
</head>
<body>
	<div class="container" id="form">
		<div class="pay-form">
			<div class="head">%item_name%</div>
			<div class="ways">
				<div class="way-1" id="pr"></div>
				<div class="way-2" id="cr"></div>
			</div>
			<input type="text" id="email" placeholder="email@email.ru" class="form-control email">
		</div>
	</div>
	<div name="amount-error" id="error" class="error" style="display:block;">Введённая сумма меньше минимальной!</div>
	<div class="loader" id="loader" style="display:none;"></div>
	
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			var p_primearea = %pr%;
			var p_cryptonator = %cr%;
			
			if (p_primearea == 1) {
				document.getElementById('pr').style.display = 'block';
			} else {
				document.getElementById('pr').style.display = 'none';
			}
			
			if (p_cryptonator == 1) {
				document.getElementById('cr').style.display = 'block';
			} else {
				document.getElementById('cr').style.display = 'none';
			}
		}, false);
		var item_id = '%id%';
		var email = document.getElementById('email');
		var error = document.getElementById('error');
		var submit_pr = document.getElementById('pr');
		var submit_cr = document.getElementById('cr');

		
		email.oninput = function() {
			if (!validateEmail(email.value)) {
				console.log(email.value);
				email.style.borderColor = 'red';
			} else {
				email.style.borderColor = 'green';
			}
		};
		
		function validateEmail(email) {
			var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			return re.test(email);
		}
		
		submit_pr.addEventListener('click', function (event) {
			if (!validateEmail(email.value)) {
				error.style.opacity = '1';
				error.innerHTML = 'Введен неверный EMAIL';
				setTimeout("error.style.opacity = '0'", 2000);
			} else {
				error.style.opacity = '0';
				proceedPayment(email.value, item_id, 'primearea');
			}
        });
		
		submit_cr.addEventListener('click', function (event) {
			if (!validateEmail(email.value)) {
				error.style.opacity = '1';
				error.innerHTML = 'Введен неверный EMAIL';
				setTimeout("error.style.opacity = '0'", 2000);
			} else {
				error.style.opacity = '0';
				proceedPayment(email.value, item_id, 'cryptonator');
			}
        });
		
		function proceedPayment(email, item_id, system)
		{
			var response = post('/pay/' + system + '/' + item_id, 'email=' + email, system);
			console.log(response);
		}
		
		function submit ()
		{
			document.getElementById("payment").submit();
		}

		function post (handlerPath, parameters, system){
			var response;
			parameters = parameters || '';
			try {
				if (window.XMLHttpRequest) req = new XMLHttpRequest();
				else if (window.ActiveXObject) {
					req = new ActiveXObject('Msxml2.XMLHTTP');
					req = new ActiveXObject('Microsoft.XMLHTTP');
				}
				req.open("POST", handlerPath, true);
				req.onload = function (e) {
					if (req.readyState === 4) {
						response = req.responseText;
						
						if (system === 'primearea') {
							document.getElementById('form').innerHTML = response;
							document.getElementById('form').style.display = 'block';
							document.getElementById('loader').style.display = 'block';
							submit();
						} else {
							window.location.href = response;
							document.getElementById('loader').style.display = 'none';
						}
						
					}
				};
				req.onerror = function (e) {
					console.log(req.statusText);
				};
				req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				req.send(parameters);
				
				document.getElementById('form').style.display = 'none';
				document.getElementById('loader').style.display = 'block';
				
			} catch (e){
				console.log('Error post: '+handlerPath);
				return false;
			}
			return true;
		}
	</script>
</body>
</html>