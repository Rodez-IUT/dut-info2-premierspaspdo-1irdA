<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>All users</title>
	</head>
	<body>

		<style>

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

    </style>
		<?php
			$host = 'localhost';
			$db   = 'my_activities';
			$user = 'root';
			$pass = 'root';
			$charset = 'utf8mb4';
			$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
			$options = [
				PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				PDO::ATTR_EMULATE_PREPARES   => false,
			];
			try {
				//  canal de communication avec la base de données
				$pdo = new PDO($dsn, $user, $pass, $options);
			} catch (PDOException $e) {
				throw new PDOException($e->getMessage(), (int)$e->getCode());
			}
		?>
		<h1>All users</h1>

		<form method="post" action="all_users3.php">
			<label>Lettre à saisir : </label>
			<input type="text" name="lettre">
			&nbsp;
			<label>Status à sélectionner : </label>
			<select name="status">
				<option value="All">All</option>
				<option value="Active account">Active account</option> <!-- 2 -->
				<option value="Waiting for account validation">Waiting for account validation</option> <!-- 1 -->
				<option value="Waiting for account deletion">Waiting for account deletion</option> <!-- 3 -->
			</select>
			&nbsp;
			<button type="submit">Valider</button>
		</form>

		<!-- Valeurs récupérées du formulaire -->
		<?php 
		    if (isset($_POST['lettre'])) {
				$lettre = htmlspecialchars($_POST['lettre']); 
				$leStatus = $_POST['status'];
			}
		?>

		<table>
			<tr>
				<th>Id</th>
				<th>Username</th>
				<th>Email</th>
				<th>Status</th>
			</tr>
		
		<?php
			$sql = "SELECT users.id AS user_id, username, email, name
					FROM users 
					JOIN status s ON users.status_id = s.id 
					WHERE username LIKE '$lettre%' 
					/*AND s.id = $leStatus*/
					ORDER BY username";

			$stmt = $pdo->query($sql);
			
			while ($row = $stmt->fetch()) {
				echo "<tr>";
				echo "<td>".$row['user_id']."</td>";
				echo "<td>".$row['username']."</td>";
				echo "<td>".$row['email']."</td>";
				echo "<td>".$row['name']."</td>";
				echo "</tr>";
			}
		?>

		</table>

	</body>
</html>