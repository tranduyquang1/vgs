<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class BackupFileAssets extends Command
{
    private $folderBackup = ['files', 'img', 'images', 'upload'];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup current database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->process = new Process(sprintf("cd public && zip -r backups/files.zip %s", join(" ", $this->folderBackup)));
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $this->process->mustRun();
            $this->info('The backup has been proceed successfully.');
        } catch (ProcessFailedException $exception) {
            $this->error('The backup process has been failed. >>> '. $exception->getMessage());
        }
    }
}
