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
	
	/**
	 * Multiple horizontal bar chart demonstration.
	 *
	 */

	include "libchart/libchart/classes/libchart.php";

	$user = $_SESSION['MM_Username'];
	
	$comando = "SELECT * FROM sessao WHERE login = '$user'";
	$sql = mysql_query($comando);

	

	$linhas = mysql_num_rows($sql);
	for($i=0;$i<$linhas;$i++){
	$down = mysql_result($sql,$i,'down');
	$up = mysql_result($sql,$i,'up');
	$data = mysql_result($sql,$i,'data');
	
	$chart = new VerticalBarChart();
	$serie1 = new XYDataSet();
	$serie1->addPoint(new Point("$data", $down));
		
	
	
	
	
	$serie2 = new XYDataSet();
	$serie2->addPoint(new Point("oiu", 44));
	

	$dataSet = new XYSeriesDataSet();
	$dataSet->addSerie("1990", $serie1);
	$dataSet->addSerie("1995", $serie2);
	$chart->setDataSet($dataSet);
	$chart->getPlot()->setGraphCaptionRatio(0.65);
}
	$chart->setTitle("Average family income (k$)");
	$chart->render("libchart/demo/generated/demo.png");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Libchart line demonstration</title>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
	<img alt="Line chart" src="libchart/demo/generated/demo.png" style="border: 1px solid gray;"/>
</body>
</html>
