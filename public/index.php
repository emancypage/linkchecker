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
</head>
<body>
	<h1>Link checker</h1>
	<form action="./index.php" method="POST">
		<textarea name="links"></textarea>

		<input type="submit">
	</form>

	<table>
		<tr>
			<td>Url</td>
			<td>Status</td>
			<td>301 redirection location</td>
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