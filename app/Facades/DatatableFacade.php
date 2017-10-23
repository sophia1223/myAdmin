<?php
namespace App\Facades;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

class DatatableFacade extends Facade {
    
    const DT_ON = '<span class="badge bg-green">%s</span>';
    const DT_OFF = '<span class="badge bg-gray">%s</span>';
    const DT_LINK_EDIT = <<<HTML
        <a id="%s" href="javascript:void(0)" class="btn btn-success btn-icon btn-circle btn-xs">
            <i class="fa fa-edit"></i>
        </a>
HTML;
    const DT_LINK_DEL = <<<HTML
        <a id="%s" href="javascript:void(0)" class="btn btn-danger btn-icon btn-circle btn-xs" data-toggle="modal">
            <i class="fa fa-trash"></i>
        </a>
HTML;
    const DT_LINK_SHOW = <<<HTML
        <a id="%s" href="javascript:void(0)" class="btn btn-primary btn-icon btn-circle btn-xs"  data-toggle="modal">
            <i class="fa fa-eye"></i>
        </a>
HTML;
    const DT_LINK_RECHARGE = <<<HTML
        <a id="%s" href="javascript:void(0)" class="btn btn-primary btn-icon btn-circle btn-xs"  >
            <i class="fa fa-money"></i>
        </a>
HTML;
    const DT_SPACE = '&nbsp;';
    const DT_PRIMARY = '<span class="badge badge-info">%s</span>';
    const DT_LOCK = '<i class="fa fa-lock"></i>&nbsp;已占用';
    const DT_UNLOCK = '<i class="fa fa-unlock"></i>&nbsp;空闲中';
    
    /**
     * Perform the SQL queries needed for an server-side processing requested,
     * utilising the menu functions of this class, limit(), order() and
     * filter() among others. The returned array is ready to be encoded as JSON
     * in response to an SSP request, or can be modified if needed before
     * sending back to the client.
     *
     * @param Model $model
     * @param array $columns Column information array
     * @param array $joins
     * @param string $condition
     * @return array Server-side processing response array
     * @internal param array|PDO $conn PDO connection resource or connection parameters array
     * @internal param string $table SQL table to query
     * @internal param string $primaryKey Primary key of the table
     */
    static function simple(Model $model, array $columns, array $joins = null, $condition = null) {
        $modelName = class_basename($model);
        $tableName = $model->getTable();
        switch ($modelName) {
            case 'Group':
                $useTable = 'Groups';
                break;
            case 'Order':
                $useTable = 'Orders';
                break;
            case 'Table':
                $useTable = 'Tables';
                break;
            case 'Procedure':
                $useTable = 'Procedures';
                break;
            default:
                $useTable = $modelName;
                break;
        }
        $from = $tableName . ' AS ' . $useTable;
        if (isset($joins)) {
            foreach ($joins as $join) {
                $from .=
                    ' ' . $join['type'] . ' JOIN ' . $join['table'] .
                    ' AS ' . $join['alias'] .
                    ' ON ' . implode(' AND ', $join['conditions']);
            }
        }
        // Build the SQL query string from the request
        $limit = self::limit();
        $order = self::order($columns);
        $where = self::filter($columns);
        if (!empty($condition)) {
            $where = empty($where) ? ' WHERE ' . $condition : $where . ' AND ' . $condition;
        }
    
        // Main query to actually get the data
        $query = "SELECT SQL_CALC_FOUND_ROWS " .
            implode(", ", self::pluck($columns, 'db')) .
            " FROM " . $from . $where . $order . $limit;
        $data = DB::select($query);
        // Data set length after filtering
        $resFilterLength = DB::select("SELECT FOUND_ROWS() AS t");
        $recordsFiltered = $resFilterLength[0]->t;
        // Total data set length
        $resTotalLength = DB::select("SELECT COUNT(*) AS t FROM " . $tableName)[0]->t;
        $recordsTotal = $resTotalLength;
        
        // Output
        return [
            "draw"            => intval(Request::get('draw')),
            "recordsTotal"    => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data"            => self::data_output($columns, $data),
        ];
        
    }
    
    /**
     * Paging
     *
     * Construct the LIMIT clause for server-side processing SQL query
     * @return string SQL limit clause
     * @internal param Request $request Data sent to server by DataTables
     * @internal param array $columns Column information array
     */
    private static function limit() {
        $limit = '';
        $start = Request::get('start');
        $length = Request::get('length');
        if (isset($start) && $length != -1) {
            $limit = "LIMIT " . intval($start) . ", " . intval($length);
        }
        
        return $limit;
        
    }
    
