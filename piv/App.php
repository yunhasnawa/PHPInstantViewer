<?php


namespace piv;


class App
{
    private $_db;
    private $_template;
    private $_view;
    private $_tableName;

    const DEFAULT_TEMPLATE = 'piv/assets/index_template.php';

    public function __construct(Db $db, $tableName, $template = null)
    {
        $this->_db = $db;

        $this->_tableName = $tableName;

        $this->_template = $template;

        if($template == null)
            $this->_template = self::DEFAULT_TEMPLATE;

        $this->_view = new View($this->_template);
    }

    public function run()
    {
        $viewData = array(
            'table_name'          => $this->_tableName,
            'pretty_column_names' => $this->_db->getTableColumnNames($this->_tableName, true),
            'column_names'        => $this->_db->getTableColumnNames($this->_tableName, false),
            'records'             => null
        );

        if(isset($_POST['submit']))
            $viewData['records'] = $this->_findRecords();

        $this->_view->setData($viewData);

        $this->_view->render();
    }

    private function _findRecords()
    {
        /*
        Array
        (
            [filter_field] => kode
            [filter_text] => tes
            [submit] => Submit
        )
        */

        // adding filter to prevent sql injection
        $filterField = $this->filterAlphaNumeric($_POST['filter_field']);
        $filterText = $this->filterAlphaNumeric($_POST['filter_text']);

        if(!empty($filterField))
            $where = " WHERE $filterField = '$filterText'";
        else
            $where = '';

        $sql = "SELECT * FROM {$this->_tableName} $where";

        $result = $this->_db->executeQuery($sql);

        if(count($result) > 0)
            return $result;
        else
            return null;
    }
    
    // filter input post to prevent sql injection
    private function filterAlphaNumeric($str = ''){
        return preg_replace("/[^A-Za-z0-9 _-]/", '', $str);
    }
}