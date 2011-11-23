<?php
 require("../lib/dhtmlxConnector/codebase/grid_connector.php");
 $res=mysql_connect("localhost","norskver_online","online432A");
 mysql_select_db("norskver_online");
 $gridConn = new GridConnector($res,"MySQL");
 $gridConn->set_config(new GridConfiguration(true));
 $gridConn->render_table("SalesReps","salesreps","repName,repPhone1");
?>