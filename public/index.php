<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use LinkChecker\Controller\CheckerController;

$controller = new CheckerController();

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Link Checker</title>
	<style>
		table {
			border-collapse: collapse;
		}
		th, td {
			border: 1px solid;
			padding: 2px 5px;
		}
	</style>
</head>
<body>
	<h1>Link checker</h1>
	<?php if (!empty($controller->getErrors())) { ?>
		<?php foreach ($controller->getErrors() as $errorMessage) { ?>
			<div class="error"><?php echo $errorMessage; ?></div>
		<?php } ?>
	<?php
	} ?>
	<form action="./index.php" method="POST">
		<label>Add links, each in new line:<br>
			<textarea name="links" rows="4" cols="50"></textarea></label>
		<br>
		<input type="submit">
	</form>
	<br>
	<table>
		<tr>
			<th>Url</th>
			<th>Status</th>
			<th>301 redirection location</th>
		</tr>
		<?php foreach ($controller->getStatusArray() as $url => $aData): ?>
			<tr>
				<td><?php echo $url; ?></td>
				<td><?php echo $aData['statusCode']; ?></td>
				<td><?php
					if(array_key_exists('Location', $aData['headers'])) {
						foreach ($aData['headers']['Location'] as $redUrl) {
                            echo $redUrl."\n";
						}
					}
					?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>

</body>
</html>