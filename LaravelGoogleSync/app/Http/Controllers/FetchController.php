<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleSheetsService;

class FetchController extends Controller
{
    protected $googleSheetsService;

    public function __construct(GoogleSheetsService $googleSheetsService)
    {
        $this->googleSheetsService = $googleSheetsService;
    }

    public function index(Request $request, $count = null)
    {
        $count = $request->get('count', $count ?? 20); // Получаем count из GET-параметра или из URL

        $comments = $this->googleSheetsService->fetchComments($count);
        return view('fetch.index', compact('comments', 'count'));
    }
}
