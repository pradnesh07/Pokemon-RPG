<?php
	include('top_header.php');
	$fetch = mysql_fetch_array(mysql_query("SELECT * FROM news ORDER BY newsid DESC"));
	echo("\n");
?>
					<div class="content">
						<table align=center width="100%">
							<tr>
								<td class="header" colspan=2>
									<?php
										echo $fetch['title'];
										echo("\n");
									?>
								</td>
							</tr>
							<tr>
								<td class="into">
									<img src="images/images.jpg">
								</td>
								<td class="into">
									<?php
										echo $fetch['text'];
										echo("\n");
									?>
								</td>
							</tr>
							<tr>
								<td class="into">Posted By:
									<?php
										echo $fetch['poster_name'];
										echo("\n");
									?>
								</td>
								<td class="into">Comments:
									<?php 
										$total = mysql_num_rows(mysql_query("SELECT * FROM comments WHERE article_id = {$fetch['newsid']}"));
										echo $total;
										echo("\n");
									?>
								</td>
							</tr>
						</table>
						<?php
							$fetcha = "SELECT * FROM comments WHERE article_id = {$fetch['newsid']} ";
							$grab = mysql_query($fetcha);
							while($list = mysql_fetch_array($grab)) {
								$poster = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE id = {$list['poster_id']}"));
								echo("<p style='text-align:center'><table align=center width=500px>");
								echo("<td class='header' colspan=2 width=100%>");
								echo("Posted by:");
								echo($poster['username']);
								echo("</td>");
								echo("<tr>");
								echo("<td class='into' width=20%>");
								echo("<img src=");
								echo($poster['avatar']);
								echo(">");
								echo("<td class='into'>");
								echo($list['content']);
								echo("</td>");
								echo("</tr>");
								echo("<tr>");
								echo("<td class=into colspan=2>");
								if($poster['signature'] != "") {
									echo $poster['signature'];
								} else {
									echo "This user has no signature";
								}
								echo "</td></tr></table></p>";
							}
							if(isset($_POST['submit'])) {
								$yourcomment = parse($_POST['comment']);
								$commentit = mysql_query("INSERT INTO `comments` (`article_id`, `poster_id`, `content`) VALUES ('".$fetch['newsid']."', '$id', '$yourcomment');");
							}
							echo("\n");
						?>
						<table align=center width="100%">
							<p style='text-align:center'>
								<form action="news.php?comment=submited" method=post>
									<textarea name=comment rows=8 cols=50>Comment!</textarea>
									<input type=submit name=submit value="Post comment">
								</form>
							</p>
						</table>
					</div>
						<?php
							echo("\n");
							include('bottom_layout.php');
						?>