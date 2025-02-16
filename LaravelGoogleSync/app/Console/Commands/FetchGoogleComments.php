<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\GoogleSheetsService;

class FetchGoogleComments extends Command
{
    protected $signature = 'fetch:comments {count?}';
    protected $description = 'Загружает комментарии из Google Sheets и выводит их в консоль';

    protected $googleSheetsService;

    public function __construct(GoogleSheetsService $googleSheetsService)
    {
        parent::__construct();
        $this->googleSheetsService = $googleSheetsService;
    }

    public function handle()
    {
        $this->info('Загружаем комментарии из Google Sheets...');

        $count = $this->argument('count') ?? 20;

        $comments = $this->googleSheetsService->fetchComments($count);

        if (empty($comments)) {
            $this->warn('Комментарии не найдены.');
            return;
        }

        $bar = $this->output->createProgressBar(count($comments));
        $bar->start();

        foreach ($comments as $comment) {
            $this->line("ID: {$comment['id']} | Комментарий: {$comment['comment']}");
            $bar->advance();
        }

        $bar->finish();
        $this->info("\nГотово! Загружено " . count($comments) . " комментариев.");
    }
}

