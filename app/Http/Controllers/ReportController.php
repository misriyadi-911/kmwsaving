<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TransactionalSavings;

class ReportController extends Controller
{
  public function index()
  {
    try {
      $request = request()->all();
      $page = isset($request['page']) ? $request['page'] : 1;
      $limit = isset($request['limit']) ? $request['limit'] : 10;
      $offset = ($page - 1) * $limit;
      $start_date = isset($request['start_date']) ? $request['start_date'] : null;
      $end_date = isset($request['end_date']) ? $request['end_date'] : null;
      $category = isset($request['category']) ? $request['category'] : 'semua';
      $type = isset($request['type']) ? $request['type'] : 1;
      $id =@$request['id'];
      $data = TransactionalSavings::where('transactional_savings.type', 'diverifikasi')
        ->join('pilgrims', 'transactional_savings.pilgrims_id', '=', 'pilgrims.pilgrims_id')
        ->join('saving_categories', 'pilgrims.saving_category_id', '=', 'saving_categories.saving_category_id')
        ->join('user_account', 'pilgrims.user_account_id', '=', 'user_account.user_account_id')
        ->leftjoin('saldo', 'pilgrims.pilgrims_id', '=', 'saldo.pilgrims_id');

      if ($start_date) {
        $data = $data->where('transactional_savings.created_at', '>=', $start_date);
      }

      if ($end_date) {
        $data = $data->where('transactional_savings.created_at', '<=', $end_date);
      }

      if ($category != 'semua') {
        $data = $data->where('saving_categories.saving_category_id', $category);
      }

      if ($type == 2) {
        // jika type 1 maka limit category < dari saldo
        $data = $data->where('saving_categories.limit', '<', 'saldo.nominal');
      }

      if ($type == 3) {
        // jika type 2 maka limit category > dari saldo
        $data = $data->where('saving_categories.limit', '>', 'saldo.nominal');
      }

      if($id) {
        $data = $data->where('user_account.user_account_id', $id);
      }

      $data = $data->offset($offset)->limit($limit)->select(
        'transactional_savings.transactional_savings_id',
        'transactional_savings.created_at',
        'transactional_savings.updated_at',
        'transactional_savings.type',
        'transactional_savings.nominal',
        'user_account.username',
        'saving_categories.name as category',
        'pilgrims.kode as kode',
        'saving_categories.limit as limit',
        'saldo.nominal as nominal_saldo'
      )->get();

      return response()->json([
        'status'  => true,
        'message' => 'Data retieved successfully',
        'data' => [
          'totalPage' => ceil($data->count() / $limit),
          'totalRows' => $data->count(),
          'pageNumber' => $page,
          'data' => $data,
        ]
      ]);
    } catch (\Throwable $th) {
      return response()->json([
        'status'  => false,
        'message' => $th->getMessage(),
      ]);
    }
  }

  public function print()
  {
    try {
      $request = request()->all();
      $start_date = isset($request['start_date']) ? $request['start_date'] : null;
      $end_date = isset($request['end_date']) ? $request['end_date'] : null;
      $category = isset($request['category']) ? $request['category'] : 'semua';
      $type = isset($request['type']) ? $request['type'] : 1;
      $id =@$request['id'];

      $data = TransactionalSavings::where('transactional_savings.type', 'diverifikasi')
        ->join('pilgrims', 'transactional_savings.pilgrims_id', '=', 'pilgrims.pilgrims_id')
        ->join('saving_categories', 'pilgrims.saving_category_id', '=', 'saving_categories.saving_category_id')
        ->join('user_account', 'pilgrims.user_account_id', '=', 'user_account.user_account_id')
        ->leftjoin('saldo', 'pilgrims.pilgrims_id', '=', 'saldo.pilgrims_id');

      if ($start_date) {
        $data = $data->where('transactional_savings.created_at', '>=', $start_date);
      }

      if ($end_date) {
        $data = $data->where('transactional_savings.created_at', '<=', $end_date);
      }

      if ($category != 'semua') {
        $data = $data->where('saving_categories.saving_category_id', $category);
      }

      if ($type == 2) {
        // jika type 1 maka limit category < dari saldo
        $data = $data->where('saving_categories.limit', '<', 'saldo.nominal');
      }

      if ($type == 3) {
        // jika type 2 maka limit category > dari saldo
        $data = $data->where('saving_categories.limit', '>', 'saldo.nominal');
      }

      if($id) {
        $data = $data->where('user_account.user_account_id', $id);
      }

      $data = $data->select(
        'transactional_savings.transactional_savings_id',
        'transactional_savings.created_at',
        'transactional_savings.updated_at',
        'transactional_savings.type',
        'transactional_savings.nominal',
        'user_account.username',
        'saving_categories.name as category',
        'pilgrims.kode as kode',
        'saldo.nominal as nominal_saldo'
      )->get();

      return response()->json([
        'status'  => true,
        'message' => 'Data retieved successfully',
        'data' => $data,
      ]);
    } catch (\Throwable $th) {
      return response()->json([
        'status'  => false,
        'message' => $th->getMessage(),
      ]);
    }
  }

