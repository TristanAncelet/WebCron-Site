<?php

namespace table;
$root = $_SERVER['DOCUMENT_ROOT'];
include("$root/Libraries/db/query.php");
use db\Query;

class Table_Cell {
    private $formats = array(
        "Normal" => "<div class=\"table_cell\">%s</div>",
        "Header" => "<div class=\"table_header\">%s</div>"
    );

    private $type;
    private $value;

    public function __construct($value, $type){
        $this->set_value($value);
        $this->set_type($type);
    }

    public function set_type($type){ 
        if (array_key_exists($type, $this->formats)){
            $this->type = $type; 
        } else {
            exit("The type provided ({$type}) is not defined.  ");
        }
    }

    public function set_value($value){ 
        $this->value = $value; 
    }

    public function get_format(){
        return $this->formats[$this->type];
    }

    public function get_html(){
        return sprintf($this->formats[$this->type], $this->value);
    }
}

class Table_Row {
    private $cells = array();

    public function add_cell($value, $type){
        $cell = new Table_Cell($value, $type);
        array_push($this->cells, $cell);
        return $cell;
    }

    public function get_html(){
        $output="";
        $output="$output<div class=\"table_row\">";

        foreach ($this->cells as $cell){
            $output="{$output}{$cell->get_html()}";
        }

        $output="{$output}</div>";
        return $output;
    }

}

class Table {
    private Query $query;
    private $name;
    private $pretty_name;
    private $headers;
    private $rows = array();

    public function __construct($name){
        $this->set_name($name);
        $this->query = new Query($name);
    }

    public function get_query(){
        return $this->query;
    }

    private function add_row(){
        $row = new Table_Row();
        array_push($this->rows, $row);
        return $row;
    }

    public function set_name($name){
        $this->name = $name;
    }

    public function set_pretty_name(string $pretty_name){
        $this->pretty_name = $pretty_name;
    }

    public function get_pretty_name(){
        $output=$this->name;
        if (!empty($this->pretty_name)){
            $output=$this->pretty_name;
        }
        return $output;
    }
 
    public function Load($db){
        $res = $db->query($this->query->get_query_string());

        // Getting header row
        $col_count=0;
        $header_row = $this->add_row();

        for ($i = 0; $i < $res->numColumns(); $i++ ){
            $value = $res->columnName($i);
            $header_row->add_cell($value, "Header");
            $col_count++;
        }

        while ($db_row = $res->fetchArray()){
            $row = $this->add_row();

            for ($i = 0; $i < $col_count; $i++){
                $value = $db_row[$i];
                $row->add_cell($value, "Normal");
            }
        }
    }
    public function get_html(){
        $output="";
        $output="{$output}<div class=\"wrapper bordered center_text\">{$this->get_pretty_name()}"; 
        $output="{$output}<div class=\"log_table bordered\">";         

        foreach ($this->rows as $row){
            $row_html = $row->get_html();
            $output="{$output}{$row_html}";
        }

        $output="{$output}</div>"; 
        $output="{$output}</div>"; 
        return $output;
    }
}
?>