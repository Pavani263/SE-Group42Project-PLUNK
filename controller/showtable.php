<?php
    require_once "E:\Se Project\SE-Group42Project-PLUNK\model\database.php";

    class Table{

        private $DB;
        private $tableName;

        function __construct($table){
            $this->DB = new DB;
            $this->tableName = $table;
        }

        function show($newQuery="", $all=true){
            if($all){
                $sql = "SELECT * FROM plunk.$this->tableName";
            }
            else{
                $sql=$newQuery;
            }
            $result = $this->DB->runQuery($sql);
            $recordCount = count($result);

            $heading = false;
            echo "<table border=1 width=100% >";
            for ($row=0; $row<$recordCount; $row++) {
                echo "<tr>";
                foreach ($result[$row] as $column=>$data){
                    if (!$heading){
                        echo "<th>$column</th>";
                    }
                    else{
                        echo "<td>$data</td>";
                    }
                }
                echo "</tr>";
                if (!$heading){
                    $row--;
                    $heading = true;
                }
            }
            echo "</table>";
        }

    }

?>