  public function export()
  {
    try {
      $request = request()->all();
      $start_date = isset($request['start_date']) ? $request['start_date'] : null;
      $end_date = isset($request['end_date']) ? $request['end_date'] : null;
      $category = isset($request['category']) ? $request['category'] : 'semua';
      $type = isset($request['type']) ? $request['type'] : 1;
      $id =@$request['id'];

      $data = TransactionalSavings::where('transactional_savings.type', 'diverifikasi')
        ->join('pilgrims', 'transactional_savings.pilgrims_id', '=', 'pilgrims.pilgrims_id')
        ->join('saving_categories', 'pilgrims.saving_category_id', '=', 'saving_categories.saving_category_id')
        ->join('user_account', 'pilgrims.user_account_id', '=', 'user_account.user_account_id')
        ->leftjoin('saldo', 'pilgrims.pilgrims_id', '=', 'saldo.pilgrims_id');

      if ($start_date) {
        $data = $data->where('transactional_savings.created_at', '>=', $start_date);
      }

      if ($end_date) {
        $data = $data->where('transactional_savings.created_at', '<=', $end_date);
      }

      if ($category != 'semua') {
        $data = $data->where('saving_categories.saving_category_id', $category);
      }

      if ($type == 2) {
        // jika type 1 maka limit category < dari saldo
        $data = $data->where('saving_categories.limit', '<', 'saldo.nominal');
      }

      if ($type == 3) {
        // jika type 2 maka limit category > dari saldo
        $data = $data->where('saving_categories.limit', '>', 'saldo.nominal');
      }

      if($id) {
        $data = $data->where('user_account.user_account_id', $id);
      }

      $data = $data->select(
        'transactional_savings.transactional_savings_id',
        'transactional_savings.created_at',
        'transactional_savings.updated_at',
        'transactional_savings.type',
        'transactional_savings.nominal',
        'user_account.username',
        'saving_categories.name as category',
        'pilgrims.kode as kode',
        'saldo.nominal as nominal_saldo',
        'saving_categories.limit as limit'
      )->get();
      $filename = 'uploads/' . time() . '.csv';
      $csv = fopen($filename, 'w');
      fputcsv($csv, [
        'Tanggal Transaksi',
        'Kode Jamaah',
        'Nama Jamaah',
        'Kategori',
        'Nominal',
        'Saldo',
      ]);
      foreach ($data as $item) {
        fputcsv($csv, [
          $item->created_at,
          $item->kode,
          $item->username,
          $item->category,
          $item->nominal,
          $item->nominal_saldo,
        ]);
      }
      fclose($csv);
      return response()->json([
        'status'  => true,
        'message' => 'Data retieved successfully',
        'data' => [
          'filename' => $filename
        ]
      ]);
    } catch (\Throwable $th) {
      return response()->json([
        'status'  => false,
        'message' => $th->getMessage(),
      ]);
    }
  }
}
