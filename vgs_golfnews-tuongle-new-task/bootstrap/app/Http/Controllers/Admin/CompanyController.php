<?php

namespace App\Http\Controllers\Admin;

use App\Models\CompanyModel as MainModel;
use App\Models\old\StatusModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CompanyController extends AdminController
{
    public function __construct()
    {
        $this->pathViewController = 'admin.pages.company.';
        $this->controllerName = 'company';
        $this->model = new MainModel();
        $this->params["pagination"]["totalItemsPerPage"] = 10;

        parent::__construct();
    }

    public function index(Request $request) 
    {
        $params = $request->all();
        $items = [];
        $isSearch = false;

        if(count($params) > 0)
            foreach($params as $p)
                if(!empty($p)) {
                    $isSearch = true;
                    break;
                }
        $items = ($isSearch) ? $this->model->getBy($params) : [];

        return view($this->pathViewController . 'index', compact('params', 'items', 'isSearch'));
    }

    public function export(Request $request) 
    {
        $params = $request->all();
        $items = [];
        $isSearch = false;

        if(count($params) > 0)
            foreach($params as $p)
                if(!empty($p)) {
                    $isSearch = true;
                    break;
                }
        $items = ($isSearch) ? $this->model->getAll($params) : [];
        
        if(count($items) > 0) {
            $spreadsheet = new Spreadsheet();
            $spreadsheet->getProperties()->setCreator('Gilimex');
            $fileName = 'export-search-'.Carbon::today()->format('d-m-Y');
            $statusArr = StatusModel::where('status', 'active')->pluck('name', 'id');

            // create data export
            $headers = array_merge(['no' => 'STT'], config('zvn.excel_field'));
            unset($headers['cont_no_block']);    
            $data = [];
           
            foreach($items as $index => $company) {
                $diff = array_diff_key($company, $headers);
                foreach($diff as $key => $value)
                    unset($company[$key]);
                
                // convert status value to string    
                if(!empty($company['status']))    
                    $company['status'] = $statusArr[$company['status']]; 
                else
                    $company['status'] = '';

                $data[$index] = array_merge(['no' => $index + 1], $company);
            }

            // ready data sheet
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->fromArray([$fileName]);
            $sheet->fromArray($headers, NULL, 'A1');
            $sheet->fromArray($data, NULL, 'A2');
            $highestRow = $sheet->getHighestRow();

            for ($row = 1; $row <= $highestRow; ++$row) {
                $value = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($row);
                $sheet->getColumnDimension($value)->setAutoSize(true);
            }

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $fileName . '.xlsx"');
            header('Cache-Control: max-age=0');

            \PhpOffice\PhpSpreadsheet\Shared\File::setUseUploadTempDirectory(true);

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            exit;
        }
    }
}
