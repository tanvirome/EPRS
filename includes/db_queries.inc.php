<?php
  function getUserByEmailQuery($email) {
    return "SELECT * FROM employees WHERE email = '$email'";
  }

  function getUserByIdQuery($id) {
    return "SELECT id, name, email, points, country, phone, type FROM employees WHERE id = '$id'";
  }
  
  function registerNewUserQuery($name, $email, $password, $country, $phone, $type) {
    $join_date = date("Y-m-d H:i:s");
    return "INSERT INTO employees (name, email, password, country, phone, type, join_date) VALUES ('$name', '$email', '$password', '$country', '$phone', '$type', '$join_date');";
  }

  function updateUserQuery($name, $email, $country, $phone, $type, $points, $id) {
    return "UPDATE employees SET name = '$name', email = '$email', country = '$country', phone = '$phone', type = '$type', points = '$points' WHERE id = $id;";
  }

  function getAllEmployeesQuery() {
    return "SELECT id, name, email, points, country, phone, type FROM employees;";
  }

  function getEmployeesBySearchQuery($searchTerm) {
    return 'SELECT id, name, email, points, country, phone, type FROM employees WHERE name LIKE "%'.$searchTerm.'%";';
  }

  function deleteAllDailyWorksOfEmployee($empId) {
    return "DELETE FROM daily_work WHERE daily_work.employeesid = '$empId';";
  }

  function deleteAllCommentsOfEmployee($empId) {
    return "DELETE FROM comment WHERE comment.employeesid = '$empId';";
  }

  function deleteAllPostsOfEmployee($empId) {
    return "DELETE FROM post WHERE post.employeesid = '$empId';";
  }

  function deleteAllReportedReportsOfEmployee($empId) {
    return "DELETE FROM report WHERE report.employeesid = '$empId';";
  }

  function deleteAllReportsOfEmployee($empId) {
    return "DELETE FROM report WHERE report.reported_to = '$empId';";
  }

  function deleteAllTaskByOtherOfEmployee($empId) {
    return "DELETE FROM task_by_others WHERE task_by_others.employeesid = '$empId';";
  }

  function deleteAllTaskByOtherOfEmployeeGivenTo($empId) {
    return "DELETE FROM task_by_others WHERE task_by_others.given_to = '$empId';";
  }

  function deleteEmployeeQuery($empId) {
    return "DELETE FROM employees WHERE employees.id = '$empId';";
  }

  function getAllTasksQuery() {
    return "SELECT d.id as 'tid', d.title, d.description, d.time, d.submission_time, d.project_point, d.deadline, e.name,e.id FROM daily_work as d JOIN employees as e ON e.id = d.employeesid;";
  }

  function getAllReportsQuery() {
    return "SELECT r.time, r.id, r.title, r.description, r.feedback_from_reported, r.admin_feedback, e.name, e1.name as 'name2' FROM employees as e JOIN report as r on e.id = r.employeesid JOIN employees as e1 on e1.id = r.reported_to;";
  }

  function postAdminFeedbackOnReportQuery($feedback, $reportId) {
    return "UPDATE report SET admin_feedback='$feedback' WHERE id = '$reportId';";
  }

  function createDailyWorkQuery($title, $description, $deadline, $point, $empId) {
    $time = date("Y-m-d H:i:s");
    return "INSERT INTO daily_work (title, description, time, deadline, project_point, employeesid) VALUES ('$title', '$description', '$time', '$deadline', $point, $empId);";
  }

  function createTaskByOthersQuery($title, $description, $deadline, $point, $empId, $loggedIn_user_id) {
    $time = date("Y-m-d H:i:s");
    return "INSERT INTO task_by_others (title, given_to,  description, time, deadline, points, employeesid) VALUES ('$title', $empId, '$description', '$time', '$deadline', $point, $loggedIn_user_id);";
  }
?>