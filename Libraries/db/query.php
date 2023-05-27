<?php
namespace db;

class Query {
    private $table_name;
    private array $columns_querying = array();
    private int $limit=0;
    private string $order_by;

    public function __construct(string $table_name){
        $this->table_name = $table_name;
    }
    public function set_columns($columns){
        if (is_array($columns)){
            $this->columns_querying = $columns;
        } 
    }

    public function set_limit(int $limit){
        if ($limit > 0){
            $this->limit = $limit;
        }
    }

    public function set_order_by_column (string $order_by){
        $this->order_by = $order_by;
    }

    private function get_columns(){
        $column_string="";

        if (count($this->columns_querying) === 0){
            $column_string="*";
        } else {
            $columns = implode(',', $this->columns_querying);
            $column_string=$columns;
        }
        return $column_string;
    }

    private function get_limit() {
        $modifier="";
        if ($this->limit > 0){
            $modifier=" LIMIT {$this->limit}";
        }
        return $modifier;
    }

    private function get_order_by(){
        $order_by="";
        if (!empty($this->order_by)){
            $order_by=" ORDER BY {$this->order_by}";
        }
        return $order_by;
    }

    private function get_where() {
        $where = "";
        return $where;
    }

    public function get_query_string(){
        $query = "SELECT {$this->get_columns()} FROM {$this->table_name}{$this->get_where()}{$this->get_order_by()}{$this->get_limit()};";
        return $query;
    }

}
?>