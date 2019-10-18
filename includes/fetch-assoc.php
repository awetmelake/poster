<?php
// function that mimics mysqli_fetch_assoc for environments where msqlnd is not available
function fetchAssocStatement($stmt)
{
    if (mysqli_stmt_num_rows($stmt) > 0) {
        $result = array();
        $md = mysqli_stmt_result_metadata($stmt);
        while ($field = mysqli_fetch_field($md)) {
            $params[] = &$result[$field->name];
        }
        call_user_func_array(array($stmt, 'bind_result'), $params);
        if (mysqli_stmt_fetch($stmt)) {
            return $result;
        }
    }
    return null;
}
