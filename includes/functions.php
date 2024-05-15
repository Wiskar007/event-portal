<?php

include('db.php');
 //function for insert field on database


 function insertData($table_name, $insert_data, $db) {
    try {
        $columns = implode(', ', array_keys($insert_data));
        $placeholders = rtrim(str_repeat('?, ', count($insert_data)), ', ');
        $sql = "INSERT INTO $table_name ($columns) VALUES ($placeholders)";
        $stmt = $db->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Error preparing the statement: " . $db->error);
        }
        
        $bindParams = [];
        $bindTypes = ''; // Store the parameter types
        
        foreach ($insert_data as $key => $value) {
            $bindParams[] = &$insert_data[$key];
            $bindTypes .= 's'; // Assuming all values are strings, change this if needed
        }

        array_unshift($bindParams, $bindTypes);
        $reflectionMethod = new ReflectionMethod('mysqli_stmt', 'bind_param');
        $reflectionMethod->invokeArgs($stmt, $bindParams);
        
        if (!$stmt->execute()) {
            throw new Exception("Error executing the statement: " . $stmt->error);
        }
        
        // Return the inserted row ID if needed
        $insertedId = $db->insert_id;
        
        // Close the database connection
        $stmt->close();
        // $db->close();
        
        return $insertedId;
    } catch (Exception $e) {
        // Error handling
        echo 'Error: ' . $e->getMessage();
        return false;
    }
}







// function for update data 

function updateData($table_name, $column_name, $new_value, $db, $where_condition = '') {
    try {
        // Build the SQL statement
        if (!empty($where_condition) && is_array($where_condition)) {
            $sql = "UPDATE $table_name SET $column_name = ? WHERE ";
            $where_clause = [];
            $params = [$new_value];
            foreach ($where_condition as $column => $value) {
                $where_clause[] = "$column = ?";
                $params[] = $value;
            }
            $sql .= implode(' AND ', $where_clause);
        } else {
            $sql = "UPDATE $table_name SET $column_name = ?";
            $params = [$new_value];
        }

        $stmt = $db->prepare($sql);
        
        // Bind the parameters
        $param_types = str_repeat('s', count($params));
        $stmt->bind_param($param_types, ...$params);
        
        // Execute the statement
        if (!$stmt->execute()) {
            throw new Exception("Error executing the statement: " . $stmt->error);
        }
        
        // Get the number of affected rows
        $num_rows_affected = $stmt->affected_rows;
        
        // Close the statement and database connection
        $stmt->close();
        $db->close();
        
        return $num_rows_affected;
    } catch (Exception $e) {
        // Error handling
        echo 'Error: ' . $e->getMessage();
        return false;
    }
}






// function for fetch data from database
function fetchData($table_name, $column_names, $where_condition, $db) {
    try {
        // Prepare the select statement
        if ($column_names === '*') {
            $sql = "SELECT * FROM $table_name";
        } else {
            $sql = "SELECT $column_names FROM $table_name";
        }
        
        // Add WHERE condition if provided
        if (!empty($where_condition)) {
            $sql .= " WHERE ";
            $params = [];
            foreach ($where_condition as $column => $value) {
                $sql .= "$column = ? AND ";
                $params[] = $value;
            }
            $sql = rtrim($sql, 'AND ');
        }
        
        $stmt = $db->prepare($sql);
        
        // Bind parameters if WHERE condition is provided
        if (!empty($where_condition)) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }
        
        // Execute the statement
        if (!$stmt->execute()) {
            throw new Exception("Error executing the statement: " . $stmt->error);
        }
        
        // Get the result set
        $result = $stmt->get_result();
        
        // Fetch the data into an array of associative arrays
        $data = $result->fetch_all(MYSQLI_ASSOC);
        
        // Close the result set (not necessary to close the connection here)
        $stmt->close();
        
        return $data;
    } catch (Exception $e) {
        // Error handling
        echo 'Error: ' . $e->getMessage();
        return false;
    }
}





// Function for deleting data from the database
function deleteData($table_name, $where_condition, $db) {
    try {
        // Prepare the delete statement
        $sql = "DELETE FROM $table_name";
        
        // Add WHERE condition if provided
        if (!empty($where_condition)) {
            $sql .= " WHERE $where_condition";
        }
        
        $stmt = $db->prepare($sql);
        
        // Execute the statement
        if (!$stmt->execute()) {
            throw new Exception("Error executing the statement: " . $stmt->error);
        }
        
        // Get the number of affected rows
        $affected_rows = $stmt->affected_rows;
        
        // Close the statement and database connection
        $stmt->close();
        $db->close();
        
        return $affected_rows;
    } catch (Exception $e) {
        // Error handling
        echo 'Error: ' . $e->getMessage();
        return false;
    }
}








?>