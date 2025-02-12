<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Group;
use App\Models\Permission;
use App\Models\Project;
use App\Models\Request;
use App\Models\Rol;
use App\Models\RolsXPermission;
use App\Models\StatusRequest;
use App\Models\User;
use App\Models\UsersProjectsRequest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AppSeeder extends Seeder
{
    public function run(): void
    {
        // INSERSION EN TABLA "permissions"
        Permission::insert([
            ['permission_name' => 'Lectura'],
            ['permission_name' => 'Dar seguimiento'],
            ['permission_name' => 'Dar solución'],
            ['permission_name' => 'Borrado físico'],
            ['permission_name' => 'Copia de seguridad'],
        ]);
        // INSERTAR DATOS EN TABLA "rols"
        Rol::insert([
            ['rol_name' => 'Administrador'],
            ['rol_name' => 'Analista'],
        ]);

        // INSERSION EN TABLA "rols_x_permissions"
        RolsXPermission::insert([
            // ADMINISTRADOR
            ['fk_rol' => 1, 'fk_permission' => 1,],
            ['fk_rol' => 1, 'fk_permission' => 2,],
            ['fk_rol' => 1, 'fk_permission' => 3,],
            ['fk_rol' => 1, 'fk_permission' => 4,],
            ['fk_rol' => 1, 'fk_permission' => 5,],
            // ANALISTA
            ['fk_rol' => 2, 'fk_permission' => 1,],
            ['fk_rol' => 2, 'fk_permission' => 2,],
            ['fk_rol' => 2, 'fk_permission' => 3,],
        ]);

        // INSERTAR DATOS EN TABLA "groups"
        Group::insert([
            [
                'group_name' => 'Gerencia de operaciones',
                'group_description' => 'Control y gestión de peticiones'
            ],
        ]);

        // INSERTAR DATOS EN TABLA "status_requests"
        StatusRequest::insert([
            ['status_name' => 'Iniciado'],
            ['status_name' => 'En proceso'],
            ['status_name' => 'Solucionado'],
        ]);

        // INSERTAR DATOS EN TABLA "projects"
        Project::insert([
            ['project_name' => 'Gran Proyecto'],
        ]);

        // INSERTAR DATOS EN TABLA "users"
        User::insert([
            [
                'fk_rol' => 1,
                'fk_group' => 1,
                'user_code' => strtoupper(Str::random(6)),
                'user_identification' => '27995612',
                'user_gender' => 'Masculino',
                'user_name' => 'José Daniel',
                'user_lastName' => 'Morian Pérez',
                'email' => 'jdmorianperez@gmail.com',
                'password' => Hash::make('Morian.-12345'),
                'user_dateOfBirth' => '2001-07-16',
                'user_status' => 'verificado',
            ],
            [
                'fk_rol' => 2,
                'fk_group' => 1,
                'user_code' => strtoupper(Str::random(6)),
                'user_identification' => '14443567',
                'user_gender' => 'Femenino',
                'user_name' => 'María Alejandra',
                'user_lastName' => 'González Castillo',
                'email' => 'example1@gmail.com',
                'password' => Hash::make('12345678'),
                'user_dateOfBirth' => '1985-08-22',
                'user_status' => 'verificado',
            ],
            [
                'fk_rol' => 2,
                'fk_group' => 1,
                'user_code' => strtoupper(Str::random(6)),
                'user_identification' => '20332561',
                'user_gender' => 'Masculino',
                'user_name' => 'Carlos Alberto',
                'user_lastName' => 'López Villegas',
                'email' => 'example2@gmail.com',
                'password' => Hash::make('12345678'),
                'user_dateOfBirth' => '1992-12-30',
                'user_status' => 'verificado',
            ],
        ]);

        // INSERTAR DATOS EN TABLA "request" PARA EL USUARIO N-1
        for ($i = 1; $i <= 10; $i++) {
            Request::insert([
                [
                    'fk_user_prime' => 1,
                    'fk_statusRequest' => 1,
                    'request_code' => strtoupper(Str::random(6)),
                    'request_applicantName' => 'clienteN ' . $i,
                    'request_applicantEmail' => 'correoElectronicoN' . $i . '@gmail.com',
                    'request_tittle' => 'TituloPeticionN ' . $i,
                    'request_description' => 'DescripcionPeticionN ' . $i,
                    'request_date_start' => now()->setTimezone('America/Caracas'),
                ],
            ]);
        }

        // INSERTAR DATOS EN TABLA "users_projects_request" PARA EL USUARIO N-1
        for ($i = 1; $i <= 10; $i++) {
            UsersProjectsRequest::insert([
                [
                    'fk_user' => 1,
                    'fk_project' => 1,
                    'fk_request' => $i,
                ]
            ]);
        }

        // INSERTAR DATOS EN TABLA "request" PARA EL USUARIO N-2
        for ($i = 11; $i <= 13; $i++) {
            Request::insert([
                [
                    'fk_user_prime' => 2,
                    'fk_statusRequest' => 1,
                    'request_code' => strtoupper(Str::random(6)),
                    'request_applicantName' => 'clienteN ' . $i,
                    'request_applicantEmail' => 'correoElectronicoN' . $i . '@gmail.com',
                    'request_tittle' => 'TituloPeticionN ' . $i,
                    'request_description' => 'DescripcionPeticionN ' . $i,
                    'request_date_start' => now()->setTimezone('America/Caracas'),
                ],
            ]);
        }

        // INSERTAR DATOS EN TABLA "users_projects_request" PARA EL USUARIO N-2
        for ($i = 11; $i <= 13; $i++) {
            UsersProjectsRequest::insert([
                [
                    'fk_user' => 2,
                    'fk_project' => 1,
                    'fk_request' => $i,
                ]
            ]);
        }
        
        // INSERTAR DATOS EN TABLA "request" PARA EL USUARIO N-3
        for ($i = 14; $i <= 15; $i++) {
            Request::insert([
                [
                    'fk_user_prime' => 3,
                    'fk_statusRequest' => 1,
                    'request_code' => strtoupper(Str::random(6)),
                    'request_applicantName' => 'clienteN ' . $i,
                    'request_applicantEmail' => 'correoElectronicoN' . $i . '@gmail.com',
                    'request_tittle' => 'TituloPeticionN ' . $i,
                    'request_description' => 'DescripcionPeticionN ' . $i,
                    'request_date_start' => now()->setTimezone('America/Caracas'),
                ],
            ]);
        }

        // INSERTAR DATOS EN TABLA "users_projects_request" PARA EL USUARIO N-3
        for ($i = 14; $i <= 15; $i++) {
            UsersProjectsRequest::insert([
                [
                    'fk_user' => 3,
                    'fk_project' => 1,
                    'fk_request' => $i,
                ]
            ]);
        }
    }
}
