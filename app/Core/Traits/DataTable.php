<?php


namespace App\Core\Traits;

use App\Core\Request;

trait DataTable
{

    protected $fields = [];
    protected $params = [];


    public function setDatatable(Request $request)
    {
        $requestData = $request->all()['post'];
        unset($requestData['sett']);
        return $this->generateDataTable($requestData);
    }

    protected function generateDataTable($data)
    {
        $draw = $data['draw'];
        $columns = $data['columns'];
        $order = $data['order'];
        $limit = $data['length'];
        $offset = $data['start'];


        foreach ($columns as $column) {
            if ($column['data'] !== 'sett') {
                $this->fields[] = $column['data'];
            }
        }

        $orderColumn = $this->fields[$order[0]['column']];
        $orderDir = $order[0]['dir'];
        $this->params = [
            'draw' => $draw,
            'dir' => $orderDir,
            'col' => $orderColumn,
            'limit' => $limit,
            'offset' => $offset
        ];

        return $this;
    }

    protected function genQuery($customQuery, $full = false)
    {
        if ($customQuery) {
            $count = $customQuery->count();
            if (!$full) {
                $query = $customQuery->limit($this->params['limit'])->offset($this->params['offset'])
                    ->orderBy($this->params['col'], $this->params['dir'])
                    ->get();
            } else {
                $query = $customQuery->get();
            }


            $tableResponse = [];
            $tableResponse['draw'] = $this->params['draw'];
            $tableResponse['data'] = $query;
            $tableResponse['recordsTotal'] = $count;
            $tableResponse['recordsFiltered'] = $count;
            return $tableResponse;
        }
    }
}
