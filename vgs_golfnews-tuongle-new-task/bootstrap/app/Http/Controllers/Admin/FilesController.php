<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Mail\MailService;
use App\Models\old\UserModel;
use App\Models\FilesModel;
use App\Models\SheetsModel;
use App\Models\old\StatusModel;
use App\Models\CompanyModel;
use Illuminate\Http\Request;
use App\Models\old\EmailBccModel;
use App\Models\CompanyLogsModel;
use App\Models\old\EmailTemplateModel;
use App\Models\FilesModel as MainModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Http\Requests\FilesRequest as MainRequest;

class FilesController extends AdminController
{
    public function __construct()
    {
        $this->pathViewController = 'admin.pages.files.';
        $this->controllerName = 'files';
        $this->model = new MainModel();
        $this->params["pagination"]["totalItemsPerPage"] = 10;

        parent::__construct();
    }

    public function index(Request $request)
    {
        $file = $this->model->where('status', 'active')->orderBy('sort', 'desc')->first();
        $user = session('userInfo');
        if (!in_array($user['level'], [1,2]) && !empty($file))
            return redirect()->route('files/multi');

        $this->params['filter']['status'] = $request->input('filter_status', 'all');
        $this->params['search']['field'] = $request->input('search_field', '');
        $this->params['search']['value'] = $request->input('search_value', '');
        $this->params["select"]["field"] = $request->input('select_field', null);
        $this->params["select"]["value"] = $request->input('select_value', 'default');

        $items = $this->model->listItems($this->params, ['task' => 'admin-list-items']);
        $itemsStatusCount = $this->model->countItems($this->params, ['task' => 'admin-count-items']);

        return view($this->pathViewController . 'index', [
            'params' => $this->params,
            'items' => $items,
            'itemsStatusCount' => $itemsStatusCount
        ]);
    }

    public function save(MainRequest $request)
    {
        if ($request->method() == 'POST') {
            $params = $request->all();
            $task = "add-item";
            $msg = "Thêm phần tử thành công!";

            if ($params['id'] !== null) {
                $task = "edit-item";
                $msg = "Cập nhật phần tử thành công!";
            }
            $this->model->saveItem($params, ['task' => $task]);

            return redirect()->route($this->controllerName)->with("zvn_notify", $msg);
        }
    }

    public function view(Request $request)
    {
        $item = $this->model->where('id', $request->id)->first();
        if(!empty($item)) {
            $sheets = $item->sheets()->get();
            $showFileName = false;
            return view($this->pathViewController . 'view', compact('sheets', 'showFileName'));
        }
    }

    public function multi(Request $request)
    {
        $items = $this->model->where('status', 'active')->get();
        $sheets = [];
        foreach($items as $item) {
            foreach($item->sheets()->get() as $sheet)
                $sheets[] = $sheet;
        }
        $showFileName = true;

        return view($this->pathViewController . 'view', compact('sheets', 'showFileName'));
    }