    /**
     * Ordering
     *
     * Construct the ORDER BY clause for server-side processing SQL query
     *
     * @param array $columns Column information array
     * @return string SQL order by clause
     * @internal param Request $request Data sent to server by DataTables
     */
    private static function order(array $columns) {
        $orderBy = '';
        $order = Request::get('order');
        if (isset($order) && count($order)) {
            $orderBy = [];
            $dtColumns = self::pluck($columns, 'dt');
            for ($i = 0, $ien = count($order); $i < $ien; $i++) {
                // Convert the column index into the column data property
                $columnIdx = intval($order[$i]['column']);
                $requestColumn = Request::get('columns')[$columnIdx];
                $columnIdx = array_search($requestColumn['data'], $dtColumns);
                $column = $columns[$columnIdx];
                if ($requestColumn['orderable'] == 'true') {
                    $dir = $order[$i]['dir'] === 'asc' ? ' ASC ' : ' DESC ';
                    $pos = stripos($column['db'], ' as ');
                    if ($pos) {
                        $column['db'] = substr($column['db'], 0, $pos);
                    }
                    $orderBy[] = /*'`' . */
                        $column['db'] . ' ' . $dir;
                }
            }
            $orderBy = ' ORDER BY ' . implode(', ', $orderBy);
        }
        
        return $orderBy;
        
    }
    
    /**
     * Pull a particular property from each assoc. array in a numeric array,
     * returning and array of the property values from each item.
     *
     * @param array $a Array to get data from
     * @param string $prop Property to read
     * @return array        Array of property values
     */
    private static function pluck(array $a, $prop) {
        $out = [];
        for ($i = 0, $len = count($a); $i < $len; $i++) {
            $out[] = $a[$i][$prop];
        }
        
        return $out;
        
    }
    
    /**
     * Searching / Filtering
     *
     * Construct the WHERE clause for server-side processing SQL query.
     *
     * NOTE this does not match the built-in DataTables filtering which does it
     * word by word on any field. It's possible to do here performance on large
     * databases would be very poor
     *
     * @param array $columns Column information array
     * @return string SQL where clause
     * @internal param Request $request Data sent to server by DataTables
     * @internal param array $bindings Array of values for PDO bindings, used in the
     *    sql_exec() function
     */
    private static function filter(array $columns) {
        $globalSearch = [];
        $columnSearch = [];
        $dtColumns = self::pluck($columns, 'dt');
        $requestSearch = Request::get('search');
        $requestColumns = Request::get('columns');
        if (isset($requestSearch) && $requestSearch['value'] != '') {
            $str = $requestSearch['value'];
            for ($i = 0, $ien = count($requestColumns); $i < $ien; $i++) {
                $requestColumn = $requestColumns[$i];
                $columnIdx = array_search($requestColumn['data'], $dtColumns);
                $column = $columns[$columnIdx];
                if ($requestColumn['searchable'] == 'true') {
                    # $binding = self::bind($bindings, '%' . $str . '%', PDO::PARAM_STR);
                    $pos = stripos($column['db'], ' as ');
                    if ($pos) {
                        $column['db'] = substr($column['db'], 0, $pos);
                    }
                    $globalSearch[] = $column['db'] . " LIKE BINARY '%" . $str . "%'";
                }
            }
        }
        // Individual column filtering
        for ($i = 0, $ien = count($requestColumns); $i < $ien; $i++) {
            $requestColumn = $requestColumns[$i];
            $columnIdx = array_search($requestColumn['data'], $dtColumns);
            $column = $columns[$columnIdx];
            $str = $requestColumn['search']['value'];
            if ($requestColumn['searchable'] == 'true' && $str != '') {
                # $binding = self::bind($bindings, '%' . $str . '%', PDO::PARAM_STR);
                $columnSearch[] = $column['db'] . " LIKE BINARY '%" . $str . "%'";
            }
        }
        // Combine the filters into a single string
        $where = '';
        if (count($globalSearch)) {
            $where = '(' . implode(' OR ', $globalSearch) . ')';
        }
        if (count($columnSearch)) {
            $where = $where === '' ?
                implode(' AND ', $columnSearch) :
                $where . ' AND ' . implode(' AND ', $columnSearch);
        }
        if ($where !== '') {
            $where = ' WHERE ' . $where;
        }
        
        return $where;
        
    }
    
