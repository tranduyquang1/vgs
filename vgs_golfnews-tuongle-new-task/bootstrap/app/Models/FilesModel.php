<?php

namespace App\Models;

use App\Models\Relations\FilesRelationTrait;
use Carbon\Carbon;
use DB;

class FilesModel extends AdminModel
{
    use FilesRelationTrait;

    public function __construct()
    {
        $this->table = 'files';
        $this->folderUpload = 'files';
        $this->fieldSearchAccepted = ['id', 'description'];

        parent::__construct();
    }

    public function listItems($params = null, $options = null)
    {
        $result = null;

        if ($options['task'] == "admin-list-items") {
            $query = $this->select();

            if ($params['filter']['status'] !== "all") {
                $query->where('status', '=', $params['filter']['status']);
            }

            if ($params['search']['value'] !== "") {
                if ($params['search']['field'] == "all") {
                    $query->where(function ($query) use ($params) {
                        foreach ($this->fieldSearchAccepted as $column) {
                            $query->orWhere($column, 'LIKE', "%{$params['search']['value']}%");
                        }
                    });
                } else if (in_array($params['search']['field'], $this->fieldSearchAccepted)) {
                    $query->where($params['search']['field'], 'LIKE', "%{$params['search']['value']}%");
                }
            }

            $query->orderBy('id', 'desc');
            $result = $query->paginate($params['pagination']['totalItemsPerPage']);
        }

        return $result;
    }

    public function countItems($params = null, $options = null)
    {
        $result = null;

        if ($options['task'] == 'admin-count-items') {

            $query = $this::groupBy('status')
                ->select(DB::raw('status , COUNT(id) as count'));

            if ($params['search']['value'] !== "") {
                if ($params['search']['field'] == "all") {
                    $query->where(function ($query) use ($params) {
                        foreach ($this->fieldSearchAccepted as $column) {
                            $query->orWhere($column, 'LIKE', "%{$params['search']['value']}%");
                        }
                    });
                } else if (in_array($params['search']['field'], $this->fieldSearchAccepted)) {
                    $query->where($params['search']['field'], 'LIKE', "%{$params['search']['value']}%");
                }
            }

            $result = $query->get()->toArray();
        }

        return $result;
    }

    public function getItem($params = null, $options = null)
    {
        $result = null;

        if ($options['task'] == 'get-item') {
            $result = self::select()->where('id', $params['id'])->first();
        }

        if ($options['task'] == 'get-file') {
            $result = self::select('id', 'file')->where('id', $params['id'])->first();
        }

        return $result;
    }

    public function saveItem($params = null, $options = null)
    {
        $username = session('userInfo')['username'];

        if ($options['task'] == 'change-status') {
            $status = ($params['currentStatus'] == "active") ? "inactive" : "active";
            self::where('id', $params['id'])->update(['status' => $status]);
        }

        if ($options['task'] == 'add-item') {
            $params['file'] = $this->uploadFile($params['file']);
            $params['status'] = 'inactive';
            $params['created_by'] = $username;
            $params['created'] = date('Y-m-d H:i:s');

            self::where('id', '>', 0)->increment('sort');
            $params['sort'] = 1;

            $id = self::insertGetId($this->prepareParams($params));

            // read excel file
            $companyModel = new CompanyModel();
            $sheetsModel = new SheetsModel();
            $link = public_path('images/files/' . $params['file']);
            $type = 'Xlsx';
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($type);
            $spreadsheet = $reader->load($link);

            // each sheet
            $workSheetNames = $reader->listWorksheetNames($link);
            foreach ($workSheetNames as $sheetName) {
                $sheetId = $sheetsModel->saveItem([
                    'files_id' => $id,
                    'name' => $sheetName,
                ], ['task' => 'add-item']);
                $sheet = $spreadsheet->getSheetByName($sheetName);
                $sheetData = $sheet->toArray(null, true, true, true);
                unset($sheetData[1]);

                foreach ($sheetData as $data) {
                    $params = [
                        'sheets_id' => $sheetId,
                        'ngay_xuat_hang' => !empty($data['A']) ? Carbon::parse($data['A'])->format('Y-m-d') : null,
                        'tuan_xuat_hang' => $data['B'] ?? '',
                        'art' => $data['C'] ?? '',
                        'art_theo_kieu_moi' => $data['D'] ?? '',
                        'ten_ma_hang' => $data['E'] ?? '',
                        'revision' => $data['F'] ?? '',
                        'revision_theo_kieu_moi' => $data['G'] ?? '',
                        'code_nm' => $data['H'] ?? '',
                        'so_luong' => $data['I'] ?? '',
                        'nhan_tuan' => $data['J'] ?? '',
                        'deviation' => $data['K'] ?? '',
                        'chu_cai_cont_noi_bo' => $data['L'] ?? '',
                        'qc_kiem' => $data['M'] ?? '',
                        'message' => $data['N'] ?? '',
                        'status' => 0,
                        'note' => '',
                    ];
                    $companyModel->saveItem($params, ['task' => 'add-item']);
                }
            }

        }

        if ($options['task'] == 'edit-item') {
            if (!empty($params['file'])) {
                $this->deleteThumb($params['file_current']);
                $params['file'] = $this->uploadFile($params['file']);
            }
            $params['modified_by'] = $username;
            $params['modified'] = date('Y-m-d H:i:s');

            self::where('id', $params['id'])->update($this->prepareParams($params));
        }
    }

    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item') {
            $item = self::getItem($params, ['task' => 'get-file']);
            $this->deleteThumb($item['file']);
            self::where('id', $params['id'])->delete();
        }
    }
}

