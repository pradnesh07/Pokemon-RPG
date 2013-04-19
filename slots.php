<?php
	include('top_header.php');
	echo("\n");
?>
					<script type="text/javascript">
						function Slots() {
							if(window.XMLHttpRequest) {
								xmlhttp = new XMLHttpRequest();
							} else {
								xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
							}
							xmlhttp.onreadystatechange = function() {
								if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
									document.getElementById("slot").innerHTML = xmlhttp.responseText;
									document.getElementById("click").innerHTML = '<input type="submit" value="Click" class="button" name="click" onclick="Slots();" />';
								} else {
									document.getElementById("slot").innerHTML = '<table align=center><tr><td><img src="/images/slots/slots.gif"></td><td><img src="/images/slots/slots.gif"></td><td><img src="/images/slots/slots.gif"></td></tr></table>';
									document.getElementById("click").innerHTML = "Loading...";
								}
							}
							var spinit = document.getElementById("slot").value;
							xmlhttp.open("POST","slotwork.php",true);
							xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
							xmlhttp.setRequestHeader("Connection", "close");
							xmlhttp.send(spinit);
						}
					</script>
					<div class="content">
						<p style='text-align:center'>
							<div id="slot" class="slots">
								<table align=center width="100%">
									<tr class="noborders">
										<td>
											<img src="/images/slots/spin.png">
										</td>
										<td>
											<img src="/images/slots/spin.png">
										</td>
										<td>
											<img src="/images/slots/spin.png">
										</td>
									</tr>
								</table>
							</div>
							<div id="click">
								<input type="submit" value="Click" class="button" name="click" onclick="Slots();" />
							</div>
						</p>
						<?php
							echo("\n");
							include('bottom_layout.php');
						?>