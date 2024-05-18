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
function fetchData($table_name, $column_names, $where_condition, $db, $join_type = null, $join_table = null, $join_condition = null) {
    try {
        // Prepare the select statement
        if ($column_names === '*') {
            $sql = "SELECT * FROM $table_name";
        } else {
            $sql = "SELECT $column_names FROM $table_name";
        }
        
        // Add JOIN clause if provided
        if ($join_type && $join_table && $join_condition) {
            $sql .= " $join_type JOIN $join_table ON $join_condition";
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



function fetchDataWithPagination($table_name, $column_names, $where_condition, $limit, $page, $db) {
    try {
        // Calculate the OFFSET for pagination
        $offset = ($page - 1) * $limit;

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
        
        // Count total rows (without limit and offset)
        $countSql = "SELECT COUNT(*) as total FROM $table_name";
        if (!empty($where_condition)) {
            $countSql .= " WHERE ";
            $countSql .= implode(" = ? AND ", array_keys($where_condition)) . " = ?";
        }
        $countStmt = $db->prepare($countSql);
        if (!empty($where_condition)) {
            $types = str_repeat('s', count($params));
            $countStmt->bind_param($types, ...$params);
        }
        $countStmt->execute();
        $countResult = $countStmt->get_result();
        $total_rows = $countResult->fetch_assoc()['total'];
        
        // Add LIMIT and OFFSET for pagination
        $sql .= " LIMIT ? OFFSET ?";
        
        $stmt = $db->prepare($sql);
        
        // Bind parameters if WHERE condition is provided
        if (!empty($where_condition)) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }

        // Bind LIMIT and OFFSET parameters
        $stmt->bind_param('ii', $limit, $offset);
        
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
        
        // Calculate total number of pages
        $total_pages = ceil($total_rows / $limit);

        // Return data along with pagination information
        return array(
            'data' => $data,
            'total_rows' => $total_rows,
            'total_pages' => $total_pages
        );
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