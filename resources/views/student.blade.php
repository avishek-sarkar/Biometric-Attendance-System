@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Database Information Dashboard</h1>
            
            @php
                try {
                    if(DB::connection()->getPdo()) {
                        $database = DB::connection()->getDatabaseName();
                        $connection = DB::connection()->getConfig();
                        
                        // Connection Info
                        echo "<div class='alert alert-success mb-4'>";
                        echo "Connected to database: " . $database . "<br>";
                        echo "Host: " . $connection['host'] . "<br>";
                        echo "Port: " . $connection['port'] . "<br>";
                        echo "Username: " . $connection['username'];
                        echo "</div>";
                        
                        // Tables Information
                        $tables = DB::select("SHOW TABLES");
                        
                        echo "<div class='card mb-4'>";
                        echo "<div class='card-header'><h4>Database Structure</h4></div>";
                        echo "<div class='card-body'>";
                        
                        foreach($tables as $table) {
                            $tableName = array_values((array)$table)[0];
                            
                            echo "<div class='mb-4'>";
                            echo "<h5>Table: " . $tableName . "</h5>";
                            
                            // Get column information
                            $columns = DB::select("SHOW COLUMNS FROM " . $tableName);
                            
                            echo "<table class='table table-sm table-bordered'>";
                            echo "<thead class='table-light'>";
                            echo "<tr><th>Column</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
                            echo "</thead><tbody>";
                            
                            foreach($columns as $column) {
                                echo "<tr>";
                                echo "<td>" . $column->Field . "</td>";
                                echo "<td>" . $column->Type . "</td>";
                                echo "<td>" . $column->Null . "</td>";
                                echo "<td>" . $column->Key . "</td>";
                                echo "<td>" . ($column->Default ?? 'NULL') . "</td>";
                                echo "<td>" . $column->Extra . "</td>";
                                echo "</tr>";
                            }
                            
                            echo "</tbody></table>";
                            
                            // Record count
                            $count = DB::table($tableName)->count();
                            echo "<p class='text-muted'>Total Records: " . $count . "</p>";
                            echo "</div>";
                        }
                        
                        echo "</div></div>";
                    }
                } catch (\Exception $e) {
                    echo "<div class='alert alert-danger'>Database Error: " . $e->getMessage() . "</div>";
                }
            @endphp
        </div>
    </div>
</div>
@endsection