    /**
     * Create the data output array for the DataTables rows
     *
     * @param  array $columns Column information array
     * @param  array $data Data from the SQL get
     * @return array Formatted data in a row based format
     */
    static function data_output(array $columns, array $data) {
        $out = [];
        $length = count($data);
        for ($i = 0; $i < $length; $i++) {
            $row = [];
            $_data = (array)$data[$i];
            $j = 0;
            foreach ($_data as $name => $value) {
                if (isset($value) && self::validateDate($value)) {
                    Carbon::setLocale('zh');
                    $dt = Carbon::createFromFormat('Y-m-d H:i:s', $value);
                    $value = $dt->diffForhumans();
                }
                
                $column = $columns[$j];
                if (isset($column['formatter'])) {
                    $row[$column['dt']] = $column['formatter']($value, $_data);
                } else {
                    $row[$column['dt']] = $value;
                }
                $j++;
            }
            $out[] = $row;
        }
        
        return $out;
        
    }
    
    /**
     * The difference between this method and the `simple` one, is that you can
     * apply additional `where` conditions to the SQL queries. These can be in
     * one of two forms:
     *
     * * 'Result condition' - This is applied to the result set, but not the
     *   overall paging information query - i.e. it will not effect the number
     *   of records that a user sees they can have access to. This should be
     *   used when you want apply a filtering condition that the user has sent.
     * * 'All condition' - This is applied to all queries that are made and
     *   reduces the number of records that the user can access. This should be
     *   used in conditions where you don't want the user to ever have access to
     *   particular records (for example, restricting by a login id).
     *
     * @param Model $model
     * @param  array $columns Column information array
     * @param  string $whereResult WHERE condition to apply to the result set
     * @param  string $whereAll WHERE condition to apply to all queries
     * @return array Server-side processing response array
     * @internal param Request $request Data sent to server by DataTables
     * @internal param array|PDO $conn PDO connection resource or connection parameters array
     * @internal param string $table SQL table to query
     * @internal param string $primaryKey Primary key of the table
     */
    static function complex(Model $model, $columns, $whereResult = null, $whereAll = null) {
        # $localWhereResult = [];
        # $localWhereAll = [];
        $whereAllSql = '';
        $table = $model->getTable();
        // Build the SQL query string from the request
        $limit = self::limit();
        $order = self::order($columns);
        $where = self::filter($columns);
        $whereResult = self::_flatten($whereResult);
        $whereAll = self::_flatten($whereAll);
        if ($whereResult) {
            $where = $where ?
                $where . ' AND ' . $whereResult :
                'WHERE ' . $whereResult;
        }
        if ($whereAll) {
            $where = $where ?
                $where . ' AND ' . $whereAll :
                'WHERE ' . $whereAll;
            $whereAllSql = 'WHERE ' . $whereAll;
        }
        // Main query to actually get the data
        $data = DB::select(
            "SELECT SQL_CALC_FOUND_ROWS `" .
            implode("`, `", self::pluck($columns, 'db')) .
            "` FROM " . $table . $where . $order . $limit
        );
        // Data set length after filtering
        $resFilterLength = DB::select("SELECT FOUND_ROWS() AS cnt");
        $recordsFiltered = $resFilterLength[0]->cnt;
        // Total data set length
        $resTotalLength = DB::select("SELECT COUNT(*) AS cnt FROM " . $table . $whereAllSql);
        $recordsTotal = $resTotalLength[0]->cnt;
        
        /*
         * Output
         */
        
        return [
            "draw"            => intval(Request::get('draw')),
            "recordsTotal"    => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data"            => self::data_output($columns, $data),
        ];
    }
    
    /**
     * Return a string from an array or a string
     *
     * @param  array|string $a Array to join
     * @param  string $join Glue for the concatenation
     * @return string Joined string
     */
    static function _flatten($a, $join = ' AND ') {
        if (!$a) {
            return '';
        } else if ($a && is_array($a)) {
            return implode($join, $a);
        }
        
        return $a;
        
    }
    
    /**
     * 操作按钮
     *
     * @param $id
     * @param bool $del
     * @param bool $show
     * @param bool $edit
     * @return string
     */
    static function dtOps($id, $del = true, $show = false, $edit = true) {
        $alias = str_replace('index','',Route::currentRouteName());
        $showLink = checkPermission($alias . 'show') && $show ? sprintf(self::DT_LINK_SHOW, 'show_' . $id) : '';
        $delLink = checkPermission($alias . 'destroy') && $del ? sprintf(self::DT_LINK_DEL, $id) : '';
        $editLink = checkPermission($alias . 'edit') && $edit ? sprintf(self::DT_LINK_EDIT, 'edit_' . $id) : '';

        return  $showLink . self::DT_SPACE . $editLink . self::DT_SPACE . $delLink;
        
    }
    
    protected static function getFacadeAccessor() { return 'Datatable'; }
    
    private static function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
}