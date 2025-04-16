<?php

namespace App\Enums;

enum RoleEnum: string {
   case SUPER_ADMIN = 'super-admin';
   case ADMIN = 'admin';
   case USER = 'user';
   case KAPRODI = 'kaprodi';
   case DOSEN = 'dosen';

   public function label(): string {
      return match ($this) {
         static::SUPER_ADMIN => 'Super Admin',
         static::ADMIN => 'Admin',
         static::USER => 'User',
         static::KAPRODI => 'Kaprodi',
         static::DOSEN => 'Dosen',
      };
   }
}