    public function update(Request $request)
    {
        $params = $request->all();
        $status = false;
        $model = new CompanyModel();
        $id = '';

        try {
            $params['time'] = date('Y-m-d H:i:s', time());
            $task = !empty($params['id']) ? 'edit-item' : 'add-item';
            $id = $model->saveItem($params, ['task' => $task]);
            $message = 'success';
            $status = true;
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'id' => $id,
            'user' => session('userInfo')['fullname'],
            'time' => Carbon::parse($params['time'])->format('H:i:s d-m-Y')
        ]);
    }

    public function add(Request $request)
    {
        $fileObject = FilesModel::where('id', $request->files_id)->first();
        $sheets = $fileObject->sheets()->pluck('name', 'id');
        return view($this->pathViewController . 'add', compact('sheets'));
    }

    public function postAdd(Request $request)
    {
        $params = $request->all();
        $model = new CompanyModel();

        $id = $model->saveItem($params, ['task' => 'add-item']);

        // $logModel = new CompanyLogsModel();
        // $logModel->saveItem([
        //     'company_id' => $id,
        //     'user_id' => session('userInfo')['id']
        // ], ['task' => 'add-item']);

        return back()->with(['sheetId' => $params['sheets_id'], 'zvn_notify' => 'Thêm phần tử thành công!']);
    }

    public function export(Request $request)
    {
        $id = $request->id;
        $files = $this->model->where('id', $id)->first();
        $fileName = 'export-'.Carbon::today()->format('d-m-Y');

        $statusArr = StatusModel::where('status', 'active')->pluck('name', 'id');

        $sheets = $files->sheets()->get();

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()->setCreator('Gilimex');

        foreach($sheets as $sheetData) {
            // add sheet
            $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, $sheetData->name);
            $spreadsheet->addSheet($myWorkSheet);

            // create data export
            $headers = array_merge(['no' => 'STT'], config('zvn.excel_field'));
            unset($headers['cont_no_block']);    
            $data = [];
            $companys = $sheetData->company()->get()->toArray();
            foreach($companys as $index => $company) {
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
            $sheet = $spreadsheet->getSheetByName($sheetData->name);
            $sheet->fromArray([$fileName]);
            $sheet->fromArray($headers, NULL, 'A1');
            $sheet->fromArray($data, NULL, 'A2');
            $highestRow = $sheet->getHighestRow();

            for ($row = 1; $row <= $highestRow; ++$row) {
                $value = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($row);
                $sheet->getColumnDimension($value)->setAutoSize(true);
            }
        }


        // remove sheet default [Worksheet]
        $sheetIndex = $spreadsheet->getIndex(
            $spreadsheet->getSheetByName('Worksheet')
        );
        $spreadsheet->removeSheetByIndex($sheetIndex);
        

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '.xlsx"');
        header('Cache-Control: max-age=0');

        \PhpOffice\PhpSpreadsheet\Shared\File::setUseUploadTempDirectory(true);

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function search(Request $request) 
    {
        $status = false;
        $params = $request->all();

        try {
            $companyModel = new CompanyModel();
            $message = $companyModel->getIdSearchFilter($params);
            $status = true;
        } catch(\Exception $e) {
            $message = $e->getMessage();
        }

        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }

    public function mail(Request $request)
    {
        $status = false;
         try {

            // Get info document  
            $id = $request->id;
            $file = $this->model->where('id', $id)->first();

            // Get user qc
            $usersQC = UserModel::where('level', 3)->get();

            // Get email bcc contact
            $mailService = new MailService();
            $templateItem = EmailTemplateModel::where(['name' => 'EMAIL_TEMPLATE_UPLOAD_NEW_FILE'])->first();
            $title = $mailService->setDataTemplate($templateItem->title, []);
            $content = $mailService->setDataTemplate($templateItem->content, [
                'username' => session('userInfo')['fullname'],
                'file_name' => $file->description,
                'time' => Carbon::now()->format('H:i:s d-m-Y')
            ]);

            $emailBccModel = new EmailBccModel();
            $bccItems = $emailBccModel->getItem(['templateId' => $templateItem->id], ['task' => 'by-template']);
            $bcc = [];
            foreach ($bccItems as $item)
                $bcc[] = $item->email;
    
            // Send mail
            foreach($usersQC as $user)
                $mailService->sendEmail($user->email, $title, $content, $bcc);

            $status = true;
            $message = 'success';

         } catch (\Exception $e) {
            $message = $e->getMessage();
         }

         return response()->json([
            'status' => $status,
            'message' => $message
         ]);
    }

    public function companyEmail(Request $request)
    {
        $status = false;
         try {

            // Get info document  
            $id = $request->id;
            $companyModel = new CompanyModel();
            $company = $companyModel->where('id', $id)->first();
            $sheet = $company->sheet()->first();

            // Get user qc
            $usersQC = UserModel::where('level', 3)->get();

            // Get email bcc contact
            $mailService = new MailService();
            $templateItem = EmailTemplateModel::where(['name' => 'EMAIL_TEMPLATE_NOTIFY_EIDT_ROW'])->first();
            $title = $mailService->setDataTemplate($templateItem->title, [
                'line_number' => $request->line_number
            ]);
            $content = $mailService->setDataTemplate($templateItem->content, [
                'line_number' => $request->line_number,
                'username' => session('userInfo')['fullname'],
                'sheet_name' => $sheet->name
            ]);

            $emailBccModel = new EmailBccModel();
            $bccItems = $emailBccModel->getItem(['templateId' => $templateItem->id], ['task' => 'by-template']);
            $bcc = [];
            foreach ($bccItems as $item)
                $bcc[] = $item->email;
    
            // Send mail
            foreach($usersQC as $user)
                $mailService->sendEmail($user->email, $title, $content, $bcc);

            $status = true;
            $message = 'success';

         } catch (\Exception $e) {
            $message = $e->getMessage();
         }

         return response()->json([
            'status' => $status,
            'message' => $message
         ]);
    }
}