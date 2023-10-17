<?php
	session_start();
	if(isset($_REQUEST['delete_history'])) $_SESSION = [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="styles/style.css">
</head>
<body>
	<h1>Basic calculator</h1>
	<form action="<?=$_SERVER["SCRIPT_NAME"]?>">
		<input type="text" name="x">
		<select name="operator">
			<option value="+">+</option>
			<option value="-">-</option>
			<option value="*">*</option>
			<option value="/">/</option>
		</select>
		<input type="text" name="y">
		<input type="submit" value="calculate">
	</form>
	<?php
		if(!isset($_REQUEST['x']) || !isset($_REQUEST['operator']) || !isset($_REQUEST['y'])) {
			echo "<p>Enter operation</p>";
		} elseif(!is_numeric($_REQUEST['x']) || !is_numeric($_REQUEST['y'])) {
			echo "<p>Enter correct numbers</p>";
		} else {
			$x = $_REQUEST['x'];
			$y = $_REQUEST['y'];
			switch($_REQUEST['operator']) {
				case '+':
					$result = $x + $y;
					break;
				case '-':
					$result = $x - $y;
					break;
				case '*':
					$result = $x * $y;
					break;
				case '/':
					try {
						if(!$y) throw new Exception("division by zero");
						$result = $x / $y;
					} catch (Exception $e) {
						echo 'Error: ',  $e->getMessage(), "\n";
						$result = INF;
					}
					break;
				default:
					echo "<p>Wrong operation</p>";
			}
			if(isset($result)) {
				echo "<p>Solution: " . $result . "</p>";
				$record = "<p>" . $x . " " . $_REQUEST['operator'] . " " . $y . " = " . $result . "</p>";
				$_SESSION['logs'][] = $record;
			}
		}
		?>
		<div class="history"> 
		<?php
		if(isset($_SESSION["logs"])) {
			echo "<h2>History:</h2>"; ?>
			<form action="<?=$_SERVER["SCRIPT_NAME"]?>">
				<input type="hidden" name="delete_history">
				<input type="submit" value="delete history">
			</form>
			<?php
			foreach(array_reverse($_SESSION['logs']) as $log) {
				echo "<p>" . $log . "</p>\n";
			}
		}
	?>
		</div>
</body>
</html>