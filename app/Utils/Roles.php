<?php

namespace App\Utils;

class Roles {
//  return array
  public static $ADMIN = 'admin';
  public static $pilgrim = 'jamaah';
  public static $ALL = ['admin', 'jamaah'];

  public static function checkExistRole($params)
  {
      $roles = explode(" ", $params);
      $result = [];
      if ($roles == null) {
          return [];
      }
      foreach ($roles as $role) {
          if (in_array($role, Roles::$ALL)) {
              $result[] = $role;
          } else {
              return [];
          }
      }
      return $result;
  }
}