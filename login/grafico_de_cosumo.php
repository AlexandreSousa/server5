<?php require_once('Connections/Conexao.php'); ?>
<?php
	/* Libchart - PHP chart library
	 * Copyright (C) 2005-2010 Jean-Marc Trémeaux (jm.tremeaux at gmail.com)
	 * 
	 * This program is free software: you can redistribute it and/or modify
	 * it under the terms of the GNU General Public License as published by
	 * the Free Software Foundation, either version 3 of the License, or
	 * (at your option) any later version.
	 * 
	 * This program is distributed in the hope that it will be useful,
	 * but WITHOUT ANY WARRANTY; without even the implied warranty of
	 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	 * GNU General Public License for more details.
	 *
	 * You should have received a copy of the GNU General Public License
	 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
	 * 
	 */
	
	/*
	 * Vertical bar chart demonstration
	 *
	 */

	include "libchart/libchart/classes/libchart.php";
	$user = $_SESSION['MM_Username'];
	
	$comando = "SELECT * FROM sessao WHERE login = '$user'";
	$sql = mysql_query($comando);

	$chart = new VerticalBarChart();

	$dataSet = new XYDataSet();
	$linhas = mysql_num_rows($sql);
	for($i=0;$i<$linhas;$i++){
	$down = mysql_result($sql,$i,'down');
	$data = mysql_result($sql,$i,'data');
	
	$dataSet->addPoint(new Point("$data", $down));
	
	}
	$chart->setDataSet($dataSet);

	$chart->setTitle("Gerado por www.uniaomaker.com.br");
	$chart->render("libchart/demo/generated/demo$user.png");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Libchart vertical bars demonstration</title>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
	<img alt="Vertical bars chart" src="libchart/demo/generated/demo<?php echo $user; ?>.png" style="border: 1px solid gray;"/>
</body>
</html>
