<?php

namespace App\Utils;


class Pagination {
  public static function init($model, $params) {
    $params['limit'] = isset($params['limit']) ?(intval($params['limit'])) : 10;
    $params['page'] = isset($params['page']) ? intval($params['page']) : 1;
    $offset = intval($params['page'] - 1) * intval($params['limit']);
    $totalPage = ceil($model::count() / intval($params['limit']));
    $totalRows = $model::count();
    $exist = $model::offset($offset)->limit($params['limit'])->get();

    if (!$exist) {
      return HttpResponse::not_found();
    }

    $result = [
      'page' => $params['page'],
      'limit' => $params['limit'],
      'total_page' => $totalPage,
      'total_rows' => $totalRows,
      'data' => $exist,
    ];

    return HttpResponse::success($result);
  }


  public static function initWithSearch($model, $params, $search = []) {
    $params['limit'] = isset($params['limit']) ?(intval($params['limit'])) : 10;
    $params['page'] = isset($params['page']) ? intval($params['page']) : 1;
    $offset = intval($params['page'] - 1) * intval($params['limit']);

    $exist = $model::where(function($query) use ($params, $search) {
      foreach ($search as $key => $value) {
        $query->orWhere($value, 'like', '%'.$params['search'].'%');
      }
    })->offset($offset)->limit($params['limit'])->get();

    $totalPage = ceil($model::where(function($query) use ($params, $search) {
      foreach ($search as $key => $value) {
        $query->orWhere($value, 'like', '%'.$params['search'].'%');
      }
    })->count() / intval($params['limit']));

    $totalRows = $model::where(function($query) use ($params, $search) {
      foreach ($search as $key => $value) {
        $query->orWhere($value, 'like', '%'.$params['search'].'%');
      }
    })->count();

    if (!$exist) {
      return HttpResponse::not_found();
    }
    $result = [
      'page' => $params['page'],
      'limit' => $params['limit'],
      'total_page' => $totalPage,
      'total_rows' => $totalRows,
      'data' => $exist,
    ];

    return HttpResponse::success($result);
  }
}