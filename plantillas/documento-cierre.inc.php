		<script src="<?php echo RUTA_JS ?>jquery.min.js"></script>
		<script src="<?php echo RUTA_JS ?>bootstrap.min.js"></script>
		<script language="Javascript">
			document.oncontextmenu =  function() {
				return false;
			}
			function right(e) {
				var msg = "Prohibido usar click derecho!!!";
				if (navigator.appName == 'Netscape' && e.which == 3) {
					alert(msg);
					return false;
				} else if (navigator.appName == 'Microsoft Internet Explorer' && event.button==2) {
					alert(msg);
					return false;
				}
				return true;
			}
			document.onmousedown = right;
		</script>
	</body>
</html>