<?php

function getAllUsers($pdo)
{
    $sql = "SELECT * FROM applicants ORDER BY first_name ASC";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute();
    if ($executeQuery) {
        return $stmt->fetchAll();
    }
}

function getUserByID($pdo, $applicant_id)
{
    $sql = "SELECT * FROM applicants WHERE applicant_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$applicant_id]);
    if ($executeQuery) {
        return $stmt->fetch();
    }
}

function searchForAUser($pdo, $searchQuery)
{
    $sql = "SELECT * FROM applicants WHERE CONCAT(first_name,last_name,date_added,phone_number,years_experience,licenses,certifications,education,desired_salary) LIKE ?";

    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute(["%" . $searchQuery . "%"]);
    if ($executeQuery) {
        return $stmt->fetchAll();
    }
}

function insertNewUser($pdo, $first_name, $last_name, $phone_number, $years_experience, $licenses, $certifications, $education, $desired_salary)
{
    $checkSql = "SELECT COUNT(*) FROM applicants WHERE first_name = ? OR last_name = ? OR phone_number = ?";

    $checkStmt = $pdo->prepare($checkSql);
    $checkStmt->execute([$first_name, $last_name, $phone_number]);
    $existingUser = $checkStmt->fetchColumn();

    if ($existingUser) {
        return false;
    }

    $sql = "INSERT INTO applicants (first_name,last_name,phone_number,years_experience,licenses,certifications,education,desired_salary) VALUES (?,?,?,?,?,?,?,?)";

    $stmt = $pdo->prepare($sql);
    $execiteQuery = $stmt->execute([$first_name, $last_name, $phone_number, $years_experience, $licenses, $certifications, $education, $desired_salary]);

    if ($execiteQuery) {
        return true;
    } else {
        return false;
    }
}

function editUser($pdo, $first_name, $last_name, $date_added, $phone_number, $years_experience, $licenses, $certifications, $education, $desired_salary, $applicant_id)
{
    $sql = "UPDATE applicants 
                SET first_name = ?, 
                    last_name = ?, 
                    date_added = ?, 
                    phone_number = ?,
                    years_experience = ?,
                    licenses = ?,
                    certifications = ?,
                    education = ?,
                    desired_salary = ?
                WHERE applicant_id = ?";

    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$first_name, $last_name, $date_added, $phone_number, $years_experience, $licenses, $certifications, $education, $desired_salary, $applicant_id]);

    if ($executeQuery) {
        return true;
    }
}

function deleteUser($pdo, $applicant_id)
{
    $sql = "DELETE FROM applicants WHERE applicant_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$applicant_id]);

    if ($executeQuery) {
        return true;
    }
}

function checkIfUserExists($pdo, $username)
{
    $response = array();
    $sql = "SELECT * FROM user_accounts WHERE username = ?";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$username])) {
        $userInfoArray = $stmt->fetch();

        if ($stmt->rowCount() > 0) {
            $response = array(
                "result" => true,
                "status" => "200",
                "userInfoArray" => $userInfoArray
            );
        } else {
            $response = array(
                "status" => "400",
                "message" => "This user doesn't exist from the database."
            );
        }
    }

    return $response;

}

function insertNewUserAcc($pdo, $username, $first_name, $last_name, $password)
{
    $response = array();
    $checkIfUserExists = checkIfUserExists($pdo, $username);

    if (!$checkIfUserExists['result']) {
        $sql = "INSERT INTO user_accounts (username, first_name, last_name, password) VALUES (?,?,?,?)";

        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([$username, $first_name, $last_name, $password])) {
            $response = array(
                "status" => "200",
                "message" => "Successfully created an account!"
            );
        } else {
            $response = array(
                "status" => "400",
                "message" => "Something went wrong with the query."
            );
        }
    } else {
        $response = array(
            "status" => "400",
            "message" => "This user already exists."
        );
    }
    return $response;
}

?>