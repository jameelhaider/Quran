<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Response;

Route::group(['prefix' => 'admin'], function () {
    Route::get('/logout', function () {
        Auth::logout();
        return redirect('/login');
    });
    Route::get('/export-database', function () {
        $date = Carbon::now()->format('d_M_y_h_i_A');
        $filename = "Backup_Steven_Steel_Gears_$date.sql";
        $tables = DB::select('SHOW TABLES');
        $tableNames = array_map('current', $tables);
        $sql = '';

        foreach ($tableNames as $table) {
            $createTableQuery = DB::select("SHOW CREATE TABLE `$table`");
            $sql .= $createTableQuery[0]->{'Create Table'} . ";\n\n";
            $rows = DB::table($table)->get();
            foreach ($rows as $row) {
                $values = array_map(function ($value) {
                    return DB::connection()->getPdo()->quote($value);
                }, (array) $row);

                $sql .= "INSERT INTO `$table` VALUES (" . implode(', ', $values) . ");\n";
            }
            $sql .= "\n\n";
        }

        return Response::make($sql, 200, [
            'Content-Type' => 'application/sql',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    })->name('export.database');

    Route::get('/send-database-backup', function () {
        $date = Carbon::now()->format('d_M_y_h_i_A');
        $filename = "Backup_Steven_Steel_Gears_$date.sql";
        $tables = DB::select('SHOW TABLES');
        $tableNames = array_map('current', $tables);
        $sql = '';

        foreach ($tableNames as $table) {
            $createTableQuery = DB::select("SHOW CREATE TABLE `$table`");
            $sql .= $createTableQuery[0]->{'Create Table'} . ";\n\n";
            $rows = DB::table($table)->get();
            foreach ($rows as $row) {
                $values = array_map(function ($value) {
                    return DB::connection()->getPdo()->quote($value);
                }, (array) $row);

                $sql .= "INSERT INTO `$table` VALUES (" . implode(', ', $values) . ");\n";
            }
            $sql .= "\n\n";
        }
        // Mail::to(['jameelhaider047@gmail.com', 'husnainbutt047@gmail.com'])
        //     ->send(new DatabaseBackupMail($sql, $filename));
        return redirect()->back()->with('success', 'Database backup sent to email successfully.');
    })->name('send.database.backup');
    Route::get('/change-password', [HomeController::class, 'changepassword'])->name("change.password");
    Route::post('/update-password', [HomeController::class, 'updatepassword'])->name("update.password");


    //products
    Route::group(['prefix' => 'products'], function () {
            Route::post('/submit', [ProductsController::class, 'submit'])->name("admin.product.submit");
            Route::get('/create', [ProductsController::class, 'create'])->name("admin.product.create");
            Route::get('/edit/{id}', [ProductsController::class, 'edit'])->name("admin.product.edit");
            Route::get('/delete/{id}', [ProductsController::class, 'delete'])->name("admin.product.delete");
            Route::post('/update/{id}', [ProductsController::class, 'update'])->name("admin.product.update");
            Route::get('/', [ProductsController::class, 'index'])->name("admin.product.index");
            Route::get('/delete/image/{id}', [ProductsController::class, 'deleteimage'])->name("admin.product.deleteimage");
        });

    Route::get('/', function () {
        if (Gate::allows('is_admin')) {
            return view('admin.index');
        } else {
            return abort(401);
        }
    })->name('admin');
});
